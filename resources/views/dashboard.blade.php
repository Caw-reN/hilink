<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Links') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 shadow-sm rounded-r mb-4" role="alert">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 shadow-sm rounded-r mb-4" role="alert">
                    <p class="font-bold">Ada Kesalahan:</p>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Add New Link</h3>
                
                <form action="{{ route('links.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row gap-4">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Icon (Opsional)</label>
                        <input type="file" name="icon" class="block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-indigo-50 file:text-indigo-700
                            hover:file:bg-indigo-100
                        "/>
                    </div>

                    <div class="flex-1">
                        <input type="text" name="title" placeholder="Link Title (e.g. My Instagram)" 
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                    
                    <div class="flex-1">
                        <input type="url" name="url" placeholder="URL (https://...)" 
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition">
                        Add Link
                    </button>
                </form>

                @if (session('success'))
                    <div class="mt-4 p-4 bg-green-100 text-green-700 rounded-md">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Your Links</h3>

                @if($links->count() > 0)
                    <div id="link-list" class="space-y-4">
                        @foreach($links as $link)
                            <div data-id="{{ $link->id }}" class="flex items-center justify-between bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <div>
                                    <h4 class="font-bold text-gray-800">{{ $link->title }}</h4>
                                    <a href="{{ $link->url }}" target="_blank" class="text-sm text-indigo-500 hover:underline">{{ $link->url }}</a>
                                </div>

                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-400">
                                    {{ $link->visits_count }} clicks
                                </span>

                                <div class="flex items-center gap-2">
                                    <a href="{{ route('links.edit', $link) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-semibold">
                                        Edit
                                    </a>
                                    <form action="{{ route('links.destroy', $link) }}" method="POST" onsubmit="return confirm('Yakin mau hapus?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-semibold">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 italic">Kamu belum punya link. Tambahkan di atas!</p>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.2/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var el = document.getElementById('link-list');
        
        // Inisialisasi SortableJS
        var sortable = Sortable.create(el, {
            animation: 150, // Animasi halus saat digeser
            ghostClass: 'bg-indigo-100', // Warna background saat item sedang ditarik
            
            // Event saat user SELESAI menggeser (Mouse dilepas)
            onEnd: function () {
                // 1. Ambil urutan ID baru
                // Hasilnya array contoh: ["5", "2", "3"]
                let ids = Array.from(el.children).map(item => item.getAttribute('data-id'));

                // 2. Kirim ke Backend pakai Fetch API / Axios
                // Kita pakai Fetch native biar gak perlu install axios npm lagi
                fetch('{{ route('links.reorder') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Wajib di Laravel!
                    },
                    body: JSON.stringify({ ids: ids })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Success:', data);
                    // Opsional: Kasih notifikasi kecil kalau berhasil
                })
                .catch((error) => {
                    console.error('Error:', error);
                    alert('Gagal menyimpan urutan!');
                });
            }
        });
    });
</script>