<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;

class MenuController extends Controller
{

    public function index()
{
    $produks = Produk::where('stok', '>', 0)->get();

    return view('karyawan.menu.index', [
        'title' => 'Semua Menu',
        'menus' => $produks
    ]);
}

    public function makanan()
    {
        // Cari kategori makanan
        $kategoriMakanan = Kategori::where('nama', 'like', '%makanan%')
            ->orWhere('nama', 'like', '%Makanan%')
            ->first();

        if ($kategoriMakanan) {
            $menus = Produk::where('kategori_id', $kategoriMakanan->id)
                ->where('stok', '>', 0)
                ->get();
        } else {
            $menus = collect(); // Koleksi kosong
        }

        return view('karyawan.menu.makanan', [
            'title' => 'Menu Makanan',
            'menus' => $menus
        ]);
    }

    public function minuman()
    {
        // Cari kategori minuman
        $kategoriMinuman = Kategori::where('nama', 'like', '%minuman%')
            ->orWhere('nama', 'like', '%Minuman%')
            ->orWhere('nama', 'like', '%drink%')
            ->first();

        if ($kategoriMinuman) {
            $menus = Produk::where('kategori_id', $kategoriMinuman->id)
                ->where('stok', '>', 0)
                ->get();
        } else {
            $menus = collect();
        }

        return view('karyawan.menu.minuman', [
            'title' => 'Menu Minuman',
            'menus' => $menus
        ]);
    }
}
