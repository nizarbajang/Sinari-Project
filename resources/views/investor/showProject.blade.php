@extends('layouts.investor')

@section('page-icon')
    <i class="fas fa-boxes me-2"></i>
@endsection

@section('page-title', 'Detail Proyek')

@section('content')
    <div class="container py-2">
        <h1 class="mb-2">{{ $project->title }}</h1>
        <div class="row">
            <div class="col-md-8">
                {{-- Detail Proyek --}}
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        Deskripsi Proyek
                    </div>
                    <div class="card-body">
                        <p class="lead">{{ $project->description }}</p>
                        <hr>
                        <p>Jenis Hewan: **{{ $project->animal_type }}**</p>
                        <p>Peternak: **{{ $project->farmer->name ?? 'N/A' }}**</p>

                        <h5 class="mt-4">Detail Finansial</h5>
                        <ul>
                            <li>Harga per Unit: **Rp {{ number_format($project->price_per_unit, 0, ',', '.') }}**</li>
                            <li>Durasi Proyek: **{{ $project->duration_months }} bulan**</li>
                            <li>Profit Sharing Investor: **{{ $project->profit_percentage }}%**</li>
                        </ul>
                        <a href="{{ route('investments.projects.index') }}" class="btn btn-warning  ">← Kembali
                            ke
                            Daftar Proyek</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                {{-- Form Investasi --}}
                <div class="card bg-light shadow-lg">
                    <div class="card-header">
                        **Mulai Investasi**
                    </div>
                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <p class="text-success">Sisa Unit Tersedia: **{{ $availableUnits }} Unit**</p>

                        <form action="{{ route('investments.store', $project->id) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="units" class="form-label">Jumlah Unit Investasi</label>
                                <input type="number" class="form-control @error('units') is-invalid @enderror"
                                    id="units" name="units" value="{{ old('units') }}" min="1"
                                    max="{{ $availableUnits }}" required
                                    oninput="calculateAmount(this.value, {{ $project->price_per_unit }})">

                                @error('units')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Total Nominal Investasi</label>
                                <p class="lead text-primary" id="totalAmount">Rp 0</p>
                            </div>

                            <div class="alert alert-info small">
                                Setelah klik **Investasi Sekarang**, Anda akan diarahkan ke halaman pembayaran.
                            </div>

                            <button type="submit" class="btn btn-success w-100"
                                @if ($availableUnits == 0) disabled @endif>
                                @if ($availableUnits == 0)
                                    Proyek Penuh
                                @else
                                    Investasi Sekarang
                                @endif
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function calculateAmount(units, price) {
            const total = units * price;
            document.getElementById('totalAmount').innerText = 'Rp ' + total.toLocaleString('id-ID');
        }
        document.addEventListener('DOMContentLoaded', function() {
            // Set nilai awal saat halaman dimuat jika ada old('units')
            const initialUnits = document.getElementById('units').value;
            if (initialUnits) {
                calculateAmount(initialUnits, {{ $project->price_per_unit }});
            }
        });
    </script>
@endsection
