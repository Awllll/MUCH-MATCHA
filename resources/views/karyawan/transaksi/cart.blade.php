@extends('layouts.karyawan')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-4xl mx-auto">
        <!-- Notifikasi -->
        @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-green-800">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-red-800">{{ session('error') }}</span>
            </div>
        </div>
        @endif

        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Keranjang Belanja</h1>
                    <p class="text-gray-600 mt-1">Kelola produk yang akan dibeli</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('karyawan.transaksi.create') }}"
                       class="px-4 py-2 bg-matcha-500 text-white rounded-lg hover:bg-matcha-600 transition-colors">
                        + Tambah Produk
                    </a>
                    <a href="{{ route('karyawan.dashboard') }}"
                       class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>

        @if(count($cart) == 0)
        <!-- Keranjang Kosong -->
        <div class="bg-white border border-gray-200 rounded-lg p-8 text-center">
            <svg class="h-16 w-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Keranjang Kosong</h3>
            <p class="text-gray-600 mb-6">Belum ada produk di keranjang Anda</p>
            <a href="{{ route('karyawan.transaksi.create') }}"
               class="inline-block px-6 py-3 bg-matcha-500 text-white rounded-lg hover:bg-matcha-600 transition-colors">
                Mulai Belanja
            </a>
        </div>
        @else
        <!-- Keranjang Berisi -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Daftar Item -->
            <div class="lg:col-span-2">
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Daftar Produk</h2>

                    <div class="space-y-4">
    @foreach($cart as $index => $item)
    <div class="border border-gray-200 rounded-lg p-4 hover:border-matcha-300 transition-colors">
        <div class="flex items-start justify-between">
            <div class="flex-1 min-w-0">
                <h4 class="font-medium text-gray-900">{{ $item['nama'] }}</h4>

                {{-- Tampilkan personalisasi --}}
                @if($item['tipe'] == 'personalisasi')
                <div class="mt-2 space-y-1">
                    @if(!empty($item['ukuran_nama']))
                    <div class="flex items-center text-sm text-gray-600">
                        <span class="w-20">Ukuran:</span>
                        <span class="font-medium">{{ $item['ukuran_nama'] }} ({{ $item['ukuran_harga'] ? '+Rp ' . number_format($item['ukuran_harga'], 0, ',', '.') : '' }})</span>
                    </div>
                    @endif

                    @if(!empty($item['kemanisan_nama']))
                    <div class="flex items-center text-sm text-gray-600">
                        <span class="w-20">Kemanisan:</span>
                        <span class="font-medium">{{ $item['kemanisan_nama'] }}</span>
                    </div>
                    @endif

                    @if(!empty($item['topping_data']) && count($item['topping_data']) > 0)
                    <div class="flex items-start text-sm text-gray-600">
                        <span class="w-20">Topping:</span>
                        <span class="font-medium">
                            @foreach($item['topping_data'] as $topping)
                                {{ $topping['nama'] }} (+Rp {{ number_format($topping['harga'], 0, ',', '.') }})@if(!$loop->last), @endif
                            @endforeach
                        </span>
                    </div>
                    @endif
                </div>
                @endif

                <div class="mt-3 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-600">Qty:</span>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('karyawan.transaksi.cart.decrease', $index) }}"
                               class="w-8 h-8 flex items-center justify-center border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                -
                            </a>
                            <span class="w-8 text-center font-medium">{{ $item['qty'] }}</span>
                            <a href="{{ route('karyawan.transaksi.cart.increase', $index) }}"
                               class="w-8 h-8 flex items-center justify-center border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                +
                            </a>
                        </div>
                    </div>

                    <div class="text-right">
                        <p class="text-sm text-gray-600">Harga Satuan</p>
                        <p class="text-lg font-semibold text-gray-900">
                            Rp {{ number_format($item['harga'], 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <div class="mt-3 pt-3 border-t border-gray-100 flex justify-between items-center">
                    <span class="text-sm text-gray-600">Subtotal</span>
                    <span class="font-bold text-gray-900">
                        @php
                            $subtotalItem = $item['harga'] * $item['qty'];
                            if (!empty($item['ukuran_harga'])) {
                                $subtotalItem += $item['ukuran_harga'] * $item['qty'];
                            }
                            if (!empty($item['topping_data'])) {
                                foreach ($item['topping_data'] as $topping) {
                                    $subtotalItem += $topping['harga'] * $item['qty'];
                                }
                            }
                        @endphp
                        Rp {{ number_format($subtotalItem, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            <div class="ml-4">
                <a href="{{ route('karyawan.transaksi.cart.remove', $index) }}"
                   class="text-red-600 hover:text-red-800 text-sm font-medium"
                   onclick="return confirm('Hapus item ini dari keranjang?')">
                    Hapus
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>

                    <!-- Tombol Aksi -->
                    <div class="mt-6 pt-6 border-t border-gray-200 flex justify-between">
                        <form action="{{ route('karyawan.transaksi.cart.clear') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                    class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors"
                                    onclick="return confirm('Kosongkan seluruh keranjang?')">
                                Kosongkan Keranjang
                            </button>
                        </form>

                        <div class="flex items-center space-x-3">
                            <span class="text-gray-600">Total Item: {{ count($cart) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ringkasan & Checkout -->
            <div class="lg:col-span-1">
                <div class="bg-white border border-gray-200 rounded-lg p-6 sticky top-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Ringkasan Belanja</h2>

                    <!-- Hitung Total -->
@php
    $subtotal = 0;
    foreach($cart as $item){
        $itemSubtotal = $item['harga'] * $item['qty'];
        if (!empty($item['ukuran_harga'])) {
            $itemSubtotal += $item['ukuran_harga'] * $item['qty'];
        }
        if (!empty($item['topping_data'])) {
            foreach ($item['topping_data'] as $topping) {
                $itemSubtotal += $topping['harga'] * $item['qty'];
            }
        }
        $subtotal += $itemSubtotal;
    }
    $tax = $subtotal * 0.10; // Pajak 10%
    $total = $subtotal + $tax;
@endphp

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">Pajak (10%)</span>
                            <span class="font-medium">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                        </div>

                        <div class="border-t border-gray-200 pt-3">
                            <div class="flex justify-between text-lg font-bold">
                                <span class="text-gray-900">Total</span>
                                <span class="text-gray-900">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Form Checkout -->
                    <form action="{{ route('karyawan.transaksi.checkout.form') }}" method="GET">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pembeli</label>
                            <input type="text"
                                   name="nama_pembeli"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-matcha-500 focus:border-transparent"
                                   required
                                   placeholder="Masukkan nama pembeli"
                                   value="{{ old('nama_pembeli') }}">
                            @error('nama_pembeli')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                                class="w-full px-4 py-3 bg-matcha-500 text-white rounded-lg hover:bg-matcha-600 transition-colors font-medium">
                            Lanjut ke Pembayaran
                        </button>
                    </form>

                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-600">atau</p>
                        <a href="{{ route('karyawan.transaksi.create') }}"
                           class="inline-block mt-2 text-sm text-matcha-600 hover:text-matcha-700 font-medium">
                            + Tambah Produk Lainnya
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
// Konfirmasi sebelum menghapus item
document.addEventListener('DOMContentLoaded', function() {
    const deleteLinks = document.querySelectorAll('a[href*="remove"]');

    deleteLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (!confirm('Hapus item ini dari keranjang?')) {
                e.preventDefault();
            }
        });
    });
});
</script>
@endpush
