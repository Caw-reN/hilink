<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Link
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('links.update', $link) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT') <div>
                        <label class="block font-medium text-sm text-gray-700">Judul Link</label>
                        <input type="text" name="title" value="{{ old('title', $link->title) }}" 
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">URL Tujuan</label>
                        <input type="url" name="url" value="{{ old('url', $link->url) }}" 
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                            Update Link
                        </button>
                        <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>