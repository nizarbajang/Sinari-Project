<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class AuthController extends Controller
{
    public function showLogin(){
        return view('auth.login');
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(auth()->attempt($credentials)){
            $request->session()->regenerate();

            if(auth()->user()->role === 'admin'){
                return redirect()->route('admin.dashboard');
            }else if(auth()->user()->role === 'investor'){
                return redirect()->route('investor.dashboard');
            }else if(auth()->user()->role === 'farmer'){
                return redirect()->route('farmer.dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records',
        ])->onlyInput('email');
    }
    public function showRegister(){
        return view('auth.register');
    }

    public function register(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required', 
                'string', 
                'confirmed', 
                Password::min(8)
            ],
        ], 
        [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.letters' => 'Password harus mengandung setidaknya satu huruf.',
            'password.mixed' => 'Password harus mengandung huruf besar dan huruf kecil.',
            'password.numbers' => 'Password harus mengandung setidaknya satu angka.',
            'password.symbols' => 'Password harus mengandung setidaknya satu simbol.',
        ]);

        // 3. Buat User Jika Validasi Berhasil
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            // Password harus di-hash sebelum disimpan
            'password' => Hash::make($request->password), 
            // Field Database Opsional (Sesuai Skema Migrasi)
            'phone' => null, 
            'role' => 'farmer', 
            'status' => 'active', 
            'address' => null,
            'avatar' => null,
        ]);
        return redirect()->route('dashboard')->with('success', 'Akun berhasil dibuat!');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }
}
