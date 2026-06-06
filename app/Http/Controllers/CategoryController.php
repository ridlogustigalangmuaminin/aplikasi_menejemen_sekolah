<?php

namespace App\Http\Controllers;

use App\Models\KategoriTugas as Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('tugas')->get();

        $totalKategori = $categories->count();

    // 3. Hitung Total Seluruh Tugas Terkait dari semua kategori
    $totalTugas = $categories->sum('tugas_count');

    // 4. Cari Kategori Paling Aktif (yang punya tugas paling banyak)
    $kategoriPalingAktif = $categories->sortByDesc('tugas_count')->first();
    $palingAktif = $kategoriPalingAktif && $kategoriPalingAktif->tugas_count > 0 
        ? $kategoriPalingAktif->nama_kategori 
        : '-';

    // 5. Cari Kategori yang Terakhir Diperbarui
    $terakhirDiperbarui = Category::whereNotNull('updated_at')->latest('updated_at')->first();
    $waktuUpdate = $terakhirDiperbarui && $terakhirDiperbarui->updated_at
        ? $terakhirDiperbarui->updated_at->diffForHumans() 
        : '-';

    // Kirim semua variabel ke view blade
    return view('categories.index', compact(
        'categories', 
        'totalKategori', 
        'totalTugas', 
        'palingAktif', 
        'waktuUpdate'
    ));
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

        return redirect()->route('categories.index');
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

        return redirect()->route('categories.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index');
    }
}