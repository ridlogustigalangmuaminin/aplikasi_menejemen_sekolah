@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex">
        @include('layouts.sidebar')

        <div class="flex-grow-1">
            @include('layouts.navbar')

            <div class="p-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h4 class="mb-0 fw-bold text-dark">
                            {{ auth()->user()->email == 'admin@gmail.com' ? '⚙️ Aksi Kategori Admin: Edit & Ganti Info Task' : '📝 Detail & Progres Tugas Anda' }}
                        </h4>
                        @if ($errors->any())
                            <div class="alert alert-danger mx-0 mt-3 mb-0 shadow-sm">
                                <ul class="mb-0 fw-semibold">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class="card-body p-4">
                        {{-- Logika Pengecekan Waktu & Masa Hangus Tugas --}}
                        @php
    $isGuru = auth()->user()->email == 'admin@gmail.com';
    $sekarang = \Carbon\Carbon::now();
    $waktuDeadline = \Carbon\Carbon::parse($task->deadline . ' ' . ($task->jam_deadline ?? '23:59:59'));
    $isHangus = $sekarang->gt($waktuDeadline);
    
    $isBatasEditHabis = false;
    if (!$isGuru && $task->updated_at && $task->status_id != 1) {
        $isBatasEditHabis = $sekarang->diffInHours($task->updated_at) > 2;
    }

    // Mengambil data lampiran berdasarkan struktur asli kamu    
    $lampiranJawaban = \App\Models\Lampiran::where('tugas_id', $task->id)->first();
