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
                        <h4 class="mb-0">Tambah Task</h4>
                    </div>

                    <div class="card-body">

                       <form action="{{ route('task.store') }}" method="POST">

    @csrf

    <div class="mb-3">
        <label class="form-label">Judul Task</label>
        <input
            type="text"
            name="title"
            class="form-control @error('title') is-invalid @enderror"
            value="{{ old('title') }}"
        >
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Deskripsi</label>
        <textarea
            name="description"
            class="form-control"
            rows="4"
        >{{ old('description') }}</textarea>
    </div>

    <div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
        @foreach($statuses as $status)
            <option value="{{ $status->id }}">{{ $status->nama_status }}</option>
        @endforeach
    </select>
</div>

    <div class="mb-3">
        <label class="form-label">Kategori</label>
        <select name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror">
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ old('kategori_id') == $category->id ? 'selected' : '' }}>
                {{ $category->nama_kategori }} 
            </option>
        @endforeach
        </select>
        @error('kategori_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Deadline</label>
        <input
            type="date"
            name="deadline"
            class="form-control"
            value="{{ old('deadline') }}"
        >
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('task.index') }}" class="btn btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-primary">Simpan Task</button>
    </div>

</form>

                    </div>
                </div>

            </div>

        </div>

    </div>

</div>
@endsection