<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Notary;
use App\Models\AppointmentSlot;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
class BookingController extends Controller
{
    // Forma për krijimin e rezervimit
    public function create($id)
    {
        $notary = Notary::with('user')->findOrFail($id);
        $slots = AppointmentSlot::where('notary_id', $id)->get();
           $services = ServiceType::all()->unique('name')->values();

        return view('bookings.create', compact('notary', 'slots', 'services'));
    }

    // Ruajtja e rezervimit
    public function store(Request $request)
{
    // Valido inputet përpara çdo veprimi
    $request->validate([
        'notary_id' => 'required|exists:notaries,id',
        'appointment_slot_id' => 'required|exists:appointment_slots,id',
        'service_type_id' => 'required|exists:service_types,id',
        'description' => 'nullable|string',
        'selected_time' => 'required|string',
        'document' => 'nullable|file|max:2048|mimes:pdf,jpg,jpeg,png,doc,docx',
    ]);

    // Kontrollo nëse ora është e zënë
    $exists = Booking::where('notary_id', $request->notary_id)
        ->where('appointment_slot_id', $request->appointment_slot_id)
        ->where('selected_time', $request->selected_time)
        ->exists();

    if ($exists) {
        return back()->withErrors(['selected_time' => 'Kjo orë është tashmë e rezervuar për këtë noter. Ju lutemi zgjidhni një orë tjetër.'])->withInput();
    }

    // Ruaj dokumentin nëse ekziston
    if ($request->hasFile('document')) {
        $file = $request->file('document');
        $filename = time() . '-' . $file->getClientOriginalName();
        $filePath = $file->storeAs('documents', $filename, 'public');
    } else {
        $filePath = null;
    }

    // Krijo rezervimin
    $booking = Booking::create([
        'user_id' => auth()->id(),
        'notary_id' => $request->notary_id,
        'appointment_slot_id' => $request->appointment_slot_id,
        'service_type_id' => $request->service_type_id,
        'description' => $request->description,
        'selected_time' => $request->selected_time,
        'document_path' => $filePath, // ✅ Kjo është kolona që ke në DB
    ]);

    session(['booking_id' => $booking->id]);

    // Ngarko relacionet për email
    $booking->load(['user', 'notary.user', 'appointmentSlot', 'serviceType']);

    try {
        Mail::to($booking->user->email)->send(new BookingConfirmation($booking));
    } catch (\Exception $e) {
        \Log::error("Email sending failed: " . $e->getMessage());
    }

    return redirect('/bookings/success')->with('success', 'Rezervimi u bë me sukses');
}


    // Eksportimi i rezervimit si PDF


public function exportPdf($id)
{
    $booking = Booking::with(['user', 'notary.user', 'serviceType', 'appointmentSlot'])->findOrFail($id);

    $pdf = Pdf::loadView('bookings.pdf', compact('booking'));

    return $pdf->download('rezervimi-' . $booking->id . '.pdf');
}
public function success(Request $request)
{
    // Merr ID-në e booking nga sesioni (që e ruajmë në store)
    $bookingId = session('booking_id');

    if (!$bookingId) {
        abort(404, 'Rezervimi nuk u gjet');
    }

    $booking = Booking::findOrFail($bookingId);

    return view('bookings.success', compact('booking'));
}
}
