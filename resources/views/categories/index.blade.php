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
            <div class="card h-100">
                <div class="card-body">
                    <small class="text-muted">TOTAL KATEGORI</small>
                    <h3 class="fw-bold">12</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <small class="text-muted">TUGAS TERKAIT</small>
                    <h3 class="fw-bold">48</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <small class="text-muted">PALING AKTIF</small>
                    <h3 class="fw-bold">Design</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <small class="text-muted">TERAKHIR DIPERBARUI</small>
                    <h3 class="fw-bold">2j lalu</h3>
                </div>
            </div>
        </div>

    </div>

    <!-- Table -->
    <div class="card">

        <div class="card-body p-0">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th>Nama Kategori</th>
                        <th>Tugas Terkait</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td>
                            <div class="fw-semibold">Design Studio</div>
                            <small class="text-muted">
                                UI/UX and Interaction Projects
                            </small>
                        </td>

                        <td>14 Tugas</td>

                        <td>
                            <span class="badge bg-success">
                                Aktif
                            </span>
                        </td>

                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-warning">
                                Edit
                            </button>

                            <button class="btn btn-sm btn-outline-danger">
                                Hapus
                            </button>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="fw-semibold">Web Dev</div>
                            <small class="text-muted">
                                Frontend dan Backend Development
                            </small>
                        </td>

                        <td>22 Tugas</td>

                        <td>
                            <span class="badge bg-success">
                                Aktif
                            </span>
                        </td>

                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-warning">
                                Edit
                            </button>

                            <button class="btn btn-sm btn-outline-danger">
                                Hapus
                            </button>
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>
</div>



@endsection