{{--
@extends('template.layout')

@section('title', 'Login - Web Perpustakaan')

@section('main')
<section class="login-container">
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berhasil!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
    <div class="card shadow-lg">
        <div class="card-header">
            <img src="{{ asset('img/book.png') }}" alt="..." class="img-logo">
            <h3 class="text-center">Login - Web Perpustakaan</h3>
        </div>


        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.submit') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="user_username" class="form-label">Username *</label>
                    <input type="text" name="user_username" id="user_username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="user_password" class="form-label">Password *</label>
                    <input type="password" name="user_password" id="user_password" class="form-control" required>
                </div>

                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Login</button>
                </div>
                <div class="card-footer">
                    <a href="{{ route('register') }}"><p class="text-primary text-center">Tidak punya akun? Silahkan mendaftar</p></a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
--}}

@extends('template.layout')

@section('title', 'Login - Web Perpustakaan')

@section('main')
    {{-- Section with a softer background and centering --}}
    <section class="d-flex align-items-center justify-content-center min-vh-100 py-5 bg-body-tertiary"> {{-- bg-light if BS < 5.3 --}}
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5 col-xl-4">

                    {{-- Alerts - Positioned above the card --}}
                    <div class="mb-4"> {{-- Wrapper for alert spacing --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <strong>Berhasil!</strong> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->has('message'))
                            <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <strong>Gagal!</strong> {{ $errors->first('message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @elseif ($errors->any() && !session('success')) {{-- Show general errors only if no specific message/success --}}
                            <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3" role="alert">
                                <i class="bi bi-exclamation-circle-fill me-2"></i>
                                <strong>Oops!</strong> Periksa kembali input Anda.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                    </div>

                    {{-- Login Card --}}
                    <div class="card shadow-lg border-0 rounded-4">
                        <div class="card-body p-4 p-lg-5"> {{-- More padding --}}

                            <div class="text-center mb-4">
                                <img src="{{ asset('img/book.png') }}" alt="Logo Perpustakaan" class="img-fluid mb-3" style="max-height: 60px;">
                                <h3 class="fw-bold mb-0">Login Akun</h3>
                                <p class="text-muted">Selamat datang kembali!</p>
                            </div>

                            <form action="{{ route('user.login') }}" method="POST">
                                @csrf
                                {{-- Username Input Group --}}
                                <div class="form-floating mb-3">
                                    <input type="text" name="user_username" id="user_username"
                                           class="form-control @error('user_username') is-invalid @enderror"
                                           placeholder="Username" {{-- Placeholder for floating label --}}
                                           value="{{ old('user_username') }}" required>
                                    <label for="user_username">
                                        <i class="bi bi-person me-2"></i>Username
                                    </label>
                                    @error('user_username')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                {{-- Password Input Group --}}
                                <div class="form-floating mb-3">
                                    <input type="password" name="user_password" id="user_password"
                                           class="form-control @error('user_password') is-invalid @enderror"
                                           placeholder="Password" {{-- Placeholder for floating label --}}
                                           required>
                                    <label for="user_password">
                                        <i class="bi bi-lock me-2"></i>Password
                                    </label>
                                     @error('user_password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                {{-- Optional: Remember Me Checkbox --}}
                                {{-- <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label" for="remember">
                                        Ingat Saya
                                    </label>
                                </div> --}}

                                <div class="d-grid my-4">
                                    <button class="btn btn-primary btn-lg fw-bold rounded-pill" type="submit">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                                    </button>
                                </div>

                                <div class="text-center">
                                    <small class="text-muted">Belum punya akun?</small>
                                    <a href="{{ route('register') }}" class="text-decoration-none fw-medium ms-1">Daftar di sini</a>
                                </div>

                            </form>
                        </div> {{-- End card-body --}}
                    </div> {{-- End card --}}
                </div> {{-- End Col --}}
            </div> {{-- End Row --}}
        </div> {{-- End Container --}}
    </section>
@endsection

@push('css')
{{-- Menambahkan CSS kustom jika perlu --}}
<style>
    /* Opsi: Menyesuaikan ukuran ikon di dalam label floating */
    .form-floating > label > .bi {
        font-size: 1.1rem; /* Sesuaikan ukuran ikon jika perlu */
        vertical-align: middle;
    }
    .form-floating > .form-control:not(:placeholder-shown) ~ label > .bi {
         /* Pastikan ikon tetap terlihat baik saat label naik */
    }

    /* Sedikit penyesuaian agar ikon tidak terlalu dekat dengan teks */
    .form-floating > label > .bi {
        margin-right: 0.5rem !important;
    }
</style>
@endpush
