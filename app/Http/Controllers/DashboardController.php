<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tugas;
class DashboardController extends Controller
{
    // public function index()
    // {
    //     $totalTugas = Tugas::count();

    //     $recentTasks = Tugas::latest()
    //         ->take(5)
    //         ->get();

    //     return view('dashboard', compact(
    //         'totalTugas',
    //         'recentTasks'
    //     ));
    // }
    public function index()
{
    $totalTugas = Tugas::count();

    $belum = Tugas::whereHas('status', function ($q) {
        $q->where('nama_status', 'Belum');
    })->count();

    $proses = Tugas::whereHas('status', function ($q) {
        $q->where('nama_status', 'Sedang Dikerjakan');
    })->count();

    $selesai = Tugas::whereHas('status', function ($q) {
        $q->where('nama_status', 'Selesai');
    })->count();

    $recentTasks = Tugas::with('status')
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
