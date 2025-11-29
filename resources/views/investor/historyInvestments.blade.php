@extends('layouts.investor')

@section('page-icon')
    <i class="fas fa-history me-2"></i>
@endsection

@section('page-title', 'Riwayat Investasi')

@section('content')
    <div class="container py-2">
        @if (session('warning'))
            <div class="alert alert-warning">{{ session('warning') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Proyek</th>
                        <th>Unit</th>
                        <th>Nominal Investasi</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($investments as $investment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><a
                                    href="{{ route('investments.projects.show', $investment->project->id) }}">{{ $investment->project->title }}</a>
                            </td>
                            <td>{{ $investment->units }} Unit</td>
                            <td>Rp {{ number_format($investment->amount, 0, ',', '.') }}</td>
                            <td>{{ $investment->created_at->format('d M Y') }}</td>
                            <td>
                                @if ($investment->status == 'paid')
                                    <span class="badge bg-success">Aktif/Lunas</span>
                                @elseif ($investment->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending Bayar</span>
                                @else
                                    <span class="badge bg-danger">{{ ucfirst($investment->status) }}</span>
                                @endif
                            </td>
                            <td>
                                @if ($investment->status == 'pending')
                                    <a href="{{ route('investments.pending', $investment->id) }}"
                                        class="btn btn-sm btn-warning">Bayar</a>
                                @else
                                    <button class="btn btn-sm btn-info" disabled>Detail</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Anda belum memiliki riwayat investasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
