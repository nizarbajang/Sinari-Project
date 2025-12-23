@extends('layouts.app') {{-- Sesuaikan dengan layout admin Anda --}}

@section('title', 'Detail Investasi')

@section('content')

    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Detail Transaksi Investasi</h1>
        <a href="{{ route('admin.investments.index') }}" class="btn btn-sm btn-secondary mb-4">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>

        <div class="row">

            {{-- KOLOM KIRI: RINGKASAN INVESTASI --}}
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Ringkasan Investasi</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Investor</th>
                                <td>{{ $investment->investor->name ?? 'User Dihapus' }} (ID: {{ $investment->user_id }})
                                </td>
                            </tr>
                            <tr>
                                <th>Proyek</th>
                                <td>{{ $investment->project->title ?? 'Proyek Dihapus' }}</td>
                            </tr>
                            <tr>
                                <th>Unit Dibeli</th>
                                <td><span class="h5 font-weight-bold text-info">{{ $investment->units }} Unit</span></td>
                            </tr>
                            <tr>
                                <th>Total Dana</th>
                                <td><span class="h4 font-weight-bold text-success">Rp
                                        {{ number_format($investment->amount, 0, ',', '.') }}</span></td>
                            </tr>
                            <tr>
                                <th>Tanggal Dibuat</th>
                                <td>{{ $investment->transaction->created_at->format('d M Y, H:i') ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Status Investasi</th>
                                <td>
                                    @php
                                        $status = $investment->status;
                                        $badgeClass =
                                            $status == 'paid'
                                                ? 'bg-success'
                                                : ($status == 'pending'
                                                    ? 'bg-warning text-dark'
                                                    : 'bg-danger');
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ strtoupper($status) }}</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: DETAIL TRANSAKSI & AKSI --}}
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Detail Transaksi</h6>
                    </div>
                    <div class="card-body">
                        @if ($investment->transaction)
                            <table class="table table-bordered">
                                <tr>
                                    <th>ID Transaksi</th>
                                    <td>{{ $investment->transaction->id ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Metode</th>
                                    <td>{{ $investment->transaction->payment_method ?? 'Transfer Bank' }}</td>
                                </tr>
                                <tr>
                                    <th>Status Transaksi</th>
                                    <td>
                                        <span
                                            class="badge 
                                            @if ($investment->transaction->status == 'success') bg-success 
                                            @elseif ($investment->transaction->status == 'pending') bg-warning text-dark
                                            @else bg-danger @endif">
                                            {{ strtoupper($investment->transaction->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Waktu Pembayaran</th>
                                    <td>{{ $investment->transaction->created_at?->format('d M Y , H:i') ?? 'Belum Dibayar' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        {{-- Tambahkan link untuk melihat bukti transfer jika ada --}}
                                        <p class="mt-2">Bukti Pembayaran: <a href="#">Lihat Bukti</a></p>
                                    </td>
                                </tr>
                            </table>

                            {{-- Form Aksi Konfirmasi/Batal --}}
                            @if ($investment->status == 'pending')
                                <hr>
                                <h6 class="font-weight-bold mb-3">Aksi Admin:</h6>

                                {{-- Tombol Konfirmasi --}}
                                <form action="{{ route('admin.investments.confirm', $investment->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success me-2"
                                        onclick="return confirm('Yakin ingin mengkonfirmasi pembayaran ini? Sold units akan bertambah!')">
                                        <i class="fas fa-check-circle"></i> Konfirmasi Bayar
                                    </button>
                                </form>

                                {{-- Tombol Batalkan --}}
                                <form action="{{ route('admin.investments.cancel', $investment->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Yakin ingin membatalkan transaksi ini?')">
                                        <i class="fas fa-times-circle"></i> Batalkan
                                    </button>
                                </form>
                            @endif
                        @else
                            <div class="alert alert-warning">Data transaksi (pembayaran) tidak ditemukan.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
