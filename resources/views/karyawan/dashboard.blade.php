@extends('layouts.karyawan')

@section('title', 'Dashboard Karyawan')

@section('content')
<div class="mb-6">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
            <p class="text-gray-600 mt-1">Selamat datang, {{ auth()->user()->nama }}! 👋</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1 bg-matcha-100 text-matcha-800 text-sm font-medium rounded-full">
                {{ ucfirst(auth()->user()->role) }}
            </span>
            <span id="liveTime" class="px-3 py-1 bg-gray-100 text-gray-800 text-sm font-medium rounded-full">
                {{ now()->format('H:i') }}
            </span>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
        <div class="flex items-center justify-between">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-600 truncate">Transaksi Hari Ini</p>
                <p class="text-xl font-bold text-gray-900 mt-1 truncate">
                    {{ \App\Models\Transaksi::hariIni()->count() }}
                </p>
            </div>
            <div class="ml-3 p-2 bg-matcha-50 rounded-lg flex-shrink-0">
                <svg class="h-5 w-5 text-matcha-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-2 truncate">Jumlah transaksi hari ini</p>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
        <div class="flex items-center justify-between">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-600 truncate">Total Pendapatan</p>
                <p class="text-xl font-bold text-gray-900 mt-1 truncate">
                    Rp {{ number_format(\App\Models\Transaksi::hariIni()->sum('total_harga'), 0, ',', '.') }}
                </p>
            </div>
            <div class="ml-3 p-2 bg-amber-50 rounded-lg flex-shrink-0">
                <svg class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-2 truncate">Pendapatan hari ini</p>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
        <div class="flex items-center justify-between">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-600 truncate">Menu Tersedia</p>
                <p class="text-xl font-bold text-gray-900 mt-1 truncate">
                    {{ \App\Models\Produk::where('stok', '>', 0)->count() }}
                </p>
            </div>
            <div class="ml-3 p-2 bg-emerald-50 rounded-lg flex-shrink-0">
                <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-2 truncate">Menu dengan stok tersedia</p>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
        <div class="flex items-center justify-between">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-600 truncate">Pelanggan</p>
                <p class="text-xl font-bold text-gray-900 mt-1 truncate">
                    {{ \App\Models\Transaksi::select('nama_pembeli')->distinct()->count() }}
                </p>
            </div>
            <div class="ml-3 p-2 bg-violet-50 rounded-lg flex-shrink-0">
                <svg class="h-5 w-5 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-2 truncate">Total pelanggan unik</p>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Quick Actions -->
    <div class="lg:col-span-1">
        <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h2>
            <div class="space-y-3">
                <a href="{{ route('karyawan.transaksi.create') }}"
                   class="flex items-center p-3 bg-matcha-500 text-white rounded-lg hover:bg-matcha-600 transition-colors shadow-sm">
                    <svg class="h-5 w-5 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span class="truncate">Buat Transaksi Baru</span>
                </a>

                <a href="{{ route('karyawan.menu.index') }}"
                   class="flex items-center p-3 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200 transition-colors">
                    <svg class="h-5 w-5 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <span class="truncate">Lihat Semua Menu</span>
                </a>

                <a href="{{ route('karyawan.transaksi.cart') }}"
                   class="flex items-center p-3 bg-matcha-100 text-matcha-800 rounded-lg hover:bg-matcha-200 transition-colors">
                    <svg class="h-5 w-5 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="truncate">Lihat Keranjang</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="lg:col-span-2">
        <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm h-full">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Aktivitas Transaksi Terbaru</h2>
                <a href="{{ route('karyawan.transaksi.index') }}" class="text-sm font-medium text-matcha-600 hover:text-matcha-700 whitespace-nowrap">
                    Lihat Semua →
                </a>
            </div>

            <div class="overflow-hidden">
                @php
                    // Gunakan scope atau query yang lebih sederhana
                    $recentTransactions = \App\Models\Transaksi::where('user_id', auth()->id())
                        ->latest()
                        ->limit(5)
                        ->get();
                @endphp

                @if($recentTransactions->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentTransactions as $transaksi)
                        <div class="flex items-center justify-between p-3 border border-gray-100 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex items-center min-w-0">
                                <div class="p-2 bg-matcha-50 rounded-lg mr-3 flex-shrink-0">
                                    <svg class="h-5 w-5 text-matcha-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="font-medium text-gray-900 truncate">{{ $transaksi->nama_pembeli }}</p>
                                    <p class="text-sm text-gray-600 truncate">{{ $transaksi->created_at->format('H:i') }} • Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <div class="text-right ml-3 flex-shrink-0">
                                <!-- PERBAIKAN DI SINI: Ganti metodePembayaran->nama dengan metode_pembayaran -->
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-matcha-100 text-matcha-800 whitespace-nowrap">
                                    {{ ucfirst($transaksi->metode_pembayaran) }}
                                </span>
                                <p class="text-xs text-gray-500 mt-1 whitespace-nowrap">{{ $transaksi->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="h-12 w-12 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-gray-600">Belum ada transaksi</p>
                        <p class="text-sm text-gray-500 mt-1">Mulai dengan membuat transaksi baru</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Popular Menu -->
<div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Menu Populer</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="p-4 border border-gray-200 rounded-lg hover:bg-matcha-50 transition-colors">
            <div class="flex items-center">
                <div class="p-2 bg-amber-100 rounded-lg mr-3 flex-shrink-0">
                    <span class="text-amber-800 font-bold text-sm">🥇</span>
                </div>
                <div class="min-w-0">
                    <p class="font-medium text-gray-900 truncate">Matcha Latte</p>
                    <p class="text-sm text-gray-600 truncate">Terjual 124x</p>
                </div>
            </div>
        </div>

        <div class="p-4 border border-gray-200 rounded-lg hover:bg-matcha-50 transition-colors">
            <div class="flex items-center">
                <div class="p-2 bg-gray-100 rounded-lg mr-3 flex-shrink-0">
                    <span class="text-gray-800 font-bold text-sm">🥈</span>
                </div>
                <div class="min-w-0">
                    <p class="font-medium text-gray-900 truncate">Cheese Cake</p>
                    <p class="text-sm text-gray-600 truncate">Terjual 89x</p>
                </div>
            </div>
        </div>

        <div class="p-4 border border-gray-200 rounded-lg hover:bg-matcha-50 transition-colors">
            <div class="flex items-center">
                <div class="p-2 bg-orange-100 rounded-lg mr-3 flex-shrink-0">
                    <span class="text-orange-800 font-bold text-sm">🥉</span>
                </div>
                <div class="min-w-0">
                    <p class="font-medium text-gray-900 truncate">Red Velvet</p>
                    <p class="text-sm text-gray-600 truncate">Terjual 67x</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Fungsi untuk update waktu real-time
function updateLiveTime() {
    const now = new Date();
    const hours = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');
    const timeString = `${hours}:${minutes}`;

    const timeElement = document.getElementById('liveTime');
    if (timeElement) {
        timeElement.textContent = timeString;
    }
}

// Update waktu setiap detik
setInterval(updateLiveTime, 1000);

// Jalankan sekali saat halaman dimuat
updateLiveTime();
</script>
@endpush

@endsection
