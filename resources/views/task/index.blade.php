@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex">

        @include('layouts.sidebar')

        <div class="flex-grow-1">

            @include('layouts.navbar')

            <div class="container p-4">

                {{-- Bagian Header & Tombol Tambah --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h3 mb-0 text-gray-800 fw-bold">
                        @if(auth()->user()->email == 'admin@gmail.com')
                            🗃️ Task List (Semua Pengumpulan Siswa)
                        @else
                            📝 Daftar Tugas Saya
                        @endif
                    </h2>

                    {{-- Tombol Tambah Task Hanya Muncul untuk Admin/Guru --}}
                    @if(auth()->user()->email == 'admin@gmail.com')
                        <a href="{{ route('task.create') }}" class="btn btn-primary d-flex align-items-center gap-2 rounded-pill px-4 shadow-sm fw-semibold">
                            <i class="bi bi-plus-circle-fill"></i> Tambah Task Baru
                        </a>
                    @endif
                </div>

                {{-- Alert Notifikasi Sukses --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Struktur Tabel Utama --}}
                <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-dark text-uppercase fs-7">
                                    <tr>
                                        {{-- Kolom Nama Siswa Hanya Terbuka untuk Guru --}}
                                        @if(auth()->user()->email == 'admin@gmail.com')
                                            <th style="width: 20%;" class="py-3 ps-3">Siswa</th>
                                        @endif
                                        <th class="py-3">Judul Tugas</th>
                                        <th style="width: 15%;" class="py-3">Kategori</th> 
                                        <th style="width: 20%;" class="py-3 text-center">Status Verifikasi (ACC)</th>
                                        <th style="width: 15%;" class="py-3">Deadline</th>
                                        <th style="width: 15%;" class="text-center py-3 pe-3">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody class="border-top-0">
                                    @forelse($tasks as $task)
                                    <tr>
                                        {{-- Tampilkan data nama siswa jika login sebagai admin --}}
                                        @if(auth()->user()->email == 'admin@gmail.com')
                                            <td class="ps-3">
                                                <span class="fw-bold text-dark d-block mb-0">{{ $task->user->name ?? 'Siswa Tidak Ditemukan' }}</span>
                                                <small class="text-muted small">{{ $task->user->email ?? '' }}</small>
                                            </td>
                                        @endif

                                        {{-- Judul Tugas --}}
                                        <td>
                                            <span class="fw-semibold text-dark">{{ $task->judul_tugas }}</span>
                                        </td>
                                        
                                        {{-- Kategori Dinamis dari Database --}}
                                        <td>
                                            <span class="badge bg-info-subtle text-info border border-info-subtle px-2.5 py-1.5 rounded">
                                                📁 {{ $task->kategori->nama_kategori ?? 'Umum' }}
                                            </span>
                                        </td>

                                        {{-- Status Verifikasi ACC (Mengambil dari Relasi Lampirans) --}}
                                        <td>
    @php
        // Mengantisipasi jika relasinya berbentuk many (collection) atau single (object)
        $lampiran = $task->lampiran;
        if ($lampiran instanceof \Illuminate\Support5\Collection || $lampiran instanceof \Illuminate\Database\Eloquent\Collection) {
            $lampiran = $lampiran->first();
        }
    @endphp

    @if($lampiran && $lampiran->is_accepted == 1)
        {{-- JIKA SUDAH DI-ACC ADMIN --}}
        <span class="badge bg-success px-2 py-1">
            <i class="bi bi-check-circle-fill me-1"></i> Selesai (ACC)
        </span>
    @elseif($lampiran)
        {{-- JIKA JAWABAN SUDAH MASUK TAPI BELUM DI-ACC --}}
        <span class="badge bg-warning text-dark px-2 py-1">
            <i class="bi bi-hourglass-split me-1"></i> Menunggu Tinjauan
        </span>
    @else
        {{-- JIKA SAMA SEKALI BELUM MENGUMPULKAN --}}
        <span class="badge bg-secondary px-2 py-1">
            {{ $task->status->nama_status ?? 'Belum Dikerjakan' }}
        </span>
    @endif
</td>
                                        
                                        {{-- Deadline --}}
                                        <td>
                                            <span class="text-secondary small fw-medium">
                                                {{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('d M Y') : 'Tanpa Deadline' }}
                                            </span>
                                        </td>

                                        {{-- Tombol Aksi Dinamis Admin / Siswa --}}
                                        <td class="text-center pe-3">
                                            <div class="d-flex justify-content-center gap-2">
                                                @if(auth()->user()->email == 'admin@gmail.com')
                                                    {{-- Jika Admin: Tombol Edit Soal Asli --}}
                                                    <a href="{{ route('task.edit', $task->id) }}" class="btn btn-sm btn-outline-warning rounded-pill px-3 fw-semibold fs-7">
                                                        <i class="bi bi-pencil-square"></i> Edit
                                                    </a>
                                                    
                                                    {{-- Tombol Hapus Hanya untuk Admin --}}
                                                    <form action="{{ route('task.destroy', $task->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus task ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-semibold fs-7">
                                                            <i class="bi bi-trash"></i> Hapus
                                                        </button>
                                                    </form>
                                                @else
                                                    {{-- Jika Siswa: Tombol Kerjakan --}}
                                                    <a href="{{ route('task.edit', $task->id) }}" class="btn btn-success btn-sm rounded-pill px-4 fw-semibold shadow-sm">
                                                        <i class="bi bi-pencil"></i> Kerjakan
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        {{-- Dynamic colspan menyesuaikan jumlah kolom guru/siswa --}}
                                        <td colspan="{{ auth()->user()->email == 'admin@gmail.com' ? 6 : 5 }}" class="text-center py-5 text-muted">
                                            <i class="bi bi-clipboard-x d-block display-5 mb-2 text-secondary opacity-50"></i>
                                            <span class="fw-semibold d-block text-dark">Belum ada task yang tercatat.</span>
                                            <small class="text-secondary">Sistem tidak mendeteksi adanya data tugas saat ini.</small>
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