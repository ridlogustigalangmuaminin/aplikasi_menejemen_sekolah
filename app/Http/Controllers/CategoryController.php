<?php

namespace App\Http\Controllers;

use App\Models\KategoriTugas as Category;
use App\Models\Tugas as Task;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $isGuru = auth()->user()->email == 'admin@gmail.com';

        if ($isGuru) {
            // ==========================================
            // LOGIKA KHUSUS GURU / ADMIN
            // ==========================================
            $categories = Category::withCount('tugas')->get();

            $totalKategori = $categories->count();

            // Hitung Total Seluruh Tugas Terkait dari semua kategori
            $totalTugas = $categories->sum('tugas_count');

            // Cari Kategori Paling Aktif (yang punya tugas paling banyak)
            $kategoriPalingAktif = $categories->sortByDesc('tugas_count')->first();
            $palingAktif = $kategoriPalingAktif && $kategoriPalingAktif->tugas_count > 0 
                ? $kategoriPalingAktif->nama_kategori 
                : '-';

            // Cari Kategori yang Terakhir Diperbarui
            $terakhirDiperbarui = Category::whereNotNull('updated_at')->latest('updated_at')->first();
            $waktuUpdate = $terakhirDiperbarui && $terakhirDiperbarui->updated_at
                ? $terakhirDiperbarui->updated_at->diffForHumans() 
                : '-';

            // Kirim semua variabel statistik ke view blade khusus Admin
            return view('categories.index', compact(
                'categories', 
                'totalKategori', 
                'totalTugas', 
                'palingAktif', 
                'waktuUpdate'
            ));

        } else {
            // ==========================================
            // LOGIKA KHUSUS SISWA (IDE RIWAYAT/HISTORY)
            // ==========================================
            // Ambil semua kategori, tapi hitung jumlah tugas milik siswa ini yang berstatus Selesai (status_id = 3)
            $categories = Category::withCount(['tugas' => function($query) {
                $query->where('user_id', auth()->id())
                      ->where('status_id', 3); // Angka 3 adalah ID status "Selesai"
            }])->get();

            // Alihkan siswa ke halaman indeks riwayat kategori khusus siswa
            return view('categories.siswa_index', compact('categories'));
        }
    }

    /**
     * Fungsi Baru: Menampilkan Riwayat Tugas yang Sudah Dikerjakan per Kategori (Khusus Siswa)
     */
    public function showHistory($id)
    {
        // Proteksi: Mencegah admin masuk ke rute khusus history siswa
        if (auth()->user()->email == 'admin@gmail.com') {
            return redirect()->route('categories.index');
        }

        $kategori = Category::findOrFail($id);
        
        // Ambil data riwayat tugas milik siswa ini yang sudah selesai di kategori terpilih
        $historyTasks = Task::where('user_id', auth()->id())
                            ->where('kategori_id', $id)
                            ->where('status_id', 3) // Hanya mengambil yang status pengerjaannya Selesai
                            ->get();

        return view('categories.siswa_history', compact('kategori', 'historyTasks'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('categories.index')->with('success', 'Info nama kategori berhasil diganti!');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategori telah berhasil dihapus!');
    }
}