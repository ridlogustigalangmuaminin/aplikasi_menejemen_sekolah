<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tugas; // Pastikan ini sesuai dengan nama model yang benar
class DashboardController extends Controller
{
    public function index()
{
    // 1. Ambil ID User yang sedang login
    $userId = auth()->id();

    // 2. Gunakan model Tugas (bukan Task, agar sinkron dengan Controller kemarin)
    $totalTugas =Tugas::where('user_id', $userId)->count();

    // 3. Hitung status berdasarkan ID Status (Jauh lebih aman daripada teks string)
    // Asumsi ID: 1 = Belum Mulai / Pending, 2 = Dikerjakan / Progress, 3 = Selesai / Completed
    $belum = Tugas::where('user_id', $userId)->where('status_id', 1)->count();
    $proses = Tugas::where('user_id', $userId)->where('status_id', 2)->count();
    $selesai = Tugas::where('user_id', $userId)->where('status_id', 3)->count();

    // 4. Ambil 5 tugas terbaru milik user ini lengkap dengan relasi statusnya
    $recentTasks = Tugas::where('user_id', $userId)
        ->with('status')
        ->latest()
        ->take(5)
        ->get(); // Menghasilkan Object Collection, dijamin tidak void lagi

    // 5. Kirimkan data ke view
    return view('dashboard', compact(
        'totalTugas',
        'belum',
        'proses',
        'selesai',
        'recentTasks'
    ));
}
}
