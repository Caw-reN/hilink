@php
    
    $baseClass = "block w-full text-center py-4 transition-all duration-300 font-semibold relative overflow-hidden group hover:scale-[1.02] shadow-sm";
    $shapeClass = $user->btn_shape ?? 'rounded-xl';

    
    $styleClass = "";
    switch ($user->btn_style) {
        case 'outline':
            
            $styleClass = "bg-transparent border-2 border-white text-white hover:bg-white hover:text-black";
            break;
        case 'soft':
            
            $styleClass = "bg-white/80 backdrop-blur-md border border-white/50 text-gray-900 hover:bg-white";
            break;
        default: 
            
            $styleClass = "bg-white border border-gray-200 text-gray-900 hover:shadow-lg";
            break;
    }

    
    $finalButtonClass = "$baseClass $shapeClass $styleClass";
@endphp

<!DOCTYPE html>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->name }} - Linktree Clone</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex flex-col items-center py-10 transition-colors duration-500" 
      style="background-color: {{ $user->bg_color ?? '#f3f4f6' }};"> 

    <div class="text-center mb-8 px-4 w-full max-w-2xl">
        <div class="w-24 h-24 bg-gray-400 rounded-full mx-auto mb-4 overflow-hidden border-4 border-white shadow-lg relative group">
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
        
        <h1 class="text-xl font-bold text-gray-800 drop-shadow-sm">{{ $user->name }}</h1>
        <p class="text-sm text-gray-600 mt-2 max-w-md mx-auto leading-relaxed">{{ $user->bio }}</p>
    </div>

    <div class="w-full max-w-md px-4 space-y-4 mb-auto">
        @foreach($links as $link)
            <a href="{{ route('links.visit', $link) }}" target="_blank" class="{{ $finalButtonClass }}">    
                <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                
                <span class="relative z-10">{{ $link->title }}</span>
            </a>
        @endforeach

        @if($links->isEmpty())
            <div class="bg-white/50 p-6 rounded-lg text-center border border-dashed border-gray-400">
                <p class="text-gray-600 italic">Belum ada link yang ditambahkan.</p>
            </div>
        @endif
    </div>

    <div class="mt-16 text-center w-full pb-8">
        <div class="inline-block bg-white/80 backdrop-blur-sm px-6 py-4 rounded-2xl shadow-sm border border-white/50 mx-4">
            <p class="text-xs text-gray-500 font-medium mb-3 uppercase tracking-wider">
                Ingin buat bio link seperti ini?
            </p>
            
            <a href="{{ route('register') }}" 
               class="inline-flex items-center gap-2 bg-black text-white px-6 py-2.5 rounded-full font-bold text-sm shadow-lg hover:bg-gray-800 hover:scale-105 transition-all duration-200">
                <span>Buat HiLink Gratis</span>
            </a>
            
            <div class="mt-4 text-[10px] text-gray-400 font-mono">
                Powered by <span class="font-bold text-gray-600">HiLink</span>
            </div>
        </div>
    </div>

</body>
</html>