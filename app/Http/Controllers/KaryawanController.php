<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KaryawanController extends Controller
{
    // Dashboard Karyawan
    public function dashboard()
    {
        $user = Auth::user();

        // Pastikan hanya karyawan yang bisa akses
        if ($user->role !== 'karyawan') {
            return redirect('/admin/dashboard')->with('error', 'Akses ditolak.');
        }

        return view('karyawan.dashboard', compact('user'));
    }

    // Tambahkan metode lain nanti
}
