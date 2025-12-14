@extends('layouts.karyawan')

@section('title', 'Buat Transaksi Baru')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-semibold text-gray-900">Buat Transaksi Baru</h1>
            <p class="text-gray-600 mt-1">Pilih produk dan sesuaikan dengan preferensi pelanggan</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Kolom Kiri: Daftar Produk -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Daftar Produk Tersedia</h2>

                    <!-- Pencarian dan Filter -->
                    <div class="mb-6">
                        <input type="text"
                               id="searchProduk"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-matcha-500 focus:border-transparent"
                               placeholder="Cari produk...">
                    </div>

                    <!-- Daftar Produk -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($produks as $produk)
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-matcha-300 transition-colors">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-medium text-gray-900 truncate">{{ $produk->nama }}</h3>
                                    <p class="text-sm text-gray-600 truncate">{{ $produk->kategori->nama ?? 'Tidak Berkategori' }}</p>
                                </div>
                                <span class="ml-2 px-2 py-1 {{ $produk->stok > 0 ? 'bg-matcha-100 text-matcha-800' : 'bg-red-100 text-red-800' }} text-xs font-medium rounded whitespace-nowrap">
                                    {{ $produk->stok > 0 ? 'Stok: ' . $produk->stok : 'Habis' }}
                                </span>
                            </div>

                            <div class="flex justify-between items-center mb-3">
                                <span class="text-lg font-semibold text-gray-900">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                            </div>

                            @if($produk->stok > 0)
                            <button onclick="addToCart({{ $produk->id }}, '{{ addslashes($produk->nama) }}', {{ $produk->harga }})"
                                    class="w-full px-3 py-2 bg-matcha-500 text-white text-sm rounded-lg hover:bg-matcha-600 transition-colors flex items-center justify-center">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Tambah ke Keranjang
                            </button>
                            @else
                            <button disabled
                                    class="w-full px-3 py-2 bg-gray-200 text-gray-500 text-sm rounded-lg cursor-not-allowed">
                                Stok Habis
                            </button>
                            @endif
                        </div>
                        @empty
                        <div class="col-span-2 text-center py-8">
                            <svg class="h-12 w-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <p class="text-gray-600">Tidak ada produk tersedia</p>
                            <p class="text-sm text-gray-500 mt-1">Semua produk sedang habis stok</p>
                        </div>
                        @endforelse
                    </div>
                </div>

<!-- Form Personalisasi (akan muncul saat menambahkan produk tertentu) -->
<div id="personalizationForm" class="hidden mt-6 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <h2 class="text-lg font-medium text-gray-900 mb-4">Personalizasi Produk</h2>

    <form method="POST" action="{{ route('karyawan.transaksi.cart.add') }}" id="personalizationFormSubmit">
        @csrf
        <input type="hidden" name="produk_id" id="formProdukId">
        <input type="hidden" name="nama" id="formNama">
        <input type="hidden" name="harga" id="formHarga">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Ukuran -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Ukuran</label>
                <select name="ukuran" id="ukuranSelect" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-matcha-500 focus:border-transparent">
                    <option value="">Pilih Ukuran</option>
                    @foreach($ukurans as $ukuran)
                    <option value="{{ $ukuran->id }}" data-harga="{{ $ukuran->harga_tambahan }}">
                        {{ $ukuran->nama }} (+Rp {{ number_format($ukuran->harga_tambahan, 0, ',', '.') }})
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Tingkat Kemanisan -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tingkat Kemanisan</label>
                <select name="kemanisan" id="kemanisanSelect" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-matcha-500 focus:border-transparent">
                    <option value="">Pilih Kemanisan</option>
                    @foreach($kemanisans as $kemanisan)
                    <option value="{{ $kemanisan->id }}">{{ $kemanisan->nama }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Topping -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Topping (Opsional)</label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                    @foreach($toppings as $topping)
                    <label class="flex items-center p-2 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                        <input type="checkbox" name="topping[]" value="{{ $topping->id }}" data-nama="{{ $topping->nama }}" data-harga="{{ $topping->harga }}" class="h-4 w-4 text-matcha-600 focus:ring-matcha-500 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700">
                            {{ $topping->nama }} (+Rp {{ number_format($topping->harga, 0, ',', '.') }})
                        </span>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <button type="button" id="cancelPersonalization" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors mr-3">
                Batal
            </button>
            <button type="submit" class="px-4 py-2 bg-matcha-500 text-white rounded-lg hover:bg-matcha-600 transition-colors">
                Tambah ke Keranjang
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
// Data sementara untuk cart
let cart = [];
let currentProduct = null; // Untuk menyimpan data produk yang sedang dipersonalisasi

// Fungsi untuk format rupiah
function formatRupiah(angka) {
    return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Fungsi untuk menghitung total
function calculateTotal() {
    let subtotal = 0;

    cart.forEach(item => {
        let itemTotal = item.harga * item.qty;

        // Tambah harga ukuran jika ada
        if (item.ukuran_harga) {
            itemTotal += item.ukuran_harga * item.qty;
        }

        // Tambah harga topping jika ada
        if (item.toppings) {
            item.toppings.forEach(topping => {
                itemTotal += topping.harga * item.qty;
            });
        }

        subtotal += itemTotal;
    });

    const tax = subtotal * 0.10; // Pajak 10%
    const total = subtotal + tax;

    return {
        subtotal: subtotal,
        tax: tax,
        total: total
    };
}

// Fungsi untuk update tampilan cart
function updateCartDisplay() {
    const cartCount = document.getElementById('cartCount');
    const cartItems = document.getElementById('cartItems');
    const subtotalEl = document.getElementById('subtotal');
    const taxEl = document.getElementById('tax');
    const cartTotalEl = document.getElementById('cartTotal');

    // Update count
    cartCount.textContent = cart.length;

    // Update items list
    if (cart.length === 0) {
        cartItems.innerHTML = `
            <div class="text-center py-8 text-gray-500">
                <svg class="h-12 w-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <p>Keranjang kosong</p>
                <p class="text-sm">Tambahkan produk dari daftar di atas</p>
            </div>
        `;
    } else {
        let itemsHTML = '';

        cart.forEach((item, index) => {
            let itemPrice = item.harga;
            let additionalInfo = '';

            if (item.ukuran_nama) {
                itemPrice += item.ukuran_harga;
                additionalInfo += `<div class="text-xs text-gray-500">Ukuran: ${item.ukuran_nama}</div>`;
            }

            if (item.kemanisan_nama) {
                additionalInfo += `<div class="text-xs text-gray-500">Kemanisan: ${item.kemanisan_nama}</div>`;
            }

            if (item.toppings && item.toppings.length > 0) {
                const toppingNames = item.toppings.map(t => t.nama).join(', ');
                additionalInfo += `<div class="text-xs text-gray-500">Topping: ${toppingNames}</div>`;
            }

            itemsHTML += `
                <div class="border border-gray-100 rounded-lg p-3">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-900 truncate">${item.nama}</p>
                            ${additionalInfo}
                            <p class="text-sm text-gray-600 mt-1">${formatRupiah(itemPrice)} x ${item.qty}</p>
                        </div>
                        <div class="flex items-center ml-2">
                            <button onclick="updateQuantity(${index}, -1)" class="w-6 h-6 flex items-center justify-center border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50">
                                -
                            </button>
                            <span class="w-8 text-center text-sm">${item.qty}</span>
                            <button onclick="updateQuantity(${index}, 1)" class="w-6 h-6 flex items-center justify-center border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50">
                                +
                            </button>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-900">${formatRupiah(itemPrice * item.qty)}</span>
                        <button onclick="removeFromCart(${index})" class="text-xs text-red-600 hover:text-red-800">
                            Hapus
                        </button>
                    </div>
                </div>
            `;
        });

        cartItems.innerHTML = itemsHTML;
    }

    // Update totals
    const totals = calculateTotal();
    subtotalEl.textContent = formatRupiah(Math.round(totals.subtotal));
    taxEl.textContent = formatRupiah(Math.round(totals.tax));
    cartTotalEl.textContent = formatRupiah(Math.round(totals.total));
}

// Fungsi untuk menambah produk ke cart (menampilkan form personalisasi)
function addToCart(produkId, produkNama, produkHarga) {
    // Isi data produk ke form
    document.getElementById('formProdukId').value = produkId;
    document.getElementById('formNama').value = produkNama;
    document.getElementById('formHarga').value = produkHarga;

    // Tampilkan form personalisasi
    document.getElementById('personalizationForm').classList.remove('hidden');
    document.getElementById('personalizationForm').scrollIntoView({ behavior: 'smooth' });
}

// Fungsi untuk konfirmasi personalisasi dan tambah ke cart
document.getElementById('confirmPersonalization').addEventListener('click', function() {
    if (!currentProduct) return;

    // Ambil data personalisasi
    const ukuranSelect = document.getElementById('ukuranSelect');
    const selectedUkuran = ukuranSelect.options[ukuranSelect.selectedIndex];

    const kemanisanSelect = document.getElementById('kemanisanSelect');
    const selectedKemanisan = kemanisanSelect.options[kemanisanSelect.selectedIndex];

    // Ambil topping yang dipilih
    const selectedToppings = [];
    document.querySelectorAll('input[name="topping"]:checked').forEach(checkbox => {
        selectedToppings.push({
            id: checkbox.value,
            nama: checkbox.dataset.nama,
            harga: parseInt(checkbox.dataset.harga)
        });
    });

    // Update currentProduct dengan data personalisasi
    if (selectedUkuran.value) {
        currentProduct.ukuran_id = selectedUkuran.value;
        currentProduct.ukuran_nama = selectedUkuran.text.split(' (+')[0];
        currentProduct.ukuran_harga = parseInt(selectedUkuran.dataset.harga);
    }

    if (selectedKemanisan.value) {
        currentProduct.kemanisan_id = selectedKemanisan.value;
        currentProduct.kemanisan_nama = selectedKemanisan.text;
    }

    if (selectedToppings.length > 0) {
        currentProduct.toppings = selectedToppings;
        currentProduct.topping_id = selectedToppings.map(t => t.id);
    }

    // Tambah ke cart
    cart.push(currentProduct);

    // Reset form dan sembunyikan
    resetPersonalizationForm();
    document.getElementById('personalizationForm').classList.add('hidden');

    // Update tampilan cart
    updateCartDisplay();

    // Reset currentProduct
    currentProduct = null;
});

// Fungsi untuk membatalkan personalisasi
document.getElementById('cancelPersonalization').addEventListener('click', function() {
    resetPersonalizationForm();
    document.getElementById('personalizationForm').classList.add('hidden');
    currentProduct = null;
});

// Fungsi reset form personalisasi
function resetPersonalizationForm() {
    document.getElementById('ukuranSelect').selectedIndex = 0;
    document.getElementById('kemanisanSelect').selectedIndex = 0;
    document.querySelectorAll('input[name="topping"]').forEach(checkbox => {
        checkbox.checked = false;
    });
}

// Fungsi update quantity
function updateQuantity(index, change) {
    if (cart[index]) {
        cart[index].qty += change;
        if (cart[index].qty < 1) {
            cart.splice(index, 1);
        }
        updateCartDisplay();
    }
}

// Fungsi hapus dari cart
function removeFromCart(index) {
    if (confirm('Hapus item dari keranjang?')) {
        cart.splice(index, 1);
        updateCartDisplay();
    }
}

// Fungsi kosongkan cart
function clearCart() {
    if (cart.length > 0 && confirm('Kosongkan seluruh keranjang?')) {
        cart = [];
        updateCartDisplay();
    }
}

// Fungsi pencarian produk
document.getElementById('searchProduk').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const productCards = document.querySelectorAll('.border.border-gray-200.rounded-lg');

    productCards.forEach(card => {
        const productName = card.querySelector('h3').textContent.toLowerCase();
        const productCategory = card.querySelector('p').textContent.toLowerCase();

        if (productName.includes(searchTerm) || productCategory.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});

// Inisialisasi saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    updateCartDisplay();
});
</script>
@endpush
@endsection
