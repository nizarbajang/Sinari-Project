<div class="mb-3">
    <label>Peternak</label>
    <select name="farmer_id" class="form-control" required>
        <option value="">-- Pilih Peternak --</option>
        @foreach ($farmers as $f)
            <option value="{{ $f->id }}"
                {{ old('farmer_id', $project->farmer_id ?? '') == $f->id ? 'selected' : '' }}>
                {{ $f->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Judul Project</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $project->title ?? '') }}" required>
</div>

<div class="mb-3">
    <label>Deskripsi</label>
    <textarea name="description" class="form-control" rows="4">{{ old('description', $project->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label>Jenis Hewan</label>
    <input type="text" name="animal_type" class="form-control"
        value="{{ old('animal_type', $project->animal_type ?? '') }}" required>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label>Harga per Unit</label>
        <input type="number" name="price_per_unit" class="form-control"
            value="{{ old('price_per_unit', $project->price_per_unit ?? '') }}" required>
    </div>

    <div class="col-md-4 mb-3">
        <label>Total Units</label>
        <input type="number" name="total_units" class="form-control"
            value="{{ old('total_units', $project->total_units ?? '') }}" required>
    </div>

    <div class="col-md-4 mb-3">
        <label>Unit Terjual</label>
        <input type="number" name="sold_units" class="form-control"
            value="{{ old('sold_units', $project->sold_units ?? 0) }}">
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label>Durasi (bulan)</label>
        <input type="number" name="duration_months" class="form-control"
            value="{{ old('duration_months', $project->duration_months ?? '') }}" required>
    </div>

    <div class="col-md-6 mb-3">
        <label>Profit (%)</label>
        <input type="number" name="profit_percentage" class="form-control"
            value="{{ old('profit_percentage', $project->profit_percentage ?? '') }}" required>
    </div>
</div>

<div class="mb-3">
    <label>Status</label>
    <select name="status" class="form-control">
        @foreach (['draft', 'active', 'full', 'finished'] as $s)
            <option value="{{ $s }}"
                {{ old('status', $project->status ?? 'draft') == $s ? 'selected' : '' }}>
                {{ ucfirst($s) }}
            </option>
        @endforeach
    </select>
</div>

{{-- UPLOAD MULTIPLE MEDIA --}}
<div class="mb-3">
    <label>Media (gambar / video) — bisa pilih banyak</label>
    <input type="file" name="media[]" class="form-control" multiple accept="image/*,video/*">
    <small class="text-muted">Format: jpg, png, mp4. Maks 10MB per file.</small>
</div>

{{-- Jika edit: tampilkan galeri media --}}
@if (!empty($project) && $project->media->count())
    <div class="mb-3">
        <label>Galeri Media</label>
        <div class="row">
            @foreach ($project->media as $m)
                <div class="col-md-3 mb-2">
                    <div class="card">
                        <div class="card-body p-2">
                            @if ($m->type === 'image')
                                <img src="{{ asset('storage/' . $m->url) }}" class="img-fluid">
                            @else
                                <video src="{{ asset('storage/' . $m->url) }}" class="w-100" controls></video>
                            @endif

                            <form action="{{ route('projects.media.destroy', [$project->id, $m->id]) }}" method="POST"
                                onsubmit="return confirm('Hapus media ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger mt-2 w-100">Hapus Media</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
