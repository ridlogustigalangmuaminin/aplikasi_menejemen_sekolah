<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container mt-5 py-4">

    <div class="row justify-content-center">

        <div class="col-md-6 col-lg-5">

            <div class="card shadow border-0 rounded-3">

                <div class="card-body p-4">

                    <h3 class="text-center mb-4 fw-bold text-dark">Register</h3>

                    @if ($errors->any())
                        <div class="alert alert-danger border-0 rounded-3 small py-2 mb-3">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary small">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary small">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-semibold text-secondary small">NISN</label>
                                <input type="text" name="nisn" class="form-control" value="{{ old('nisn') }}" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold text-secondary small">Nomor Telepon</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label for="kelas" class="form-label fw-semibold text-secondary small">Kelas</label>
                                <input id="kelas" type="text" class="form-control" name="kelas" value="{{ old('kelas') }}" placeholder="Contoh: XII RPL 1">
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold text-secondary small">Tahun Masuk</label>
                                <input type="number" name="enrollment_year" class="form-control" value="{{ old('enrollment_year', 2026) }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary small">Password</label>
                            <div class="input-group">
                                <input type="password" id="password" name="password" class="form-control border-end-0" required>
                                <button class="btn btn-outline-secondary border-start-0" type="button" onclick="togglePass('password', 'icon-pass')">
                                    <i class="bi bi-eye" id="icon-pass"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary small">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control border-end-0" required>
                                <button class="btn btn-outline-secondary border-start-0" type="button" onclick="togglePass('password_confirmation', 'icon-confirm')">
                                    <i class="bi bi-eye" id="icon-confirm"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-2 fw-semibold rounded-3">
                            Register
                        </button>

                    </form>

                    <p class="text-center mt-3 mb-0 small text-muted">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-success fw-semibold text-decoration-none">Login</a>
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

<script>
function togglePass(inputId, iconId) {
    const passwordInput = document.getElementById(inputId);
    const icon = document.getElementById(iconId);

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash"); // Mengubah ikon jadi mata dicoret
    } else {
        passwordInput.type = "password";
        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye"); // Mengubah kembali jadi mata normal
    }
}
</script>

</body>
</html>