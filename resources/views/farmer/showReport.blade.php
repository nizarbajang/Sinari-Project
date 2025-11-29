@extends('layouts.farmer')

@section('content')
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Detail Laporan Proyek</h3>
            <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                &larr; Kembali
            </a>
        </div>

        {{-- Informasi Proyek --}}
        <div class="card mb-4">
            <div class="card-header">
                <strong>Informasi Proyek</strong>
            </div>
            <div class="card-body">
                <p><strong>Nama Proyek:</strong> {{ $report->project->title }}</p>
                <p><strong>Tanggal Laporan:</strong> {{ $report->created_at->format('d M Y, H:i') }}</p>
            </div>
        </div>

        {{-- Detail Laporan --}}
        <div class="card mb-4">
            <div class="card-header">
                <strong>Data Laporan</strong>
            </div>
            <div class="card-body">
                <p><strong>Berat (kg):</strong> {{ $report->weight ?? '-' }}</p>
                <p><strong>Kondisi Kesehatan:</strong> {{ $report->health_status ?? '-' }}</p>
                <p><strong>Catatan:</strong></p>
                <p>{{ $report->notes ?? '-' }}</p>
            </div>
        </div>

        {{-- Media Foto / Video --}}
        <div class="card">
            <div class="card-header">
                <strong>Media (Foto / Video)</strong>
            </div>
            <div class="card-body">

                @if ($report->media->count() > 0)
                    <div class="row">
                        @foreach ($report->media as $media)
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    @if ($media->type == 'image')
                                        <img src="{{ asset('storage/' . $media->url) }}" class="card-img-top"
                                            alt="Media">
                                    @else
                                        <video controls class="w-100">
                                            <source src="{{ asset('storage/' . $media->url) }}" type="video/mp4">
                                        </video>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">Tidak ada media yang diunggah.</p>
                @endif

            </div>
        </div>

    </div>
@endsection
