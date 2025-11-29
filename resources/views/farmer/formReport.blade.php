<div class="mb-3">
    <label>Project</label>
    <select name="project_id" class="form-control">
        @foreach ($projects as $p)
            <option value="{{ $p->id }}" {{ isset($report) && $report->project_id == $p->id ? 'selected' : '' }}>
                {{ $p->title }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Berat (kg)</label>
    <input type="number" step="0.01" name="weight" value="{{ old('weight', $report->weight ?? '') }}"
        class="form-control">
</div>

<div class="mb-3">
    <label>Status Kesehatan</label>
    <input type="text" name="health_status" value="{{ old('health_status', $report->health_status ?? '') }}"
        class="form-control">
</div>

<div class="mb-3">
    <label>Catatan</label>
    <textarea name="notes" class="form-control">{{ old('notes', $report->notes ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label>Media (Foto/Video)</label>
    <input type="file" name="media[]" class="form-control" multiple>
</div>
