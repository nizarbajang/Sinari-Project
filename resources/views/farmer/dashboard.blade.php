@extends('layouts.farmer')

@section('title', 'Dashboard Peternak')

@section('content')

    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">👋 Selamat Datang, {{ $farmer->name }}!</h1>

        <div class="row">

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Modal Terkumpul
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    Rp {{ number_format($totalCapitalRaised, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-coins fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Profit Sudah Dibagikan
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    Rp {{ number_format($totalProfitShared, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-share-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Proyek Aktif
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $projectStatusCounts['active'] ?? 0 }} Proyek
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-boxes fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Proyek Penuh
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $projectStatusCounts['full'] ?? 0 }} Proyek
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-warehouse fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">📦 Proyek yang Saya Kelola</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Proyek</th>
                                        <th>Unit Terjual</th>
                                        <th>Target Dana</th>
                                        <th>Profit (%)</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($projects as $project)
                                        <tr>
                                            <td class="font-weight-bold">{{ $project->title }}</td>
                                            <td>{{ $project->sold_units }} / {{ $project->total_units }}</td>
                                            <td>Rp
                                                {{ number_format($project->price_per_unit * $project->total_units, 0, ',', '.') }}
                                            </td>
                                            <td>{{ number_format($project->profit_percentage, 0) }}%</td>
                                            <td>
                                                <span
                                                    class="badge 
                                                    @if ($project->status == 'active') bg-primary 
                                                    @elseif ($project->status == 'full') bg-success 
                                                    @elseif ($project->status == 'finished') bg-info 
                                                    @else bg-secondary @endif">
                                                    {{ ucfirst($project->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('farmer.projects.show', $project->id) ?? '#' }}"
                                                    class="btn btn-sm btn-info me-1" title="Detail Proyek"><i
                                                        class="fas fa-eye"></i></a>
                                                {{-- Asumsi ada route untuk Farmer membuat laporan --}}
                                                <a href="{{ route('reports.create', $project->id) ?? '#' }}"
                                                    class="btn btn-sm btn-warning" title="Buat Laporan"><i
                                                        class="fas fa-plus"></i> Lapor</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Anda belum memiliki proyek yang
                                                terdaftar.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $projects->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">🔔 Aktivitas Transaksi Proyek Terakhir</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @forelse ($recentTransactions as $transaction)
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="font-weight-bold text-sm">
                                            @if ($transaction->type == 'invest')
                                                <i class="fas fa-arrow-up text-success me-1"></i> Investasi Baru
                                            @elseif ($transaction->type == 'profit')
                                                <i class="fas fa-arrow-down text-info me-1"></i> Pembagian Profit
                                            @else
                                                <i class="fas fa-exchange-alt text-secondary me-1"></i> Transaksi
                                            @endif

                                        </div>
                                        <small
                                            class="text-muted">{{ $transaction->project->title ?? 'Proyek Dihapus' }}</small>
                                    </div>
                                    <div>
                                        <span
                                            class="badge 
                                            @if ($transaction->status == 'success') bg-success 
                                            @elseif ($transaction->status == 'pending') bg-warning text-dark 
                                            @else bg-danger @endif">
                                            Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </span>
                                        <div class="text-end text-xs text-muted mt-1">
                                            {{ $transaction->created_at->diffForHumans() }}</div>
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item text-center text-muted">Belum ada aktivitas transaksi terbaru.
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
