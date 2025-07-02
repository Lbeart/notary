<?php 
namespace App\Http\Controllers;

use App\Models\Notary;
use App\Models\City;
use Illuminate\Http\Request;

class NotaryController extends Controller
{
public function dashboard()
{
    $notary = auth()->user()->notary;

    $today = \Carbon\Carbon::today();

    // Orari i sotëm
    $appointmentSlots = $notary->appointmentSlots()
        ->whereDate('date', $today)
        ->orderBy('date', 'asc')
        ->get();

    // Rezervimet e sotme
    $bookings = \App\Models\Booking::with(['user', 'appointmentSlot'])
        ->where('notary_id', $notary->id)
        ->whereHas('appointmentSlot', function ($query) use ($today) {
            $query->whereDate('date', $today);
        })
        ->orderBy('appointment_slot_id', 'asc')
        ->get();

    return view('notaries.dashboard', compact('appointmentSlots', 'bookings'));
}

    public function index(Request $request)
    {
        // Merr të gjitha qytetet, veçanërisht unikët sipas emrit (nëse ka ndonjë dyfishim)
        $cities = City::all()->unique('name')->values();

        // Merr noteret, me lidhjet e nevojshme user dhe city
        // Nëse ka filtrim për qytet, filtro sipas city_id
        $notaries = Notary::with('user', 'city')
            ->when($request->city, function ($query, $cityId) {
                $query->where('city_id', $cityId);
            })
            ->get();

        // Kthe view me të dhënat
        return view('home', compact('notaries', 'cities'));
    }

    public function show($id)
    {
        // Gjej noterin me user dhe city
        $notary = Notary::with('user', 'city')->findOrFail($id);

        return view('notaries.show', compact('notary'));
    }
}
