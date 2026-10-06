@props(['active' => false, 'icon' => 'dashboard'])

@php
    $classes = $active
        ? 'bg-white/10 text-white font-semibold shadow-inner'
        : 'text-gray-300 hover:bg-white/5 hover:text-white';

    $iconPath = match($icon) {
        'dashboard' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
        'document'  => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
        'news'      => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z',
        'user'      => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
        default     => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
    };
@endphp

<a {{ $attributes->merge(['class' => "flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group $classes"]) }}>
    <svg class="w-5 h-5 shrink-0 {{ $active ? 'text-red-400' : 'text-gray-400 group-hover:text-white' }}" 
         fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}"/>
    </svg>
    <span class="text-sm">{{ $slot }}</span>
</a>