@extends('layouts.karyawan')  {{-- PERHATIKAN: layouts (jamak) bukan layout --}}

@section('title', 'Menu Makanan')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">{{ $title ?? 'Menu Makanan' }}</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($menus->count() > 0)
        <div class="row">
            @foreach ($menus as $item)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-img-top d-flex justify-content-center align-items-center"
                             style="height: 180px; overflow: hidden; background: #f8f9fa;">
                            @if($item->gambar && file_exists(public_path('uploads/produk/' . $item->gambar)))
                                <img src="{{ asset('uploads/produk/' . $item->gambar) }}"
                                     alt="{{ $item->nama }}"
                                     style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div class="text-center text-muted">
                                    <i class="fas fa-utensils fa-3x"></i>
                                    <p class="mt-2">No Image</p>
                                </div>
                            @endif
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">{{ $item->nama }}</h5>
                            <p class="card-text text-muted small mb-2">
                                {{ Str::limit($item->deskripsi ?? 'Tidak ada deskripsi', 60) }}
                            </p>
                            <p class="card-text">
                                <strong>Rp {{ number_format($item->harga, 0, ',', '.') }}</strong>
                            </p>

                            @if($item->stok > 0)
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-success">Stok: {{ $item->stok }}</span>
                                    <form action="{{ route('karyawan.cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="produk_id" value="{{ $item->id }}">
                                        <input type="hidden" name="nama" value="{{ $item->nama }}">
                                        <input type="hidden" name="harga" value="{{ $item->harga }}">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-cart-plus"></i> Tambah
                                        </button>
                                    </form>
                                </div>
                            @else
                                <button class="btn btn-secondary btn-sm w-100" disabled>
                                    <i class="fas fa-times-circle"></i> Stok Habis
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info text-center py-5">
            <i class="fas fa-info-circle fa-3x mb-3"></i>
            <h4>Belum ada menu makanan</h4>
            <p>Silakan hubungi admin untuk menambahkan menu makanan</p>
        </div>
    @endif
</div>
@endsection
