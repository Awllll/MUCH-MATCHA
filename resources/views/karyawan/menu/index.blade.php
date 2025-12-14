@extends('layouts.karyawan')

@section('title', 'Semua Menu')

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Semua Menu</h1>
            <p class="text-gray-600">Pilih menu untuk ditambahkan ke transaksi</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('karyawan.menu.makanan') }}"
               class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors text-sm">
                Lihat Makanan
            </a>
            <a href="{{ route('karyawan.menu.minuman') }}"
               class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors text-sm">
                Lihat Minuman
            </a>
        </div>
    </div>
</div>

<!-- Filter dan Pencarian (opsional) -->
<div class="stats-card p-4 mb-6">
    <div class="flex items-center space-x-4">
        <div class="flex-1">
            <input type="text"
                   placeholder="Cari menu..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
        </div>
        <select class="px-4 py-2 border border-gray-300 rounded-lg">
            <option>Semua Kategori</option>
            <option>Makanan</option>
            <option>Minuman</option>
        </select>
        <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
            Filter
        </button>
    </div>
</div>

<!-- Daftar Menu -->
@if(isset($menus) && $menus->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($menus as $item)
        <div class="stats-card p-5 hover:shadow-lg transition-shadow">
            <div class="flex items-start">
                <!-- Gambar Produk -->
                <div class="w-24 h-24 bg-gray-100 rounded-lg flex items-center justify-center mr-4 overflow-hidden">
                    @if(!empty($item->gambar) && file_exists(public_path('uploads/produk/' . $item->gambar)))
                        <img src="{{ asset('uploads/produk/' . $item->gambar) }}"
                             alt="{{ $item->nama }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="text-center">
                            @if(isset($item->kategori) && stripos($item->kategori->nama ?? '', 'minuman') !== false)
                                <span class="text-3xl text-gray-400">🍵</span>
                            @else
                                <span class="text-3xl text-gray-400">🍽️</span>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Info Produk -->
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-semibold text-gray-800 text-lg">{{ $item->nama }}</h3>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $item->kategori->nama ?? $item->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                            </p>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium {{ $item->stok > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }} rounded">
                            {{ $item->stok > 0 ? 'Stok: ' . $item->stok : 'Stok Habis' }}
                        </span>
                    </div>

                    <p class="text-gray-600 text-sm mt-3 line-clamp-2">
                        {{ $item->deskripsi ?? 'Tidak ada deskripsi' }}
                    </p>

                    <div class="flex items-center justify-between mt-4">
                        <div>
                            <p class="text-lg font-bold text-emerald-600">
                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </p>
                        </div>

                        <form action="{{ route('karyawan.cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $item->id }}">
                            <input type="hidden" name="nama" value="{{ $item->nama }}">
                            <input type="hidden" name="harga" value="{{ $item->harga }}">
                            <button type="submit"
                                    class="px-4 py-2 bg-emerald-500 text-white text-sm font-medium rounded-lg hover:bg-emerald-600 transition-colors {{ $item->stok <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    {{ $item->stok <= 0 ? 'disabled' : '' }}>
                                <span class="flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Tambah
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination (opsional) -->
    <div class="mt-8 flex justify-center">
        <nav class="inline-flex space-x-2">
            <a href="#" class="px-3 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">← Prev</a>
            <a href="#" class="px-3 py-2 bg-emerald-500 text-white rounded-lg">1</a>
            <a href="#" class="px-3 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">2</a>
            <a href="#" class="px-3 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">3</a>
            <a href="#" class="px-3 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Next →</a>
        </nav>
    </div>
@else
    <!-- Jika tidak ada menu -->
    <div class="stats-card p-12 text-center">
        <svg class="h-16 w-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
        </svg>
        <h3 class="text-lg font-medium text-gray-800 mb-2">Belum ada menu tersedia</h3>
        <p class="text-gray-500 mb-4">Silakan hubungi admin untuk menambahkan menu baru</p>
        <a href="{{ route('karyawan.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600">
            Kembali ke Dashboard
        </a>
    </div>
@endif

<!-- Info Tambahan -->
<div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="stats-card p-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-50 rounded-lg mr-4">
                <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Menu</p>
                <p class="text-2xl font-bold text-gray-800">{{ \App\Models\Produk::count() }}</p>
            </div>
        </div>
    </div>

    <div class="stats-card p-6">
        <div class="flex items-center">
            <div class="p-3 bg-emerald-50 rounded-lg mr-4">
                <svg class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Menu Tersedia</p>
                <p class="text-2xl font-bold text-gray-800">{{ \App\Models\Produk::where('stok', '>', 0)->count() }}</p>
            </div>
        </div>
    </div>

    <div class="stats-card p-6">
        <div class="flex items-center">
            <div class="p-3 bg-amber-50 rounded-lg mr-4">
                <svg class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Terakhir Update</p>
                <p class="text-lg font-bold text-gray-800">{{ now()->format('d M Y') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .line-clamp-2 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
</style>
@endpush
