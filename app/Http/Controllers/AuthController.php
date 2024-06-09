<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    public function login(Request $request){
    // Validasi input
    $validated = $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string|min:8'
    ]);

    // Coba login dengan kredensial yang diberikan
    if (Auth::attempt($validated)) {
        // Regenerasi session untuk keamanan
        $request->session()->regenerate();

        // Redirect berdasarkan peran pengguna
        $roleRoutes = [
            'admin' => '/admin/',
            'dokter' => '/dokter/',
            'pegawai' => '/pegawai/',
        ];
        $role = Auth::user()->role;
        return isset($roleRoutes[$role])
            ? redirect($roleRoutes[$role])
            : redirect('/home');
    }

    // Gagal login
    return redirect('/login')->with('error', 'Email atau password salah');
}


    public function register(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'address' => 'required',
            'phone' => 'required',
            'password' => 'required|min:8',
        ]);
        $validated["password"] = Hash::make($validated["password"]);
        User::create($validated);
        $request->session()->flash('success', 'Register Berhasil');
        return redirect('/login');

    }
    public function logout(Request $request) :RedirectResponse{
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
