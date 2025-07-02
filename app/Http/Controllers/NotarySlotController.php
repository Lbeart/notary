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

    public function edit($id)
    {
        $slot = AppointmentSlot::findOrFail($id);

        if ($slot->notary_id !== auth()->user()->notary->id) {
            abort(403, 'Nuk ke leje për ta edituar këtë orar.');
        }

        return view('notaries.slots.edit', compact('slot'));
    }

   public function update(Request $request, $id)
{
    $request->validate([
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
    ]);

    $slot = AppointmentSlot::findOrFail($id);

    if ($slot->notary_id !== auth()->user()->notary->id) {
        abort(403, 'Nuk ke leje për këtë orar.');
    }

    $slot->start_time = $request->start_time;
    $slot->end_time = $request->end_time;
    $slot->save();

    return redirect()->route('notary.dashboard')->with('success', 'Orari u përditësua me sukses.');
}

    public function destroy($id)
    {
        $slot = AppointmentSlot::findOrFail($id);

        if ($slot->notary_id !== auth()->user()->notary->id) {
            abort(403, 'Nuk ke leje për ta fshirë këtë orar.');
        }

        $slot->delete();

        return redirect()->route('notary.dashboard')->with('success', 'Orari u fshi me sukses.');
    }
}
