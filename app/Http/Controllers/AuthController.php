<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        return redirect('/login')->with('success', 'U regjistruat me sukses');
    }

   public function login(Request $request)
{

      $credentials = $request->only('email', 'password');
if (Auth::attempt($credentials)) {
    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'notary') {
        return redirect()->route('notary.dashboard');
    } else {
        return redirect()->route('home');
    }
     return back()->withErrors(['email' => 'Kredencialet janë të pasakta']);
}

    return back()->withErrors(['email' => 'Kredencialet janë të pasakta']);
}
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}

