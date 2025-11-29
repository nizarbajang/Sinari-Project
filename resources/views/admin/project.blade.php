@extends('layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Daftar Proyek Investasi Aktif</h5>
            <a href="{{ route('projects.create') }}" class="btn btn-primary-custom">
                <i class="fas fa-plus me-2"></i> Buat Proyek Baru
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Judul Proyek</th>
                            <th>Peternak</th>
                            <th>Harga/Unit</th>
                            <th>Unit</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->title }}</td>
                                <td>{{ $p->farmer->name }}</td>
                                <td>Rp {{ number_format($p->price_per_unit) }}</td>
                                <td>{{ $p->sold_units }}/{{ $p->total_units }}</td>
                                <td><span class="badge bg-info">{{ $p->status }}</span></td>
                                <td>
                                    <a href="{{ route('projects.show', $p->id) }}" class="btn btn-sm btn-info">Detail</a>
                                    <a href="{{ route('projects.edit', $p->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                    <form action="{{ route('projects.destroy', $p->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Hapus project ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
