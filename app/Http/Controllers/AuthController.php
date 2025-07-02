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
            $cities = \App\Models\City::all();
        return view('auth.register',compact('cities'));
    }

  public function register(Request $request)
{
    $request->validate([
    'name' => 'required',
    'email' => 'required|email|unique:users,email',
    'password' => 'required|min:6',
    'role' => 'required|in:user,notary',
    'city_id' => 'required_if:role,notary|exists:cities,id',
    'phone' => 'required_if:role,notary|unique:notaries,phone',
    'address' => 'required_if:role,notary|string|max:255',
], [
    'email.unique' => 'Ky email është në përdorim.',
    'phone.unique' => 'Ky numër telefoni është në përdorim.',
    'city_id.required_if' => 'Qyteti është i detyrueshëm për noterët.',
    'phone.required_if' => 'Telefoni është i detyrueshëm për noterët.',
      'address.required_if' => 'Adresa është e detyrueshme për noterët.',
]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
         'phone' => $request->phone, // Marrim rolin nga forma
    ]);

    // Nëse është noter, mundesh me kriju edhe një Notary record për të:
    if ($request->role === 'notary') {
        \App\Models\Notary::create([
            'user_id' => $user->id,
            'city_id' => $request->city_id,
            'phone' => $request->phone,
             'address' => $request->address,
        ]);
    }

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

