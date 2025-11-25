<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function showTransaction($id)
    {
        // Di aplikasi nyata, nanti kita ambil data dari database berdasarkan $id
        // Contoh: $transaction = Transaction::find($id);

        return view('admin.transaction-detail', ['id' => $id]);
    }
}
