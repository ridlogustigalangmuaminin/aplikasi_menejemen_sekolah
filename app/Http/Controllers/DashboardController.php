<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tugas; // Pastikan ini sesuai dengan nama model yang benar
class DashboardController extends Controller
{
    public function index()
{
    $isAdmin = auth()->user()->email == 'admin@gmail.com';

    if ($isAdmin) {
        // Ambil semua tugas dari semua siswa untuk ditampilkan di dashboard admin
        $tasks =Tugas::with(['user', 'kategori', 'lampirans'])
            ->latest()
            ->take(5) // Ambil 5 tugas terbaru saja untuk ringkasan dashboard
            ->get();

        // Hitung statistik untuk counter box di atas dashboard
        $totalTasks = Tugas::count();
        $belumDikerjakan =Tugas::whereDoesntHave('lampirans')->count();
        $selesai = Tugas::whereHas('lampirans', function($q) {
            $q->where('is_accepted', 1);
        })->count();
        $sedangDikerjakan = $totalTasks - ($belumDikerjakan + $selesai);

    } else {
        // Jika yang login Siswa biasa
        $tasks = Tugas::where('user_id', auth()->id())
            ->with(['kategori', 'lampirans'])
            ->latest()
            ->take(5)
            ->get();

        $totalTasks =Tugas::where('user_id', auth()->id())->count();
        $belumDikerjakan = Tugas::where('user_id', auth()->id())->whereDoesntHave('lampirans')->count();
        $selesai = Tugas::where('user_id', auth()->id())->whereHas('lampirans', function($q) {
            $q->where('is_accepted', 1);
        })->count();
        $sedangDikerjakan = $totalTasks - ($belumDikerjakan + $selesai);
    }

    return view('dashboard', [
    'recentTasks'      => $tasks,             
    'totalTugas'       => $totalTasks,     
    'belum'            => $belumDikerjakan,   
    'proses'           => $sedangDikerjakan,  
    'selesai'          => $selesai 
]);
}
}
