<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ToppingController;
use App\Http\Controllers\UkuranController;
use App\Http\Controllers\JenisSusuController;
use App\Http\Controllers\KepekatanMatchaController;
use App\Http\Controllers\TingkatKemanisanController;
use App\Http\Controllers\EsBatuController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PersonalisasiController;
use App\Models\Produk;

// ====================================================
// 1. HALAMAN PUBLIK (Landing Page) - HANYA SATU ROUTE /
// ====================================================
Route::get('/', function () {
    try {
        // Coba ambil produk dengan relasi kategori
        $produk = Produk::with('kategori')->where('stok', '>', 0)->get();

        // Jika error atau kosong, ambil tanpa relasi
        if ($produk->isEmpty()) {
            $produk = Produk::where('stok', '>', 0)->get();
        }
    } catch (\Exception $e) {
        \Log::error('Error loading products: ' . $e->getMessage());
        // Fallback: ambil semua produk atau array kosong
        try {
            $produk = Produk::all();
        } catch (\Exception $e2) {
            $produk = [];
        }
    }

    return view('welcome', compact('produk'));
});

// ====================================================
// 2. HALAMAN LOGIN
// ====================================================
Route::get('/login', [AuthController::class, 'loginAdmin'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ====================================================
// 3. HALAMAN ADMIN
// ====================================================
Route::middleware(['auth'])->group(function () {

    // --- AREA ADMIN ---
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/transaksi/detail', function () {
        return view('admin.transaksi.detail');
    })->name('admin.transaksi.detail');

    Route::resource('admin/users', UserController::class)->names('admin.users');
    Route::resource('admin/produk', ProdukController::class)->names('admin.produk');
    Route::resource('admin/kategori', KategoriController::class)->names('admin.kategori');
    Route::resource('admin/topping', ToppingController::class)->names('admin.topping');
    Route::resource('admin/ukuran', UkuranController::class)->names('admin.ukuran');
    Route::resource('admin/jenis-susu', JenisSusuController::class)->names('admin.jenis_susu');
    Route::resource('admin/kepekatan', KepekatanMatchaController::class)->names('admin.kepekatan');
    Route::resource('admin/tingkat-kemanisan', TingkatKemanisanController::class)->names('admin.tingkat_kemanisan');
    Route::resource('admin/es-batu', EsBatuController::class)->names('admin.es_batu');
});

// ====================================================
// 4. AREA KARYAWAN
// ====================================================
Route::middleware(['auth'])->prefix('karyawan')->name('karyawan.')->group(function() {
    // Dashboard
    Route::get('/dashboard', [KaryawanController::class, 'dashboard'])->name('dashboard');

    // Menu
    Route::prefix('menu')->name('menu.')->group(function() {
        Route::get('/', [MenuController::class, 'index'])->name('index');
        Route::get('/makanan', [MenuController::class, 'makanan'])->name('makanan');
        Route::get('/minuman', [MenuController::class, 'minuman'])->name('minuman');
        Route::get('/karyawan/menu', [MenuController::class, 'index'])->name('karyawan.menu.index');
    });

    // Transaksi
    Route::prefix('transaksi')->name('transaksi.')->group(function() {
        // Cart & Checkout Process
        Route::get('/cart', [TransaksiController::class, 'cart'])->name('cart');
        Route::post('/cart/add', [TransaksiController::class, 'addToCart'])->name('cart.add');
        Route::get('/cart/increase/{index}', [TransaksiController::class, 'increaseCart'])->name('cart.increase');
        Route::get('/cart/decrease/{index}', [TransaksiController::class, 'decreaseCart'])->name('cart.decrease');
        Route::get('/cart/remove/{index}', [TransaksiController::class, 'removeFromCart'])->name('cart.remove');
        Route::post('/cart/clear', [TransaksiController::class, 'clearCart'])->name('cart.clear');



        // Checkout Steps
        Route::get('/checkout/form', [TransaksiController::class, 'checkoutForm'])->name('checkout.form');
        Route::post('/checkout/confirm', [TransaksiController::class, 'confirmPayment'])->name('checkout.confirm');
        Route::get('/checkout/metode', [TransaksiController::class, 'metodePembayaran'])->name('checkout.metode');
        Route::post('/checkout/process', [TransaksiController::class, 'checkout'])->name('checkout.process');

        // Transaksi CRUD
        Route::get('/', [TransaksiController::class, 'index'])->name('index');
        Route::get('/create', [TransaksiController::class, 'create'])->name('create');
        Route::post('/', [TransaksiController::class, 'store'])->name('store');
        Route::get('/{id}', [TransaksiController::class, 'show'])->name('show');
        Route::get('/struk/{id}', [TransaksiController::class, 'struk'])->name('struk');
        Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::get('/transaksi/struk/{id}', [TransaksiController::class, 'struk'])->name('transaksi.struk');
    });

    // Personalisasi
    Route::get('/personalisasi/form', [PersonalisasiController::class, 'form'])->name('personalisasi.form');
});
