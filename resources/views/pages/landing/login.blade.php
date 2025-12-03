@extends('layouts.landing')

@section('title', 'Login - Abeka Transportation')

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="login-wrapper">
        <div class="container flex justify-center align-items-center">
            <div class="login-card mx-auto">
                @error('username')
                    <div class="alert alert-danger" role="alert">
                        {{  $message }}
                    </div>
                @enderror

                {{-- <h2 class="login-title">Login ke Akun Anda</h2> --}}
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" placeholder="Masukkan username Anda"
                        value="{{ old('username') }}"
                        pattern="[A-Za-z0-9_]{3,20}"
                        title="Only letters, numbers, and underscores (3-20 chars)">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Masukkan kata sandi Anda" required>
                </div>

                <button type="submit" class="btn btn-orange w-100 mt-3">Masuk</button>

                {{-- <div class="text-center mt-3 login-footer">
                    <p class="text-sm text-gray-600 mb-0">Belum punya akun?
                    </p>
                </div> --}}
            </div>
        </div>
    </div>
</form>

<style>
    .login-wrapper {
        height: calc(100vh - 66px);
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #ffffff;
        background-image: linear-gradient(135deg, #fff 50%, #fef7f5 50%);
    }

    .login-card {
        background-color: #fff;
        border: 1px solid #e5e7eb;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        border-radius: 1rem;
        width: 100%;
        max-width: 420px;
        padding: 2.5rem;
        transition: all 0.3s ease;
    }

    .login-card:hover {
        box-shadow: 0 10px 35px rgba(0, 0, 0, 0.12);
    }

    .login-title {
        font-weight: 800;
        color: #1a1a1a;
        text-align: center;
        margin-bottom: 1rem;
    }

    .login-subtitle {
        text-align: center;
        color: #6b7280;
        font-size: 0.95rem;
        margin-bottom: 2rem;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
    }

    .form-control {
        border-radius: 0.6rem;
        border: 1px solid #d1d5db;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
    }

    .form-control:focus {
        border-color: #F15A29;
        box-shadow: 0 0 0 0.2rem rgba(241, 90, 41, 0.25);
    }

    .btn-orange {
        background-color: #F15A29;
        color: #fff;
        font-weight: 600;
        border-radius: 0.6rem;
        padding: 0.75rem;
        transition: all 0.2s ease-in-out;
    }

    .btn-orange:hover {
        background-color: #d94c21;
    }

    .login-footer a {
        color: #F15A29;
        font-weight: 600;
        text-decoration: none;
    }

    .login-footer a:hover {
        text-decoration: underline;
    }
</style>

@endsection

{{-- belum di route -jae --}}