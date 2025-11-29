@extends('layouts.farmer')

@section('content')
    <div class="container">
        <h3>Edit Laporan</h3>

        <a href="{{ route('reports.index') }}" class="btn btn-secondary mb-3">Kembali</a>

        <form action="{{ route('reports.update', $report->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            @include('farmer.formReport')

            <button class="btn btn-primary mt-3">Update</button>
        </form>
    </div>
@endsection
