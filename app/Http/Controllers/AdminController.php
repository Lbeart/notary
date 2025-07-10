<?php

namespace App\Http\Controllers;

use App\Models\Notary;
use App\Models\User;
use App\Models\City;
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

        $latestBookings = Booking::with(['user', 'notary.user', 'serviceType'])
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
        $notaries = Notary::with(['user', 'city'])->paginate(10);
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
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'city_id' => 'required|exists:cities,id',
            'phone' => 'required|string',
            'address' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'notary',
            'phone' => $request->phone,
        ]);

        $notary = Notary::create([
            'user_id' => $user->id,
            'city_id' => $request->city_id,
            'address' => $request->address,
        ]);

        return redirect()->route('admin.notaries.index')->with('success', 'Noteri u krijua me sukses.');
    }

    public function editNotary($id)
    {
        $notary = Notary::with('user')->findOrFail($id);
        $cities = City::all();
        return view('admin.notaries.edit', compact('notary', 'cities'));
    }

    public function updateNotary(Request $request, $id)
    {
        $notary = Notary::with('user')->findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'last_name' => 'required|string',
            'email' => "required|email|unique:users,email,{$notary->user->id}",
            'city_id' => 'required|exists:cities,id',
            'phone' => 'required|string',
            'address' => 'required|string',
        ]);

        $notary->user->update([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        $notary->update([
            'city_id' => $request->city_id,
            'address' => $request->address,
             'phone' => $request->phone, // te Notary
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
        return view('admin.monthly-bookings', ['months' => []]); // placeholder, sepse nuk ka më appointment_slot
    }

    public function bookingsByMonth(Request $request)
    {
        abort(404, 'Kjo veçori është hequr.');
    }
    public function listUsers()
{
    $users = User::where('role', 'user')->latest()->get();
    return view('admin.users.index', compact('users'));
}
public function editUser($id)
{
    $user = User::findOrFail($id);
    return view('admin.users.edit', compact('user'));
}

public function updateUser(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required|string',
        'last_name' => 'required|string',
        'email' => "required|email|unique:users,email,{$id}",
        'phone' => 'nullable|string',
        'password' => 'nullable|min:6', // fjalëkalimi opsional
    ]);

    $data = [
        'name' => $request->name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        'phone' => $request->phone,
    ];

    if ($request->filled('password')) {
        $data['password'] = \Hash::make($request->password);
    }

    $user->update($data);

    return redirect()->route('admin.users.index')->with('success', 'Përdoruesi u përditësua me sukses.');
}

public function destroyUser($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->route('admin.users.index')->with('success', 'Përdoruesi u fshi me sukses.');
}
}
