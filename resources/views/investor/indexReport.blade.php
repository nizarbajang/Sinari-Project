@extends('layouts.investor')

@section('page-icon')
    <i class="fas fa-file-alt me-2"></i>
@endsection

@section('page-title', 'Laporan Peternak')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Laporan Proyek</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    @if ($reports->isEmpty())
                        <div class="alert alert-info text-center">
                            Belum ada laporan perkembangan dari proyek yang Anda danai.
                        </div>
                    @else
                        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Proyek</th>
                                    <th>Tanggal Laporan</th>
                                    <th>Berat (kg)</th>
                                    <th>Status Kesehatan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reports as $index => $report)
                                    <tr>
                                        <td>{{ $reports->firstItem() + $index }}</td>
                                        <td>
                                            <a href="#" class="text-primary font-weight-bold">
                                                {{ $report->project->title ?? 'Proyek Dihapus' }}
                                            </a>
                                        </td>
                                        <td>{{ $report->created_at->format('d M Y') }}</td>
                                        <td>
                                            <strong>{{ number_format($report->weight, 2) ?? '-' }}</strong>
                                        </td>
                                        <td>
                                            <span
                                                class="badge 
                                                @if (Str::lower($report->health_status) == 'sehat') bg-success 
                                                @elseif(Str::lower($report->health_status) == 'kurang sehat') bg-warning text-dark
                                                @else bg-secondary @endif">
                                                {{ $report->health_status ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('investorReports.show', $report->id) }}"
                                                class="btn btn-info btn-sm" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

                <div class="mt-3 d-flex justify-content-center">
                    {{ $reports->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
