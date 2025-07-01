<?php

use App\Models\AppointmentSlot;
use App\Http\Controllers\Controller;
class AppointmentSlotController extends Controller
{
    public function showByNotary($notaryId)
    {
        $slots = AppointmentSlot::where('notary_id', $notaryId)
            ->where('is_booked', false)
            ->orderBy('date')
            ->get();

        return view('slots.index', compact('slots'));
    }
}
