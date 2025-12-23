@extends('layouts.investor') {{-- Sesuaikan dengan layout Anda --}}

@section('title', 'Detail Transaksi Investasi')
@section('page-title', 'Detail Investasi')

@section('content')

    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Riwayat Detail Transaksi</h1>
        <a href="{{ route('investments.history') }}" class="btn btn-sm btn-secondary mb-4">
            <i class="fas fa-arrow-left"></i> Kembali ke Riwayat Investasi
        </a>

        <div class="row">
            {{-- KOLOM KIRI: RINGKASAN & STATUS --}}
            <div class="col-lg-5">
                <div class="card shadow mb-4">
                    <div
                        class="card-header py-3 
                        @if ($investment->status == 'paid') bg-success 
                        @elseif ($investment->status == 'cancelled' || $investment->status == 'failed') bg-danger 
                        @else bg-primary @endif">
                        <h6 class="m-0 font-weight-bold text-white">Status Investasi</h6>
                    </div>
                    <div class="card-body text-center">
                        <i class="
                            @if ($investment->status == 'paid') fas fa-check-circle text-success 
                            @elseif ($investment->status == 'cancelled' || $investment->status == 'failed') fas fa-times-circle text-danger
                            @else fas fa-question-circle text-secondary @endif"
                            style="font-size: 4rem;"></i>

                        <h2 class="mt-3">
                            <span
                                class="badge 
                                @if ($investment->status == 'paid') bg-success 
                                @elseif ($investment->status == 'cancelled') bg-warning text-dark
                                @elseif ($investment->status == 'failed') bg-danger 
                                @else bg-secondary @endif">
                                {{ strtoupper($investment->status) }}
                            </span>
                        </h2>
                        <p class="text-muted mt-3">Investasi dilakukan pada:
                            {{ $investment->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                {{-- INFORMASI PROYEK --}}
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Proyek</h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Proyek:</strong> {{ $investment->project->title ?? 'Proyek Dihapus' }}</p>
                        <p><strong>Peternak:</strong> {{ $investment->project->farmer->name ?? 'N/A' }}</p>
                        <p><strong>Harga/Unit:</strong> Rp
                            {{ number_format($investment->project->price_per_unit ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: DETAIL TRANSAKSI & JUMLAH --}}
            <div class="col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Detail Jumlah dan Pembayaran</h6>
                    </div>
                    <div class="card-body">

                        <table class="table table-striped">
                            <tr>
                                <th style="width: 40%;">ID Transaksi</th>
                                <td>{{ $investment->transaction->id ?? 'TIDAK TERSEDIA' }}</td>
                            </tr>
                            <tr>
                                <th>Jumlah Unit</th>
                                <td class="font-weight-bold h5">{{ number_format($investment->units, 0, ',', '.') }} Unit
                                </td>
                            </tr>
                            <tr>
                                <th>Total Dana Investasi</th>
                                <td class="font-weight-bold text-success h4">Rp
                                    {{ number_format($investment->amount, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Metode Pembayaran</th>
                                <td>{{ $investment->transaction->payment_method ?? 'Transfer Bank' }}</td>
                            </tr>
                            @if ($investment->status == 'paid')
                                <tr>
                                    <th>Tanggal Pembayaran</th>
                                    <td>{{ $investment->transaction->created_at->format('d M Y, H:i') ?? 'N/A' }}</td>
                                </tr>
                            @endif
                            @if ($investment->status == 'failed' || $investment->status == 'cancelled')
                                <tr>
                                    <th>Keterangan Gagal/Batal</th>
                                    <td>
                                        @if ($investment->status == 'cancelled')
                                            Dibatalkan oleh Investor.
                                        @else
                                            Transaksi gagal/kadaluarsa.
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
