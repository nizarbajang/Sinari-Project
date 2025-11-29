@extends('layouts.farmer')

@section('content')
    <div class="container">
        <h3>Laporan Peternakan</h3>
        <a href="{{ route('reports.create') }}" class="btn btn-primary mb-3">Buat Laporan</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Project</th>
                    <th>Berat</th>
                    <th>Status Kesehatan</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $r)
                    <tr>
                        <td>{{ $r->project->title }}</td>
                        <td>{{ $r->weight ?? '-' }}</td>
                        <td>{{ $r->health_status ?? '-' }}</td>
                        <td>{{ $r->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('reports.edit', $r->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <a href="{{ route('reports.show', $r->id) }}" class="btn btn-info btn-sm"> Detail</a>
                            <form action="{{ route('reports.destroy', $r->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Hapus laporan?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $reports->links() }}
    </div>
@endsection
