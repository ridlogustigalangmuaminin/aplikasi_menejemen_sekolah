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

            <div class="p-4">

                <h1 class="fw-bold">
                    Welcome back, {{ auth()->user()->nama }}!
                </h1>

                <p class="text-muted">
                    Kelola tugas sekolahmu dengan lebih mudah.
                </p>

                <!-- Statistik -->
                <div class="row g-3 mb-4">

                    <div class="col-md-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h6 class="text-muted">Total Tasks</h6>
                                <h2>{{ $totalTugas ?? 0 }}</h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h6 class="text-muted">Belum Dikerjakan</h6>
                                <h2>{{ $belum ?? 0 }}</h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h6 class="text-muted">Sedang Dikerjakan</h6>
                                <h2>{{ $proses ?? 0 }}</h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h6 class="text-muted">Selesai</h6>
                                <h2>{{ $selesai ?? 0 }}</h2>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <!-- Recent Tasks -->
                    <div class="col-lg-8">

                        <div class="card shadow-sm border-0">

                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Recent Tasks</h5>

                                <a href="{{ route('task.index') }}"
                                   class="btn btn-success btn-sm">
                                    Lihat Semua
                                </a>
                            </div>

                            <div class="card-body p-0">

                                <table class="table table-hover mb-0">

                                    <thead class="table-light">
                                        <tr>
                                            <th>Judul Tugas</th>
                                            <th>Status</th>
                                            <th>Deadline</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @forelse($recentTasks ?? [] as $task)

                                        <tr>
                                            <td>{{ $task->judul_tugas }}</td>

                                            <td>
                                                {{ $task->status->nama_status ?? '-' }}
                                            </td>

                                            <td>
                                                {{ $task->deadline }}
                                            </td>
                                        </tr>

                                        @empty

                                        <tr>
                                            <td colspan="3" class="text-center py-4">
                                                Belum ada data tugas
                                            </td>
                                        </tr>

                                        @endforelse

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                    <!-- Informasi -->
                    <div class="col-lg-4">

    <!-- Grafik Status Tugas -->
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-header bg-white">
            <h5 class="mb-0">Grafik Status Tugas</h5>
        </div>

        <div class="card-body">

            

        </div>
    </div>

    <!-- Informasi -->
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">
            <h5 class="mb-0">Informasi</h5>
        </div>

        <div class="card-body">

            <div class="mb-3">
                <strong>Total Tugas :</strong>
                <span>{{ $totalTugas ?? 0 }}</span>
            </div>

            <div class="mb-3">
                <strong>Belum Dikerjakan :</strong>
                <span>{{ $belum ?? 0 }}</span>
            </div>

            <div class="mb-3">
                <strong>Sedang Dikerjakan :</strong>
                <span>{{ $proses ?? 0 }}</span>
            </div>

            <div>
                <strong>Selesai :</strong>
                <span>{{ $selesai ?? 0 }}</span>
            </div>

        </div>

    </div>

</div>

                </div>

            </div>

        </div>

    </div>

</div>
@endsection