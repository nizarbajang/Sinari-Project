@extends('layouts.investor')

@section('page-icon')
    <i class="fas fa-tachometer-alt me-2"></i>
@endsection

@section('page-title', 'Dashboard Utama')

@section('content')
    <div class="container py-4">
        <div class="row">
            {{-- Kartu Ringkasan Investasi (Data dari DashboardController) --}}
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Total Nilai Investasi Aktif</div>
                    <div class="card-body">
                        <h2 class="card-title">Rp {{ number_format($totalInvested, 0, ',', '.') }}</h2>
                        <p class="card-text">{{ $activeInvestmentsCount ?? 0 }} Proyek Aktif</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Dana Menunggu Pembayaran</div>
                    <div class="card-body">
                        <h2 class="card-title">Rp {{ number_format($pendingAmount, 0, ',', '.') }}</h2>
                        <p class="card-text">{{ $pendingInvestmentsCount ?? 0 }} Transaksi Pending</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-white bg-info mb-3">
                    <div class="card-header">Potensi Keuntungan (Est.)</div>
                    <div class="card-body">
                        <h2 class="card-title">Rp {{ number_format($estimatedProfit, 0, ',', '.') }}</h2>
                        <p class="card-text">Berdasarkan profit sharing</p>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        {{-- Bagian Proyek Terbaru --}}
        <h3 class="mt-4 mb-3">✨ Proyek Peternakan Terbaru</h3>

        @forelse ($latestProjects as $project)
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="card-title">{{ $project->title }} ({{ $project->animal_type }})</h4>
                            <p class="card-text text-muted">{{ Str::limit($project->description, 100) }}</p>
                            <p class="mb-1">Harga Unit: **Rp {{ number_format($project->price_per_unit, 0, ',', '.') }}**
                            </p>
                            <p>Durasi: **{{ $project->duration_months }} bulan** | Profit Share:
                                **{{ $project->profit_percentage }}%**</p>
                        </div>
                        <div class="col-md-4 text-end">
                            @php
                                $available = $project->total_units - $project->sold_units;
                                $percentage = ($project->sold_units / $project->total_units) * 100;
                            @endphp
                            <p class="mb-1">Terjual: **{{ $project->sold_units }}/{{ $project->total_units }} Unit**</p>
                            <div class="progress mb-2" role="progressbar" style="height: 10px;">
                                <div class="progress-bar bg-primary" style="width: {{ $percentage }}%"></div>
                            </div>
                            <a href="{{ route('investments.projects.show', $project->id) }}"
                                class="btn btn-primary mt-2">Lihat Detail & Investasi</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info">Belum ada proyek aktif saat ini.</div>
        @endforelse

        <div class="text-center mt-4">
            <a href="{{ route('investments.projects.index') }}" class="btn btn-outline-secondary">Lihat Semua
                Proyek</a>
            <a href="{{ route('investments.history') }}" class="btn btn-outline-success">Lihat Riwayat
                Investasi</a>
        </div>

    </div>
@endsection
