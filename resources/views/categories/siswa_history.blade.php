@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex">
        @include('layouts.sidebar')

        <div class="flex-grow-1">
            @include('layouts.navbar')

            <div class="p-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 fw-bold text-dark">
                            ✅ Riwayat Tugas Selesai: Kategori {{ $kategori->nama_kategori }}
                        </h4>
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Kembali ke Kategori
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mb-0 align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th>Judul Tugas Berhasil</th>
                                        <th>Deskripsi Tugas</th>
                                        <th>Tanggal Selesai Dikirim</th>
                                        <th class="text-center">Bukti Foto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($historyTasks as $task)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><strong class="text-success">{{ $task->judul_tugas }}</strong></td>
                                            <td>{{ $task->deskripsi ?? '-' }}</td>
                                            <td>{{ $task->updated_at->translatedFormat('d F Y, H:i') }} WIB</td>
                                            <td class="text-center">
                                                @if($task->bukti_foto)
                                                    <img src="{{ asset('storage/' . $task->bukti_foto) }}" class="img-thumbnail" style="max-height: 60px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal{{ $task->id }}">
                                                    
                                                    <div class="modal fade" id="imageModal{{ $task->id }}" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Bukti Tugas: {{ $task->judul_tugas }}</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                    <img src="{{ asset('storage/' . $task->bukti_foto) }}" class="img-fluid rounded">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-muted small">Tidak ada foto</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                Belum ada rekaman data tugas selesai untuk kategori ini.
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