@extends('template.layout')

@section('title', 'Login - Web Perpustakaan')

@section('main')
    {{-- Use Bootstrap utilities for centering and background --}}
    <section class="d-flex align-items-center justify-content-center min-vh-100 py-5 bg-body-tertiary">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-6 col-xl-5"> {{-- Responsive column sizing --}}

                    {{-- Alerts container (outside the card) --}}
                    <div class="mb-4">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <strong>Berhasil!</strong> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- Specific error from session('error') --}}
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <strong>Gagal!</strong> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        {{-- General validation errors (only if no specific session('error')) --}}
                        @elseif ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3" role="alert">
                                 <i class="bi bi-exclamation-circle-fill me-2"></i>
                                <strong>Oops!</strong> Periksa kembali input berikut:
                                <ul class="mb-0 mt-2 small ps-3"> {{-- Smaller list for errors --}}
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                    </div>

                    {{-- Login Card --}}
                    <div class="card shadow-lg border-0 rounded-4">
                        <div class="card-header bg-primary text-white text-center py-3">
                            {{-- Use max-height for better logo control --}}
                            <img src="{{ asset('img/people.png') }}" alt="Logo Perpustakaan" class="mb-2" style="max-height: 55px;">
                            <h4 class="mb-0 fw-bold">Login Perpustakaan</h4>
                        </div>

                        <div class="card-body p-4 p-lg-5"> {{-- Increased padding --}}
                            <form action="{{ route('user.login') }}" method="POST" novalidate> {{-- novalidate prevents browser default validation --}}
                                @csrf
                                <div class="mb-3">
                                    <label for="user_username" class="form-label">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="user_username" id="user_username"
                                           class="form-control form-control-lg @error('user_username') is-invalid @enderror" {{-- Larger input --}}
                                           placeholder="Masukkan username Anda"
                                           value="{{ old('user_username') }}" required>
                                    @error('user_username')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="user_password" class="form-label">Password <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-lg"> {{-- Larger input group --}}
                                        <input type="password" name="user_password" id="user_password"
                                               class="form-control @error('user_password') is-invalid @enderror"
                                               placeholder="Masukkan password Anda" required>
                                        {{-- Use Bootstrap Icons and standard button style --}}
                                        <button type="button" id="toggle-password" class="btn btn-outline-secondary">
                                            <i class="bi bi-eye-fill" id="eye-icon"></i>
                                        </button>
                                        {{-- Error message for password needs d-block with input-group --}}
                                        @error('user_password')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-grid my-4"> {{-- Use d-grid for full width button --}}
                                    <button class="btn btn-primary btn-lg fw-bold" type="submit">Login</button>
                                </div>
                            </form>
                        </div> {{-- End card-body --}}

                        <div class="card-footer text-center py-3 bg-light">
                             <small class="text-muted">Tidak punya akun?</small>
                             {{-- Remove <p> inside <a> --}}
                             <a href="{{ route('register') }}" class="text-decoration-none fw-medium ms-1">Silakan mendaftar</a>
                        </div>
                    </div> {{-- End card --}}
                </div> {{-- End Col --}}
            </div> {{-- End Row --}}
        </div> {{-- End Container --}}
    </section>
@endsection

@push('scripts')
{{-- Toggle Password Script (using Bootstrap Icons) --}}
<script>
    // Wait for the DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function () {
        const togglePasswordButton = document.getElementById('toggle-password');
        const passwordField = document.getElementById('user_password');
        const eyeIcon = document.getElementById('eye-icon');

        // Check if all elements exist before adding listener
        if (togglePasswordButton && passwordField && eyeIcon) {
            togglePasswordButton.addEventListener('click', function () {
                // Toggle the type attribute
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);

                // Toggle the eye icon
                if (type === 'password') {
                    // Show eye
                    eyeIcon.classList.remove('bi-eye-slash-fill');
                    eyeIcon.classList.add('bi-eye-fill');
                } else {
                    // Show eye-slash
                    eyeIcon.classList.remove('bi-eye-fill');
                    eyeIcon.classList.add('bi-eye-slash-fill');
                }
            });
        } else {
            console.error('Password toggle elements not found');
        }
    });
</script>
@endpush