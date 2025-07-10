<?php 

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Notary;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmation;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingController extends Controller
{
    // Forma për rezervim
    public function create($id)
    {
        $notary = Notary::with('user')->findOrFail($id);
        $services = ServiceType::all()->unique('name')->values();

        return view('bookings.create', compact('notary', 'services'));
    }

    // Ruajtja e rezervimit
    public function store(Request $request)
    {
        $request->validate([
            'notary_id' => 'required|exists:notaries,id',
            'service_type_id' => 'required|exists:service_types,id',
            'description' => 'nullable|string',
            'selected_time' => 'required|string',
        ]);

        // Kontrollo nëse ora është rezervuar
        $exists = Booking::where('notary_id', $request->notary_id)
            ->where('selected_time', $request->selected_time)
            ->exists();

        if ($exists) {
            return back()->withErrors(['selected_time' => 'Kjo orë është tashmë e rezervuar për këtë noter.'])->withInput();
        }

        // Lista e fushave për dokumente
        $documentFields = [
            'document', 'ownership_document', 'document_to_legalize', 'child_document', 'identity_document',
            'additional_document', 'client_photo', 'testament_file', 'property_contract', 'mortgage_document',
            'exchange_document', 'rental_agreement', 'coownership_document', 'pledge_document', 'rights_document',
            'company_documents', 'signature_doc', 'employment_contract', 'id_card', 'signed_document',
            'contract_to_verify', 'original_copy', 'testament_to_store', 'document_to_translate', 'sales_contract',
            'donation_contract', 'lease_contract', 'child_passport', 'legalization_document', 'notarization_file'
        ];

        // Ruaj dokumentet dinamike
        $filePaths = [];
        foreach ($documentFields as $field) {
            if ($request->hasFile($field)) {
                $filePaths[$field . '_path'] = $request->file($field)->store('documents', 'public');
            }
        }

        // Krijo rezervimin
        $booking = Booking::create(array_merge([
            'user_id' => auth()->id(),
            'notary_id' => $request->notary_id,
            'service_type_id' => $request->service_type_id,
            'description' => $request->description,
            'selected_time' => $request->selected_time,

            // Tekste shtesë
            'heir_name' => $request->heir_name,
            'heir_id' => $request->heir_id,
            'property_description' => $request->property_description,
            'authorized_name' => $request->authorized_name,
            'proxy_purpose' => $request->proxy_purpose,
            'declaration_content' => $request->declaration_content,
            'child_name' => $request->child_name,
            'travel_destination' => $request->travel_destination,

            'translated_path' => null,
            'is_translated' => false,
            'signed_path' => null,
            'signature_path' => null,
            'is_signed' => false,
            'is_sealed' => false,
        ], $filePaths));

        session(['booking_id' => $booking->id]);

        $booking->load(['user', 'notary.user', 'serviceType']);

        try {
            Mail::to($booking->user->email)->send(new BookingConfirmation($booking));
        } catch (\Exception $e) {
            \Log::error("Email sending failed: " . $e->getMessage());
        }

        return redirect('/bookings/success')->with('success', 'Rezervimi u bë me sukses');
    }

    // Eksporto PDF
    public function exportPdf($id)
    {
        $booking = Booking::with(['user', 'notary.user', 'serviceType'])->findOrFail($id);
        $pdf = Pdf::loadView('bookings.pdf', compact('booking'));
        return $pdf->download('rezervimi-' . $booking->id . '.pdf');
    }

    // Faqja pas suksesit
    public function success(Request $request)
    {
        $bookingId = session('booking_id');

        if (!$bookingId) {
            abort(404, 'Rezervimi nuk u gjet');
        }

        $booking = Booking::findOrFail($bookingId);

        return view('bookings.success', compact('booking'));
    }
}