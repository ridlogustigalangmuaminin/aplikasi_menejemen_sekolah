<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login – EduTask</title>
  <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/906/906334.png" type="image/png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600&family=Syne:wght@700;800&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: #0d1117;
      min-height: 100vh;
    }
    .left-panel {
      background: linear-gradient(145deg, #0a3d2e 0%, #0d1117 60%);
      min-height: 100vh;
      position: relative;
      overflow: hidden;
    }
    .left-panel::before {
      content: '';
      position: absolute;
      top: -80px; left: -80px;
      width: 320px; height: 320px;
      background: radial-gradient(circle, #1D9E7522 0%, transparent 70%);
    }
    .left-panel::after {
      content: '';
      position: absolute;
      bottom: -60px; right: 20px;
      width: 220px; height: 220px;
      background: radial-gradient(circle, #5DCAA522 0%, transparent 70%);
    }
    .brand-icon {
      width: 38px; height: 38px;
      background: #1D9E75;
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
    }
    .brand-icon i { font-size: 20px; color: #fff; }
    .brand-name {
      font-family: 'Syne', sans-serif;
      font-size: 20px; color: #fff; font-weight: 700;
    }
    .hero-title {
      font-family: 'Syne', sans-serif;
      font-size: 36px; font-weight: 800;
      color: #fff; line-height: 1.2;
      letter-spacing: -1px;
    }
    .hero-title span { color: #1D9E75; }
    .hero-sub { font-size: 14px; color: #6b7c93; line-height: 1.7; }
    .feature-item { font-size: 13px; color: #8fa3b8; }
    .feature-dot {
      width: 6px; height: 6px;
      border-radius: 50%; background: #1D9E75;
      flex-shrink: 0; margin-top: 6px;
    }
    .right-panel {
      background: #fff;
      min-height: 100vh;
    }
    .form-title {
      font-family: 'Syne', sans-serif;
      font-size: 26px; font-weight: 800;
      color: #0d1117; letter-spacing: -0.5px;
    }
    .form-control {
      padding-left: 40px;
      border: 1.5px solid #e5e7eb;
      background: #fafafa;
      font-size: 13px;
      border-radius: 9px;
    }
    .form-control:focus {
      border-color: #1D9E75;
      background: #fff;
      box-shadow: none;
    }
    .input-icon {
      position: absolute;
      left: 13px; top: 50%;
      transform: translateY(-50%);
      font-size: 16px; color: #9ca3af;
      z-index: 5;
    }
    .pass-toggle {
      position: absolute;
      right: 13px; top: 50%;
      transform: translateY(-50%);
      font-size: 16px; color: #9ca3af;
      cursor: pointer; z-index: 5;
    }
    .btn-login {
      background: #1D9E75;
      color: #fff;
      border: none;
      border-radius: 9px;
      font-size: 14px; font-weight: 600;
      padding: 11px;
      width: 100%;
      transition: background 0.2s;
    }
    .btn-login:hover { background: #0F6E56; color: #fff; }
    .forgot-link { font-size: 12px; color: #1D9E75; text-decoration: none; font-weight: 500; }
    .forgot-link:hover { color: #0F6E56; }
    .register-link { font-size: 13px; color: #6b7c93; }
    .register-link a { color: #1D9E75; font-weight: 600; text-decoration: none; }
    .remember-label { font-size: 12px; color: #6b7c93; }
    .form-check-input:checked { background-color: #1D9E75; border-color: #1D9E75; }
    @media (max-width: 768px) {
      .left-panel { display: none; }
    }
  </style>
</head>
<body>
<div class="container-fluid p-0">
  <div class="row g-0">

    {{-- KIRI --}}
    <div class="col-md-7 left-panel d-flex flex-column justify-content-between p-5">
      {{-- Brand --}}
      <div class="d-flex align-items-center gap-2">
        <div class="brand-icon"><i class="ti ti-checklist"></i></div>
        <div class="brand-name">EduTask</div>
      </div>

      {{-- Hero --}}
      <div>
        <div class="hero-title mb-3">
          Kelola tugasmu<br>lebih <span>terstruktur</span>
        </div>
        <p class="hero-sub" style="max-width:300px;">
          Pantau semua tugas sekolah, deadline, dan lampiran dalam satu tempat.
        </p>
      </div>

      {{-- Features --}}
      <div class="d-flex flex-column gap-2">
        <div class="d-flex align-items-start gap-2 feature-item">
          <div class="feature-dot"></div> Manajemen tugas dengan kategori & status
        </div>
        <div class="d-flex align-items-start gap-2 feature-item">
          <div class="feature-dot"></div> Upload lampiran PDF, gambar, dokumen
        </div>
        <div class="d-flex align-items-start gap-2 feature-item">
          <div class="feature-dot"></div> Pantau deadline secara real-time
        </div>
      </div>
    </div>

    {{-- KANAN --}}
    <div class="col-md-5 right-panel d-flex align-items-center justify-content-center">
      <div style="width: 100%; max-width: 380px; padding: 40px 32px;">

        <div class="form-title mb-1 fs-1">Masuk ke akun</div>
        <p class="mb-4" style="font: size 20px; color:#6b7c93;">Selamat datang 👋</p>

        {{-- Alert Error --}}
        @if($errors->any())
          <div class="alert alert-danger py-2 px-3" style="font-size:12px; border-radius:9px;">
            {{ $errors->first() }}
          </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
          @csrf

          {{-- Email --}}
          <div class="mb-3">
            <label class="form-label" style="font-size:12px; font-weight:600; color:#374151;">Email</label>
            <div class="position-relative">
              <i class="ti ti-mail input-icon"></i>
              <input
                type="email"
                name="email"
                class="form-control"
                placeholder="email@siswa.sch.id"
                value="{{ old('email') }}"
                required
              >
            </div>
          </div>

          {{-- Password --}}
          <div class="mb-3">
            <label class="form-label" style="font-size:12px; font-weight:600; color:#374151;" for="password">Password</label>
            <div class="position-relative">
              <i class="ti ti-lock input-icon"></i>
              <input
                type="password"
                name="password"
                id="password"
                class="form-control"
                placeholder="Masukkan password"
                required
              >
              <i class="ti ti-eye pass-toggle" onclick="togglePass()"></i>
            </div>
          </div>

          {{-- Remember & Forgot --}}
          <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="remember" id="remember">
              <label class="form-check-label remember-label" for="remember">Ingat saya</label>
            </div>
            @if(Route::has('password.request'))
              <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
            @endif
          </div>

          <button type="submit" class="btn-login mb-3">Masuk</button>

        </form>

        <form action="">
          <p class="register-link text-center">
            Belum punya akun?
            <a href="{{ route('register') }}">Daftar sekarang</a>
          </p>
        </form>

      </div>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function togglePass() {
    const input = document.getElementById('password');
    input.type = input.type === 'password' ? 'text' : 'password';
  }
</script>
</body>
</html>