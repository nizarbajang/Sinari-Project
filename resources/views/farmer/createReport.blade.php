@extends('layouts.farmer')

@section('content')
    <div class="container">
        <h3>Buat Laporan Baru</h3>

        <a href="{{ route('reports.index') }}" class="btn btn-secondary mb-3">Kembali</a>

        <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @include('farmer.formReport')

            <button class="btn btn-primary my-3">Simpan</button>
        </form>
    </div>
@endsection
