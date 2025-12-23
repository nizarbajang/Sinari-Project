<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request){
        // Mulai query
        $query = User::orderBy('id', 'desc');

        // 1. Logika Pencarian (Search by Name or Email)
        if ($request->filled('keyword')) {
            $keyword = $request->get('keyword');
            $query->where(function($q) use ($keyword) {
                // Cari di kolom 'name' ATAU 'email'
                $q->where('name', 'like', '%' . $keyword . '%')
                  ->orWhere('email', 'like', '%' . $keyword . '%');
            });
        }

        // 2. Logika Filter Role
        if ($request->filled('role')) {
            $role = $request->get('role');
            // Pastikan role yang difilter valid
            if (in_array($role, ['admin', 'investor', 'farmer'])) {
                $query->where('role', $role);
            }
        }

        // Ambil hasil query dengan pagination
        $users = $query->paginate(10);
        // Tambahkan parameter query string (keyword dan role) ke pagination links
        $users->appends($request->query());
        return view('admin.user', compact('users'));
    }

    public function create(){
        $user = new User();
        $roles = ['admin', 'investor', 'farmer'];

        return view('admin.kelolaUser', [
            'user' => $user,
            'roles' => $roles,
            'action' => route('users.store'),
            'method' => 'POST']);
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', 'string', Rule::in(['admin', 'investor', 'farmer'])],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $avatarPath = $this->handleAvatarUpload($request);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
            'avatar' => $avatarPath, // Simpan path avatar
            'email_verified_at' => now(),
            'status' => 'active',
        ]);

        // 4. Redirect dengan pesan sukses
        return redirect()->route('users.index')
                         ->with('success', 'User ' . $user->name . ' berhasil ditambahkan.');
    }

    public function edit(User $user){
        $roles = ['admin', 'investor', 'farmer'];

        return view('admin.kelolaUser', [
            'user' => $user,
            'roles' => $roles,
            'action' => route('users.update', $user),
            'method' => 'PUT',
        ]);
    }

    public function update(Request $request, User $user){
        // 1. Validasi Data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => ['required', 'string', Rule::in(['admin', 'investor', 'farmer'])],
            'status' => ['required', 'string', Rule::in(['active', 'suspended'])], // Tambahkan validasi status
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $avatarPath = $this->handleAvatarUpload($request, $user);
        $updateData = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'role' => $validatedData['role'],
            'status' => $validatedData['status'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'], 
        ];

        if($avatarPath !== null){
            $updateData['avatar'] = $avatarPath;
        }

        if($request->filled('password')){
            $updateData['password'] = Hash::make($validatedData['password']);
        }

        $user->update($updateData);
        return redirect()->route('users.index')->with('success', 'Data Berhasil Diperbarui');
    }

    public function destroy(User $user)
    {
        // Opsional: Cek apakah user mencoba menghapus dirinya sendiri
        if (auth()->id() === $user->id) {
             return redirect()->route('admin.users.index')
                             ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Hapus file avatar lama dari storage sebelum menghapus user
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }
        
        // Hapus User (cascadeOnDelete akan menghapus data terkait di Projects, Investments, dll.)
        $user->delete();

        // 3. Redirect dengan pesan sukses
        return redirect()->route('admin.users.index')
                         ->with('success', 'User ' . $user->name . ' berhasil dihapus.');
    }

    public function updateStatus(Request $request, User $user)
    {
        // Validasi status
        $request->validate([
            'status' => ['required', Rule::in(['active', 'suspended'])],
        ]);

        // Cek apakah user mencoba suspend dirinya sendiri
        if (auth()->id() === $user->id && $request->status === 'suspended') {
             return redirect()->route('users.index')
                             ->with('error', 'Anda tidak dapat men-suspend akun Anda sendiri.');
        }

        // Update Status
        $user->update([
            'status' => $request->status
        ]);

        // Redirect
        $message = ($request->status == 'active') 
            ? 'User ' . $user->name . ' berhasil diaktifkan kembali.' 
            : 'User ' . $user->name . ' berhasil disuspend.';

        return redirect()->route('users.index')
                         ->with('success', $message);
    }
    private function handleAvatarUpload(Request $request, User $user = null): ?string
    {
        // Cek apakah ada file 'avatar' yang diupload
        if ($request->hasFile('avatar')) {
            // 1. Hapus file lama jika ini adalah proses update
            if ($user && $user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            // 2. Simpan file baru
            // Store di folder 'avatars' pada disk 'public'
            $path = $request->file('avatar')->store('avatars', 'public');
            
            return $path;
        }

        return null;
    }
}
