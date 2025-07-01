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
class AdminController extends Controller
{

    public function dashboard()
{
    return view('admin.dashboard', [
        'totalBookings' => Booking::count(),
        'totalNotaries' => Notary::count(),
        'totalUsers' => User::where('role', 'user')->count(),
        'latestBookings' => Booking::with(['user', 'notary.user', 'appointmentSlot', 'serviceType'])
            ->latest()
            ->take(5)
            ->get(),
    ]);
}
    // Lista e notarëve (Read)
    public function listNotaries()
    {
        $notaries = Notary::with(['user', 'city', 'appointmentSlots'])->paginate(10);
        return view('admin.notaries.index', compact('notaries'));
    }

    // Forma për krijim noter (Create - form)
    public function createNotary()
    {
        $cities = City::all();
        return view('admin.notaries.create', compact('cities'));
    }

    // Ruaj noter (Create - store)
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
    'password' => Hash::make($request->password), // Këtu bëhet hash i passwordit
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

    // Forma për edit (Update - form)
    public function editNotary($id)
    {
        $notary = Notary::with('user', 'appointmentSlots')->findOrFail($id);
        $cities = City::all();
        return view('admin.notaries.edit', compact('notary', 'cities'));
    }

    // Përditëso noterin (Update - save)
    public function updateNotary(Request $request, $id)
    {
        $notary = Notary::with('user')->findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'email' => "required|email|unique:users,email,{$notary->user->id}",
            'city_id' => 'required|exists:cities,id',
            'phone' => 'required|string',
            'address' => 'required|string',
            // slots validation mund të shtohet sipas nevojës
        ]);

        // Përditëso userin
        $notary->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Përditëso noterin
        $notary->update([
            'city_id' => $request->city_id,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        // Përditëso slots: mund të implementosh si do, ja një shembull i thjeshtë që fshin të gjitha dhe shton të reja:
    

       
        return redirect()->route('admin.notaries.index')->with('success', 'Noteri u përditësua me sukses.');
    }

    // Fshi noterin (Delete)
    public function destroyNotary($id)
    {
        $notary = Notary::findOrFail($id);
        $user = $notary->user;

   

        // Fshi noterin
        $notary->delete();

        // Fshi userin
        $user->delete();

        return redirect()->route('admin.notaries.index')->with('success', 'Noteri u fshi me sukses.');
    }


    
}
