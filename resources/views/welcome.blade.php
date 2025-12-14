<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Much Matcha') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <nav class="bg-white/90 backdrop-blur-md shadow-sm fixed w-full z-50 top-0 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">

                <div class="flex-shrink-0 flex items-center gap-2 cursor-pointer">
                    <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-lg">M</div>
                    <span class="text-2xl font-bold text-green-700 tracking-wide">Much Matcha</span>
                </div>

                <div class="hidden md:flex space-x-8 items-center">
                    <a href="#" class="text-green-700 font-semibold border-b-2 border-green-600">Home</a>
                    <a href="#menu" class="text-gray-500 hover:text-green-600 font-medium transition duration-200">Menu</a>
                    <a href="#" class="text-gray-500 hover:text-green-600 font-medium transition duration-200">About</a>
                </div>

                <div class="flex items-center gap-3">

                    @auth
                        <a href="{{ Auth::user()->role == 'admin' ? route('admin.dashboard') : route('karyawan.dashboard') }}"
                           class="bg-green-100 text-green-700 px-5 py-2 rounded-full text-sm font-semibold hover:bg-green-200 transition shadow-sm border border-green-200">
                            Ke Dashboard
                        </a>

                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="w-9 h-9 flex items-center justify-center rounded-full bg-red-50 text-red-500 hover:bg-red-100 transition border border-red-100" title="Keluar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>

                    @else
                        <a href="{{ route('login') }}" class="bg-green-600 text-white px-6 py-2.5 rounded-full text-sm font-bold hover:bg-green-700 transition shadow-lg shadow-green-200 transform hover:scale-105 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Masuk
                        </a>
                    @endauth

                </div>
            </div>
        </div>
    </nav>

    <div class="relative pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-green-100 text-green-700 text-xs font-bold tracking-wider mb-4 uppercase">Premium Quality Matcha</span>
            <h1 class="text-5xl md:text-7xl font-extrabold text-gray-900 tracking-tight leading-tight mb-6">
                Rasakan Kesegaran <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-500 to-green-800">Matcha Asli Jepang</span>
            </h1>
            <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500 mb-10 font-light">
                Nikmati perpaduan rasa autentik dan modern. Dibuat dengan bahan pilihan untuk menemani setiap momen bahagiamu.
            </p>
            <div class="flex justify-center gap-4">
                <a href="#menu" class="px-8 py-4 bg-green-600 text-white font-bold rounded-full shadow-xl hover:bg-green-700 hover:shadow-2xl transition transform hover:-translate-y-1">Lihat Menu</a>
                <a href="#" class="px-8 py-4 bg-white text-green-700 border border-green-200 font-bold rounded-full shadow-sm hover:bg-gray-50 transition">Tentang Kami</a>
            </div>
        </div>
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10">
            <div class="absolute -top-40 -right-40 w-[600px] h-[600px] bg-green-400/10 rounded-full blur-3xl"></div>
            <div class="absolute top-40 -left-20 w-[400px] h-[400px] bg-yellow-300/20 rounded-full blur-3xl"></div>
        </div>
    </div>

    <section id="menu" class="bg-white py-20 rounded-t-[3rem] shadow-[0_-10px_40px_rgba(0,0,0,0.05)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Menu Favorit</h2>
                <div class="w-24 h-1.5 bg-green-500 mx-auto rounded-full"></div>
                <p class="mt-4 text-gray-500 max-w-lg mx-auto">Pilih minuman atau makanan favoritmu dari koleksi terbaik kami hari ini.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($produk as $item)
                <div class="group bg-white border border-gray-100 rounded-3xl overflow-hidden hover:shadow-2xl transition duration-300 flex flex-col h-full relative">
                    <div class="relative h-64 w-full overflow-hidden bg-gray-100">
                        <img src="{{ asset($item->gambar) }}" alt="{{ $item->nama }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700 ease-in-out" onerror="this.onerror=null; this.src='https://placehold.co/400x300?text=No+Image';">
                        <div class="absolute inset-0 bg-black/10 group-hover:bg-black/0 transition duration-300"></div>
                        @if(isset($item->kategori))
                        <div class="absolute top-4 left-4"><span class="bg-white/95 backdrop-blur text-green-800 text-xs font-bold px-3 py-1.5 rounded-full shadow-sm uppercase tracking-wide">{{ $item->kategori->nama ?? ($item->kategori->nama_kategori ?? 'Matcha Special') }}</span></div>
                        @endif
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-green-600 transition truncate">{{ $item->nama }}</h3>
                        <p class="text-sm text-gray-500 mb-6 line-clamp-2 leading-relaxed">{{ $item->deskripsi }}</p>
                        <div class="mt-auto flex items-center justify-between">
                            <div class="flex flex-col"><span class="text-xs text-gray-400 uppercase font-semibold">Harga</span><span class="text-xl font-bold text-green-600">Rp {{ number_format($item->harga, 0, ',', '.') }}</span></div>
                            <button class="w-10 h-10 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center hover:bg-green-600 hover:text-white transition shadow-sm hover:shadow-green-300"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg></button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full flex flex-col items-center justify-center py-20 text-center">
                    <div class="bg-gray-100 p-6 rounded-full mb-4"><svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg></div>
                    <h3 class="text-lg font-medium text-gray-900">Belum ada menu tersedia</h3>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold text-green-500 mb-4">Much Matcha</h2>
            <p class="text-gray-400 mb-8 max-w-md mx-auto">Menyajikan kebahagiaan dalam setiap tegukan dan gigitan. Fresh, Delicious, & Authentic.</p>
            <div class="border-t border-gray-800 pt-8 text-sm text-gray-500">&copy; {{ date('Y') }} Much Matcha. All rights reserved.</div>
        </div>
    </footer>
</body>
</html>
