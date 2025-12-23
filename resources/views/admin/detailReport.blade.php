@extends('layouts.app')

@section('title', 'Detail Laporan Proyek')

@section('content')

    <div class="row">
        <div class="col-lg-12">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Laporan #{{ $report->id }}</h6>
                    <a href="{{ route('admin.reports.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                            <h5><i class="fas fa-info-circle"></i> Informasi Umum</h5>
                            <hr>
                            <p><strong>Proyek:</strong> {{ $report->project->title ?? 'N/A' }}</p>
                            <p><strong>Peternak:</strong> {{ $report->farmer->name ?? 'N/A' }}</p>
                            <p><strong>Tanggal Laporan:</strong> {{ $report->created_at->format('d M Y, H:i') }}</p>
                            <p><strong>Status Verifikasi:</strong>
                                @if (str_contains($report->notes ?? '', '[Verified by admin]'))
                                    <span class="badge bg-success">Sudah Diverifikasi</span>
                                @else
                                    <span class="badge bg-warning text-dark">Belum Diverifikasi</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h5><i class="fas fa-bullseye"></i> Data Hewan</h5>
                            <hr>
                            <p><strong>Perkiraan Berat:</strong>
                                {{ $report->weight ? number_format($report->weight, 2) . ' kg' : 'N/A' }}</p>
                            <p><strong>Status Kesehatan:</strong>
                                <span class="badge bg-primary">{{ $report->health_status ?? 'N/A' }}</span>
                            </p>
                        </div>
                    </div>

                    <h5 class="mt-4"><i class="fas fa-sticky-note"></i> Catatan Peternak</h5>
                    <hr>
                    <div class="border p-3 bg-light rounded mb-4">
                        <p class="mb-0">{!! nl2br(e($report->notes ?? 'Tidak ada catatan dari peternak.')) !!}</p>
                    </div>

                    <h5 class="mt-4"><i class="fas fa-images"></i> Media Pendukung</h5>
                    <hr>
                    <div class="row">
                        @forelse ($report->media as $media)
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-body p-2 text-center">
                                        @if ($media->type == 'image')
                                            <a href="{{ asset('storage/' . $media->url) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $media->url) }}" class="img-fluid rounded"
                                                    style="max-height: 150px; width: 100%; object-fit: cover;"
                                                    alt="Gambar Laporan">
                                            </a>
                                        @elseif ($media->type == 'video')
                                            <i class="fas fa-video fa-5x text-secondary d-block my-3"></i>
                                            <a href="{{ asset('storage/' . $media->url) }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary mt-2">
                                                Lihat Video <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        @endif
                                        <small class="d-block mt-2 text-muted">{{ ucfirst($media->type) }}</small>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-muted">Tidak ada media (foto/video) yang dilampirkan.</p>
                            </div>
                        @endforelse
                    </div>

                    <h5 class="mt-4"><i class="fas fa-check-circle"></i> Aksi Admin</h5>
                    <hr>
                    @if (!str_contains($report->notes ?? '', '[Verified by admin]'))
                        <form action="{{ route('admin.reports.verify', $report->id) }}" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin memverifikasi laporan ini? Verifikasi akan menambahkan catatan ke laporan.');">
                            @csrf
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-check"></i> Verifikasi Laporan Ini
                            </button>
                        </form>
                    @else
                        <button class="btn btn-success btn-lg" disabled>
                            <i class="fas fa-check-double"></i> Laporan Sudah Diverifikasi
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
