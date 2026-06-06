<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tugas;
class DashboardController extends Controller
{
    public function index()
{
    // 1. Ambil ID User yang sedang login agar guru/murid hanya melihat tugas yang relevan
    $userId = auth()->id();

    // 2. Hitung total tugas milik user ini
    $totalTugas = Tugas::where('user_id', $userId)->count();

    // 3. Hitung status "Pending" (Belum Dikerjakan)
    $belum = Tugas::where('user_id', $userId)
        ->whereHas('status', function ($q) {
            $q->where('nama_status', 'Pending'); // Sesuaikan dengan teks di DB Anda
        })->count();

    // 4. Hitung status "Progress" atau "Sedang Dikerjakan"
    $proses = Tugas::where('user_id', $userId)
        ->whereHas('status', function ($q) {
            // Jika di database tulisannya 'In Progress' atau 'Progress', ganti ke tulisan itu ya!
            $q->where('nama_status', 'Progress'); 
        })->count();

    // 5. Hitung status "Completed" (Selesai)
    $selesai = Tugas::where('user_id', $userId)
        ->whereHas('status', function ($q) {
            $q->where('nama_status', 'Completed'); // Menggunakan 'Completed' sesuai tampilan tabel Anda
        })->count();

    // 6. Ambil 5 tugas terbaru milik user ini
    $recentTasks = Tugas::where('user_id', $userId)
        ->with('status')
        ->latest()
        ->take(5)
        ->get();

    return view('dashboard', compact(
        'totalTugas',
        'belum',
        'proses',
        'selesai',
        'recentTasks'
    ));
}
}
