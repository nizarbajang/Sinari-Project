@extends('layouts.investor')

@section('page-icon')
    <i class="fas fa-search-dollar me-2"></i>
@endsection

@section('page-title', 'Cari Proyek Investasi')

@section('content')
    <div class="container py-2">
        <p class="lead">Pilih proyek yang Anda minati dan mulai berinvestasi.</p>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
            @forelse ($projects as $project)
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <span class="badge bg-primary float-end">{{ $project->animal_type }}</span>
                            <h4 class="card-title">{{ $project->title }}</h4>
                            <p class="text-muted small">Oleh Peternak: **{{ $project->farmer->name ?? 'N/A' }}**</p>
                            <p class="card-text">{{ Str::limit($project->description, 150) }}</p>

                            <ul class="list-group list-group-flush mb-3">
                                <li class="list-group-item">Harga Unit: **Rp
                                    {{ number_format($project->price_per_unit, 0, ',', '.') }}**</li>
                                <li class="list-group-item">Durasi: **{{ $project->duration_months }} bulan**</li>
                                <li class="list-group-item">Profit Sharing Investor: **{{ $project->profit_percentage }}%**
                                </li>
                            </ul>

                            @php
                                $available = $project->total_units - $project->sold_units;
                                $percentage = ($project->sold_units / $project->total_units) * 100;
                            @endphp

                            <p class="mb-1">Unit Terjual: **{{ $project->sold_units }}/{{ $project->total_units }}**
                                (Sisa: **{{ $available }} Unit**)
                            </p>
                            <div class="progress mb-3" role="progressbar" style="height: 15px;">
                                <div class="progress-bar bg-info text-dark" style="width: {{ $percentage }}%">
                                    {{ round($percentage) }}%
                                </div>
                            </div>

                            <a href="{{ route('investments.projects.show', $project->id) }}"
                                class="btn btn-primary w-100">Investasi Sekarang</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning">Saat ini belum ada proyek aktif yang tersedia untuk investasi.</div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
