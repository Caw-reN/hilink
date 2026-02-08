<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - {{ config('app.name') }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-white">

    <div class="flex min-h-screen">
        
        <div class="hidden lg:flex lg:w-1/2 relative bg-gray-900">
            <img src="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=1000&q=80" 
                 alt="Background" 
                 class="absolute inset-0 w-full h-full object-cover opacity-60">
            
            <div class="relative z-10 flex flex-col justify-center px-12 text-white">
                <h2 class="text-4xl font-bold mb-4">Welcome Back!</h2>
                <p class="text-lg text-gray-200">Kelola link bio kamu dengan mudah dan profesional bersama HiLink.</p>
            </div>
        </div>

        <div class="flex flex-col justify-center w-full lg:w-1/2 px-8 lg:px-24 bg-white">
            
            <div class="mb-8 text-center lg:text-left">
                <h1 class="text-3xl font-bold text-indigo-600 mb-2">HiLink.</h1>
                <p class="text-gray-500">Silakan login ke akun anda.</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                    <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                           class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-0 text-sm transition duration-200">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                           class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-0 text-sm transition duration-200">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="block mb-6">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">Ingat Saya</span>
                    </label>
                </div>

                <div class="flex items-center justify-between mb-6">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-indigo-600 hover:text-indigo-800 font-semibold" href="{{ route('password.request') }}">
                            Lupa Password?
                        </a>
                    @endif
                </div>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300 shadow-lg transform hover:-translate-y-0.5">
                    Masuk Sekarang
                </button>

                <p class="mt-8 text-center text-sm text-gray-600">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-indigo-600 font-bold hover:underline">Daftar Gratis</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>