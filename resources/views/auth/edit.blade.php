@extends('layouts.app')

@section('content')
<div class="d-flex">
    @include('layouts.sidebar')

    <div class="flex-grow-1" style="background-color: #f8f9fa; min-height: 100vh;">
        @include('layouts.navbar')

        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card shadow-sm border-0 p-4 bg-white rounded-3">
                        <div class="d-flex align-items-center gap-3 mb-3 pb-2 border-bottom">
                            <a href="{{ route('profile.index') }}" class="btn btn-light btn-sm rounded-circle">
                                <i class="bi bi-arrow-left"></i>
                            </a>
                            <h5 class="fw-bold text-dark m-0">Ubah Kata Sandi</h5>
                        </div>

                        <form action="{{ route('password.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="current_password" class="form-label text-muted small fw-bold text-uppercase">Password Sekarang</label>
                                <input type="password" name="current_password" id="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label text-muted small fw-bold text-uppercase">Password Baru</label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label text-muted small fw-bold text-uppercase">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ route('profile.index') }}" class="btn btn-light w-50 fw-semibold rounded-3 py-2">Batal</a>
                                <button type="submit" class="btn btn-success w-50 fw-semibold rounded-3 py-2">Perbarui Password</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection