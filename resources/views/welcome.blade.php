<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>{{ config('app.name', 'HiLink') }} - Semua Link, Satu Tempat</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700,800&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        /* Animasi Floating Halus */
        @keyframes floatSlow {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        @keyframes floatMedium {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(2deg); }
        }
        .animate-float-slow { animation: floatSlow 6s ease-in-out infinite; }
        .animate-float-medium { animation: floatMedium 5s ease-in-out infinite; }
        
        /* Utility Delay Animate.css */
        .delay-1 { animation-delay: 0.2s; }
        .delay-2 { animation-delay: 0.4s; }
        .delay-3 { animation-delay: 0.6s; }
        
        /* Fix untuk tampilan mobile Safari toolbar */
        @supports (-webkit-touch-callout: none) {
            .min-h-screen { height: -webkit-fill-available; }
        }
    </style>
</head>
<body class="antialiased font-sans bg-[#F3F4F6] overflow-x-hidden relative selection:bg-indigo-500 selection:text-white">

    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute top-[-10%] right-[-10%] w-[300px] md:w-[500px] h-[300px] md:h-[500px] rounded-full bg-purple-300/40 blur-3xl animate-float-slow"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[300px] md:w-[600px] h-[300px] md:h-[600px] rounded-full bg-indigo-300/40 blur-3xl animate-float-medium" style="animation-delay: -2s;"></div>
    </div>

    <nav class="fixed top-0 left-0 right-0 z-50 pt-2 sm:pt-4 px-2 sm:px-6 animate__animated animate__fadeInDown">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white/80 backdrop-blur-md rounded-full shadow-sm border border-white/40 py-2.5 px-4 sm:px-6 flex justify-between items-center transition-all hover:bg-white/90">
                <a href="/" class="flex items-center gap-2 group">
                   <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-gradient-to-tr from-indigo-600 to-purple-600 text-white shadow-sm group-hover:scale-110 transition-transform">
                        <i class="fas fa-share-nodes text-sm"></i>
                    </div>
                    <span class="text-lg sm:text-xl font-black tracking-tighter text-gray-900">
                        HiLink<span class="text-indigo-600">.</span>
                    </span>
                </a>

                <div class="flex items-center gap-2 text-sm font-semibold">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-3 py-2 text-gray-700 hover:text-indigo-600 transition text-xs sm:text-sm">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="hidden sm:block px-4 py-2 text-gray-700 hover:text-gray-900 transition">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-gray-900 hover:bg-black text-white px-4 sm:px-5 py-2 rounded-full shadow-md hover:shadow-lg transition-all hover:-translate-y-0.5 text-xs sm:text-sm">
                                    Daftar
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <section class="min-h-screen flex items-center pt-24 pb-12 relative px-4 sm:px-6">
        <div class="max-w-6xl mx-auto grid lg:grid-cols-2 gap-12 items-center w-full">
            
            <div class="space-y-6 sm:space-y-8 text-center lg:text-left">
                
                <h1 class="text-5xl sm:text-6xl md:text-7xl lg:text-8xl font-extrabold tracking-tight leading-[1.1] animate__animated animate__fadeInUp">
                    Semua Link.<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-500">
                        Satu Tempat.
                    </span>
                </h1>
                
                <p class="text-base sm:text-lg text-gray-600 max-w-lg mx-auto lg:mx-0 animate__animated animate__fadeInUp delay-1 leading-relaxed px-2 sm:px-0">
                    Gabungkan semua sosial media dan portofolio kamu hanya dalam satu halaman bio yang simpel, modern, dan gratis.
                </p>

                <div class="animate__animated animate__fadeInUp delay-2 w-full max-w-md mx-auto lg:mx-0">
                    <form action="{{ route('register') }}" method="GET" class="flex flex-col sm:flex-row gap-3 relative p-2 bg-white rounded-[2rem] sm:rounded-full shadow-lg border border-gray-100 ring-4 ring-gray-100/50">
                        
                        <div class="flex-1 relative flex items-center pl-5 h-12 sm:h-auto border-b sm:border-b-0 border-gray-100 sm:border-none">
                            <span class="text-gray-400 font-semibold mr-1 select-none text-sm sm:text-base">hilink.id/</span>
                            <input 
                                type="text" 
                                name="username" 
                                required 
                                placeholder="username" 
                                class="flex-1 py-3 bg-transparent border-0 focus:ring-0 text-gray-900 font-bold placeholder:text-gray-300 outline-none w-full text-base sm:text-lg" 
                                autocomplete="off"
                            >
                        </div>

                        <button type="submit" class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3.5 sm:py-3 rounded-full font-bold transition-all active:scale-95 hover:scale-105 flex items-center justify-center gap-2 shrink-0 shadow-md text-base">
                            Buat <span class="inline">Sekarang</span> <i class="fas fa-arrow-right"></i>
                        </button>
                    </form>
                    
                    <p class="text-xs text-gray-500 mt-3 sm:ml-4 flex items-center justify-center lg:justify-start gap-1">
                        <i class="fas fa-check-circle text-green-500"></i> Gratis selamanya. Tanpa ribet.
                    </p>
                </div>
            </div>

            <div class="relative hidden lg:flex justify-center items-center animate__animated animate__fadeInRight delay-1">
                 
                 <div class="relative z-10 animate-float-slow">
                    <div class="w-[300px] h-[600px] bg-gray-900 rounded-[3rem] border-[12px] border-gray-900 shadow-2xl overflow-hidden ring-1 ring-white/20 relative">
                         <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-1/3 h-6 bg-gray-900 rounded-b-xl z-20"></div>
                         
                         <div class="w-full h-full bg-gradient-to-b from-indigo-500 via-purple-500 to-indigo-600 flex flex-col items-center pt-16 px-6 gap-4">
                            <div class="w-24 h-24 bg-white/20 backdrop-blur-sm rounded-full mb-2 animate__animated animate__zoomIn delay-2 border-2 border-white/30"></div>
                            <div class="w-40 h-5 bg-white/20 rounded-full animate__animated animate__fadeIn delay-3"></div>
                            
                            <div class="w-full h-14 bg-white rounded-xl shadow-lg flex items-center px-4 text-sm font-bold text-indigo-900 animate__animated animate__fadeInUp delay-3 cursor-pointer hover:scale-105 transition mt-4 transform hover:-translate-y-1">
                                <i class="fab fa-instagram text-2xl mr-4 text-pink-600"></i> 
                                <span>Instagram</span>
                            </div>
                            <div class="w-full h-14 bg-white rounded-xl shadow-lg flex items-center px-4 text-sm font-bold text-indigo-900 animate__animated animate__fadeInUp delay-4 cursor-pointer hover:scale-105 transition transform hover:-translate-y-1">
                                <i class="fab fa-tiktok text-2xl mr-4 text-black"></i> 
                                <span>TikTok</span>
                            </div>
                             <div class="w-full h-14 bg-white/90 rounded-xl shadow-lg flex items-center px-4 text-sm font-bold text-indigo-900 animate__animated animate__fadeInUp delay-5 opacity-90">
                                <i class="fas fa-globe text-2xl mr-4 text-blue-600"></i> 
                                <span>Website</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="absolute top-24 -left-16 p-4 bg-white/70 backdrop-blur-xl rounded-2xl shadow-xl border border-white/50 animate-float-medium text-sm font-bold text-gray-800 flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600"><i class="fas fa-chart-line"></i></div>
                    <div>
                        <div class="text-xs text-gray-500">Total Views</div>
                        <div class="text-lg">12.5K</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="text-center py-6 text-gray-400 text-xs sm:text-sm animate__animated animate__fadeIn delay-5 relative z-10 pb-8 sm:pb-6">
        <p>&copy; {{ date('Y') }} HiLink.</p>
    </footer>

    <script>
        if (history.scrollRestoration) { history.scrollRestoration = 'manual'; }
        window.onbeforeunload = function () { window.scrollTo(0, 0); }
        window.onload = function() { window.scrollTo(0, 0); }
    </script>

</body>
</html>