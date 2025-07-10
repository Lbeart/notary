<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Notary;
use App\Models\City;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    public function showLogin()
    {
        $cities = City::all();
        return view('auth.login', compact('cities'));
    }

    public function showRegister()
    {
        $cities = City::all();
        return view('auth.register', compact('cities'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:user,notary',
            'phone' => 'required|string|max:20|unique:users,phone',
            'city_id' => 'nullable|exists:cities,id',
            'address' => 'nullable|string|max:255',
        ], [
            'email.unique' => 'Ky email është në përdorim.',
            'phone.unique' => 'Ky numër telefoni është në përdorim.',
            'last_name.required' => 'Mbiemri është i detyrueshëm.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
        ]);

        if ($request->role === 'notary') {
            if (!$request->city_id || !$request->address) {
                return back()->withErrors(['city_id' => 'Qyteti dhe adresa janë të detyrueshme për noterët.'])->withInput();
            }

            Notary::create([
                'user_id' => $user->id,
                'city_id' => $request->city_id,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);
        }

        // ✅ Triggero eventin për email verifikim
        event(new Registered($user));

        return redirect('/login')->with('success', 'U regjistruat me sukses. Ju lutemi verifikoni emailin tuaj para se të hyni.');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

       if (Auth::attempt($credentials)) {
    $user = Auth::user();

    // Kontrollo nëse nuk është admin dhe nuk e ka verifikuar email-in
    if ($user->role !== 'admin' && !$user->hasVerifiedEmail()) {
        Auth::logout();
        return back()->withErrors(['email' => 'Ju lutem verifikoni email-in para se të hyni në sistem.']);
    }

    // Redirect bazuar në rolin e përdoruesit
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'notary') {
        return redirect()->route('notary.dashboard');
    } elseif ($user->role === 'user') {
        return redirect()->route('home');
    }
}

        return back()->withErrors(['email' => 'Kredencialet janë të pasakta']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
