@extends('layouts.app')

@section('content')
<div class="d-flex">
    @include('layouts.sidebar')

    <div class="flex-grow-1" style="background-color: #f8f9fa; min-height: 100vh;">
        
        @include('layouts.navbar')

        <div class="container-fluid py-4 px-4">
            <div class="row g-4">
                
                <div class="col-12">
                    <div class="card shadow-sm border-0 p-4 bg-white rounded-3 mb-4">
    <div class="d-flex align-items-center gap-4">
        
        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center fw-bold shadow-sm" 
             style="width: 100px; height: 100px; font-size: 2.5rem; min-width: 100px;">
            {{ strtoupper(substr(Auth::user()->nama, 0, 2)) }}
        </div>

        <div class="flex-grow-1">
            <h2 class="fw-bold text-dark mb-2 m-0">{{ Auth::user()->nama }}</h2>
            
            <span class="badge bg-light text-success border border-success px-3 py-2 rounded-pill fw-semibold">
                <i class="bi bi-mortarboard-fill me-2"></i> 
                {{ Auth::user()->kelas ?? 'Belum Pilih Kelas' }}
            </span>
        </div>

        <div>
            <button class="btn btn-success rounded-3 px-4 py-2 fw-semibold d-flex align-items-center gap-2 shadow-sm">
                <i class="bi bi-share"></i> Bagian Profil
            </button>
        </div>

    </div>
</div>
                </div>

                <div class="col-lg-8">
                    <div class="row g-4">
                        
                        @php
                            $persentase = $totalTugas > 0 ? round(($totalCompleted / $totalTugas) * 100) : 0;

                            // Logika Grade Akademik Rating dinamis berdasarkan nilai persentase
                            if ($persentase >= 90) {
                                $grade = 'A+';
                                $pesan = 'Luar biasa! Kamu termasuk murid paling produktif.';
                            } elseif ($persentase >= 75) {
                                $grade = 'A';
                                $pesan = 'Kinerja bagus! Pertahankan ritme kerjamu.';
                            } elseif ($persentase >= 60) {
                                $grade = 'B';
                                $pesan = 'Cukup baik, ayo selesaikan tugas yang tersisa.';
                            } elseif ($persentase >= 40) {
                                $grade = 'C';
                                $pesan = 'Ayo lebih giat lagi mengumpulkan tugas!';
                            } else {
                                $grade = 'D';
                                $pesan = 'Waduh, segera cicil tugas-tugasmu yang menumpuk!';
                            }
                        @endphp

                        <div class="col-md-6">
                            <div class="card shadow-sm border-0 p-4 bg-white rounded-3 h-100">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="p-3 bg-success-subtle text-success rounded-3">
                                        <i class="bi bi-check-all fs-4"></i>
                                    </div>
                                    <span class="badge bg-success text-white px-2 py-1 rounded">{{ $persentase }}% Selesai</span>
                                </div>
                                
                                <small class="text-muted fw-bold text-uppercase tracking-wider">Total Tasks Completed</small>
                                
                                <h1 class="fw-bold text-dark my-2" style="font-size: 2.8rem;">
                                    {{ $totalCompleted }} 
                                    <span class="fs-4 text-muted fw-normal">/ {{ $totalTugas }} Tugas</span>
                                </h1>
                                
                                <div class="progress rounded-pill mt-3" style="height: 6px;">
                                    <div class="progress-bar bg-success rounded-pill" role="progressbar" style="width: {{ $persentase }}%" aria-valuenow="{{ $persentase }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                
                                <small class="text-muted d-block mt-2">
                                    <i class="bi bi-info-circle text-success me-1"></i> 
                                    {{ $totalCompleted }} dari {{ $totalTugas }} tugas telah terverifikasi selesai.
                                </small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card shadow-sm border-0 p-4 bg-white rounded-3 h-100">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="p-3 bg-primary-subtle text-primary rounded-3">
                                        <i class="bi bi-star-fill fs-4"></i>
                                    </div>
                                    <span class="badge bg-primary text-white px-2 py-1 rounded">
                                        {{ $persentase >= 75 ? 'Peringkat Atas' : 'Perlu Ditingkatkan' }}
                                    </span>
                                </div>
                                <small class="text-muted fw-bold text-uppercase tracking-wider">Akademik Rating</small>
                                <h1 class="fw-bold text-dark my-2" style="font-size: 2.8rem;">{{ $grade }}</h1>
                                <div class="progress rounded-pill mt-3" style="height: 6px;">
                                    <div class="progress-bar bg-primary rounded-pill" role="progressbar" style="width: {{ $persentase }}%"></div>
                                </div>
                                <small class="text-muted d-block mt-2"><i class="bi bi-graph-up-arrow text-primary me-1"></i> {{ $pesan }}</small>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card shadow-sm border-0 p-4 bg-white rounded-3">
                                <h5 class="fw-bold text-dark mb-4 pb-2 border-bottom"><i class="bi bi-person-badge-fill me-2 text-secondary"></i>Personal Information</h5>
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label class="text-muted small d-block fw-bold text-uppercase mb-1">Email Address</label>
                                        <span class="fw-semibold text-dark fs-6">{{ $user->email }}</span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="text-muted small d-block fw-bold text-uppercase mb-1">Phone Number</label>
                                        <span class="fw-semibold text-dark fs-6">{{ $user->phone ?? 'Belum diisi' }}</span>
                                    </div>
                                    <div class="col-sm-6 mt-3">
                                        <label class="text-muted small d-block fw-bold text-uppercase mb-1">Student ID (NISN)</label>
                                        <span class="fw-semibold text-dark fs-6">{{ $user->nisn ?? 'Belum diisi' }}</span>
                                    </div>
                                    <div class="col-sm-6 mt-3">
                                        <label class="text-muted small d-block fw-bold text-uppercase mb-1">Enrollment Year</label>
                                        <span class="fw-semibold text-dark fs-6">{{ $user->enrollment_year ?? 'Belum diisi' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> </div> <div class="col-lg-4">
                    <div class="card shadow-sm border-0 p-4 bg-white rounded-3 h-100">
                        <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom">
                            <i class="bi bi-gear-fill me-2 text-secondary"></i>Account Settings
                        </h5>
                        
                        <div class="list-group list-group-flush">
                            <a href="{{ route('password.edit') }}" class="py-3 d-flex justify-content-between align-items-center border-bottom text-decoration-none text-dark" style="cursor: pointer;">
                                <span class="fw-semibold">
                                    <i class="bi bi-shield-lock me-3 text-muted fs-5"></i> Ganti Password
                                </span>
                                <i class="bi bi-chevron-right text-muted small"></i>
                            </a>

                            <a href="#" onclick="alert('Fitur pengaturan notifikasi sedang dalam pengembangan!')" class="py-3 d-flex justify-content-between align-items-center border-bottom text-decoration-none text-dark" style="cursor: pointer;">
                                <span class="fw-semibold">
                                    <i class="bi bi-bell me-3 text-muted fs-5"></i> Notifikasi Sistem
                                </span>
                                <i class="bi bi-chevron-right text-muted small"></i>
                            </a>
                        </div>
                        
                        <form action="{{ route('profile.deactivate') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menonaktifkan akun ini secara permanen?')" class="mt-4">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100 rounded-3 py-2 fw-bold">
                                Nonaktifkan Akun
                            </button>
                        </form>
                    </div>
                </div> </div> </div> </div> </div> @endsection