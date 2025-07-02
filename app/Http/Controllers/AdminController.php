<?php

namespace App\Http\Controllers;

use App\Models\Notary;
use App\Models\User;
use App\Models\City;
use App\Models\AppointmentSlot;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalBookings = Booking::count();
        $totalNotaries = Notary::count();
        $totalUsers = User::where('role', 'user')->count();

        $latestBookings = Booking::with(['user', 'notary.user', 'appointmentSlot', 'serviceType'])
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        $monthlyBookings = [];
        $monthlyNotaries = [];
        $monthlyUsers = [];

        foreach (range(1, 12) as $month) {
            $monthlyBookings[] = Booking::whereMonth('created_at', $month)->count();
            $monthlyNotaries[] = Notary::whereMonth('created_at', $month)->count();
            $monthlyUsers[] = User::where('role', 'user')->whereMonth('created_at', $month)->count();
        }

        return view('admin.dashboard', compact(
            'totalBookings',
            'totalNotaries',
            'totalUsers',
            'latestBookings',
            'months',
            'monthlyBookings',
            'monthlyNotaries',
            'monthlyUsers'
        ));
    }

    public function listNotaries()
    {
        $notaries = Notary::with(['user', 'city', 'appointmentSlots'])->paginate(10);
        return view('admin.notaries.index', compact('notaries'));
    }

    public function createNotary()
    {
        $cities = City::all();
        return view('admin.notaries.create', compact('cities'));
    }

    public function storeNotary(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'city_id' => 'required|exists:cities,id',
            'phone' => 'required|string',
            'address' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'notary',
        ]);

        \Log::info('Notary user created', ['id' => $user->id, 'role' => $user->role]);

        $notary = Notary::create([
            'user_id' => $user->id,
            'city_id' => $request->city_id,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('admin.notaries.index')->with('success', 'Noteri u krijua me sukses.');
    }

    public function editNotary($id)
    {
        $notary = Notary::with('user', 'appointmentSlots')->findOrFail($id);
        $cities = City::all();
        return view('admin.notaries.edit', compact('notary', 'cities'));
    }

    public function updateNotary(Request $request, $id)
    {
        $notary = Notary::with('user')->findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'email' => "required|email|unique:users,email,{$notary->user->id}",
            'city_id' => 'required|exists:cities,id',
            'phone' => 'required|string',
            'address' => 'required|string',
        ]);

        $notary->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $notary->update([
            'city_id' => $request->city_id,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('admin.notaries.index')->with('success', 'Noteri u përditësua me sukses.');
    }

    public function destroyNotary($id)
    {
        $notary = Notary::findOrFail($id);
        $user = $notary->user;

        $notary->delete();
        $user->delete();

        return redirect()->route('admin.notaries.index')->with('success', 'Noteri u fshi me sukses.');
    }

    public function monthlyBookingsSummary()
    {
        $monthlyData = Booking::selectRaw('
                MONTH(appointment_slots.date) as month,
                SUM(client_payments.amount) as total
            ')
            ->join('appointment_slots', 'appointment_slots.id', '=', 'bookings.appointment_slot_id')
            ->join('client_payments', 'client_payments.booking_id', '=', 'bookings.id')
            ->whereYear('appointment_slots.date', 2025)
            ->groupBy('month')
            ->get()
            ->keyBy('month');

        $months = collect(range(1, 12))->map(function ($month) use ($monthlyData) {
            return [
                'month' => $month,
                'name' => \Carbon\Carbon::create()->month($month)->translatedFormat('F'),
                'total' => number_format($monthlyData[$month]->total ?? 0, 2),
            ];
        });

        return view('admin.monthly-bookings', compact('months'));
    }

    public function bookingsByMonth(Request $request)
    {
        $month = $request->query('month');

        if (!$month || $month < 1 || $month > 12) {
            abort(404, 'Muaji nuk është valid.');
        }

        $bookings = Booking::with(['user', 'notary.user', 'appointmentSlot', 'serviceType'])
            ->whereHas('appointmentSlot', function ($query) use ($month) {
                $query->whereMonth('date', $month);
            })
            ->orderByDesc('created_at')
            ->get();

        $monthName = \Carbon\Carbon::create()->month($month)->translatedFormat('F');

        return view('admin.bookings-by-month', compact('bookings', 'monthName', 'month'));
    }
}