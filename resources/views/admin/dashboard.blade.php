@extends('layouts.admin')

@section('header-title', 'Dashboard Admin')
@section('header-subtitle', 'Ringkasan penjualan dan akses cepat ke menu utama')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Penjualan Hari Ini</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">Rp 289.300</h3>
                </div>
                <div class="p-2 bg-emerald-50 rounded-lg text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Jumlah Transaksi</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">5</h3>
                </div>
                <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Pelanggan</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">5</h3>
                </div>
                <div class="p-2 bg-purple-50 rounded-lg text-purple-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Rata-rata Transaksi</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">Rp 57.860</h3>
                </div>
                <div class="p-2 bg-orange-50 rounded-lg text-orange-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="font-semibold text-lg text-emerald-900">Riwayat Transaksi Terbaru</h3>
            <p class="text-sm text-gray-500">10 transaksi terakhir</p>
        </div>

        <div class="divide-y divide-gray-50">
            <div class="p-4 hover:bg-gray-50 transition-colors flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div>
                        <p class="font-medium text-gray-800">TRX001 <span class="ml-2 text-xs bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full font-medium">selesai</span></p>
                        <p class="text-sm text-gray-400 flex items-center gap-1 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            10:30 &bull; Walk-in Customer
                        </p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-bold text-gray-800">Rp 74.800</p>
                    <a href="{{ route('dashboard.transaction.detail', ['id' => '001']) }}" class="text-xs font-medium text-emerald-600 hover:text-emerald-700 flex items-center justify-end gap-1 mt-1 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Detail
                    </a>
                </div>
            </div>

            <div class="p-4 hover:bg-gray-50 transition-colors flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div>
                        <p class="font-medium text-gray-800">TRX002 <span class="ml-2 text-xs bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full font-medium">selesai</span></p>
                        <p class="text-sm text-gray-400 flex items-center gap-1 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            11:15 &bull; John Doe
                        </p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-bold text-gray-800">Rp 38.500</p>
                    <a href="{{ route('dashboard.transaction.detail', ['id' => '002']) }}" class="text-xs font-medium text-emerald-600 hover:text-emerald-700 flex items-center justify-end gap-1 mt-1 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Detail
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
