@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Edit Project</h3>
        <a href="{{ route('projects.index') }}" class="btn btn-secondary mb-3">&larr; Kembali</a>

        <form action="{{ route('projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('admin.projectsForm')

            <button type="submit" class="btn btn-primary my-3">Update</button>
        </form>
    </div>
@endsection
