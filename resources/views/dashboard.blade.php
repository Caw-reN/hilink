<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Links') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Add New Link</h3>
                
                <form action="{{ route('links.store') }}" method="POST" class="flex flex-col sm:flex-row gap-4">
                    @csrf
                    
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
                    <div class="space-y-4">
                        @foreach($links as $link)
                            <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <div>
                                    <h4 class="font-bold text-gray-800">{{ $link->title }}</h4>
                                    <a href="{{ $link->url }}" target="_blank" class="text-sm text-indigo-500 hover:underline">{{ $link->url }}</a>
                                </div>
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