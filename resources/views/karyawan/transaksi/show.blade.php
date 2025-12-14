@extends('layouts.karyawan')

@section('title', 'Detail Transaksi')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Detail Transaksi</h1>
                    <p class="text-gray-600 mt-1">Kode: {{ $transaksi->kode_transaksi }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('karyawan.transaksi.index') }}"
                       class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Kembali ke Daftar
                    </a>
                    <a href="{{ route('karyawan.transaksi.struk', $transaksi->id) }}"
                       class="px-4 py-2 bg-matcha-500 text-white rounded-lg hover:bg-matcha-600 transition-colors">
                        Cetak Struk
                    </a>
                </div>
            </div>
        </div>

        <!-- Informasi Transaksi -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Info Utama -->
            <div class="lg:col-span-2">
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Informasi Transaksi</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Kode Transaksi</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $transaksi->kode_transaksi }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-600">Tanggal</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $transaksi->created_at->format('d/m/Y H:i') }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-600">Nama Pembeli</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $transaksi->nama_pembeli ?? 'Tidak dicatat' }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-600">Kasir</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $transaksi->user->nama ?? 'Tidak diketahui' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ringkasan Pembayaran -->
            <div class="lg:col-span-1">
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Ringkasan Pembayaran</h2>

                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Metode Pembayaran</span>
                            <span class="font-medium">{{ ucfirst($transaksi->metode_pembayaran) }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">Status</span>
                            <span class="px-2 py-1 text-xs font-medium rounded-full
                                {{ $transaksi->status == 'selesai' ? 'bg-matcha-100 text-matcha-800' :
                                   ($transaksi->status == 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                   'bg-red-100 text-red-800') }}">
                                {{ ucfirst($transaksi->status) }}
                            </span>
                        </div>

                        <div class="border-t border-gray-200 pt-3 mt-3">
                            <div class="flex justify-between text-lg font-bold">
                                <span class="text-gray-900">Total</span>
                                <span class="text-gray-900">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Produk -->
        <div class="bg-white border border-gray-200 rounded-lg p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Daftar Produk</h2>

            @if($transaksi->detailTransaksi && $transaksi->detailTransaksi->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($transaksi->detailTransaksi as $detail)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">{{ $detail->produk->nama ?? 'Produk tidak ditemukan' }}</div>
                                    @if($detail->ukuran)
                                        <div class="text-sm text-gray-600">Ukuran: {{ $detail->ukuran->nama }}</div>
                                    @endif
                                    @if($detail->kemanisan)
                                        <div class="text-sm text-gray-600">Kemanisan: {{ $detail->kemanisan->nama }}</div>
                                    @endif
                                    @if($detail->topping && $detail->topping->count() > 0)
                                        <div class="text-sm text-gray-600">
                                            Topping: {{ $detail->topping->pluck('nama')->implode(', ') }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3">{{ $detail->jumlah }}</td>
                                <td class="px-4 py-3">Rp {{ number_format($detail->harga_saat_transaksi, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 font-medium">
                                    Rp {{ number_format($detail->jumlah * $detail->harga_saat_transaksi, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <p>Tidak ada detail transaksi</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
