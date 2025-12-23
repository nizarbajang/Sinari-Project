@extends('layouts.app')

@section('title', 'Kelola Permintaan Withdraw')

@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Permintaan Withdraw</h6>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>User ID</th>
                            <th>Jumlah</th>
                            <th>Bank Tujuan</th>
                            <th>No. Rekening</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($withdraws as $withdraw)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $withdraw->created_at->format('d M Y H:i') }}</td>
                                <td>{{ $withdraw->user_id }}</td>
                                <td class="font-weight-bold">
                                    Rp {{ number_format($withdraw->amount, 0, ',', '.') }}
                                </td>
                                <td>{{ $withdraw->bank_name }}</td>
                                <td>{{ $withdraw->bank_account }}</td>
                                <td>
                                    <span
                                        class="badge 
                                        @if ($withdraw->status == 'approved') bg-success 
                                        @elseif ($withdraw->status == 'rejected') bg-danger 
                                        @else bg-warning text-dark @endif">
                                        {{ ucfirst($withdraw->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if ($withdraw->status == 'pending')
                                        {{-- Tombol Approve --}}
                                        <form action="{{ route('finance.withdraw.approve', $withdraw->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Yakin ingin menyetujui penarikan ini? Pastikan dana telah ditransfer.');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success me-1">
                                                <i class="fas fa-check"></i> Setujui
                                            </button>
                                        </form>

                                        {{-- Tombol Reject --}}
                                        <form action="{{ route('finance.withdraw.reject', $withdraw->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Yakin ingin menolak penarikan ini? Tindakan ini tidak dapat dibatalkan.');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-sm btn-secondary" disabled>Selesai</button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada permintaan withdraw yang tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center">
                {{ $withdraws->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
