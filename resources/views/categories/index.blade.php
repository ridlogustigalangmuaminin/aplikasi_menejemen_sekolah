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

            <!-- Content -->
            <div class="container-fluid p-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Manajemen Kategori</h2>
            <p class="text-muted mb-0">
                Kelola kategori tugas akademik Anda agar lebih terorganisir.
            </p>
        </div>

        <button class="btn btn-success">
            + Tambah Kategori
        </button>
    </div>

    <!-- Statistik -->
    <div class="row g-3 mb-4">

    <div class="col-md-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <small class="text-muted fw-semibold text-uppercase">Total Kategori</small>
                <h3 class="fw-bold text-primary mt-1">{{ $totalKategori }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <small class="text-muted fw-semibold text-uppercase">Tugas Terkait</small>
                <h3 class="fw-bold text-success mt-1">{{ $totalTugas }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <small class="text-muted fw-semibold text-uppercase">Paling Aktif</small>
                <h3 class="fw-bold text-warning mt-1 text-truncate" title="{{ $palingAktif }}">
                    {{ $palingAktif }}
                </h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <small class="text-muted fw-semibold text-uppercase">Terakhir Diperbarui</small>
                <h3 class="fw-bold text-danger mt-1 fs-4 text-truncate">
                    {{ $waktuUpdate }}
                </h3>
            </div>
        </div>
    </div>

</div>

    <!-- Table -->
    <div class="table-responsive">
    <table class="table table-hover align-middle border-0">
        <thead class="table-light text-secondary">
            <tr>
                <th scope="col" style="width: 40%;">Nama Kategori & Deskripsi</th>
                <th scope="col" style="width: 20%;">Jumlah Tugas</th>
                <th scope="col" style="width: 20%;">Status</th>
                <th scope="col" class="text-center" style="width: 20%;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
            <tr>
                <td>
                    <div class="fw-bold text-dark">{{ $category->nama_kategori }}</div>
                    @if($category->deskripsi)
                        <small class="text-muted d-block mt-1">
                            {{ $category->deskripsi }}
                        </small>
                    @else
                        <small class="text-muted d-block mt-1-italic">- Tidak ada deskripsi -</small>
                    @endif
                </td>

                <td>
                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                        {{ $category->tugas_count ?? 0 }} Tugas
                    </span>
                </td>

                <td>
                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded">
                        {{ $category->status ?? 'Aktif' }}
                    </span>
                </td>

                <td class="text-center">
                    <div class="d-flex justify-content-center gap-2">
                        <button class="btn btn-sm btn-outline-warning px-3">
                            <i class="bi bi-pencil"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-outline-danger px-3">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center text-muted py-4">
                    <span class="d-block mb-2">📂</span> Belum ada data kategori tersedia.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

</div>
</div>



@endsection