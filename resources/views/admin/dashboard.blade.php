@extends('layouts.app')

@section('title', 'Dashboard Admin Peternakan')

@section('content')

    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">✨ Dashboard Utama</h1>
        <div class="row">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Proyek Aktif
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalActiveProjects }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-boxes fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Pengguna (Investor & Farmer)
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalRegisteredUsers }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Uang Masuk
                                    (Investasi Success)</div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">Rp
                                            {{ number_format($totalMoneyIn, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-money-check-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-xl-7 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">📈 Perkembangan Investasi (6 Bulan Terakhir)</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="investmentChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-5 col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">📦 10 Proyek Terbaru</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Proyek</th>
                                        <th>Unit</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($recentProjects as $project)
                                        <tr>
                                            <td>{{ $project->title }}</td>
                                            <td>{{ $project->sold_units }}/{{ $project->total_units }}</td>
                                            <td>
                                                <span
                                                    class="badge 
                                                    @if ($project->status == 'active') badge-success 
                                                    @elseif ($project->status == 'full') badge-warning 
                                                    @elseif ($project->status == 'finished') badge-info 
                                                    @else badge-secondary @endif">
                                                    {{ ucfirst($project->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">Belum ada proyek terdaftar.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <a href="{{ route('projects.index') ?? '#' }}" class="btn btn-primary btn-sm btn-block mt-3">Lihat
                            Semua Proyek &rarr;</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data dari Controller
            const investmentData = @json($investmentsData);

            if (investmentData.labels.length > 0) {
                const ctx = document.getElementById('investmentChart').getContext('2d');

                const investmentChart = new Chart(ctx, {
                    type: 'bar', // Menggunakan Bar Chart untuk visualisasi jumlah
                    data: {
                        labels: investmentData.labels, // Nama-nama bulan
                        datasets: [{
                            label: 'Total Investasi Berhasil (Rp)',
                            data: investmentData.data, // Total nominal investasi
                            backgroundColor: 'rgba(78, 115, 223, 0.7)', // Warna Biru
                            borderColor: 'rgba(78, 115, 223, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                beginAtZero: true,
                                // Callback untuk format label Y menjadi mata uang (Opsional)
                                ticks: {
                                    callback: function(value, index, values) {
                                        if (parseInt(value) >= 1000) {
                                            return 'Rp ' + value.toString().replace(
                                                /\B(?=(\d{3})+(?!\d))/g, ".");
                                        } else {
                                            return 'Rp ' + value;
                                        }
                                    }
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true
                            }
                        }
                    }
                });
            } else {
                // Tampilkan pesan jika tidak ada data
                document.getElementById('investmentChart').closest('.chart-area').innerHTML =
                    '<p class="text-center text-muted mt-5">Belum ada data investasi yang tercatat.</p>';
            }
        });
    </script>
@endpush
