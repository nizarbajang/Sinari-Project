@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1">

                {{-- Tentukan Judul Berdasarkan Aksi --}}
                <h2 class="mb-4">
                    @if ($user->exists)
                        ✏️ Edit User: {{ $user->name }}
                    @else
                        ➕ Tambah User Baru
                    @endif
                </h2>

                <a href="{{ route('users.index') }}" class="btn btn-secondary mb-3">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar User
                </a>

                <div class="card shadow">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Form Data User</h5>
                    </div>
                    <div class="card-body">

                        {{-- FORM UTAMA --}}
                        <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Override Method untuk Edit --}}
                            @if ($method !== 'POST')
                                @method($method)
                            @endif

                            <div class="row">
                                {{-- Field Nama --}}
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label fw-bold">Nama Lengkap <span
                                            class="text-danger">*</span></label>
                                    {{-- Gunakan old() untuk menjaga input, dan fallback ke nilai user jika ada --}}
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Field Email --}}
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-bold">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Field Role --}}
                                <div class="col-md-6 mb-3">
                                    <label for="role" class="form-label fw-bold">Role Akun <span
                                            class="text-danger">*</span></label>
                                    <select name="role" id="role"
                                        class="form-select @error('role') is-invalid @enderror" required>
                                        <option value="">Pilih Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role }}"
                                                {{ old('role', $user->role) == $role ? 'selected' : '' }}>
                                                {{ ucfirst($role) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Field Status (Hanya muncul saat EDIT) --}}
                                @if ($user->exists)
                                    <div class="col-md-6 mb-3">
                                        <label for="status" class="form-label fw-bold">Status Akun <span
                                                class="text-danger">*</span></label>
                                        <select name="status" id="status"
                                            class="form-select @error('status') is-invalid @enderror" required>
                                            <option value="active"
                                                {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="suspended"
                                                {{ old('status', $user->status) == 'suspended' ? 'selected' : '' }}>
                                                Suspended</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif

                                <hr class="mt-3 mb-3">

                                {{-- Field Password --}}
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label fw-bold">
                                        Password @if (!$user->exists)
                                            <span class="text-danger">*</span>
                                        @else
                                            (Kosongkan jika tidak diubah)
                                        @endif
                                    </label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" @if (!$user->exists) required @endif>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Field Konfirmasi Password --}}
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password
                                        @if (!$user->exists)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" @if (!$user->exists) required @endif>
                                </div>

                                <hr class="mt-3 mb-3">

                                {{-- Field Avatar --}}
                                <div class="col-md-12 mb-3">
                                    <label for="avatar" class="form-label fw-bold">Avatar (Opsional)</label>

                                    @if ($user->avatar)
                                        <div class="mb-2">
                                            Avatar Saat Ini: <img src="{{ asset('storage/' . $user->avatar) }}"
                                                alt="Avatar" class="rounded-circle"
                                                style="width: 50px; height: 50px; object-fit: cover;">
                                        </div>
                                    @endif

                                    <input type="file" class="form-control @error('avatar') is-invalid @enderror"
                                        id="avatar" name="avatar">
                                    <small class="text-muted">Max 2MB. Format: JPG, PNG, GIF. Menggantikan avatar lama jika
                                        ada.</small>
                                    @error('avatar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Field Phone --}}
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label fw-bold">Telepon (Opsional)</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Field Address --}}
                                <div class="col-md-6 mb-3">
                                    <label for="address" class="form-label fw-bold">Alamat (Opsional)</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-2"></i> {{ $user->exists ? 'Update User' : 'Simpan User' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
