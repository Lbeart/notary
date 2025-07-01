<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppointmentSlot;

class NotarySlotController extends Controller
{
    public function create()
    {
        return view('notaries.slots.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        AppointmentSlot::create([
            'notary_id' => auth()->user()->notary->id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('notary.dashboard')->with('success', 'Orari u shtua me sukses.');
    }
}
