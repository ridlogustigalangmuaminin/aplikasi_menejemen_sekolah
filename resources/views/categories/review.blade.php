@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex">
        @include('layouts.sidebar')

        <div class="flex-grow-1">
            @include('layouts.navbar')

            <div class="container-fluid p-4">
                <div class="mb-4">
                    <a href="{{ route('categories.index') }}" class="btn btn-sm btn-secondary mb-2">⬅️ Kembali ke Kategori</a>
                    <h2 class="fw-bold text-dark">📋 Validasi Tugas Kategori: {{ $category->nama_kategori }}</h2>
                    <p class="text-muted">Berikut adalah daftar pengumpulan jawaban siswa pada kategori ini.</p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <!-- THEAD: Dibuat gelap elegan dengan teks agak abu-abu lembut -->
                <thead class="table-dark text-uppercase fs-7 border-0" style="letter-spacing: 0.5px; opacity: 0.9;">
                    <tr>
                        <th scope="col" class="py-3 ps-4" style="width: 25%;"> Nama Tugas</th>
                        <th scope="col" class="py-3" style="width: 20%;">🧑‍🎓 Siswa Pengirim</th>
                        <th scope="col" class="py-3" style="width: 40%;">📝 Isi Jawaban Siswa</th>
                        <th scope="col" class="py-3 text-center pe-4" style="width: 15%;"> Verification</th>
                    </tr>
                </thead>
                
                <!-- TBODY: Menggunakan border halus antar baris -->
                <tbody class="border-top-0">
                    @forelse($submissions as $submission)
                    <tr class="transition-all">
                        
                        <!-- 1. DETAIL TUGAS -->
                        <td class="py-4 ps-4">
                            <span class="fw-bold text-dark fs-6 d-block mb-1">
                                {{ $submission->tugas->judul_tugas ?? 'Tugas Terhapus' }}
                            </span>
                            <span class="badge bg-light text-secondary border rounded-pill px-2 py-1 small">
                                <i class="bi bi-clock-history me-1"></i>
                                {{ $submission->created_at->format('d M Y, H:i') }} WIB
                            </span>
                        </td>

                        <!-- 2. AVATAR & NAMA SISWA -->
                        <td class="py-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-gradient bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" 
                                     style="width: 40px; height: 40px; font-size: 16px; background: linear-gradient(45deg, #0d6efd, #0b5ed7);">
                                    {{ strtoupper(substr($submission->tugas->user->name ?? 'S', 0, 1)) }}
                                </div>
                                <div>
                                    <span class="fw-semibold text-dark d-block mb-0 fs-6">
                                        {{ $submission->tugas->user->name ?? 'Siswa Tidak Diketahui' }}
                                    </span>
                                    <small class="text-muted d-block small" style="font-size: 13px;">
                                        {{ $submission->tugas->user->email ?? '-' }}
                                    </small>
                                </div>
                            </div>
                        </td>

                        <!-- 3. BOX ISI JAWABAN (Dibuat mirip gelembung chat bersih) -->
                        <td class="py-4">
                            <div class="p-3 bg-light rounded-3 text-secondary text-wrap border border-light-subtle shadow-inner" 
                                 style="white-space: pre-line; max-height: 120px; overflow-y: auto; font-size: 14px; line-height: 1.6;">
                                {{ $submission->file_name }}
                            </div>
                        </td>

                        <!-- 4. SAKELAR ACC AUTOMATIC -->
                        <td class="py-4 text-center pe-4">
                            <form action="{{ route('lampiran.categoryAcc', $submission->id) }}" method="POST">
                                @csrf
                                <div class="form-check form-switch d-inline-block mb-1">
                                    <input 
                                        class="form-check-input custom-switch" 
                                        type="checkbox" 
                                        name="is_accepted" 
                                        role="switch"
                                        id="accSwitch{{ $submission->id }}"
                                        value="1"
                                        {{ $submission->is_accepted ? 'checked' : '' }}
                                        onchange="this.form.submit()"
                                        style="transform: scale(1.4); cursor: pointer;"
                                    >
                                </div>
                                <div class="mt-2">
                                    @if($submission->is_accepted)
                                        <span class="badge bg-success border border-success-subtle rounded-pill px-3 py-1.5 fw-semibold shadow-sm animate-fade-in" style="font-size: 11px;">
                                            ● DITERIMA (ACC)
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark border border-warning-subtle rounded-pill px-3 py-1.5 fw-semibold shadow-sm" style="font-size: 11px;">
                                            ● MENUGGU VALIDASI
                                        </span>
                                    @endif
                                </div>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <!-- TAMPILAN KOSONG: Dibuat super clean dengan ilustrasi emoji -->
                    <tr>
                        <td colspan="4" class="text-center text-muted py-5 bg-light-subtle shadow-inner rounded-3">
                            <div class="display-5 mb-3 filter-grayscale opacity-75">📥</div>
                            <h5 class="fw-bold text-dark mb-1">Belum Ada Pengumpulan</h5>
                            <p class="text-muted small mb-0">Para siswa belum mengirimkan jawaban teks di dalam kategori ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

            </div>
        </div>
    </div>
</div>
@endsection