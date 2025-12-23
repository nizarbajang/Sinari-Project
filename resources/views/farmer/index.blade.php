@extends('layouts.farmer')

@section('title', 'Daftar Semua Laporan Saya')

@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">📑 Riwayat Laporan Perkembangan Proyek</h6>
            <a href="{{ route('reports.create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i> Buat Laporan Baru
            </a>
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
                            <th>Tanggal Laporan</th>
                            <th>Status Kesehatan</th>
                            <th>Status Admin</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reports as $report)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="font-weight-bold">{{ $report->project->title ?? 'N/A' }}</td>
                                <td>{{ $report->created_at->format('d M Y H:i') }}</td>
                                <td>{{ $report->health_status ?? 'N/A' }}</td>
                                <td>
                                    @if (str_contains($report->notes ?? '', '[Verified by admin]'))
                                        <span class="badge bg-success">Diverifikasi</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('reports.show', $report->id) }}" class="btn btn-sm btn-info me-1"
                                        title="Detail"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-sm btn-primary me-1"
                                        title="Edit"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('reports.destroy', $report->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin ingin menghapus laporan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada laporan yang Anda buat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center">
                {{ $reports->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
