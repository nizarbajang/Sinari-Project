{{-- Variabel yang harus tersedia di sini: $projects, dan $report (bisa null untuk create) --}}

{{-- Pilih Proyek --}}
<div class="mb-3">
    <label for="project_id" class="form-label">Pilih Proyek <span class="text-danger">*</span></label>
    <select class="form-select @error('project_id') is-invalid @enderror" id="project_id" name="project_id" required>
        <option value="">-- Pilih Proyek yang Dilaporkan --</option>
        @foreach ($projects as $project)
            <option value="{{ $project->id }}"
                {{ old('project_id', $report->project_id ?? null) == $project->id ? 'selected' : '' }}>
                {{ $project->title }} ({{ ucfirst($project->status) }})
            </option>
        @endforeach
    </select>
    @error('project_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    {{-- Perkiraan Berat --}}
    <div class="col-md-6 mb-3">
        <label for="weight" class="form-label">Perkiraan Berat Hewan (kg)</label>
        <input type="number" step="0.01" class="form-control @error('weight') is-invalid @enderror" id="weight"
            name="weight" value="{{ old('weight', $report->weight ?? null) }}">
        @error('weight')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Status Kesehatan --}}
    <div class="col-md-6 mb-3">
        <label for="health_status" class="form-label">Status Kesehatan</label>
        <input type="text" class="form-control @error('health_status') is-invalid @enderror" id="health_status"
            name="health_status" value="{{ old('health_status', $report->health_status ?? null) }}"
            placeholder="Contoh: Sehat, Sakit Ringan, dll.">
        @error('health_status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

{{-- Catatan --}}
<div class="mb-3">
    <label for="notes" class="form-label">Catatan Perkembangan (Detail)</label>
    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="5">{{ old('notes', $report->notes ?? null) }}</textarea>
    <small class="form-text text-muted">Jelaskan kondisi umum, makanan, dan perkembangan penting lainnya.</small>
    @error('notes')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Lampiran Media (Sama untuk Create dan Edit) --}}
<div class="mb-3">
    <label for="media" class="form-label">Lampirkan Foto/Video (Max 50MB per file)</label>
    <input type="file" class="form-control @error('media.*') is-invalid @enderror" id="media" name="media[]"
        multiple accept=".jpg,.jpeg,.png,.mp4">
    <small class="form-text text-muted">Untuk Edit: Media yang sudah ada tidak akan hilang, ini hanya untuk menambahkan
        media baru.</small>
    @error('media.*')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
