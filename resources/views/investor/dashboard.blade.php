@extends('layouts.investor') {{-- Sesuaikan dengan layout Anda --}}

@section('title', 'Dashboard Investor')
@section('page-title', 'Dashboard Investor')

@section('content')

    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">📊 Ringkasan Investasi Anda</h1>

        {{-- BAGIAN 1: KOTAK STATISTIK UTAMA --}}
        <div class="row">

            {{-- Total Dana Investasi --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Dana Investasi (Dibayar)
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    Rp {{ number_format($totalInvestment, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-wallet fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Transaksi Pending --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Transaksi Pending
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $pendingTransactions }} Transaksi
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Jumlah Proyek Diinvestasikan --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Proyek Diinvestasikan
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $investedProjects }} Proyek
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Estimasi Keuntungan --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Estimasi Total Keuntungan (Gross)
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    Rp {{ number_format($estimasiKeuntungan, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-funnel-dollar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <hr>

        {{-- BAGIAN 2: DAFTAR PROYEK YANG TERSEDIA --}}
        <h2 class="h4 mt-4 mb-3 text-gray-800">💰 Proyek Siap Investasi</h2>

        @if ($availableProjects->isEmpty())
            <div class="alert alert-info text-center shadow">
                <i class="fas fa-bullhorn me-2"></i> Mohon maaf, saat ini belum ada proyek baru yang tersedia untuk
                investasi.
            </div>
        @else
            <div class="row">
                @foreach ($availableProjects as $project)
                    @php
                        $slotsAvailable = $project->total_units - $project->sold_units;
                        $progressPercentage = ($project->sold_units / $project->total_units) * 100;
                        $firstMedia = $project->media->first();
                    @endphp

                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card shadow h-100">
                            {{-- Gambar Proyek --}}
                            @if ($firstMedia && $firstMedia->type == 'image')
                                <img src="{{ asset('storage/' . $firstMedia->url) }}" class="card-img-top"
                                    alt="{{ $project->title }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="text-center bg-light p-5 rounded-top" style="height: 200px;">
                                    <i class="fas fa-box-open fa-3x text-secondary mt-4"></i>
                                    <p class="text-muted mt-2">Gambar Tidak Tersedia</p>
                                </div>
                            @endif

                            <div class="card-body">
                                {{-- Judul dan Harga --}}
                                <h5 class="card-title font-weight-bold text-primary">{{ $project->title }}</h5>
                                <p class="card-text text-success h6">
                                    Rp {{ number_format($project->price_per_unit, 0, ',', '.') }} / Unit
                                </p>
                                <p class="card-text text-sm mb-1">Profit Investor:
                                    **{{ number_format($project->profit_percentage, 0) }}%**</p>

                                {{-- Progress Bar --}}
                                <small class="text-muted">Slot Terisi: {{ $project->sold_units }} /
                                    {{ $project->total_units }}</small>
                                <div class="progress mb-3">
                                    <div class="progress-bar bg-primary" role="progressbar"
                                        style="width: {{ $progressPercentage }}%;"
                                        aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ number_format($progressPercentage, 0) }}% Terisi
                                    </div>
                                </div>

                                {{-- Informasi Slot Kosong --}}
                                <p class="text-danger small font-weight-bold">
                                    <i class="fas fa-tag"></i> Tersisa: {{ $slotsAvailable }} Unit
                                </p>

                                {{-- Tombol Aksi --}}
                                <a href="{{ route('investments.projects.show', $project->id) }}}}"
                                    class="btn btn-primary btn-block">
                                    <i class="fas fa-search"></i> Lihat Detail & Investasi
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
@endsection
