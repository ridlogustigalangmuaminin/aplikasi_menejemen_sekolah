<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\Tugas;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index()
    {
        // 1. Ambil data user yang sedang login
        $user = Auth::user();

        // 2. Hitung total tugas yang sudah diselesaikan oleh user ini
        // Memanfaatkan relasi status atau pencarian string 'Completed'
        $totalCompleted = Tugas::where('user_id', $user->id)
            ->whereHas('status', function ($q) {
                $q->where('nama_status', 'Completed');
            })->count();

        // 3. Hitung total tugas yang dimiliki oleh user ini
        $totalTugas = Tugas::where('user_id', $user->id)->count();

        // Kirim data user dan total tugas selesai ke view profile
        return view('profil', compact('user', 'totalCompleted', 'totalTugas'));
    }

    public function editPassword() {
    return view('auth.edit'); // atau arahkan ke view form password Anda
}

        // Fungsi memproses update password baru
        public function updatePassword(Request $request)
        {
            $request->validate([
                'current_password' => ['required', 'current_password'], // Memastikan password lama cocok
                'password' => ['required', Password::defaults(), 'confirmed'], // Memastikan password baru & konfirmasinya sama
            ]);

            $request->user()->update([
                'password' => Hash::make($request->password),
            ]);

            return back()->with('status', 'password-updated');
        }

        public function deactivate(Request $request)
    {
        $user = Auth::user(); // Ambil data user yang sedang login

        // 1. Proses Logout paksa dari aplikasi
        Auth::logout();

        // 2. Hapus data user dari database
        $user->delete();

        // 3. Bersihkan session browser agar aman
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 4. Oper balik ke halaman utama (welcome/login) dengan pesan sukses
        return redirect('/')->with('success', 'Akun Anda telah berhasil dinonaktifkan.');
    }
}
