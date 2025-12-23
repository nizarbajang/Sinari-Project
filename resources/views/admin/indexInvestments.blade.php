@extends('layouts.app')

@section('title', 'Konfirmasi Investasi')

@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi Investasi</h6>
            <p class="text-muted small mb-0 mt-2">Daftar ini berisi investasi yang perlu dikonfirmasi pembayaran, dibatalkan,
                atau yang sudah selesai diproses.</p>
        </div>
        <div class="card-body">
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

            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Investor</th>
                            <th>Proyek</th>
                            <th>Unit</th>
                            <th>Total Dana</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($investments as $investment)
                            @php
                                // Mengambil totalAmount langsung dari kolom amount di model Investment (jika ada)
                                // Jika tidak ada, gunakan perhitungan seperti sebelumnya:
                                // $totalAmount = $investment->units * ($investment->project->unit_price ?? 0);
                                $totalAmount = $investment->amount; // Asumsi kolom 'amount' tersedia di Investment
                                $status = $investment->status;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $investment->investor->name ?? 'User Dihapus' }}</td>
                                <td>{{ $investment->project->title ?? 'Proyek Dihapus' }}</td>
                                <td>{{ number_format($investment->units) }} Unit</td>
                                <td class="font-weight-bold text-success">
                                    Rp {{ number_format($totalAmount, 0, ',', '.') }}
                                </td>
                                <td>{{ $investment->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    @if ($status == 'pending')
                                        <span class="badge bg-warning text-dark">Menunggu Pembayaran</span>
                                    @elseif ($status == 'paid')
                                        <span class="badge bg-success">Terkonfirmasi (Lunas)</span>
                                    @elseif ($status == 'cancelled' || $status == 'cancceled')
                                        <span class="badge bg-danger">Dibatalkan</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- TOMBOL BARU: LIHAT DETAIL (mengarah ke AdminInvestmentController@detail) --}}
                                    <a href="{{ route('admin.investments.detail', $investment->id) }}"
                                        class="btn btn-sm btn-info me-1" title="Lihat Detail Transaksi">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>

                                    @if ($status == 'pending')
                                        {{-- Tombol Konfirmasi (Bayar) --}}
                                        <form action="{{ route('admin.investments.confirm', $investment->id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Yakin konfirmasi pembayaran investasi ini? Sold units proyek akan bertambah!');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success me-1"
                                                title="Konfirmasi Pembayaran">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>

                                        {{-- Tombol Batalkan --}}
                                        <form action="{{ route('admin.investments.cancel', $investment->id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Yakin ingin MEMBATALKAN investasi ini?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" title="Batalkan Investasi">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada transaksi investasi yang tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center">
                {{ $investments->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
