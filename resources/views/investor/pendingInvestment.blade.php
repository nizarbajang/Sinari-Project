@extends('layouts.investor')

@section('page-icon')
    <i class="fas fa-hourglass-half me-2"></i>
@endsection

@section('page-title', 'Pembayaran Pending')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center shadow-lg border-warning">
                    <div class="card-header bg-warning text-dark">
                        Pembayaran Menunggu Konfirmasi
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <h2 class="card-title text-danger">Total Pembayaran: Rp
                            {{ number_format($investment->amount, 0, ',', '.') }}</h2>
                        <p class="lead">
                            Anda telah berhasil membuat pesanan investasi untuk proyek **{{ $investment->project->title }}**
                            sebanyak **{{ $investment->units }} unit**.
                        </p>

                        <hr>

                        <p>Nomor Transaksi: **TRX-{{ $investment->transaction->id }}**</p>
                        <p>Status: **{{ strtoupper($investment->status) }}**</p>

                        <h4 class="mt-4">Langkah Selanjutnya: Selesaikan Pembayaran</h4>

                        <div class="alert alert-primary">
                            **[Tombol Integrasi Payment Gateway]** <br>
                            Di sini Anda akan menempatkan tombol/link yang mengarahkan user ke Payment Gateway.
                        </div>

                        <p class="text-muted small">Jika pembayaran telah berhasil, status investasi Anda akan otomatis
                            diperbarui.</p>
                    </div>
                    <div class="card-footer text-muted">
                        <form action="{{ route('investments.cancel', $investment->id) }}" method="POST"
                            onsubmit="return confirm('Anda yakin ingin membatalkan transaksi ini? Proses ini tidak dapat diulang.');"
                            class="mt-4">
                            @csrf
                            <button type="submit" class="btn btn-danger "><i class="fas fa-times me-2"></i> Batalkan
                                Transaksi</button>
                        </form>
                        <a href="{{ route('investments.history') }}" class="btn btn-primary my-2">Lihat
                            Riwayat Transaksi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
