@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Tambah Project Baru</h3>
        <a href="{{ route('projects.index') }}" class="btn btn-secondary mb-3">&larr; Kembali</a>

        <form action="{{ route('projects.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @include('admin.projectsForm')

            <button class="btn btn-primary my-3">Simpan</button>
        </form>
    </div>
@endsection
