@extends('layouts.app')


@section('content')
    {{-- Konten Kelola User --}}
    <div class="container-fluid">
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Daftar User Terdaftar</h5>
                {{-- Tombol Tambah User --}}
                <a href="{{ route('users.create') }}" class="btn btn-primary-custom">
                    <i class="fas fa-user-plus me-2"></i> Tambah User
                </a>
            </div>

            <div class="card-body">
                {{-- Pesan Sukses/Error --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Form Pencarian dan Filter Role --}}
                <form action="{{ route('users.index') }}" method="GET" class="row g-3 mb-4 align-items-center">
                    <div class="col-md-5">
                        <input type="text" name="keyword" class="form-control" placeholder="Cari Nama atau Email..."
                            value="{{ request('keyword') }}" />
                    </div>
                    <div class="col-md-3">
                        <select name="role" class="form-select">
                            <option value="">-- Filter Role --</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="investor" {{ request('role') == 'investor' ? 'selected' : '' }}>Investor</option>
                            <option value="farmer" {{ request('role') == 'farmer' ? 'selected' : '' }}>Farmer</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-info text-white w-100"><i class="fas fa-search"></i>
                            Cari</button>
                    </div>
                    @if (request('keyword') || request('role'))
                        <div class="col-md-2">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary w-100"><i
                                    class="fas fa-sync-alt"></i> Reset</a>
                        </div>
                    @endif
                </form>

                {{-- Tabel Data User --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Avatar</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Role</th> {{-- Menggantikan 'Status Investasi' dengan Role yang lebih universal --}}
                                <th>Status Akun</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                    <td>
                                        @if ($user->avatar)
                                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar"
                                                class="rounded-circle"
                                                style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <i class="fas fa-user-circle fa-2x text-muted"></i>
                                        @endif
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        {{-- Badge Role --}}
                                        @php
                                            $roleClass = 'badge bg-secondary';
                                            if ($user->role === 'admin') {
                                                $roleClass = 'bg-primary';
                                            } elseif ($user->role === 'investor') {
                                                $roleClass = 'bg-success';
                                            } elseif ($user->role === 'farmer') {
                                                $roleClass = 'bg-warning';
                                            }
                                        @endphp
                                        <span class="badge {{ $roleClass }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td>
                                        {{-- Badge Status Akun --}}
                                        @if ($user->status === 'active')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Suspend</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{-- Tombol Edit (Arahkan ke edit.blade.php) --}}
                                        <a href="{{ route('users.edit', $user) }}"
                                            class="btn btn-sm btn-info text-white me-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- Tombol Aksi Suspend/Aktifkan --}}
                                        @if ($user->status === 'active')
                                            <button class="btn btn-sm btn-warning text-dark"
                                                onclick="if(confirm('Yakin ingin men-suspend {{ $user->name }}?')) { document.getElementById('suspend-form-{{ $user->id }}').submit(); }">
                                                <i class="fas fa-ban"></i> Suspend
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-success"
                                                onclick="if(confirm('Yakin ingin mengaktifkan {{ $user->name }}?')) { document.getElementById('activate-form-{{ $user->id }}').submit(); }">
                                                <i class="fas fa-check-circle"></i> Aktifkan
                                            </button>
                                        @endif

                                        {{-- Form Tersembunyi untuk Aksi Suspend/Aktifkan --}}
                                        {{-- Catatan: Anda perlu membuat route dan fungsi di controller untuk menangani status update ini --}}
                                        <form id="suspend-form-{{ $user->id }}"
                                            action="{{ route('users.updateStatus', $user) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="suspended">
                                        </form>
                                        <form id="activate-form-{{ $user->id }}"
                                            action="{{ route('users.updateStatus', $user) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="active">
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data pengguna yang ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center">
                    {{ $users->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
