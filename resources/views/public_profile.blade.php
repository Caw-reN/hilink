<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->name }} - Linktree Clone</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex flex-col items-center py-10" style="background-color: {{ $user->bg_color }};">

    <div class="text-center mb-8 px-4">
        <div class="w-24 h-24 bg-gray-400 rounded-full mx-auto mb-4 overflow-hidden border-4 border-white shadow-lg">
             @if($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" 
                    alt="{{ $user->name }}" 
                    class="w-full h-full object-cover">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&size=200" 
                    alt="{{ $user->name }}" 
                    class="w-full h-full object-cover">
            @endif
        </div>
        
        <h1 class="text-xl font-bold text-gray-800">{{ $user->name }}</h1>
        <p class="text-sm text-gray-600 mt-2 max-w-md mx-auto">{{ $user->bio }}</p>
    </div>

    <div class="w-full max-w-md px-4 space-y-4">
        @foreach($links as $link)
            <a href="{{ route('links.visit', $link) }}" target="_blank"
               class="block w-full bg-white text-gray-800 text-center py-4 rounded-lg shadow hover:shadow-md hover:scale-[1.02] transition-transform duration-200 border border-gray-200 font-semibold">
                {{ $link->title }}
            </a>
        @endforeach

        @if($links->isEmpty())
            <p class="text-center text-gray-500 italic">Belum ada link yang ditambahkan.</p>
        @endif
    </div>

    <div class="mt-12 text-gray-400 text-xs">
        Made with Laravel by {{ $user->username }}
    </div>

</body>
</html>