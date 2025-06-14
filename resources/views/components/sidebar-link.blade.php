@props([
    'route',
    'icon' => 'fa-solid fa-circle',
])

@php
    $isActive = request()->routeIs($route);
@endphp

<a href="{{ route($route) }}"
   class="flex items-center gap-3 px-4 py-2 rounded-lg transition-colors duration-200
          {{ $isActive ? 'bg-indigo-100 text-indigo-600 font-semibold' : 'text-gray-600 hover:bg-gray-100 hover:text-indigo-500' }}">
    
    {{-- Ikon --}}
    <div class="flex items-center justify-center w-5 h-5">
        <i class="{{ $icon }} text-[16px] leading-none text-inherit"></i>
    </div>

    {{-- Teks --}}
    <span class="text-sm leading-[1.25]">{{ $slot }}</span>
</a>
