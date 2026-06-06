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
            <div class="p-4">

                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4 class="mb-0">Edit Task</h4>
                        @if ($errors->any())
    <div class="alert alert-danger mx-4 mt-3">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                    </div>

                    <div class="card-body">

                    <form action="{{ route('task.update', $task->id) }}" method="POST">
    @csrf
    @method('PUT') 

    <input type="hidden" name="kategori_id" value="{{ $task->kategori_id }}">
    <input type="hidden" name="judul_tugas" value="{{ $task->judul_tugas }}">
    <input type="hidden" name="deskripsi" value="{{ $task->deskripsi }}">
    <input type="hidden" name="deadline" value="{{ $task->deadline }}">

    <div class="mb-4 p-3 bg-light rounded border">
        <h5 class="fw-bold text-secondary mb-1">Tugas yang Sedang Diperiksa:</h5>
        <h4 class="text-dark fw-semibold">{{ $task->judul_tugas }}</h4>
        <p class="text-muted mb-0">{{ $task->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
    </div>

    <div class="mb-4">
        <label class="form-label fw-bold text-uppercase text-muted small">Status Pemeriksaan Guru</label>
        <select name="status_id" class="form-select form-select-lg border-2 border-primary fw-semibold">
            @foreach($statuses as $status)
                <option value="{{ $status->id }}" {{ $task->status_id == $status->id ? 'selected' : '' }}>
                    @if($status->id == 3) {{-- Sesuaikan ID 3 jika di DB artinya Selesai --}}
                        ✅ {{ $status->nama_status }} (Sudah Selesai / Disetujui Guru)
                    @else
                        ⏳ {{ $status->nama_status }} (Masih Proses / Revisi)
                    @endif
                </option>
            @endforeach
        </select>
        <small class="text-muted d-block mt-2">Pilih status menjadi "Selesai" jika tugas ini sudah Anda nyatakan lulus.</small>
    </div>

    <div class="mt-4 pt-2 border-top">
        <a href="{{ route('task.index') }}" class="btn btn-secondary px-4">Kembali</a>
        <button type="submit" class="btn btn-primary px-4 fw-bold">Simpan Perubahan Status</button>
    </div>
</form>

                    </div>
                </div>

            </div>

        </div>

    </div>

</div>
@endsection