<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success') || session('status'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                     class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-lg shadow-sm flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>{{ session('success') ?? session('status') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-6">
                    
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <span class="bg-indigo-100 text-indigo-600 p-2 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </span>
                            Tambah Link Baru
                        </h2>
                        
                        <form action="{{ route('links.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Judul Link</label>
                                    <input type="text" name="title" placeholder="Contoh: WhatsApp Bisnis" required
                                           class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50 transition-all text-sm py-3">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">URL Tujuan</label>
                                    <input type="url" name="url" placeholder="https://wa.me/..." required
                                           class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50 transition-all text-sm py-3">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Icon (Opsional)</label>
                                <input type="file" name="icon" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer border border-gray-200 rounded-xl">
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="bg-gray-900 hover:bg-black text-white font-bold py-3 px-6 rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-sm">
                                    Simpan Link
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center justify-between ml-1 mb-2">
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider">Link Aktif ({{ $links->count() }})</h3>
                        </div>
                        
                        @forelse ($links as $link)
                            <div class="group bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all flex items-center gap-4">
                                <div class="text-gray-300 cursor-grab hover:text-gray-500">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path></svg>
                                </div>

                                <div class="flex-shrink-0">
                                    @if ($link->icon_path)
                                        <img src="{{ asset('storage/' . $link->icon_path) }}" class="w-12 h-12 rounded-lg object-cover bg-gray-50 border border-gray-100">
                                    @else
                                        <div class="w-12 h-12 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-500">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-1 min-w-0">
                                    <h4 class="text-gray-900 font-bold truncate">{{ $link->title }}</h4>
                                    <a href="{{ $link->url }}" target="_blank" class="text-gray-400 text-xs truncate hover:text-indigo-500 block">{{ $link->url }}</a>
                                    
                                    <div class="mt-2 inline-flex items-center gap-1 text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md border border-emerald-100">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                        {{ $link->visits_count }} Klik
                                    </div>
                                </div>

                                <div class="flex items-center gap-1 opacity-100 lg:opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('links.edit', $link) }}" class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('links.destroy', $link) }}" method="POST" onsubmit="return confirm('Yakin mau hapus link ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12 bg-white rounded-2xl border border-dashed border-gray-300">
                                <p class="text-gray-500 font-medium">Belum ada link.</p>
                                <p class="text-sm text-gray-400">Yuk, tambahkan link pertamamu!</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="space-y-6">
                    
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 text-center relative overflow-hidden group">
                        <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-r from-indigo-500 to-purple-500 opacity-10 group-hover:opacity-20 transition-opacity"></div>
                        
                        <div class="relative z-10 mt-4">
                            @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-24 h-24 rounded-full mx-auto object-cover border-4 border-white shadow-lg mb-3">
                            @else
                                <div class="w-24 h-24 rounded-full mx-auto bg-indigo-100 flex items-center justify-center text-indigo-600 text-3xl font-bold border-4 border-white shadow-lg mb-3">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                            
                            <h3 class="text-xl font-bold text-gray-800">{{ Auth::user()->name }}</h3>
                            <a href="{{ url('/' . Auth::user()->username) }}" target="_blank" class="text-sm text-indigo-500 hover:text-indigo-700 font-medium mb-4 inline-block">
                                hilink.id/{{ strtolower(str_replace(' ', '', Auth::user()->username)) }} ↗
                            </a>
                            
                            <a href="{{ url('/' . Auth::user()->username) }}" target="_blank" 
                               class="block w-full border-2 border-indigo-100 text-indigo-600 hover:bg-indigo-50 hover:border-indigo-200 font-bold py-2 rounded-xl transition-all text-sm">
                                Lihat Profil Publik
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 text-center">
                            <p class="text-3xl font-black text-indigo-600">{{ $totalViews ?? 0 }}</p>
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-wide mt-1">Visitors</p>
                        </div>
                        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 text-center">
                            <p class="text-3xl font-black text-pink-600">{{ $totalLinkClicks ?? 0 }}</p>
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-wide mt-1">Total Klik</p>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h3 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                            Kustomisasi Tampilan
                        </h3>
                        
                        <form action="{{ route('profile.appearance') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            
                            <div class="mb-5">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Background Color</label>
                                <div class="flex items-center gap-3">
                                    <input type="color" name="bg_color" value="{{ Auth::user()->bg_color ?? '#ffffff' }}" 
                                        class="h-10 w-full rounded-lg cursor-pointer border-2 border-gray-200">
                                </div>
                            </div>

                            <div class="mb-5">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Bentuk Tombol</label>
                                <div class="grid grid-cols-3 gap-2">
                                    <label class="cursor-pointer">
                                        <input type="radio" name="btn_shape" value="rounded-none" class="peer sr-only" 
                                            {{ Auth::user()->btn_shape == 'rounded-none' ? 'checked' : '' }}>
                                        <div class="h-9 bg-gray-100 border-2 border-transparent peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:text-indigo-700 flex items-center justify-center text-xs font-bold rounded-none transition-all">Kotak</div>
                                    </label>

                                    <label class="cursor-pointer">
                                        <input type="radio" name="btn_shape" value="rounded-xl" class="peer sr-only" 
                                            {{ (Auth::user()->btn_shape ?? 'rounded-xl') == 'rounded-xl' ? 'checked' : '' }}>
                                        <div class="h-9 bg-gray-100 border-2 border-transparent peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:text-indigo-700 flex items-center justify-center text-xs font-bold rounded-xl transition-all">Standar</div>
                                    </label>

                                    <label class="cursor-pointer">
                                        <input type="radio" name="btn_shape" value="rounded-full" class="peer sr-only" 
                                            {{ Auth::user()->btn_shape == 'rounded-full' ? 'checked' : '' }}>
                                        <div class="h-9 bg-gray-100 border-2 border-transparent peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:text-indigo-700 flex items-center justify-center text-xs font-bold rounded-full transition-all">Bulat</div>
                                    </label>
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Gaya Tombol</label>
                                <div class="grid grid-cols-3 gap-2">
                                    <label class="cursor-pointer">
                                        <input type="radio" name="btn_style" value="solid" class="peer sr-only" 
                                            {{ (Auth::user()->btn_style ?? 'solid') == 'solid' ? 'checked' : '' }}>
                                        <div class="h-9 bg-gray-800 text-white border-2 border-transparent peer-checked:ring-2 peer-checked:ring-offset-1 peer-checked:ring-gray-800 flex items-center justify-center text-xs font-bold rounded-lg transition-all">Solid</div>
                                    </label>

                                    <label class="cursor-pointer">
                                        <input type="radio" name="btn_style" value="outline" class="peer sr-only" 
                                            {{ Auth::user()->btn_style == 'outline' ? 'checked' : '' }}>
                                        <div class="h-9 bg-white text-gray-800 border-2 border-gray-800 peer-checked:bg-gray-50 peer-checked:ring-2 peer-checked:ring-offset-1 peer-checked:ring-gray-800 flex items-center justify-center text-xs font-bold rounded-lg transition-all">Garis</div>
                                    </label>

                                    <label class="cursor-pointer">
                                        <input type="radio" name="btn_style" value="soft" class="peer sr-only" 
                                            {{ Auth::user()->btn_style == 'glass' ? 'checked' : '' }}>
                                        <div class="h-9 bg-gray-200 text-gray-800 border-2 border-transparent bg-opacity-50 peer-checked:border-gray-400 peer-checked:bg-gray-300 flex items-center justify-center text-xs font-bold rounded-lg transition-all">Glass</div>
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl text-sm font-bold transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                Simpan Tampilan
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>