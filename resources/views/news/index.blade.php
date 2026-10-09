@extends('layouts.app')

@section('title', 'News & Announcements — PT Patimban International Car Terminal')

@section('content')

{{-- ============ HERO ============ --}}
<section class="relative bg-[#0A2540] text-white pt-32 pb-16 sm:pt-40 sm:pb-24 overflow-hidden">
    <div class="absolute -right-24 -top-24 w-96 h-96 rounded-full bg-teal-500/10 blur-3xl pointer-events-none"></div>
    <div class="absolute -left-24 bottom-0 w-80 h-80 rounded-full bg-red-500/10 blur-3xl pointer-events-none"></div>

    <div class="relative max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold leading-tight max-w-3xl">
            News &amp; Announcements
        </h1>
        <p class="mt-5 text-base sm:text-lg text-white/70 max-w-2xl leading-relaxed">
            Latest information about operations, services, and activities at Patimban International Car Terminal.
        </p>
    </div>
</section>

{{-- ============ GRID BERITA ============ --}}
<section class="bg-slate-50 py-16 sm:py-24">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">

        @if($newsList->count() > 0)
            {{-- Info jumlah --}}
            <div class="flex items-center justify-between mb-8">
                <p class="text-sm text-gray-500">
                    Menampilkan
                    <span class="font-semibold text-[#0A2540]">{{ $newsList->firstItem() }}</span>–<span class="font-semibold text-[#0A2540]">{{ $newsList->lastItem() }}</span>
                    dari
                    <span class="font-semibold text-[#0A2540]">{{ $newsList->total() }}</span>
                    berita
                </p>
            </div>

            {{-- Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @foreach($newsList as $item)
                    <article class="group bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">

                        {{-- Gambar --}}
                        <a href="{{ route('news.show', $item->slug) }}" class="block relative aspect-[16/10] overflow-hidden bg-gray-100">
                            @if($item->image_url)
                                <img
                                    src="{{ $item->image_url }}"
                                    alt="{{ $item->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out"
                                    loading="lazy"
                                >
                            @else
                                <div class="flex flex-col items-center justify-center h-full text-gray-400 text-xs gap-1">
                                    <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>No image</span>
                                </div>
                            @endif

                            {{-- Badge kategori (opsional) --}}
                            @if(!empty($item->category))
                                <span class="absolute top-3 left-3 bg-red-700 text-white text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-md shadow-sm">
                                    {{ $item->category }}
                                </span>
                            @endif
                        </a>

                        {{-- Konten --}}
                        <div class="p-5 sm:p-6 flex flex-col flex-grow">
                            @if($item->created_at)
                                <time datetime="{{ $item->created_at->toDateString() }}"
                                      class="block text-xs text-gray-500 mb-2 uppercase tracking-wider">
                                    {{ $item->created_at->translatedFormat('d F Y') }}
                                </time>
                            @endif

                            <h2 class="text-lg sm:text-xl font-bold text-[#0A2540] mb-3 leading-snug line-clamp-2 group-hover:text-red-700 transition-colors">
                                <a href="{{ route('news.show', $item->slug) }}">
                                    {{ $item->title }}
                                </a>
                            </h2>

                            <p class="text-sm text-gray-600 leading-relaxed mb-5 line-clamp-3 flex-grow">
                                {{ $item->excerpt }}
                            </p>

                            <a href="{{ route('news.show', $item->slug) }}"
                               class="inline-flex items-center gap-1.5 text-red-700 hover:text-red-800 text-sm font-semibold group/link">
                                Learn More
                                <svg class="w-4 h-4 transition-transform group-hover/link:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-14 flex justify-center">
                {{ $newsList->links() }}
            </div>
        @else
            <div class="text-center py-20 bg-white rounded-2xl border border-gray-200 shadow-sm">
                <h3 class="text-lg font-bold text-gray-700">No news found</h3>
                <p class="text-sm text-gray-500 mt-1">Latest updates and announcements will appear here soon.</p>
            </div>
        @endif

    </div>
</section>

@endsection