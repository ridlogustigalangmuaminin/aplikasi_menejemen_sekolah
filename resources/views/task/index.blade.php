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
                    <h2 class="h3 mb-0 text-gray-800">
                        @if(auth()->user()->email == 'admin@gmail.com')
                            Task List (Semua Siswa)
                        @else
                            Daftar Tugas Saya
                        @endif
                    </h2>

                    {{-- Tombol Tambah Task Hanya Muncul untuk Admin/Guru --}}
                    @if(auth()->user()->email == 'admin@gmail.com')
                        <a href="{{ route('task.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                            <i class="bi bi-plus-circle"></i> Tambah Task Baru
                        </a>
                    @endif
                </div>

                {{-- Alert Notifikasi Sukses --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Struktur Tabel Utama --}}
                <div class="card shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mb-0 align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        {{-- Kolom Nama Siswa Hanya Terbuka untuk Guru --}}
                                        @if(auth()->user()->email == 'admin@gmail.com')
                                            <th style="width: 20%;">Nama Siswa</th>
                                        @endif
                                        <th>Judul Tugas</th>
                                        <th style="width: 15%;">Status</th>
                                        <th style="width: 12%;">Kategori</th> 
                                        <th style="width: 15%;">Deadline</th>
                                        <th style="width: 18%;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($tasks as $task)
                                    <tr>
                                        {{-- Tampilkan data nama siswa jika login sebagai admin --}}
                                        @if(auth()->user()->email == 'admin@gmail.com')
                                            <td><strong>{{ $task->user->name ?? 'Siswa Tidak Ditemukan' }}</strong></td>
                                        @endif

                                        <td>{{ $task->judul_tugas }}</td>
                                        
                                        <td>
                                            @if(($task->status->nama_status ?? '') == 'Selesai')
                                                <span class="badge bg-success px-2 py-1">Selesai</span>
                                            @elseif(($task->status->nama_status ?? '') == 'Sedang Dikerjakan')
                                                <span class="badge bg-warning text-dark px-2 py-1">Sedang Dikerjakan</span>
                                            @else
                                                <span class="badge bg-secondary px-2 py-1">{{ $task->status->nama_status ?? 'Belum Dikerjakan' }}</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if(($task->kategori->nama_kategori ?? '') == 'Sulit')
                                                <span class="badge bg-danger px-2 py-1">Sulit</span>
                                            @elseif(($task->kategori->nama_kategori ?? '') == 'Sedang')
                                                <span class="badge bg-info text-dark px-2 py-1">Sedang</span>
                                            @else
                                                <span class="badge bg-success px-2 py-1">Mudah</span>
                                            @endif
                                        </td>
                                        
                                        <td>{{ $task->deadline ?? 'Tanpa Deadline' }}</td>

                                        <td class="text-center">
                                            {{-- Tombol Edit/Kerjakan --}}
                                            <a href="{{ route('task.edit', $task->id) }}" class="btn btn-warning btn-sm fw-semibold">
                                                @if(auth()->user()->email == 'admin@gmail.com')
                                                    Edit
                                                @else
                                                    Kerjakan
                                                @endif
                                            </a>

                                            {{-- Tombol Hapus Hanya untuk Admin --}}
                                            @if(auth()->user()->email == 'admin@gmail.com')
                                                <form action="{{ route('task.destroy', $task->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus task ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm ms-1">Hapus</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        {{-- Dynamic colspan menyesuaikan jumlah kolom guru/siswa --}}
                                        <td colspan="{{ auth()->user()->email == 'admin@gmail.com' ? 6 : 5 }}" class="text-center py-5 text-muted">
                                            <i class="bi bi-clipboard-x d-block display-6 mb-2"></i>
                                            Belum ada task yang tercatat dalam sistem.
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