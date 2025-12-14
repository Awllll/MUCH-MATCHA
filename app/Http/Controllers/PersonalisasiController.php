<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PersonalisasiController extends Controller
{
    public function form()
    {
        return view('karyawan.personalisasi.form');
    }
}
