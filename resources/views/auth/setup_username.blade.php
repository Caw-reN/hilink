<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Setup Username - HiLink</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50">

    <div class="min-h-screen flex flex-col justify-center items-center p-6 relative overflow-hidden">
        
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute top-0 right-1/4 w-96 h-96 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-32 left-1/3 w-96 h-96 bg-pink-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
        </div>

        <div class="w-full max-w-lg bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 relative z-10">
            
            <div class="bg-white px-8 py-6 border-b border-gray-100 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-md">2</div>
                    <span class="text-sm font-bold text-gray-500 uppercase tracking-wider">Langkah Terakhir</span>
                </div>
                <div class="flex gap-1">
                    <div class="h-2 w-8 bg-indigo-200 rounded-full"></div>
                    <div class="h-2 w-16 bg-indigo-600 rounded-full"></div>
                </div>
            </div>

            <div class="p-8 sm:p-10">
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-black text-gray-900 mb-3 tracking-tight">Klaim Link Kamu!</h2>
                    <p class="text-gray-500">Pilih username unik agar mudah diingat oleh teman dan klien.</p>
                </div>

                <form action="{{ route('setup.username.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2 ml-1">Username Link</label>
                        
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-5 pointer-events-none">
                                <span class="text-gray-400 font-bold font-mono text-lg tracking-tight">hilink.web.id/</span>
                            </div>

                            <input type="text" id="usernameInput" name="username" required autofocus autocomplete="off"
                                class="w-full pl-40 pr-12 py-4 bg-gray-50 border-2 border-gray-200 rounded-2xl text-gray-900 font-bold text-lg placeholder-gray-300 focus:outline-none focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50/50 transition-all duration-300"
                                placeholder="username">
                            
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                <span id="statusIcon" class="hidden transition-all duration-300 transform scale-0 opacity-0"></span>
                            </div>
                        </div>

                        <div id="validationMsg" class="mt-3 ml-1 text-sm font-medium min-h-[24px] transition-all duration-300"></div>
                    </div>

                    <button type="submit" id="submitBtn" disabled
                        class="w-full bg-gray-900 text-white font-bold py-4 rounded-2xl transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:shadow-none flex items-center justify-center gap-2 group text-lg mt-4">
                        <span>Selesai & Masuk Dashboard</span>
                        <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </button>
                </form>
            </div>
            
            <div class="bg-gray-50 px-8 py-4 border-t border-gray-100 text-center">
                <p class="text-xs text-gray-400 font-medium">Username dapat diubah nanti di menu Pengaturan.</p>
            </div>
        </div>
    </div>

    <script>
        const input = document.getElementById('usernameInput');
        const msgDiv = document.getElementById('validationMsg');
        const statusIcon = document.getElementById('statusIcon');
        const submitBtn = document.getElementById('submitBtn');
        let timeout = null;

        // SVG Icons Constants
        const iconLoading = `<svg class="animate-spin h-6 w-6 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>`;
        
        const iconSuccess = `<div class="bg-emerald-100 rounded-full p-1"><svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></div>`;
        
        const iconError = `<div class="bg-red-100 rounded-full p-1"><svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></div>`;

        input.addEventListener('input', function() {
            clearTimeout(timeout);
            const val = this.value.replace(/\s+/g, '').toLowerCase(); 
            this.value = val;

            if (val === '') {
                resetUI();
                return;
            }

            const regex = /^[a-z0-9-_]+$/;
            if (!regex.test(val)) {
                showError('Hanya huruf kecil, angka, - dan _');
                return;
            }

            showLoading();

            timeout = setTimeout(() => {
                checkAvailability(val);
            }, 500);
        });

        async function checkAvailability(username) {
            try {
                const response = await fetch(`{{ route('username.check') }}?username=${username}`);
                const data = await response.json();

                if (data.status === 'available') {
                    showSuccess('Username tersedia! Keren.');
                } else if (data.status === 'taken') {
                    showError('Yah, username ini sudah dipakai.');
                }
            } catch (error) {
                console.error('Error:', error);
                showError('Gagal terhubung ke server.');
            }
        }

        // --- UI Functions ---

        function resetUI() {
            msgDiv.innerHTML = '';
            statusIcon.classList.add('scale-0', 'opacity-0');
            statusIcon.classList.remove('scale-100', 'opacity-100'); // Hide Animation
            setTimeout(() => { statusIcon.classList.add('hidden'); }, 300);

            input.classList.remove('border-red-500', 'border-emerald-500', 'focus:border-indigo-500');
            input.classList.add('border-gray-200');
            disableBtn();
        }

        function showLoading() {
            msgDiv.innerHTML = '<span class="text-gray-400 flex items-center gap-2 text-sm">Mengecek ketersediaan...</span>';
            
            statusIcon.innerHTML = iconLoading;
            statusIcon.classList.remove('hidden', 'scale-0', 'opacity-0');
            statusIcon.classList.add('scale-100', 'opacity-100');
            
            disableBtn();
        }

        function showSuccess(message) {
            msgDiv.innerHTML = `<span class="text-emerald-600 font-bold flex items-center gap-1 animate-pulse">${message}</span>`;
            
            statusIcon.innerHTML = iconSuccess;
            
            input.classList.remove('border-gray-200', 'border-red-500', 'focus:border-indigo-500');
            input.classList.add('border-emerald-500');
            
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed', 'bg-gray-900');
            submitBtn.classList.add('bg-indigo-600', 'hover:bg-indigo-700', 'shadow-lg');
        }

        function showError(message) {
            msgDiv.innerHTML = `<span class="text-red-500 font-bold flex items-center gap-1">${message}</span>`;
            
            statusIcon.innerHTML = iconError;

            input.classList.remove('border-gray-200', 'border-emerald-500', 'focus:border-indigo-500');
            input.classList.add('border-red-500');
            
            disableBtn();
        }

        function disableBtn() {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed', 'bg-gray-900');
            submitBtn.classList.remove('bg-indigo-600', 'hover:bg-indigo-700', 'shadow-lg');
        }
    </script>
</body>
</html>