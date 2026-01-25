<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'MyLinkApp') }} - Satu Link untuk Semua</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="antialiased font-sans text-gray-900 bg-white">

    <nav class="sticky top-6 z-50 w-full px-4 sm:px-6 lg:px-8 mt-6">
    
        <div class="bg-white rounded-full shadow-xl max-w-7xl mx-auto px-6 py-3 md:py-4 flex justify-between items-center ring-1 ring-gray-900/5 transition-all duration-300">
            
            <div class="flex items-center gap-2">
                <i class="fas fa-star-of-life text-2xl text-black animate-pulse-slow"></i>
                
                <span class="text-2xl font-bold tracking-tight text-black">
                    HiLink
                </span>
            </div>

            

            <div class="flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-black transition px-4">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="hidden sm:block px-5 py-2.5 rounded-md text-black font-semibold bg-gray-100 hover:bg-gray-200 transition text-[15px]">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-6 py-2.5 rounded-full text-white font-semibold bg-gray-900 hover:bg-black hover:scale-105 transition transform shadow-lg text-[15px]">
                                Sign up free
                            </a>
                        @endif
                    @endauth
                @endif
            </div>

        </div>
    </nav>

    <header class="relative overflow-hidden pt-12 pb-24 lg:pt-20">
        <div class="max-w-7xl mx-auto px-6 md:px-12 flex flex-col-reverse lg:flex-row items-center gap-12">
            
            <div class="lg:w-1/2 text-center lg:text-left space-y-6">
                <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight text-gray-900 leading-tight">
                    Satu Link untuk <br>
                    <span class="text-indigo-600">Segala Identitasmu.</span>
                </h1>
                <p class="text-lg text-gray-600 max-w-lg mx-auto lg:mx-0">
                    Gabungkan TikTok, Instagram, Twitter, dan portofoliomu dalam satu halaman cantik. Bagikan ke audiensmu dengan mudah.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start pt-4">
                    <form action="{{ route('register') }}" method="GET" class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start pt-4 w-full">
    
                        <div class="relative rounded-full shadow-sm flex-1 max-w-md group">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-5">
                                <span class="text-gray-500 font-medium sm:text-lg">hilink.id/</span>
                            </div>
                            
                            <input 
                                type="text" 
                                name="username" 
                                required
                                class="block w-full rounded-full border-0 py-4 pl-28 pr-6 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-lg sm:leading-6 bg-white transition-shadow" 
                                placeholder="nama-kamu"
                                autocomplete="off"
                            >
                        </div>

                        <button type="submit" class="bg-gray-900 hover:bg-black text-white px-8 py-4 rounded-full font-bold shadow-lg transform transition hover:-translate-y-1 flex items-center justify-center gap-2 whitespace-nowrap">
                            Buat Link Kamu <i class="fas fa-arrow-right text-sm"></i>
                        </button>

                    </form>
                </div>
            </div>

            <div class="lg:w-1/2 flex justify-center relative">
                <div class="absolute top-0 right-10 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
                <div class="absolute bottom-0 left-10 w-72 h-72 bg-indigo-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>

                <div class="relative mx-auto border-gray-800 dark:border-gray-800 bg-gray-800 border-[14px] rounded-[2.5rem] h-[500px] w-[280px] shadow-2xl z-10">
                    <div class="h-[32px] w-[3px] bg-gray-800 absolute -left-[17px] top-[72px] rounded-l-lg"></div>
                    <div class="h-[46px] w-[3px] bg-gray-800 absolute -left-[17px] top-[124px] rounded-l-lg"></div>
                    <div class="h-[46px] w-[3px] bg-gray-800 absolute -left-[17px] top-[178px] rounded-l-lg"></div>
                    <div class="h-[64px] w-[3px] bg-gray-800 absolute -right-[17px] top-[142px] rounded-r-lg"></div>
                    <div class="rounded-[2rem] overflow-hidden w-full h-full bg-white dark:bg-gray-800 relative">
                        <div class="bg-indigo-500 h-full w-full flex flex-col items-center pt-10 px-4 space-y-3">
                            <div class="w-20 h-20 bg-white rounded-full border-4 border-indigo-300 mb-2"></div>
                            <div class="w-32 h-4 bg-white/50 rounded-full"></div>
                            <div class="w-full h-10 bg-white rounded-lg mt-6 shadow-sm flex items-center px-4 text-xs text-gray-400">Instagram</div>
                            <div class="w-full h-10 bg-white rounded-lg shadow-sm flex items-center px-4 text-xs text-gray-400">Website Toko</div>
                            <div class="w-full h-10 bg-white rounded-lg shadow-sm flex items-center px-4 text-xs text-gray-400">Kontak WA</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-12">Kenapa Memilih Kami?</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center mx-auto mb-4 text-xl">
                        <i class="fas fa-paint-brush"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Desain Kustom</h3>
                    <p class="text-gray-600">Ubah warna, font, dan latar belakang sesuai dengan branding personal kamu.</p>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center mx-auto mb-4 text-xl">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Analitik Lengkap</h3>
                    <p class="text-gray-600">Lihat berapa banyak orang yang mengklik link kamu setiap harinya.</p>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center mx-auto mb-4 text-xl">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Aman & Cepat</h3>
                    <p class="text-gray-600">Dibangun dengan teknologi terbaru untuk memastikan link kamu selalu bisa diakses.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center">
            <div class="mb-4 md:mb-0">
                <span class="text-white font-bold text-lg">HiLink</span>
                <p class="text-sm mt-1">&copy; 2026 Developed by Hibrizi.</p>
            </div>
            <div class="flex gap-6 text-sm">
                <a href="#" class="hover:text-white transition">Tentang</a>
                <a href="#" class="hover:text-white transition">Login</a>
            </div>
        </div>
    </footer>

    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
    </style>
</body>
</html>