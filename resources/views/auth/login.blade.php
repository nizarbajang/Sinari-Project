<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Investasi Peternakan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    <div class="login-card">
        <div class="login-header">
            <img src="{{ asset('logo.png') }}" alt="logo" width="90" />
            <h1>Sinari<span>Farm</span></h1>
            <p class="text-muted">Kelola Investasi Ternak Anda</p>
        </div>

        <form action="{{ route('login') }}" method="POST">
            @csrf

            @if ($errors->has('login_error'))
                <div class="alert alert-danger text-center">{{ $errors->first('login_error') }}</div>
            @endif

            <div class="mb-3">
                <label for="email" class="form-label fw-bold">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" placeholder="Masukkan email Anda" value="{{ old('email') }}" required />
                </div>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="form-label fw-bold">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password" placeholder="Masukkan password Anda" required />
                </div>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-grid gap-2 mb-3">
                <button type="submit" class="btn btn-custom">
                    <i class="fas fa-sign-in-alt me-2"></i> Masuk ke Akun
                </button>
            </div>
            <div class="text-center">
                <p class="mt-3 text-muted">
                    Belum punya akun?
                    <a href="{{ route('register') }}" style="color: var(--color-primary); font-weight: 600">Daftar
                        Sekarang</a>
                </p>
            </div>

        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
