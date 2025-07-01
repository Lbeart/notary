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
        $exists = Booking::where('notary_id', $request->notary_id)
    ->where('appointment_slot_id', $request->appointment_slot_id)
    ->where('selected_time', $request->selected_time)
    ->exists();

if ($exists) {
    return back()->withErrors(['selected_time' => 'Kjo orë është tashmë e rezervuar për këtë noter. Ju lutemi zgjidhni një orë tjetër.'])->withInput();
}
       $request->validate([
        'notary_id' => 'required|exists:notaries,id',
        'appointment_slot_id' => 'required|exists:appointment_slots,id',
        'service_type_id' => 'required|exists:service_types,id',
        'description' => 'nullable|string',
        'selected_time' => 'required|string'
    ]);

    $booking = Booking::create([
        'user_id' => auth()->id(),
        'notary_id' => $request->notary_id,
        'appointment_slot_id' => $request->appointment_slot_id,
        'service_type_id' => $request->service_type_id,
        'description' => $request->description,
         'selected_time' => $request->selected_time // e re
    ]);
   session(['booking_id' => $booking->id]);
    // Ngarko relacionet
    $booking->load(['user', 'notary.user', 'appointmentSlot', 'serviceType']);

    // Provoni me dërgu email, nëse dështoj thjesht vazhdo
    try {
        Mail::to($booking->user->email)->send(new BookingConfirmation($booking));
    } catch (\Exception $e) {
        // Nëse ka problem me email, thjesht mos e dërgo dhe mos e ndërpris ekzekutimin
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
