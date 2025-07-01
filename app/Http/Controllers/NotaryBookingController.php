<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class NotaryBookingController extends Controller
{
    public function downloadPdf($id)
    {
        $booking = Booking::with(['user', 'appointmentSlot', 'notary.user'])->findOrFail($id);

        if (Auth::id() !== $booking->notary->user_id) {
            abort(403, 'Nuk keni qasje në këtë rezervim.');
        }

        $pdf = Pdf::loadView('notaries.pdf.booking', compact('booking'));

        return $pdf->download('rezervimi-'.$booking->id.'.pdf');
    }
}