@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex">
        @include('layouts.sidebar')

        <div class="flex-grow-1">
            @include('layouts.navbar')

            <div class="p-4">
                <div class="mb-4">
                    <h2 class="h3 text-dark fw-bold">📊 Riwayat Pencapaian Kategori Tugas</h2>
                    <p class="text-muted">Pilih tingkat kesulitan untuk melihat daftar tugas yang telah Anda selesaikan.</p>
                </div>

                <div class="row">
                    @foreach($categories as $category)
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-body d-flex flex-column justify-content-between p-4">
                                    <div>
                                        <span class="badge bg-primary mb-2">Tingkat Kesulitan</span>
                                        <h4 class="card-title fw-bold text-dark mb-3">{{ $category->nama_kategori }}</h4>
                                        
                                        <div class="p-3 bg-light rounded mb-4">
                                            <span class="d-block text-secondary small fw-bold text-uppercase">Tugas Diselesaikan:</span>
                                            <span class="display-6 fw-bold text-success">{{ $category->tugas_count }}</span> <small class="text-muted">Tugas</small>
                                        </div>
                                    </div>

                                    @if($category->tugas_count > 0)
                                        {{-- JIKA SUDAH PERNAH MENGERJAKAN: Tombol Aksi berubah jadi Tombol Info History --}}
                                        <a href="{{ route('categories.history', $category->id) }}" class="btn btn-success w-100 fw-bold py-2 shadow-sm">
                                            <i class="bi bi-clock-history"></i> Lihat Riwayat Tugas
                                        </a>
                                    @else
                                        {{-- JIKA BELUM ADA TUGAS YANG SELESAI --}}
                                        <button class="btn btn-secondary w-100 py-2" disabled>
                                            Belum Ada Riwayat
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection