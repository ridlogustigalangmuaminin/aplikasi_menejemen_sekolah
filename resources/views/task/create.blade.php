@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex">
        @include('layouts.sidebar')

        <div class="flex-grow-1">
            @include('layouts.navbar')

            <div class="p-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4 class="mb-0">Tambah Task Baru (Mode Guru)</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('task.store') }}" method="POST">
                            @csrf

                            {{-- STATUS DISEMBUNYIKAN: Otomatis ID status default (misal: 1 untuk Belum Dikerjakan) --}}
                            <input type="hidden" name="status_id" value="1">

                            <div class="mb-3">
                                <label class="form-label">Judul Task</label>
                                <input
                                    type="text"
                                    name="judul_tugas"
                                    class="form-control @error('judul_tugas') is-invalid @enderror"
                                    value="{{ old('judul_tugas') }}"
                                    required
                                >
                                @error('judul_tugas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea
                                    name="deskripsi"
                                    class="form-control"
                                    rows="4"
                                >{{ old('deskripsi') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
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
                                    required
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