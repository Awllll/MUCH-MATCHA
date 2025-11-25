@extends('layouts.admin')

@section('header-title')
    <div class="flex items-center gap-4">
        <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-emerald-600 transition-colors flex items-center gap-1 text-sm font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
        <span class="text-gray-300">|</span>
        Detail Transaksi
    </div>
@endsection

@section('header-subtitle', 'Rincian pembelian untuk setiap transaksi')

@section('content')
    <div class="max-w-4xl space-y-6">

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h3 class="text-lg font-bold text-emerald-950">TRX{{ $id ?? '001' }}</h3>
                    <p class="text-sm text-gray-500">Informasi transaksi</p>
                </div>
                <span class="bg-emerald-50 text-emerald-600 text-xs font-bold px-3 py-1 rounded-full border border-emerald-100">
                    selesai
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-emerald-50 rounded-lg text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Tanggal</p>
                        <p class="text-gray-800 font-medium">2025-11-22</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="p-2 bg-emerald-50 rounded-lg text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Waktu</p>
                        <p class="text-gray-800 font-medium">10:30</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="p-2 bg-emerald-50 rounded-lg text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Pelanggan</p>
                        <p class="text-gray-800 font-medium">Walk-in Customer</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="p-2 bg-emerald-50 rounded-lg text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Metode Pembayaran</p>
                        <p class="text-gray-800 font-medium">Tunai</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="mb-6 border-b border-gray-100 pb-4">
                <h3 class="text-lg font-bold text-gray-800">Item Pesanan</h3>
                <p class="text-sm text-gray-500">Daftar produk yang dibeli</p>
            </div>

            <div class="space-y-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-bold text-gray-800 text-lg">Cappuccino</p>
                        <p class="text-sm text-gray-500">+ Extra Shot Espresso</p>
                        <p class="text-sm text-gray-400 mt-1">2 x Rp 25.000</p>
                    </div>
                    <p class="font-bold text-emerald-600">Rp 50.000</p>
                </div>

                <hr class="border-dashed border-gray-200">

                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-bold text-gray-800 text-lg">Sandwich</p>
                        <p class="text-sm text-gray-400 mt-1">1 x Rp 18.000</p>
                    </div>
                    <p class="font-bold text-emerald-600">Rp 18.000</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-6 border-b border-gray-100 pb-4">Ringkasan Pembayaran</h3>

            <div class="space-y-3">
                <div class="flex justify-between text-gray-600">
                    <span>Subtotal</span>
                    <span class="font-medium">Rp 68.000</span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>Pajak (10%)</span>
                    <span class="font-medium">Rp 6.800</span>
                </div>

                <div class="border-t border-gray-200 my-4"></div>

                <div class="flex justify-between items-center">
                    <span class="font-bold text-gray-800 text-lg">Total</span>
                    <span class="font-bold text-emerald-600 text-xl">Rp 74.800</span>
                </div>
            </div>
        </div>

    </div>
@endsection
