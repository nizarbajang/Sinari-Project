@extends('layouts.app')

@section('title', 'Kelola Laporan Proyek')

@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Laporan Proyek Peternak</h6>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Proyek</th>
                            <th>Peternak</th>
                            <th>Status Kesehatan</th>
                            <th>Tanggal Laporan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reports as $report)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $report->project->title ?? 'N/A' }}</td>
                                <td>{{ $report->farmer->name ?? 'N/A' }}</td>
                                <td>{{ $report->health_status ?? 'Tidak ada data' }}</td>
                                <td>{{ $report->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.reports.show', $report->id) }}"
                                        class="btn btn-sm btn-info me-2">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada laporan yang tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center">
                {{ $reports->links() }}
            </div>
        </div>
    </div>
@endsection
