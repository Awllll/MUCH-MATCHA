<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Much Matcha') - Panel Karyawan</title>

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Matcha Color Palette */
        .bg-matcha-50 { background-color: #f0f7e9; }
        .bg-matcha-100 { background-color: #e1efd3; }
        .bg-matcha-200 { background-color: #c2dfa7; }
        .bg-matcha-300 { background-color: #a3cf7b; }
        .bg-matcha-400 { background-color: #84bf4f; }
        .bg-matcha-500 { background-color: #7db249; }
        .bg-matcha-600 { background-color: #639534; }
        .bg-matcha-700 { background-color: #4a771a; }
        .bg-matcha-800 { background-color: #365c10; }
        .bg-matcha-900 { background-color: #234106; }

        .text-matcha-50 { color: #f0f7e9; }
        .text-matcha-100 { color: #e1efd3; }
        .text-matcha-200 { color: #c2dfa7; }
        .text-matcha-300 { color: #a3cf7b; }
        .text-matcha-400 { color: #84bf4f; }
        .text-matcha-500 { color: #7db249; }
        .text-matcha-600 { color: #639534; }
        .text-matcha-700 { color: #4a771a; }
        .text-matcha-800 { color: #365c10; }
        .text-matcha-900 { color: #234106; }

        .border-matcha-200 { border-color: #c2dfa7; }
        .border-matcha-300 { border-color: #a3cf7b; }
        .border-matcha-400 { border-color: #84bf4f; }
        .border-matcha-500 { border-color: #7db249; }
        .border-matcha-600 { border-color: #639534; }
        .border-matcha-700 { border-color: #4a771a; }
        .border-matcha-800 { border-color: #365c10; }

        .hover\:bg-matcha-200:hover { background-color: #c2dfa7; }
        .hover\:bg-matcha-300:hover { background-color: #a3cf7b; }
        .hover\:bg-matcha-400:hover { background-color: #84bf4f; }
        .hover\:bg-matcha-500:hover { background-color: #7db249; }
        .hover\:bg-matcha-600:hover { background-color: #639534; }
        .hover\:bg-matcha-700:hover { background-color: #4a771a; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            overflow-x: hidden; /* Mencegah scroll horizontal */
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #c2dfa7;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a3cf7b;
        }
    </style>
</head>
<body class="bg-gray-50 overflow-x-hidden">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-matcha-800 text-white flex-shrink-0 h-screen sticky top-0">
            <!-- Logo -->
            <div class="p-6 border-b border-matcha-700">
                <h1 class="text-2xl font-bold tracking-tight">Much Matcha</h1>
                <p class="text-matcha-200 text-sm mt-1 font-medium">Panel Karyawan</p>
            </div>

            <!-- User Info -->
            <div class="p-6 border-b border-matcha-700">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-matcha-600 flex items-center justify-center ring-2 ring-matcha-500 ring-offset-2 ring-offset-matcha-800">
                        <span class="font-bold">{{ substr(auth()->user()->nama, 0, 1) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold truncate">{{ auth()->user()->nama }}</p>
                        <p class="text-matcha-200 text-sm truncate">Karyawan</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                <a href="{{ route('karyawan.dashboard') }}"
                   class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('karyawan.dashboard') ? 'bg-matcha-700' : 'hover:bg-matcha-700' }} transition-all duration-200">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="{{ route('karyawan.transaksi.create') }}"
                   class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('karyawan.transaksi.create') ? 'bg-matcha-700' : 'hover:bg-matcha-700' }} transition-all duration-200">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    <span class="font-medium">Buat Transaksi</span>
                </a>

                <a href="{{ route('karyawan.transaksi.index') }}"
                   class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('karyawan.transaksi.index') ? 'bg-matcha-700' : 'hover:bg-matcha-700' }} transition-all duration-200">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="font-medium">Lihat Transaksi</span>
                </a>

                <a href="{{ route('karyawan.menu.index') }}"
                   class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('karyawan.menu.*') ? 'bg-matcha-700' : 'hover:bg-matcha-700' }} transition-all duration-200">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    <span class="font-medium">Menu</span>
                </a>
            </nav>

            <!-- Logout -->
            <div class="p-4 border-t border-matcha-700">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center space-x-3 p-3 rounded-lg w-full text-left hover:bg-matcha-700 text-red-300 transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span class="font-medium">Keluar</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 min-w-0">
            <main class="p-6 max-w-full overflow-x-hidden">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Scripts -->
    @stack('scripts')
</body>
</html>
