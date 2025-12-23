@extends('layouts.investor') {{-- Sesuaikan dengan layout Anda --}}

@section('title', 'Detail Laporan: ' . $report->project->title ?? 'N/A')
@section('page-icon')
    <i class="fas fa-file-alt me-2"></i>
@endsection

@section('page-title', 'Laporan Peternak')

@section('content')

    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">📋 Detail Laporan Perkembangan</h1>

        <a href="{{ route('investor.reports.index') }}" class="btn btn-sm btn-secondary mb-4">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Laporan
        </a>

        <div class="row">

            {{-- KOLOM KIRI: RINGKASAN & DETAIL LAPORAN --}}
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-primary">
                        <h6 class="m-0 font-weight-bold text-white">Laporan Proyek:
                            {{ $report->project->title ?? 'Proyek Dihapus' }}</h6>
                    </div>
                    <div class="card-body">

                        <p class="text-muted small">Dilaporkan pada: **{{ $report->created_at->format('d F Y, H:i') }}**</p>
                        <hr>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <h5><i class="fas fa-heartbeat text-success me-2"></i> Status Kesehatan</h5>
                                <p class="h4 font-weight-bold text-success">{{ $report->health_status ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h5><i class="fas fa-balance-scale text-info me-2"></i> Perkiraan Berat</h5>
                                <p class="h4 font-weight-bold text-info">
                                    {{ $report->weight ? number_format($report->weight, 2) . ' kg' : 'N/A' }}
                                </p>
                            </div>
                        </div>

                        <h5 class="mt-3"><i class="fas fa-clipboard-list text-primary me-2"></i> Catatan Peternak</h5>
                        <div class="p-3 border rounded bg-light">
                            <p style="white-space: pre-wrap;">
                                {{ $report->notes ?? 'Peternak tidak melampirkan catatan tambahan.' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: GALERI MEDIA --}}
            <div class="col-lg-4">
                <div class="card shadow mb-4 sticky-top" style="top: 20px;">
                    <div class="card-header py-3 bg-warning">
                        <h6 class="m-0 font-weight-bold text-dark">📷 Bukti Dokumentasi</h6>
                    </div>
                    <div class="card-body">
                        @forelse ($report->media as $media)
                            <div class="mb-3 text-center border p-2 rounded">
                                @if ($media->type == 'image')
                                    <a href="{{ asset('storage/' . $media->url) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $media->url) }}" class="img-fluid rounded"
                                            style="max-height: 150px; width: 100%; object-fit: cover;" alt="Gambar Laporan">
                                    </a>
                                    <small class="text-muted mt-1 d-block">Gambar</small>
                                @elseif ($media->type == 'video')
                                    <i class="fas fa-video fa-3x text-primary d-block my-2"></i>
                                    <a href="{{ asset('storage/' . $media->url) }}" target="_blank"
                                        class="btn btn-sm btn-outline-primary mt-1">
                                        Tonton Video <i class="fas fa-external-link-alt"></i>
                                    </a>
                                    <small class="text-muted mt-1 d-block">Video</small>
                                @else
                                    <small class="text-danger">File Tidak Dikenal</small>
                                @endif
                            </div>
                        @empty
                            <div class="alert alert-info text-center small">
                                Tidak ada foto atau video yang dilampirkan pada laporan ini.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
