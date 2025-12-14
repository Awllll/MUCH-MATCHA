<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\DetailTransaksiTopping;
use App\Models\Produk;
use App\Models\Topping;
use App\Models\User;
use App\Models\Kategori;
use App\Models\MetodePembayaran;
use App\Models\TingkatKemanisan;
use App\Models\Ukuran;

class TransaksiController extends Controller
{
    // ==================== METHOD UNTUK CART/KERANJANG ====================

    /**
     * Tambah produk ke keranjang
     */
public function addToCart(Request $request)
{
    try {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'nama' => 'required',
            'harga' => 'required|numeric'
        ]);

        $produk = Produk::find($request->produk_id);

        if (!$produk) {
            return back()->with('error', 'Produk tidak ditemukan!');
        }

        if ($produk->stok <= 0) {
            return back()->with('error', 'Stok produk habis! Stok tersedia: ' . $produk->stok);
        }

        $cart = session()->get('cart', []);

        // Ambil data personalisasi
        $ukuran = $request->ukuran;
        $kemanisan = $request->kemanisan;
        $topping = $request->topping ?? [];

        // Inisialisasi variabel untuk nama dan harga tambahan
        $ukuran_nama = null;
        $ukuran_harga = 0;
        $kemanisan_nama = null;
        $topping_nama = [];

        // Jika ada ukuran, ambil data dari database
        if ($ukuran) {
            $ukuranModel = Ukuran::find($ukuran);
            if ($ukuranModel) {
                $ukuran_nama = $ukuranModel->nama;
                $ukuran_harga = $ukuranModel->harga_tambahan;
            }
        }

        // Jika ada kemanisan, ambil data dari database
        if ($kemanisan) {
            $kemanisanModel = TingkatKemanisan::find($kemanisan);
            if ($kemanisanModel) {
                $kemanisan_nama = $kemanisanModel->nama;
            }
        }

        // Jika ada topping, ambil data dari database
        $topping_data = [];
        if (!empty($topping)) {
            foreach ($topping as $toppingId) {
                $toppingModel = Topping::find($toppingId);
                if ($toppingModel) {
                    $topping_data[] = [
                        'id' => $toppingId,
                        'nama' => $toppingModel->nama,
                        'harga' => $toppingModel->harga
                    ];
                }
            }
        }

        // Buat item baru
        $newItem = [
            'produk_id' => $produk->id,
            'nama' => $produk->nama,
            'harga' => $produk->harga,
            'qty' => 1,
            'tipe' => 'personalisasi', // karena kita menggunakan form personalisasi
            'ukuran_id' => $ukuran,
            'ukuran_nama' => $ukuran_nama,
            'ukuran_harga' => $ukuran_harga,
            'kemanisan_id' => $kemanisan,
            'kemanisan_nama' => $kemanisan_nama,
            'topping_id' => $topping,
            'topping_data' => $topping_data,
        ];

        // Cek apakah item sudah ada di cart dengan personalisasi yang sama
        $itemExists = false;
        foreach ($cart as $key => $item) {
            if ($item['produk_id'] == $newItem['produk_id']
                && $item['ukuran_id'] == $newItem['ukuran_id']
                && $item['kemanisan_id'] == $newItem['kemanisan_id']) {

                // Untuk topping, kita bandingkan array
                $topping_sama = true;
                if (count($item['topping_id']) != count($newItem['topping_id'])) {
                    $topping_sama = false;
                } else {
                    sort($item['topping_id']);
                    sort($newItem['topping_id']);
                    if ($item['topping_id'] != $newItem['topping_id']) {
                        $topping_sama = false;
                    }
                }

                if ($topping_sama) {
                    // Update quantity
                    $cart[$key]['qty']++;
                    $itemExists = true;
                    break;
                }
            }
        }

        // Jika item belum ada, tambahkan baru
        if (!$itemExists) {
            $cart[] = $newItem;
        }

        // Simpan ke session
        session()->put('cart', $cart);

