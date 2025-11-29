@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Detail Project</h3>
        <a href="{{ route('projects.index') }}" class="btn btn-secondary mb-3">&larr; Kembali</a>

        <div class="card mb-3">
            <div class="card-body">
                <h4>{{ $project->title }}</h4>

                <p><b>Peternak:</b> {{ $project->farmer->name }}</p>
                <p><b>Jenis Hewan:</b> {{ $project->animal_type }}</p>
                <p><b>Harga Unit:</b> Rp {{ number_format($project->price_per_unit) }}</p>
                <p><b>Unit:</b> {{ $project->sold_units }} / {{ $project->total_units }}</p>
                <p><b>Durasi:</b> {{ $project->duration_months }} bulan</p>
                <p><b>Profit:</b> {{ $project->profit_percentage }}%</p>
                <p><b>Status:</b> {{ $project->status }}</p>

                <hr>

                <p>{{ $project->description }}</p>
            </div>
        </div>

        {{-- Galeri Media --}}
        @if ($project->media->count())
            <div class="mb-4">
                <h5>Galeri Media</h5>
                <div class="row">
                    @foreach ($project->media as $m)
                        <div class="col-md-3 mb-3">
                            @if ($m->type === 'image')
                                <img src="{{ asset('storage/' . $m->url) }}" class="img-thumbnail w-100">
                            @else
                                <video src="{{ asset('storage/' . $m->url) }}" class="w-100" controls></video>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
