@extends('layouts.investor')

@section('page-icon')
    <i class="fas fa-search-dollar me-2"></i>
@endsection

@section('page-title', 'Cari Proyek Investasi')

@section('content')

    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">🔍 Proyek Tersedia untuk Investasi</h1>
        <p class="mb-4 text-muted">Telusuri berbagai proyek peternakan yang sedang membuka unit investasi.</p>

        @if ($availableProjects->isEmpty())
            <div class="alert alert-info text-center shadow">
                <i class="fas fa-bullhorn me-2"></i> Saat ini belum ada proyek baru yang tersedia. Silakan cek kembali nanti!
            </div>
        @else
            <div class="row">
                @foreach ($availableProjects as $project)
                    @php
                        $progressPercentage = ($project->sold_units / $project->total_units) * 100;
                        $slotsAvailable = $project->total_units - $project->sold_units;
                        $firstMedia = $project->media->first();
                    @endphp

                    {{-- Ukuran Card 2 per baris: col-md-6 --}}
                    <div class="col-xl-6 col-md-6 mb-4">
                        <div class="card shadow h-100">
                            <div class="row g-0">
                                {{-- Kolom Gambar (Kiri) --}}
                                <div class="col-md-4">
                                    @if ($firstMedia && $firstMedia->type == 'image')
                                        <img src="{{ asset('storage/' . $firstMedia->url) }}"
                                            class="img-fluid rounded-start" alt="{{ $project->title }}"
                                            style="height: 100%; width: 100%; object-fit: cover;">
                                    @else
                                        <div class="text-center bg-light p-4 rounded-start d-flex align-items-center justify-content-center"
                                            style="height: 100%;">
                                            <i class="fas fa-image fa-3x text-secondary"></i>
                                        </div>
                                    @endif
                                </div>

                                {{-- Kolom Informasi (Kanan) --}}
                                <div class="col-md-8">
                                    <div class="card-body d-flex flex-column h-100">
                                        <h5 class="card-title font-weight-bold text-primary">{{ $project->title }}</h5>
                                        <p class="card-text text-success h6">
                                            Rp {{ number_format($project->price_per_unit, 0, ',', '.') }} / Unit
                                        </p>

                                        <ul class="list-unstyled small mt-2">
                                            <li><i class="fas fa-percent text-info"></i> Profit Bagi Hasil:
                                                **{{ number_format($project->profit_percentage, 0) }}%**</li>
                                            <li><i class="fas fa-money-bill-wave text-success"></i> Total Target Dana: Rp
                                                **{{ number_format($project->total_units * $project->price_per_unit, 0, ',', '.') }}**
                                            </li>
                                        </ul>

                                        {{-- Progress Bar Slot --}}
                                        <small class="text-muted">Slot Terisi: {{ $project->sold_units }} /
                                            {{ $project->total_units }}</small>
                                        <div class="progress mb-3">
                                            <div class="progress-bar bg-primary" role="progressbar"
                                                style="width: {{ $progressPercentage }}%;"
                                                aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0"
                                                aria-valuemax="100">
                                                {{ number_format($progressPercentage, 0) }}%
                                            </div>
                                        </div>

                                        {{-- Informasi Slot Kosong dan Tombol Aksi --}}
                                        <div class="mt-auto d-flex justify-content-between align-items-center">
                                            <span class="text-danger font-weight-bold">
                                                <i class="fas fa-tag"></i> Tersisa: {{ $slotsAvailable }} Unit
                                            </span>
                                            <a href="{{ route('investments.projects.show', $project->id) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="fas fa-hand-holding-usd"></i> Investasi
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $availableProjects->links('pagination::bootstrap-5') }}
            </div>
        @endif

    </div>
@endsection
