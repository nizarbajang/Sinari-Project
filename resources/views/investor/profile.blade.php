@extends('layouts.investor')
@section('title', 'Profile Saya')
@section('page-icon')
    <i class="fas fa-user-circle"></i>
@endsection

@section('page-title', 'Profil Saya')

@section('content')
    <div class="container py-3">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="row g-4">

            {{-- Card Profil --}}
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">

                        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default-avatar.png') }}"
                            class="rounded-circle mb-3" width="120" height="120" style="object-fit:cover;">

                        <h5 class="fw-bold">{{ $user->name }}</h5>
                        <p class="text-muted mb-1">{{ ucfirst($user->role) }}</p>
                        <p class="text-muted small">{{ $user->email }}</p>

                    </div>
                </div>
            </div>

            {{-- Form Update Profil --}}
            <div class="col-md-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-bold">Edit Profil</div>
                    <div class="card-body">

                        <form action="{{ route(Auth::user()->role . '.profile.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" value="{{ $user->name }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nomor HP</label>
                                <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea name="address" class="form-control" rows="3">{{ $user->address }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Foto Profil</label>
                                <input type="file" name="avatar" class="form-control">
                                <small class="text-muted">Format: jpg, jpeg, png (max: 2MB)</small>
                            </div>

                            <button class="btn btn-primary w-100">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>

                {{-- Form Update Password --}}
                <div class="card shadow-sm">
                    <div class="card-header fw-bold">Ganti Password</div>
                    <div class="card-body">

                        <form action="" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Password Lama</label>
                                <input type="password" name="old_password" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="new_password" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" name="confirm_new_password" class="form-control" required>
                            </div>

                            <button class="btn btn-warning w-100">Update Password</button>

                        </form>

                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection
