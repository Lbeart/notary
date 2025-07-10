<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\IOFactory;
use Spatie\PdfToText\Pdf as PdfReader;
use Carbon\Carbon;
use setasign\Fpdi\Fpdi;
use ZipArchive;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingNotification;

class NotaryBookingController extends Controller
{
    public function downloadPdf($id)
    {
        $booking = Booking::with(['user', 'appointmentSlot', 'notary.user'])->findOrFail($id);

        if (Auth::id() !== $booking->notary->user_id) {
            abort(403);
        }

        $signatureUrl = $booking->signature_path ? asset('storage/' . $booking->signature_path) : null;

        $pdf = Pdf::loadView('notaries.pdf.booking', [
            'booking' => $booking,
            'signatureUrl' => $signatureUrl,
        ]);

        return $pdf->download('rezervimi-' . $booking->id . '.pdf');
    }

   public function monthly(Request $request)
{
    $notaryId = auth()->user()->notary->id;
    $month = $request->query('month', now()->month);

    $bookings = Booking::with(['user', 'serviceType'])
        ->where('notary_id', $notaryId)
        ->whereMonth('selected_time', $month)
        ->orderBy('selected_time')
        ->get();

    $monthName = \Carbon\Carbon::create()->month($month)->translatedFormat('F');

    return view('notaries.monthly-bookings', compact('bookings', 'month', 'monthName'));
}

    public function uploadTranslation(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        if (Auth::id() !== $booking->notary->user_id) {
            abort(403);
        }

        $request->validate([
            'translated_file' => 'required|file|mimes:pdf,txt,doc,docx',
        ]);

        $file = $request->file('translated_file');
        $extension = $file->getClientOriginalExtension();
        $originalName = 'booking_' . $booking->id . '_original.' . $extension;

        $originalPath = $file->storeAs('documents/original', $originalName, 'public');
        $text = '';

        try {
            if ($extension === 'txt') {
                $text = file_get_contents($file->getRealPath());
            } elseif (in_array($extension, ['doc', 'docx'])) {
                $phpWord = IOFactory::load($file->getRealPath());
                foreach ($phpWord->getSections() as $section) {
                    foreach ($section->getElements() as $element) {
                        if (method_exists($element, 'getText')) {
                            $text .= $element->getText() . "\n";
                        }
                    }
                }
            } elseif ($extension === 'pdf') {
                $text = PdfReader::getText($file->getRealPath());
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Nuk u lexua dot përmbajtja e dokumentit.');
        }

        if (empty(trim($text))) {
            $booking->update(['document_path' => $originalPath]);
            return back()->with('warning', 'Dokumenti u ruajt, por nuk kishte tekst për përkthim.');
        }

        $response = Http::post('https://libretranslate.de/translate', [
            'q' => $text,
            'source' => 'sq',
            'target' => 'en',
            'format' => 'text',
        ]);

        $translatedText = $response->json()['translatedText'] ?? null;

        if (!$translatedText) {
            return back()->with('error', 'Përkthimi automatik dështoi.');
        }

        $translatedPath = 'documents/translated/booking_' . $booking->id . '.txt';
        Storage::disk('public')->put($translatedPath, $translatedText);

        $booking->update([
            'document_path' => $originalPath,
            'translated_path' => $translatedPath,
            'is_translated' => true,
        ]);

        return back()->with('success', 'Dokumenti u përkthye dhe u ruajt me sukses!');
    }

    public function uploadSignature(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        if (Auth::id() !== $booking->notary->user_id) {
            abort(403);
        }

        $request->validate([
            'signed_file' => 'required|file|mimes:pdf',
        ]);

        $path = $request->file('signed_file')->store('documents/signed', 'public');

        $booking->update([
            'signed_path' => $path,
            'is_signed' => true,
        ]);

        return back()->with('success', 'Dokumenti i nënshkruar u ngarkua me sukses.');
    }

    public function storeSignatureImage(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'signature' => 'required|string',
            'x' => 'required|numeric',
            'y' => 'required|numeric',
        ]);

        $imageData = $request->input('signature');
        $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));

        $fileName = 'signature_booking_' . $booking->id . '.png';
        $path = 'documents/signatures/' . $fileName;
        Storage::disk('public')->put($path, $image);

        $booking->update(['signature_path' => $path]);

        $this->applySignatureToDocument($id, $request->x, $request->y);

        return redirect()->route('notary.booking.pdf', $id)->with('success', 'Nënshkrimi u aplikua me sukses.');
    }

    public function applySignatureToDocument($id, $x = 150, $y = 250)
    {
        $booking = Booking::findOrFail($id);

        $originalPath = storage_path('app/public/' . $booking->document_path);
        $signaturePath = storage_path('app/public/' . $booking->signature_path);
        $newSignedPdfPath = 'documents/signed/booking_' . $booking->id . '_signed.pdf';
        $outputPath = storage_path('app/public/' . $newSignedPdfPath);

        if (!str_ends_with(strtolower($originalPath), '.pdf')) {
            return;
        }

        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($originalPath);

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);

            $pdf->AddPage();
            $pdf->useTemplate($templateId, 0, 0, $size['width'], $size['height']);

            if ($pageNo === $pageCount) {
                $pdf->Image($signaturePath, $x, $y, 40);
            }
        }

        $pdf->Output($outputPath, 'F');

        $booking->update([
            'signed_path' => $newSignedPdfPath,
            'is_signed' => true,
        ]);
    }

    public function sealDocument($id)
    {
        $booking = Booking::findOrFail($id);

        if (Auth::id() !== $booking->notary->user_id) {
            abort(403);
        }

        $booking->update(['is_sealed' => true]);

        return back()->with('success', 'Dokumenti u vulos me sukses.');
    }

    public function showSignatureForm($id)
    {
        $booking = Booking::findOrFail($id);

        if (Auth::id() !== $booking->notary->user_id) {
            abort(403);
        }

        return view('notaries.sign', compact('booking'));
    }
  public function downloadDocuments($id)
{
    $booking = Booking::with('user')->findOrFail($id);

    $documentFields = array_filter($booking->getAttributes(), function ($value, $key) {
        return str_ends_with($key, '_path') && $value;
    }, ARRAY_FILTER_USE_BOTH);

    if (empty($documentFields)) {
        return back()->with('error', 'Ky klient nuk ka dokumente për të shkarkuar.');
    }

    $zipFileName = 'dokumentet-' . Str::slug($booking->user->name) . '-' . now()->format('Ymd_His') . '.zip';
    $zipPath = storage_path("app/public/{$zipFileName}");

    $zip = new ZipArchive;
    if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
        foreach ($documentFields as $field => $relativePath) {
            $fullPath = storage_path('app/public/' . $relativePath);
            if (file_exists($fullPath)) {
                $fileName = basename($relativePath);
                $zip->addFile($fullPath, $fileName);
            }
        }
        $zip->close();
    }

    return response()->download($zipPath)->deleteFileAfterSend(true);
}
public function sendEmail(Booking $booking)
{
    $user = $booking->user;

    Mail::to($user->email)->send(new BookingNotification($booking));

    return back()->with('success', '📧 Emaili u dërgua me sukses te ' . $booking->user->email);
}
}
