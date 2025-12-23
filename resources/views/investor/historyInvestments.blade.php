@extends('layouts.investor')

@section('page-icon')
    <i class="fas fa-history me-2"></i>
@endsection

@section('page-title', 'Riwayat Investasi')

@section('content')

    <div class="container-fluid">
        <p class="mb-2 text-muted">Daftar semua unit proyek yang pernah Anda beli dan status transaksinya.</p>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Investasi</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID Transaksi</th>
                                <th>Proyek</th>
                                <th>Unit</th>
                                <th>Total Dana</th>
                                <th>Status Pembayaran</th>
                                <th>Tanggal Investasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($investments as $investment)
                                <tr>
                                    <td class="font-weight-bold">{{ $investment->transaction->id ?? 'N/A' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('investments.projects.show', $investment->project->id ?? '#') }}"
                                            class="text-primary font-weight-bold">
                                            {{ $investment->project->title ?? 'Proyek Dihapus' }}
                                        </a>
                                    </td>
                                    <td>{{ number_format($investment->units, 0, ',', '.') }} Unit</td>
                                    <td>Rp {{ number_format($investment->amount, 0, ',', '.') }}</td>
                                    <td>
                                        @php
                                            $status = $investment->transaction->status ?? 'N/A';
                                            $badgeClass = 'bg-secondary';
                                            if ($status === 'success') {
                                                $badgeClass = 'bg-success';
                                            } elseif ($status === 'pending') {
                                                $badgeClass = 'bg-warning text-dark';
                                            } elseif ($status === 'failed') {
                                                $badgeClass = 'bg-danger';
                                            }
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ ucfirst($status) }}</span>
                                    </td>
                                    <td>{{ $investment->created_at->format('d M Y H:i') }}</td>
                                    <td>
                                        {{-- Tombol Aksi --}}
                                        @if ($status === 'pending')
                                            {{-- Ganti dengan route ke halaman detail transaksi jika ada --}}
                                            <a href="{{ route('investments.pending', $investment->id ?? '#') }}"
                                                class="btn btn-sm btn-info" title="Detail Transaksi">
                                                <i class="fas fa-eye"></i> Bayar Sekarang
                                            </a>
                                        @else
                                            {{-- Tombol View untuk riwayat --}}
                                            <a href="{{ route('investments.detail', $investment->id) }}"
                                                class="btn btn-sm btn-secondary" title="Detail Riwayat">
                                                <i class="fas fa-search"></i> Detail
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Anda belum pernah melakukan investasi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $investments->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