        return redirect()->route('karyawan.transaksi.cart')
            ->with('success', 'Produk "' . $produk->nama . '" berhasil ditambahkan ke keranjang!');

    } catch (\Exception $e) {
        \Log::error('Error addToCart: ' . $e->getMessage());
        return back()->with('error', 'Gagal menambahkan produk: ' . $e->getMessage());
    }
}

    /**
     * Tampilkan keranjang
     */
    public function cart()
{
    // Ambil cart dari session
    $cart = session()->get('cart', []);

    // Debug: tampilkan isi cart
    \Log::info('Cart di method cart():', $cart);
    \Log::info('Total items in cart:', [count($cart)]);

    return view('karyawan.transaksi.cart', compact('cart'));
}

    /**
     * Tambah jumlah item di cart
     */
    public function increaseCart($index)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$index])) {
            $produk = Produk::find($cart[$index]['produk_id'] ?? null);

            // Cek stok
            if ($produk && $produk->stok > $cart[$index]['qty']) {
                $cart[$index]['qty'] += 1;
                session()->put('cart', $cart);
                return back()->with('success', 'Jumlah berhasil ditambah');
            } else {
                return back()->with('error', 'Stok tidak mencukupi');
            }
        }

        return back()->with('error', 'Item tidak ditemukan');
    }

    /**
     * Kurangi jumlah item di cart
     */
    public function decreaseCart($index)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$index])) {
            if ($cart[$index]['qty'] > 1) {
                $cart[$index]['qty'] -= 1;
            } else {
                unset($cart[$index]);
                $cart = array_values($cart); // Reset index array
            }
            session()->put('cart', $cart);
            return back()->with('success', 'Jumlah berhasil dikurangi');
        }

        return back()->with('error', 'Item tidak ditemukan');
    }

    /**
     * Hapus item dari cart
     */
    public function removeFromCart($index)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$index])) {
            unset($cart[$index]);
            $cart = array_values($cart); // Reset index array
            session()->put('cart', $cart);
            return back()->with('success', 'Item berhasil dihapus dari keranjang');
        }

        return back()->with('error', 'Item tidak ditemukan');
    }

    /**
     * Kosongkan seluruh cart
     */
    public function clearCart()
    {
        session()->forget('cart');
        return back()->with('success', 'Keranjang berhasil dikosongkan');
    }

    // ==================== METHOD UNTUK CHECKOUT & TRANSAKSI ====================

    /**
     * Form checkout (isi data pembeli)
     */
    public function checkoutForm()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += ($item['harga'] ?? 0) * ($item['qty'] ?? 1);
        }

        return view('karyawan.transaksi.checkout', compact('cart', 'total'));
    }

    /**
     * Simpan data pembeli dan lanjut ke metode pembayaran
     */
    public function confirmPayment(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('karyawan.checkout.form')->with('error', 'Keranjang kosong!');
        }

        $request->validate([
            'nama_pembeli' => 'required|string|max:100'
        ]);

        session(['checkout_data' => [
            'nama_pembeli' => $request->nama_pembeli
        ]]);

        return redirect()->route('karyawan.transaksi.metode_pembayaran');
    }

    /**
     * Tampilkan pilihan metode pembayaran
     */
    public function metodePembayaran()
    {
        $cart = session()->get('cart', []);
        $checkoutData = session('checkout_data', []);

        if (empty($cart) || empty($checkoutData)) {
            return redirect()->route('karyawan.checkout.form')
                ->with('error', 'Keranjang atau data pembeli kosong!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += ($item['harga'] ?? 0) * ($item['qty'] ?? 1);
        }

        // Gunakan model MetodePembayaran
        $metode = MetodePembayaran::where('status', true)->get();

        return view('karyawan.transaksi.metode_pembayaran', compact('cart', 'total', 'metode'));
    }

    /**
     * Proses akhir transaksi
     */
public function checkout(Request $request)
{
    $cart = session()->get('cart', []);
    $checkoutData = session('checkout_data', []);

    if (empty($cart) || empty($checkoutData)) {
        return redirect()->route('karyawan.checkout.form')
            ->with('error', 'Keranjang atau data pembeli kosong!');
    }

    $request->validate([
        'metode_pembayaran' => 'required|string' // Ubah validasi
    ]);

    $totalHarga = 0;
    foreach ($cart as $item) {
        $totalHarga += ($item['harga'] ?? 0) * ($item['qty'] ?? 1);
    }

    $transaksi = null;

    DB::transaction(function() use ($request, $cart, $totalHarga, $checkoutData, &$transaksi) {
        // Generate kode transaksi
        $kodeTransaksi = 'TRX-' . date('Ymd') . '-' . str_pad(Transaksi::count() + 1, 3, '0', STR_PAD_LEFT);

        $transaksi = Transaksi::create([
            'user_id' => auth()->id(),
            'kode_transaksi' => $kodeTransaksi,
            'nama_pembeli' => $checkoutData['nama_pembeli'],
            'total_harga' => $totalHarga,
            'metode_pembayaran' => $request->metode_pembayaran, // String, bukan ID
            'status' => 'selesai'
        ]);

            foreach ($cart as $item) {
                $produkId = $item['id'] ?? $item['produk_id'] ?? null;
                $detailData = [
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $produkId,
                    'jumlah' => $item['qty'] ?? 1,
                    'harga_saat_transaksi' => $item['harga'] ?? 0,
                ];

                // Tambah data personalisasi jika ada
                if (!empty($item['ukuran_id'])) {
                    $detailData['ukuran_id'] = $item['ukuran_id'];
                }

                if (!empty($item['kemanisan_id'])) {
                    $detailData['kemanisan_id'] = $item['kemanisan_id'];
                }

                $detail = DetailTransaksi::create($detailData);

                // Kurangi stok produk
                if ($produkId) {
                    $produk = Produk::find($produkId);
                    if ($produk) {
                        $produk->stok -= ($item['qty'] ?? 1);
                        $produk->save();
                    }
                }

                // Tambah topping jika ada
                if (!empty($item['topping_id'])) {
                    foreach ($item['topping_id'] as $tid) {
                        $topping = Topping::find($tid);

                        DetailTransaksiTopping::create([
                            'detail_transaksi_id' => $detail->id,
                            'topping_id' => $tid,
                            'harga_topping_saat_transaksi' => $topping ? $topping->harga : 0
                        ]);

                        // Kurangi stok topping
                        if ($topping) {
                            $topping->stok -= ($item['qty'] ?? 1);
                            $topping->save();
                        }
                    }
                }
            }
        });

        // Hapus session setelah transaksi berhasil
            session()->forget(['cart', 'checkout_data']);

    return redirect()->route('karyawan.transaksi.struk', $transaksi->id)
        ->with('success', 'Transaksi berhasil disimpan!');
    }

    /**
     * Tampilkan struk transaksi
     */
    public function struk($id)
    {
        $transaksi = Transaksi::with([
            'user',
            'detailTransaksi.produk',
            'detailTransaksi.ukuran',
            'detailTransaksi.kemanisan',
            'detailTransaksi.topping'
        ])->findOrFail($id);

        return view('karyawan.transaksi.struk', compact('transaksi'));
    }

    /**
     * Tampilkan daftar transaksi (untuk riwayat)
     */
    public function index()
    {
        // Ubah dari 'pengguna_id' menjadi 'user_id'
        $transaksi = Transaksi::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('karyawan.transaksi.index', compact('transaksi'));
    }

    /**
     * Tampilkan detail transaksi
     */
    public function show($id)
    {
        $transaksi = Transaksi::with([
            'metodePembayaran',
            'user', // Ubah dari 'pengguna' menjadi 'user'
            'detailTransaksi.produk',
            'detailTransaksi.ukuran',
            'detailTransaksi.kemanisan',
            'detailTransaksi.topping'
        ])->findOrFail($id);

        // Ubah dari 'pengguna_id' menjadi 'user_id'
        if ($transaksi->user_id != auth()->id()) {
            return redirect()->route('karyawan.transaksi.index')
                ->with('error', 'Anda tidak memiliki akses ke transaksi ini.');
        }

        return view('karyawan.transaksi.show', compact('transaksi'));
    }

    /**
     * Form untuk membuat transaksi baru (dengan personalisasi)
     */
    public function create()
    {
        $produks = Produk::where('stok', '>', 0)->get();
        $toppings = Topping::where('stok', '>', 0)->get();
        $ukurans = Ukuran::all();
        $kemanisans = TingkatKemanisan::all();
        $metodePembayaran = MetodePembayaran::where('status', true)->get();

        return view('karyawan.transaksi.create', compact(
            'produks', 'toppings', 'ukurans', 'kemanisans', 'metodePembayaran'
        ));
    }

    /**
     * Simpan transaksi baru (alternatif dari checkout)
     */
public function store(Request $request)
{
    $request->validate([
        'produk_id' => 'required|exists:produks,id',
        'nama_pembeli' => 'required|string|max:100',
        'metode_pembayaran' => 'required|string|in:tunai,qris,transfer', // validasi untuk string
        'jumlah' => 'required|integer|min:1'
    ]);

    $produk = Produk::find($request->produk_id);

    // Cek stok
    if ($produk->stok < $request->jumlah) {
        return back()->with('error', 'Stok produk tidak mencukupi!');
    }

    // Generate kode transaksi
    $kodeTransaksi = 'TRX-' . date('Ymd') . '-' . str_pad(Transaksi::count() + 1, 3, '0', STR_PAD_LEFT);

    $transaksi = Transaksi::create([
        'user_id' => auth()->id(),
        'kode_transaksi' => $kodeTransaksi,
        'nama_pembeli' => $request->nama_pembeli,
        'total_harga' => $produk->harga * $request->jumlah,
        'metode_pembayaran' => $request->metode_pembayaran,
        'status' => 'selesai'
    ]);

        // Simpan detail transaksi
        $detail = DetailTransaksi::create([
            'transaksi_id' => $transaksi->id,
            'produk_id' => $produk->id,
            'jumlah' => $request->jumlah,
            'harga_saat_transaksi' => $produk->harga,
            'ukuran_id' => $request->ukuran_id,
            'kemanisan_id' => $request->kemanisan_id,
        ]);

        // Kurangi stok produk
        $produk->stok -= $request->jumlah;
        $produk->save();

        // Tambah topping jika ada
        if ($request->has('topping_id')) {
            foreach ($request->topping_id as $toppingId) {
                $topping = Topping::find($toppingId);

                if ($topping && $topping->stok > 0) {
                    DetailTransaksiTopping::create([
                        'detail_transaksi_id' => $detail->id,
                        'topping_id' => $toppingId,
                        'harga_topping_saat_transaksi' => $topping->harga
                    ]);

                    $topping->stok -= $request->jumlah;
                    $topping->save();

                    // Update total harga transaksi
                    $transaksi->total_harga += ($topping->harga * $request->jumlah);
                    $transaksi->save();
                }
            }
        }

        return redirect()->route('karyawan.transaksi.struk', $transaksi->id)
            ->with('success', 'Transaksi berhasil dibuat!');
    }
}