@endphp

                        <form id="formTask" action="{{ route('task.update', $task->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- Jika siswa, kunci data soal asli agar tidak hilang atau ter-overwrite --}}
                            @if(!$isGuru)
                                <input type="hidden" name="judul_tugas" value="{{ $task->judul_tugas }}">
                                <input type="hidden" name="deskripsi" value="{{ $task->deskripsi }}">
                                <input type="hidden" name="kategori_id" value="{{ $task->kategori_id }}">
                                <input type="hidden" name="deadline" value="{{ $task->deadline }}">
                                <input type="hidden" name="jam_deadline" value="{{ $task->jam_deadline ?? '23:59' }}">
                            @endif

                            {{-- TAMPILAN JIKA LOGIN SEBAGAI GURU/ADMIN --}}
                            @if($isGuru)
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Judul Task</label>
                                    <input 
                                        type="text" 
                                        name="judul_tugas" 
                                        class="form-control" 
                                        value="{{ old('judul_tugas', $task->judul_tugas) }}"
                                        required
                                    >
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Deskripsi Soal (Guru)</label>
                                    <textarea 
                                        name="deskripsi" 
                                        class="form-control" 
                                        rows="4"
                                    >{{ old('deskripsi', $task->deskripsi) }}</textarea>
                                </div>
                            @else
                                {{-- TAMPILAN INFORMASI SOAL UNTUK SISWA --}}
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Judul Task</label>
                                    <input type="text" class="form-control bg-light" value="{{ $task->judul_tugas }}" readonly>
                                </div>

                                <div class="mb-4 p-3 border border-info rounded bg-light">
                                    <label class="form-label fw-bold text-info"><i class="bi bi-info-circle-fill"></i> Deskripsi Soal Dari Guru:</label>
                                    <p class="mb-0 text-dark" style="white-space: pre-line;">{{ $task->deskripsi ?? 'Tidak ada deskripsi soal.' }}</p>
                                </div>
                            @endif

                            {{-- DROPDOWN KATEGORI (GURU EDIT, SISWA HANYA INFO) --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Kategori Tingkat Kesulitan</label>
                                @if($isGuru)
                                    <select name="kategori_id" class="form-select" required>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ $task->kategori_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <div class="p-2 bg-light border rounded text-dark fw-semibold">
                                        ℹ️ Info Tingkat Kesulitan: <span class="badge bg-info text-dark">{{ $task->kategori->nama_kategori ?? 'Tidak Diketahui' }}</span>
                                    </div>
                                @endif
                            </div>

                            {{-- INPUT TANGGAL DEADLINE --}}
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label fw-bold">Tanggal Batas Pengumpulan</label>
                                    <input 
                                        type="date" 
                                        name="deadline" 
                                        class="form-control" 
                                        value="{{ old('deadline', $task->deadline) }}"
                                        {{ !$isGuru ? 'readonly bg-light' : '' }}
                                        required
                                    >
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Jam Batas Pengumpulan</label>
                                    <input 
                                        type="time" 
                                        name="jam_deadline" 
                                        class="form-control" 
                                        value="{{ old('jam_deadline', $task->jam_deadline ?? '23:59') }}"
                                        {{ !$isGuru ? 'readonly bg-light' : '' }}
                                        required
                                    >
                                </div>
                            </div>

                            <hr class="my-4">

                            {{-- CEK APAKAH TUGAS SUDAH HANGUS ATAU OVER TIME UNTUK EDIT PROGRES --}}
                            @if($isHangus && !$isGuru)
                                <div class="alert alert-danger fw-bold text-center border-2 border-danger py-3 shadow-sm mb-0">
                                    ⚠️ AKUN PERINGATAN PERNYATAAN: Tugas ini dinyatakan HANGUS! Batas waktu pengumpulan telah terlewati dan tugas sudah tidak dapat dikerjakan kembali.
                                </div>
                            @elseif($isBatasEditHabis && !$isGuru)
                                <div class="alert alert-warning fw-bold text-center border-2 border-warning py-3 shadow-sm mb-0">
                                    ⚠️ BATAS UBAH DATA HABIS: Progres tugas ini sudah tidak dapat diubah lagi karena telah melewati batas toleransi pengubahan (Maksimal 2 Jam).
                                </div>
                            @else
                                {{-- DROPDOWN STATUS --}}
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-uppercase text-primary small">Status Progress Tugas</label>
                                    <select id="status_id" name="status_id" class="form-select form-select-lg border-2 border-primary fw-semibold">
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->id }}" {{ $task->status_id == $status->id ? 'selected' : '' }}>
                                                @if(($status->nama_status ?? '') == 'Selesai')
                                                    ✅ {{ $status->nama_status }}
                                                @elseif(($status->nama_status ?? '') == 'Sedang Dikerjakan')
                                                    ⏳ {{ $status->nama_status }}
                                                @else
                                                    📌 {{ $status->nama_status }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted d-block mt-2">
                                        {{ $isGuru ? 'Sebagai Admin/Guru, Anda memiliki hak penuh mengubah instrumen validasi tugas ini kapan saja.' : 'Perhatian: Pastikan mengunggah foto fisik jika Anda menaruh status pekerjaan ke tahap "Selesai".' }}
                                    </small>
                                </div>

                                {{-- INPUT JAWABAN TEKS SISWA (DIALIKKAN KE TABEL LAMPIRAN) --}}
                                {{-- INPUT JAWABAN TEKS SISWA (MASUK KE KOLOM FILE_NAME) --}}
@if(!$isGuru)
    <div class="mb-4 p-3 bg-light border border-2 rounded">
        <label class="form-label fw-bold text-dark">Jawaban Tugas (Simpan Ke Lampiran) <span class="text-danger">*</span></label>
        <textarea
    name="jawaban_siswa"  class="form-control"
    rows="5"
    placeholder="Tulis lembar jawaban kamu di sini berdasarkan petunjuk soal di atas..."
    required
>{{ old('jawaban_siswa', $lampiranJawaban ? $lampiranJawaban->file_name : '') }}</textarea>{{-- Menggunakan file_name --}}
        <small class="text-danger d-block mt-2 fw-semibold">
            ⚠️ PENTING: Anda memiliki waktu 30 menit setelah mengirim jawaban untuk melakukan perubahan kembali!
        </small>
    </div>
@endif

                                <div class="mt-4 pt-2 border-top">
                                    <a href="{{ route('task.index') }}" class="btn btn-secondary px-4">Kembali</a>
                                    <button type="submit" class="btn btn-primary px-4 fw-bold">Simpan Perubahan Data</button>
                                </div>
                            @endif

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- JAVASCRIPT ALERT KONFIRMASI SAAT KLIK TOMBOL SIMPAN --}}
<script>
    document.getElementById('formTask').addEventListener('submit', function(e) {
        // Cek jika yang login bukan guru/admin, maka jalankan alert konfirmasi 30 menit
        @if(auth()->user()->email != 'admin@gmail.com')
            e.preventDefault(); // Tahan form agar tidak langsung mengirim data
            
            let yakin = confirm("Apakah Anda yakin ingin menyimpan perubahan jawaban?\n\nPERINGATAN: Setelah tombol ditekan, Anda hanya diberikan batas toleransi waktu 30 menit untuk mengubah jawaban ini kembali!");
            
            if (yakin) {
                this.submit(); // Kirim data jika klik OK
            }
        @endif
    });
</script>

{{-- SCRIPT SIKLUS DELAY 30 MENIT --}}
@if (session('success'))
<script>
    (function () {
        const success = @json(session('success'));
        const delayMs = 30 * 60 * 1000; // 30 menit

        setTimeout(function () {
            alert('✅ ' + success + '\n\n⏳ Peringatan: Perubahan sudah tersimpan. Pastikan yakin menyimpan perubahan.');
        }, delayMs);
    })();
</script>
@endif

@endsection