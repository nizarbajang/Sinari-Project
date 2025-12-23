<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function investorProfile(){
        $user = Auth::user();
        return view('investor.profile', compact('user'));
    }
    public function farmerProfile(){
        $user = Auth::user();
        return view('farmer.profile', compact('user'));
    }
     public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validasi
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'phone'     => 'nullable|string|max:20',
            'address'   => 'nullable|string|max:500',
            'avatar'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update avatar jika ada
        if ($request->hasFile('avatar')) {

            // Hapus avatar lama jika ada
            if ($user->avatar && Storage::exists('public/' . $user->avatar)) {
                Storage::delete('public/' . $user->avatar);
            }

            // Simpan avatar baru
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }
        $user->update($validated);

        // Redirect sesuai role
        if ($user->role == 'admin') {
            return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui.');
        }
        if ($user->role == 'investor') {
            return redirect()->route('investor.profile')->with('success', 'Profil berhasil diperbarui.');
        }
        if ($user->role == 'farmer') {
            return redirect()->route('farmer.profile')->with('success', 'Profil berhasil diperbarui.');
        }

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
