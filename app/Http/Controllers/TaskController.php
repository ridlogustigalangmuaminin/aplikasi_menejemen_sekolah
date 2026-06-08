<?php

namespace App\Http\Controllers;

use App\Models\Tugas as Task;
use App\Models\KategoriTugas as Kategori;
use App\Models\StatusTugas;
use App\Models\User; // Tambahkan ini jika ingin mengambil list siswa
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
        // Jika admin/guru, ambil semua data tugas di aplikasi beserta relasi kategorinya
        if (auth()->user()->email == 'admin@gmail.com') {
            $tasks = Task::with(['status', 'kategori'])->latest()->get();
        } else {
            // Jika siswa, hanya ambil data tugas yang 'user_id' nya cocok dengan id siswa tersebut
            $tasks = Task::with(['status', 'kategori'])->where('user_id', auth()->user()->id)->latest()->get();
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
        // 1. Validasi: pastikan nama yang dicek adalah 'image' sesuai HTML kamu
        $request->validate([
            'judul_tugas' => 'required|string|max:255',
            'deadline' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
        ]);

        // 2. Inisialisasi Model Tugas / Task
        $task = new Task();
        $task->user_id = auth()->id();
        $task->judul_tugas = $request->judul_tugas;
        $task->deadline = $request->deadline;
        $task->jam_deadline = $request->jam_deadline ?? '23:59:00';
        $task->status_id = 1; // Default status: Belum Mulai

        // 3. PROSES UPLOAD (disimpan ke tabel lampirans)
        if (!$request->hasFile('image')) {
            return redirect()->back()->withInput()->with('error', 'File bukti tidak terbaca oleh sistem.');
        }

        $file = $request->file('image');
        $namaFile = time() . '_' . $file->getClientOriginalName();

        $path = $file->storeAs('public/bukti', $namaFile);

        // simpan dulu tugas
        $task->save();

        // simpan lampiran
        $task->lampirans()->create([
            'file_name' => $namaFile,
            'file_path' => $path,
        ]);

        return redirect()->route('dashboard')->with('success', 'Tugas berhasil disimpan beserta bukti foto!');
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
    public function update(Request $request, Task $task)
    {
        $isGuru = auth()->user()->email == 'admin@gmail.com';
        $sekarang = \Carbon\Carbon::now();
        $waktuDeadline = \Carbon\Carbon::parse($task->deadline . ' ' . ($task->jam_deadline ?? '23:59:59'));

        if (!$isGuru) {

            if ($sekarang->gt($waktuDeadline)) {
                return back()->withErrors(['error' => 'Tugas sudah HANGUS'])->withInput();
            }

            if ($task->updated_at && $task->status_id != 1 && $sekarang->diffInHours($task->updated_at) > 2) {
                return back()->withErrors(['error' => 'Batas edit sudah habis'])->withInput();
            }

            $request->validate([
                'status_id' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            if ($request->hasFile('image')) {
                // hapus lampiran lama (ambil yang terakhir saja)
                $lampiranLama = $task->lampirans()->latest()->first();
                if ($lampiranLama && $lampiranLama->file_path) {
                    \Storage::disk('public')->delete($lampiranLama->file_path);
                }

                $file = $request->file('image');
                $namaFile = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('bukti_tugas', $namaFile, 'public');

                $task->lampirans()->create([
                    'file_name' => $namaFile,
                    'file_path' => $path,
                ]);
            }

            $task->status_id = $request->status_id;

        } else {

            $request->validate([
                'judul_tugas' => 'required',
                'kategori_id' => 'required',
                'deadline' => 'required',
                'jam_deadline' => 'required',
                'status_id' => 'required',
            ]);

            $task->update([
                'judul_tugas' => $request->judul_tugas,
                'deskripsi' => $request->deskripsi,
                'kategori_id' => $request->kategori_id,
                'deadline' => $request->deadline,
                'jam_deadline' => $request->jam_deadline,
                'status_id' => $request->status_id,
            ]);

            if ($request->hasFile('image')) {
                $lampiranLama = $task->lampirans()->latest()->first();
                if ($lampiranLama && $lampiranLama->file_path) {
                    \Storage::disk('public')->delete($lampiranLama->file_path);
                }

                $file = $request->file('image');
                $namaFile = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('bukti_tugas', $namaFile, 'public');

                $task->lampirans()->create([
                    'file_name' => $namaFile,
                    'file_path' => $path,
                ]);
            }
        }

        $task->save();

        return redirect()->route('task.index')->with('success', 'Tugas berhasil diupdate');
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