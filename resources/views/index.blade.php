<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Investasi Ternak Produktif | SINARIFARM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}" />
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">SINARIFARM</a>

            <button class="navbar-toggler bg-white" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#proyek">Proyek</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#cara-kerja">Cara Kerja</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#keunggulan">Keunggulan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#kontak">Kontak</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-outline-light btn-sm px-3 py-2" href="{{ route('login') }}">Login / Daftar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <header class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">
                Investasi Produktif, Dari
                <span class="text-primary">Peternakan Langsung</span> ke Tangan Anda.
            </h1>
            <p class="lead mb-4 text-light">
                Dapatkan potensi keuntungan optimal dengan mendanai proyek peternakan
                yang terkurasi.
            </p>
            <a href="#proyek" class="btn btn-primary btn-lg px-5 shadow-lg">
                Mulai Cari Proyek <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </header>
    <!-- SECTION KEUNGGULAN -->
    <section id="keunggulan" class="py-5 py-lg-6 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <p class="section-title">Kenapa Kami?</p>
                <h2 class="fw-bold">Keuntungan Berinvestasi Bersama Kami</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card p-4 text-center">
                        <i class="fas fa-clipboard-list text-primary fa-3x mb-3"></i>
                        <h5 class="fw-bold">Transparansi Laporan</h5>
                        <p class="text-muted">
                            Peternak mengirimkan laporan perkembangan ternak, termasuk foto
                            dan data berat/kesehatan, yang dapat Anda akses kapan saja.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4 text-center">
                        <i class="fas fa-shield-alt text-primary fa-3x mb-3"></i>
                        <h5 class="fw-bold">Keamanan Dana</h5>
                        <p class="text-muted">
                            Hanya proyek dengan rekam jejak yang solid dan telah melewati
                            proses audit internal yang kami tampilkan.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4 text-center">
                        <i class="fas fa-chart-line text-primary fa-3x mb-3"></i>
                        <h5 class="fw-bold">Potensi Imbal Hasil</h5>
                        <p class="text-muted">
                            Nikmati potensi bagi hasil yang kompetitif, lebih tinggi dari
                            instrumen investasi tradisional.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- <hr class="text-secondary-accent" /> -->

    <section id="cara-kerja" class="py-5 py-lg-6">
        <div class="container">
            <div class="text-center mb-5">
                <p class="section-title">Langkah Mudah</p>
                <h2 class="fw-bold">Proses Investasi Cepat dan Aman</h2>
            </div>
            <div class="row text-center">
                <div class="col-md-3">
                    <div class="p-3">
                        <div class="step-icon"><i class="fas fa-hand-pointer"></i></div>
                        <h4 class="fw-bold">1. Pilih Proyek</h4>
                        <p class="text-muted">
                            Telusuri daftar proyek dan unit yang tersedia.
                        </p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3">
                        <div class="step-icon"><i class="fas fa-credit-card"></i></div>
                        <h4 class="fw-bold">2. Beli Unit & Bayar</h4>
                        <p class="text-muted">
                            Tentukan jumlah unit investasi dan selesaikan pembayaran.
                        </p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3">
                        <div class="step-icon"><i class="fas fa-chart-area"></i></div>
                        <h4 class="fw-bold">3. Pantau Perkembangan</h4>
                        <p class="text-muted">
                            Akses laporan ternak berkala langsung dari *dashboard* Anda.
                        </p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3">
                        <div class="step-icon"><i class="fas fa-wallet"></i></div>
                        <h4 class="fw-bold">4. Terima Hasil</h4>
                        <p class="text-muted">
                            Dana pokok dan bagi hasil ditransfer setelah proyek selesai.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PROYEK -->
    <section id="proyek" class="py-5 py-lg-6 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <p class="section-title">Investasi Sekarang</p>
                <h2 class="fw-bold">Proyek Investasi yang Sedang Dibuka</h2>
            </div>

            <div class="row g-4">

                {{-- Tampilkan 3 proyek utama --}}
                @foreach ($mainProjects as $project)
                    <div class="col-md-4">
                        <div class="card card-project shadow-sm">

                            <img src="{{ optional($project->media->first())->url
                                ? asset('storage/' . $project->media->first()->url)
                                : asset('images/no-image.png') }}"
                                class="card-img-top" alt="Gambar Proyek">

                            <div class="card-body">
                                <h5 class="fw-bold">{{ $project->title }}</h5>
                                <p class="text-muted small">Peternak: {{ $project->farmer->name }}</p>

                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Harga per Unit</span>
                                        <span class="fw-bold text-primary">Rp
                                            {{ number_format($project->price_per_unit, 0, ',', '.') }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Unit Tersedia</span>
                                        <span class="fw-bold">
                                            {{ round((1 - $project->sold_units / $project->total_units) * 100) }}%
                                        </span>
                                    </li>
                                </ul>

                                <a href="{{ route('login') }}" class="btn btn-primary w-100">Lihat Detail Proyek</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- SLIDER jika proyek lebih dari 3 --}}
            @if ($otherProjects->count() > 0)
                <div class="mt-5">
                    <h4 class="fw-bold mb-3 text-center">Proyek Lainnya</h4>

                    <div id="projectSlider" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">

                            @foreach ($otherProjects->chunk(3) as $index => $chunk)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <div class="row g-4">

                                        @foreach ($chunk as $project)
                                            <div class="col-md-4">
                                                <div class="card card-project shadow-sm">

                                                    <img src="{{ optional($project->media->first())->url
                                                        ? asset('storage/' . $project->media->first()->url)
                                                        : asset('images/no-image.png') }}"
                                                        class="card-img-top" alt="Gambar Proyek">


                                                    <div class="card-body">
                                                        <h5 class="fw-bold">{{ $project->title }}</h5>

                                                        <a href="#" class="btn btn-outline-primary w-100">
                                                            Detail Proyek
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#projectSlider"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#projectSlider"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                </div>
            @endif

        </div>
    </section>

    <section class="cta-footer text-center">
        <div class="container">
            <h2 class="fw-bold">Siap Menumbuhkan Aset Anda?</h2>
            <p class="lead text-50">
                Mulai berinvestasi pada proyek peternakan yang transparan sekarang
                juga.
            </p>

            <a href="{{ route('login') }}" class="btn btn-primary text-light fw-bold btn-lg px-5">
                Daftar Gratis Sekarang!
            </a>
        </div>
    </section>

    <!-- FOOTER -->
    <footer id="kontak" class="py-4 main-footer text-white-50">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h6 class="text-white fw-bold">SINARIFARM</h6>
                    <p class="small">
                        Platform investasi peternakan dengan sistem yang transparan dan
                        modern.
                    </p>
                </div>

                <div class="col-md-4 mb-3">
                    <h6 class="text-white fw-bold">Kontak</h6>
                    <ul class="list-unstyled small">
                        <li><i class="fas fa-envelope me-2"></i> info@aplikasi.com</li>
                        <li><i class="fas fa-phone me-2"></i> (021) 1234 5678</li>
                        <li>
                            <i class="fas fa-map-marker-alt me-2"></i> Jl. Investasi No. 1,
                            Jakarta
                        </li>
                    </ul>
                </div>

                <div class="col-md-4 mb-3">
                    <h6 class="text-white fw-bold">Ikuti Kami</h6>
                    <a href="#" class="text-white-50 me-3">
                        <i class="fab fa-facebook-f fa-lg"></i>
                    </a>
                    <a href="#" class="text-white-50 me-3">
                        <i class="fab fa-twitter fa-lg"></i>
                    </a>
                    <a href="#" class="text-white-50">
                        <i class="fab fa-instagram fa-lg"></i>
                    </a>
                    <p class="small mt-3">
                        Berizin dan diawasi oleh OJK (jika sudah berizin).
                    </p>
                </div>
            </div>

            <hr class="bg-secondary" />
            <div class="text-center small">
                © 2025 SINARIFARM. All Rights Reserved.
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener("scroll", function() {
            const navbar = document.querySelector(".navbar");
            if (window.scrollY > 80) {
                navbar.classList.add("navbar-scrolled");
            } else {
                navbar.classList.remove("navbar-scrolled");
            }
        });
    </script>
</body>

</html>
