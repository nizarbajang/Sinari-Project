@extends('layouts.farmer')

@section('title', 'Detail Proyek: ' . $project->title)

@section('content')

    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Detail Proyek: {{ $project->title }}</h1>
        <a href="{{ route('farmer.dashboard') }}" class="btn btn-sm btn-secondary mb-4">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>

        <div class="row">
            {{-- KOLOM KIRI: INFO PROYEK & MEDIA --}}
            <div class="col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Proyek</h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Nama Proyek:</strong> {{ $project->title }}</p>
                        <p><strong>Deskripsi:</strong> {{ $project->description }}</p>
                        <p><strong>Target Dana:</strong> Rp
                            {{ number_format($project->total_units * $project->price_per_unit, 0, ',', '.') }}</p>
                        <p><strong>Unit Proyek:</strong> {{ $project->sold_units }} / {{ $project->total_units }}</p>
                        <p><strong>Profit Bagi Hasil:</strong> {{ number_format($project->profit_percentage, 0) }}%</p>
                        <p><strong>Status:</strong>
                            <span
                                class="badge 
                                @if ($project->status == 'active') bg-primary 
                                @elseif ($project->status == 'full') bg-success 
                                @elseif ($project->status == 'finished') bg-info 
                                @else bg-secondary @endif">
                                {{ ucfirst($project->status) }}
                            </span>
                        </p>
                    </div>
                </div>

                {{-- BAGIAN BARU: GALERI MEDIA PROYEK --}}
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">📸 Galeri Media Proyek</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @forelse ($project->media as $media)
                                <div class="col-md-6 mb-3">
                                    <div class="card p-2 text-center border">
                                        @if ($media->type == 'image')
                                            <a href="{{ asset('storage/' . $media->url) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $media->url) }}" class="img-fluid rounded"
                                                    style="max-height: 200px; width: 100%; object-fit: cover;"
                                                    alt="Gambar Proyek">
                                            </a>
                                        @elseif ($media->type == 'video')
                                            {{-- Placeholder untuk video --}}
                                            <i class="fas fa-video fa-5x text-primary d-block my-3"></i>
                                            <a href="{{ asset('storage/' . $media->url) }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary mt-2">
                                                Tonton Video <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        @endif
                                        <small class="d-block mt-2 text-muted">{{ ucfirst($media->type) }}</small>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-warning text-center">Tidak ada foto atau video yang dilampirkan
                                        untuk proyek ini.</div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                {{-- AKHIR BAGIAN GALERI MEDIA --}}

            </div>

            {{-- KOLOM KANAN: AKTIVITAS LAPORAN & LAINNYA --}}
            <div class="col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Aktivitas Laporan</h6>
                    </div>
                    <div class="card-body">
                        <p>Total Laporan: <span class="badge bg-dark">{{ $project->reports->count() }}</span></p>
                        <p>Laporan Terakhir:
                            @if ($project->reports->isNotEmpty())
                                {{ $project->reports->first()->created_at->format('d M Y') }}
                            @else
                                Belum ada
                            @endif
                        </p>
                        <a href="{{ route('reports.create', ['project_id' => $project->id]) ?? '#' }}"
                            class="btn btn-success btn-sm mt-2"><i class="fas fa-plus"></i> Buat Laporan Baru</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
