@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex">

        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="flex-grow-1">

            <!-- Navbar -->
            @include('layouts.navbar')

            <!-- Content Area -->
            <div class="container-fluid p-4">

                <!-- Header Halaman -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                    <div>
                        <h2 class="fw-bold text-dark mb-1">🗂️ Manajemen Kategori</h2>
                        <p class="text-muted mb-0">
                            Kelola kategori tugas akademik Anda agar lebih terorganisir dan rapi.
                        </p>
                    </div>

                    <button class="btn btn-success px-4 py-2 fw-semibold rounded-pill shadow-sm align-self-start align-self-md-center">
                        <i class="bi bi-plus-circle-fill me-2"></i>Tambah Kategori
                    </button>
                </div>

                <!-- Statistik Grid -->
                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-3">
                        <div class="card h-100 border-0 shadow-sm bg-white">
                            <div class="card-body py-3">
                                <small class="text-muted fw-bold text-uppercase fs-7">Total Kategori</small>
                                <h3 class="fw-bold text-primary mt-1 mb-0">{{ $totalKategori ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="card h-100 border-0 shadow-sm bg-white">
                            <div class="card-body py-3">
                                <small class="text-muted fw-bold text-uppercase fs-7">Tugas Terkait</small>
                                <h3 class="fw-bold text-success mt-1 mb-0">{{ $totalTugas ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="card h-100 border-0 shadow-sm bg-white">
                            <div class="card-body py-3">
                                <small class="text-muted fw-bold text-uppercase fs-7">Paling Aktif</small>
                                <h3 class="fw-bold text-warning mt-1 mb-0 text-truncate" title="{{ $palingAktif ?? '-' }}">
                                    {{ $palingAktif ?? '-' }}
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="card h-100 border-0 shadow-sm bg-white">
                            <div class="card-body py-3">
                                <small class="text-muted fw-bold text-uppercase fs-7">Terakhir Diperbarui</small>
                                <h3 class="fw-bold text-danger mt-1 mb-0 fs-5 text-truncate" title="{{ $waktuUpdate ?? '-' }}">
                                    {{ $waktuUpdate ?? '-' }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bagian Konten Utama: Tabel Kategori -->
                <div class="card border-0 shadow-sm bg-white">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light text-uppercase fs-7 text-secondary border-bottom">
                                    <tr>
                                        <th scope="col" class="py-3 ps-4" style="width: 45%;">Nama Kategori & Deskripsi</th>
                                        <th scope="col" class="py-3" style="width: 20%;">Jumlah Tugas</th>
                                        <th scope="col" class="py-3" style="width: 15%;">Status</th>
                                        <th scope="col" class="py-3 pe-4 text-center" style="width: 20%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="border-top-0">
                                    @forelse($categories ?? [] as $category)
                                    <tr>
                                        <!-- Nama Kategori & Deskripsi -->
                                        <td class="py-3 ps-4">
                                            <div class="fw-bold text-dark fs-6">{{ $category->nama_kategori }}</div>
                                            @if($category->deskripsi)
                                                <small class="text-muted d-block mt-1 text-wrap" style="max-width: 400px;">
                                                    {{ $category->deskripsi }}
                                                </small>
                                            @else
                                                <small class="text-muted d-block mt-1 fst-italic text-opacity-50">
                                                    - Tidak ada deskripsi -
                                                </small>
                                            @endif
                                        </td>

                                        <!-- Jumlah Tugas Terkait -->
                                        <td class="py-3">
                                            <span class="badge bg-light text-dark border border-secondary-subtle px-3 py-2 rounded-pill fw-medium fs-7">
                                                📁 {{ $category->tugas_count ?? 0 }} Tugas
                                            </span>
                                        </td>

                                        <!-- Status Kategori -->
                                        <td class="py-3">
                                            @if(($category->status ?? 'Aktif') == 'Aktif')
                                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1.5 rounded fs-7">
                                                    ● Aktif
                                                </span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1.5 rounded fs-7">
                                                    ● Non-Aktif
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Tombol Aksi -->
                                        <td class="py-3 pe-4 text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <button class="btn btn-sm btn-outline-warning px-3 rounded-pill fw-semibold fs-7 d-inline-flex align-items-center gap-1">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger px-3 rounded-pill fw-semibold fs-7 d-inline-flex align-items-center gap-1">
                                                    <i class="bi bi-trash3-fill"></i> Hapus
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <!-- Jika Data Kosong -->
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-5">
                                            <div class="fs-2 mb-2">📂</div> 
                                            <span class="fw-semibold d-block">Belum ada data kategori tersedia.</span>
                                            <small class="text-secondary opacity-75">Klik tombol "+ Tambah Kategori" untuk membuat baru.</small>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- End Card -->

            </div> <!-- End Container-Fluid Internal -->
        </div> <!-- End Flex-Grow-1 -->
    </div> <!-- End D-Flex -->
</div> <!-- End Container-Fluid Utama -->
@endsection