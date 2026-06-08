@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex">

        @include('layouts.sidebar')

        <div class="flex-grow-1">

            @include('layouts.navbar')

            <div class="p-4">

                <h1 class="fw-bold text-dark mb-1">
                    Welcome back, {{ auth()->user()->nama }}! 
                    @if(auth()->user()->email == 'admin@gmail.com')
                        <span class="badge bg-primary fs-6 align-middle ms-2">Admin</span>
                    @else
                        <span class="badge bg-success fs-6 align-middle ms-2">Siswa ({{ auth()->user()->kelas ?? 'Umum' }})</span>
                    @endif
                </h1>

                <p class="text-muted mb-4">
                    @if(auth()->user()->email == 'admin@gmail.com')
                        Kelola data dan pantau seluruh tugas sekolah dengan lebih mudah.
                    @else
                        Kelola tugas sekolahmu dan pantau progres belajarmu dengan lebih mudah.
                    @endif
                </p>

                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-3">
                        <div class="card shadow-sm border-0 h-100 bg-white">
                            <div class="card-body">
                                <h6 class="text-muted fw-semibold small text-uppercase">Total Tasks</h6>
                                <h2 class="fw-bold text-dark mb-0">{{ $totalTugas ?? 0 }}</h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="card shadow-sm border-0 h-100 bg-white">
                            <div class="card-body">
                                <h6 class="text-muted fw-semibold small text-uppercase text-secondary">Belum Dikerjakan</h6>
                                <h2 class="fw-bold text-secondary mb-0">{{ $belum ?? 0 }}</h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="card shadow-sm border-0 h-100 bg-white">
                            <div class="card-body">
                                <h6 class="text-muted fw-semibold small text-uppercase text-warning">Sedang Dikerjakan</h6>
                                <h2 class="fw-bold text-warning-emphasis mb-0">{{ $proses ?? 0 }}</h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="card shadow-sm border-0 h-100 bg-white">
                            <div class="card-body">
                                <h6 class="text-muted fw-semibold small text-uppercase text-success">Selesai</h6>
                                <h2 class="fw-bold text-success mb-0">{{ $selesai ?? 0 }}</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">

                    <div class="col-lg-8">
                        <div class="card shadow-sm border-0 h-100 bg-white">
                            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom-0">
                                <h5 class="mb-0 fw-bold text-dark">
                                    @if(auth()->user()->email == 'admin@gmail.com')
                                        📋 Tugas Terbaru (Semua Siswa)
                                    @else
                                        📋 Tugas Terbaru Saya
                                    @endif
                                </h5>
                                <a href="{{ route('task.index') }}" class="btn btn-success btn-sm px-3 fw-semibold rounded-pill">
                                    Lihat Semua
                                </a>
                            </div>

                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light text-uppercase fs-7 text-secondary border-bottom">
                                            <tr>
                                                <th scope="col" class="py-3 ps-4" style="width: 40%;">Nama Tugas</th>
                                                <th scope="col" class="py-3" style="width: 25%;">Status Progres</th>
                                                <th scope="col" class="py-3 pe-4" style="width: 35%;">Batas Waktu (Deadline)</th>
                                            </tr>
                                        </thead>
                                        <tbody class="border-top-0">
                                            @forelse($recentTasks ?? [] as $task)
                                            @php
                                                if (!$task) continue;

                                                // 1. Deteksi kolom jam dari database
                                                $jamTugas = $task->jam_deadline ?? $task->jam ?? '23:59:00';
                                                
                                                // 2. Gabungkan tanggal dan jam menjadi Carbon objek
                                                $waktuDeadline = \Carbon\Carbon::parse(($task->deadline ?? now()->toDateString()) . ' ' . $jamTugas);
                                                $sekarang = \Carbon\Carbon::now();
                                                
                                                // 3. Hitung selisih jam
                                                $sisaJam = $sekarang->diffInHours($waktuDeadline, false);
                                                $statusId = $task->status_id ?? null;

                                                // 4. Logika penentuan warna teks & Badge Keterangan Waktu
                                                if ($statusId == 3) {
                                                    $warnaWaktu = 'text-success';
                                                    $badgeWaktu = '<span class="badge bg-success-subtle text-success border border-success-subtle ms-2 px-2 py-1 small">Selesai</span>';
                                                } elseif ($sisaJam < 0) {
                                                    $warnaWaktu = 'text-danger fw-bold';
                                                    $badgeWaktu = '<span class="badge bg-danger-subtle text-danger border border-danger-subtle ms-2 px-2 py-1 small">Terlewat!</span>';
                                                } elseif ($sisaJam <= 24) {
                                                    $warnaWaktu = 'text-warning-emphasis fw-bold';
                                                    $badgeWaktu = '<span class="badge bg-warning-subtle text-warning border border-warning-subtle ms-2 px-2 py-1 small">Mepet!</span>';
                                                } else {
                                                    $warnaWaktu = 'text-dark';
                                                    $badgeWaktu = '';
                                                }

                                                // 5. Logika Desain Badge Status Progress
                                                if ($statusId == 3) {
                                                    $badgeStatus = '<span class="badge bg-success text-white px-2.5 py-1.5 rounded-pill fs-7"><i class="bi bi-check-circle-fill me-1"></i> Selesai</span>';
                                                } elseif ($statusId == 2) {
                                                    $badgeStatus = '<span class="badge bg-warning text-dark px-2.5 py-1.5 rounded-pill fs-7"><i class="bi bi-hourglass-split me-1"></i> Dikerjakan</span>';
                                                } else {
                                                    $badgeStatus = '<span class="badge bg-secondary text-white px-2.5 py-1.5 rounded-pill fs-7"><i class="bi bi-bookmark-fill me-1"></i> Belum Mulai</span>';
                                                }
                                            @endphp

                                            <tr>
                                                <td class="py-3 ps-4 fw-semibold text-dark text-truncate" style="max-width: 250px;">
                                                    {{ $task->judul_tugas ?? 'Tanpa Judul' }}
                                                </td>
                                                <td class="py-3">
                                                    {!! $badgeStatus !!}
                                                </td>
                                                <td class="py-3 pe-4">
                                                    <div class="{{ $warnaWaktu }} d-flex align-items-center flex-wrap gap-1 fs-7">
                                                        <span>📅 {{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('d-m-Y') : '-' }}</span>
                                                        <span class="ms-2">⏰ {{ \Carbon\Carbon::parse($jamTugas)->format('H:i') }} WIB</span>
                                                        {!! $badgeWaktu !!}
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="3" class="text-center py-5 text-muted">
                                                    <div class="mb-2 fs-3 text-secondary">📁</div>
                                                    <span class="fw-medium">Belum ada data tugas terbaru yang tercatat.</span>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">

                        <div class="card shadow-sm border-0 mb-4 bg-white">
                            <div class="card-header bg-white py-3 border-bottom-0">
                                <h5 class="mb-0 fw-bold text-dark">📊 Grafik Status Tugas</h5>
                            </div>
                            <div class="card-body pt-0">
                                <div style="position: relative; height:220px; width:100%">
                                    <canvas id="statusTaskChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm border-0 bg-white">
                            <div class="card-header bg-white py-3 border-bottom-0">
                                <h5 class="mb-0 fw-bold text-dark">ℹ️ Informasi Akun Tugas</h5>
                            </div>
                            <div class="card-body pt-0">
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <strong class="text-secondary">Total Tugas :</strong>
                                    <span class="badge bg-dark px-2.5 py-1.5 rounded text-white fw-bold">{{ $totalTugas ?? 0 }}</span>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <strong class="text-secondary">Belum Dikerjakan :</strong>
                                    <span class="badge bg-secondary px-2.5 py-1.5 rounded text-white fw-bold">{{ $belum ?? 0 }}</span>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <strong class="text-secondary">Sedang Dikerjakan :</strong>
                                    <span class="badge bg-warning text-dark px-2.5 py-1.5 rounded fw-bold">{{ $proses ?? 0 }}</span>
                                </div>
                                <div class="d-flex justify-content-between py-2">
                                    <strong class="text-secondary">Selesai :</strong>
                                    <span class="badge bg-success px-2.5 py-1.5 rounded text-white fw-bold">{{ $selesai ?? 0 }}</span>
                                </div>
                            </div>
                        </div>

                    </div> </div> </div> </div> </div> </div> <script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('statusTaskChart');
        
        if (ctx) {
            // SINKRONISASI VARIABEL: Menggunakan variabel '$selesai' milik controller Anda
            const tugasSelesai = {{ $selesai ?? 0 }};
            const totalTugas = {{ $totalTugas ?? 0 }};
            
            let sisaTugas = totalTugas - tugasSelesai;
            if (sisaTugas < 0) sisaTugas = 0; 

            new Chart(ctx, {
                type: 'doughnut', 
                data: {
                    labels: ['Selesai', 'Belum Selesai'],
                    datasets: [{
                        label: 'Jumlah Tugas',
                        data: [tugasSelesai, sisaTugas], 
                        backgroundColor: [
                            '#198754', // Hijau
                            '#dc3545'  // Merah
                        ],
                        borderColor: ['#ffffff', '#ffffff'],
                        borderWidth: 2,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom', 
                            labels: {
                                boxWidth: 12,
                                padding: 15,
                                font: { size: 12, weight: '500' }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    let value = context.raw || 0;
                                    return ` ${label}: ${value} Tugas`;
                                }
                            }
                        }
                    },
                    cutout: '72%' 
                }
            });
        }
    });
</script>
@endsection