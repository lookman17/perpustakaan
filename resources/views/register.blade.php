@extends('template.layout')

@section('title', 'Register - Web Perpustakaan')

@section('main')

<section class="login-container" style="height: 100vh; display: flex; justify-content: center; align-items: center; padding: 0; margin: 0; background-color: #f8f9fa;">
    <div class="card shadow-lg bg-light" style="width: 100%; max-width: 600px; height: 90%; display: flex; flex-direction: column;">
        <div class="card-header bg-primary text-white text-center" style="flex-shrink: 0;">
            <img src="{{ asset('img/people.png') }}" alt="Logo" class="img-logo" style="height: 80px; margin-bottom: 10px;">
            <h3>Register - Web Perpustakaan</h3>
        </div>
        <div class="card-body" style="flex-grow: 1; overflow-y: auto; padding: 20px;">
            <form action="{{ route('user.register') }}" method="POST" style="display: flex; flex-direction: column; gap: 1rem; height: 100%;">
                @csrf
                
                <div class="form-group" style="display: flex; flex-wrap: wrap; gap: 1rem;">
                    <div style="flex: 1;">
                        <label for="nama" class="form-label">Nama Lengkap *</label>
                        <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan fullname" value="{{ old('nama') }}">
                        @error('nama')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div style="flex: 1;">
                        <label for="alamat" class="form-label">Alamat *</label>
                        <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Masukkan alamat" value="{{ old('alamat') }}">
                        @error('alamat')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group" style="display: flex; flex-wrap: wrap; gap: 1rem;">
                    <div style="flex: 1;">
                        <label for="username" class="form-label">Username *</label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username" value="{{ old('username') }}">
                        @error('username')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div style="flex: 1;">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan email" value="{{ old('email') }}">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div> 
                <div class="form-group" style="display: flex; flex-wrap: wrap; gap: 1rem;">
                    <div style="flex: 1;">
                        <label for="password" class="form-label">Password *</label>
                        <div style="display: flex; align-items: center;">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password Anda">
                            <button type="button" id="toggle-password" class="btn btn-outline-primary" style="margin-left: 0.5rem;">
                                <i class="fa fa-eye" id="eye-icon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div style="flex: 1;">
                        <label for="notelp" class="form-label">Nomor Telp *</label>
                        <input type="number" name="notelp" id="notelp" class="form-control" placeholder="Masukkan nomor telepon Anda" value="{{ old('notelp') }}">
                        @error('notelp')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <button class="btn btn-primary" type="submit" style="align-self: stretch;">Daftar</button>
            </form>
        </div>
        <div class="card-footer text-center" style="flex-shrink: 0;">
            <a href="{{ route('login') }}" class="text-primary">Sudah punya akun? Silahkan login</a>
        </div>
    </div>
</section>
<style>
    @keyframes fadeIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    body {
        font-family: 'Poppins', sans-serif;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        transition: 0.3s;
    }

    .card {
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }
</style>
<script>
    document.getElementById('toggle-password').addEventListener('click', function () {
        const passwordField = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
        
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passwordField.type = 'password';
            eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    });
</script>
@endsection
