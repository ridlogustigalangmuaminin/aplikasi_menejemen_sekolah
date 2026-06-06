<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kelas' => 'nullable',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'nisn' => ['required', 'string', 'max:20'],
        'phone' => ['required', 'string', 'max:20'],
        'enrollment_year' => ['required', 'numeric', 'digits:4'],

        ]);

        $user = User::create([
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nisn' => $request->nisn,
            'phone' => $request->phone,
            'enrollment_year' => $request->enrollment_year,
        ]);

        

        return redirect('/login');
        dd($request->all());
    }
    
}