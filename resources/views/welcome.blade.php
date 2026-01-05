<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SIMPKH') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased font-sans">
    <div
        class="relative min-h-screen flex flex-col items-center justify-center selection:bg-forest-500 selection:text-white">

        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1542273917363-3b1817f69a2d?q=80&w=2074&auto=format&fit=crop"
                alt="Forest Background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-br from-forest-900/90 via-forest-800/80 to-black/60"></div>
        </div>

        <!-- Navbar (Overlay) -->
        <nav class="absolute top-0 w-full z-20 p-6 flex justify-between items-center max-w-7xl mx-auto">
            <div class="flex items-center space-x-2">
                <!-- Logo (SVG) -->
                <svg class="h-10 w-10 text-forest-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                </svg>
                <span class="text-white font-bold text-xl tracking-wider">SIMPKH</span>
            </div>
            <div class="space-x-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="text-white hover:text-forest-200 font-semibold transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-white hover:text-forest-200 font-semibold transition">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="px-4 py-2 bg-forest-500 hover:bg-forest-400 text-white rounded-full font-bold transition shadow-lg hover:shadow-forest-500/30">Daftar</a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>

        <!-- Main Content -->
        <main class="relative z-10 max-w-5xl mx-auto px-6 text-center text-white">
            <div class="animate-fade-in-up">
                <span
                    class="inline-block py-1 px-3 rounded-full bg-white/10 border border-white/20 text-forest-200 text-sm font-semibold mb-6 backdrop-blur-sm">
                    Sistem Informasi Manajemen Pengelolaan Kehutanan
                </span>
                <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-6 leading-tight">
                    Lestarikan Hutan,<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-forest-300 to-green-400">Jaga Masa
                        Depan.</span>
                </h1>
                <p class="text-lg md:text-xl text-gray-300 mb-10 max-w-2xl mx-auto">
                    Platform terintegrasi untuk pemetaan, pelaporan, dan pengelolaan data kehutanan Indonesia yang
                    transparan dan akuntabel.
                </p>

                <div class="flex flex-col md:flex-row justify-center items-center gap-4">
                    <a href="{{ route('register') }}"
                        class="w-full md:w-auto px-8 py-4 bg-forest-600 hover:bg-forest-500 text-white rounded-xl font-bold text-lg transition transform hover:-translate-y-1 shadow-xl hover:shadow-forest-600/40 flex items-center justify-center gap-2">
                        <span>Mulai Sekarang</span>
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                    <a href="#features"
                        class="w-full md:w-auto px-8 py-4 bg-white/10 hover:bg-white/20 text-white border border-white/30 rounded-xl font-bold text-lg transition backdrop-blur-sm">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="mt-20 grid grid-cols-2 md:grid-cols-4 gap-6 border-t border-white/10 pt-10">
                <div class="p-4 rounded-lg bg-white/5 backdrop-blur-sm border border-white/5">
                    <p class="text-3xl font-bold text-forest-300">{{ number_format($totalForestArea, 0, ',', '.') }} Ha
                    </p>
                    <p class="text-sm text-gray-400">Hektar Hutan</p>
                </div>
                <div class="p-4 rounded-lg bg-white/5 backdrop-blur-sm border border-white/5">
                    <p class="text-3xl font-bold text-forest-300">34</p>
                    <p class="text-sm text-gray-400">Provinsi Terdata</p>
                </div>
                <div class="p-4 rounded-lg bg-white/5 backdrop-blur-sm border border-white/5">
                    <p class="text-3xl font-bold text-forest-300">24/7</p>
                    <p class="text-sm text-gray-400">Monitoring Realtime</p>
                </div>
                <div class="p-4 rounded-lg bg-white/5 backdrop-blur-sm border border-white/5">
                    <p class="text-3xl font-bold text-forest-300">100%</p>
                    <p class="text-sm text-gray-400">Transparansi</p>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="absolute bottom-6 w-full text-center z-10 text-gray-500 text-sm">
            &copy; {{ date('Y') }} SIMPKH - Kementerian Kehutanan Digital.
        </footer>
    </div>

    <style>
        @keyframes fade-in-up {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.8s ease-out forwards;
        }
    </style>
</body>

</html>