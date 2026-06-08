<?php

namespace App\Http\Controllers;

use App\Models\Tugas as Task;
use App\Models\KategoriTugas as Kategori;
use App\Models\StatusTugas;
use App\Models\User;
use App\Models\Lampiran;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $isAdmin = auth()->user()->email == 'admin@gmail.com';

    if ($isAdmin) {
        // PASTIKAN ada 'lampiran' atau 'lampirans' di dalam array with()
        $tasks = Task::with(['status', 'kategori', 'user', 'lampirans']) 
            ->latest()
            ->get();
    } else {
        $tasks = Task::with(['status', 'kategori', 'lampirans'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
    }

    return view('task.index', compact('tasks'));
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Proteksi: Siswa tidak boleh buka halaman Create
        if (auth()->user()->email != 'admin@gmail.com') {
            abort(403, 'Hanya Guru yang dapat membuat tugas.');
        }

        $categories = Kategori::all();
        $statuses = StatusTugas::all();

        // Ambil semua user yang bukan admin untuk didistribusikan tugasnya (Opsional jika ingin menunjuk siswa)
        $students = User::where('email', '!=', 'admin@gmail.com')->get();

        return view('task.create', compact('categories', 'statuses', 'students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // 1. Validasi Input Form
    $request->validate([
        'judul_tugas' => 'required|string|max:255',
        'kategori_id' => 'required',
        'deadline'    => 'required|date',
    ]);

    // 2. Ambil semua data user yang merupakan SISWA (bukan admin)
    $students = \App\Models\User::where('email', '!=', 'admin@gmail.com')->get();

    if ($students->isEmpty()) {
        return redirect()->back()->with('error', 'Gagal membuat tugas! Belum ada data siswa yang terdaftar di aplikasi.');
    }

    // 3. SEBARKAN TUGAS KE SEMUA SISWA (Looping)
    foreach ($students as $student) {
        $task = new \App\Models\Tugas();
        $task->user_id     = $student->id; // <-- Tugas dikunci ke ID masing-masing siswa!
        $task->kategori_id = $request->kategori_id;
        $task->judul_tugas = $request->judul_tugas;
        $task->deskripsi   = $request ->deskripsi;
        $task->deadline     = $request->deadline;

        $task->status_id    = 1; // Default: Belum Mulai
        $task->save();
    }

    return redirect()->route('task.index')->with('success', 'Tugas baru berhasil dibuat dan otomatis dibagikan ke semua siswa!');
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $isAdmin = auth()->user()->email == 'admin@gmail.com';

        // SOLUSI BUG EDIT (HAK AKSES): 
        // Guru boleh edit semua task. Siswa HANYA boleh edit task miliknya sendiri.
        if (!$isAdmin && $task->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke tugas ini.');
        }

        $statuses = StatusTugas::all();
        $categories = Kategori::all();

        return view('task.edit', compact('task', 'statuses', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // 1. Ambil data tugas berdasarkan ID yang sedang diedit
        $task = \App\Models\Tugas::findOrFail($id); // Sesuaikan nama model Tugas / Task kamu
        $isGuru = auth()->user()->email == 'admin@gmail.com';

        if (!$isGuru) {
            $sekarang = \Carbon\Carbon::now();

            // 2. Ambil data lampiran yang sudah ada untuk tugas ini (jika ada)
            $lampiran = \App\Models\Lampiran::where('tugas_id', $task->id)->first();

            if ($lampiran) {
                // Cek batas toleransi edit jawaban (30 menit)
                $waktuKirim = \Carbon\Carbon::parse($lampiran->created_at);
                $selisihMenit = $waktuKirim->diffInMinutes($sekarang);

                if ($selisihMenit > 30) {
                    return redirect()->back()->with('error', 'Gagal! Batas toleransi waktu 30 menit untuk mengubah jawaban telah habis.');
                }

                // UPDATE LAMPIRAN JIKA SUDAH PERNAH MENGISI
                $lampiran->update([
                    'file_name' => $request->jawaban_siswa, // Menangkap input name="jawaban_siswa" dari Blade
                    'file_path' => 'text_input'
                ]);
            } else {
                Lampiran::create([
                    'tugas_id' => $task->id,
                    'file_name' => (string) $request->input('jawaban_siswa', ''),
                    'file_path' => 'text_input',
                ]);
            }

            // Siswa hanya mengupdate status progres tugasnya saja di tabel tugas
            $task->update([
                'status_id' => $request->status_id,
            ]);

        } else {
            // Logika jika Guru/Admin yang mengubah instrumen soal asli
            $task->update($request->all());
        }

        return redirect()->route('task.index')->with('success', 'Perubahan berhasil disimpan!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        // Proteksi: Hanya guru yang boleh menghapus data tugas apa pun
        if (auth()->user()->email != 'admin@gmail.com') {
            abort(403, 'Siswa tidak diizinkan menghapus tugas.');
        }

        $task->delete();

        return redirect()
            ->route('task.index')
            ->with('success', 'Task berhasil dihapus');
    }
}