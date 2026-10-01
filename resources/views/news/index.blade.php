@extends('layouts.app')

@section('content')

{{-- ============ HERO ============ --}}
{{-- pt-32/pt-40 memberi ruang agar tidak tertutup navbar floating --}}
<section class="relative bg-[#0A2540] text-white pt-32 pb-16 sm:pt-40 sm:pb-24 overflow-hidden">
    {{-- aksen dekoratif halus --}}
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

{{-- ============ DAFTAR BERITA ============ --}}
<section class="bg-slate-50 py-16 sm:py-24">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="space-y-16 sm:space-y-24">
            @forelse($newsList as $item)
                @php $isEven = $loop->iteration % 2 === 0; @endphp

                <article class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-16 items-center">

                    {{-- Gambar --}}
                    <div class="{{ $isEven ? 'md:order-1' : 'md:order-2' }}">
                        <div class="aspect-[16/10] rounded-2xl overflow-hidden bg-gray-100 shadow-lg ring-1 ring-gray-200/60">
                            @if($item->image)
                                <img
                                    src="{{ asset('storage/' . $item->image) }}"
                                    alt="{{ $item->title }}"
                                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-700 ease-out"
                                    loading="lazy"
                                >
                            @else
                                <div class="flex flex-col items-center justify-center h-full text-gray-400 text-sm gap-2">
                                    <svg class="w-10 h-10 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>No image available</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Teks --}}
                    <div class="{{ $isEven ? 'md:order-2' : 'md:order-1' }} md:px-4">
                        @if($item->created_at)
                            <time datetime="{{ $item->created_at->toDateString() }}" class="block text-sm text-gray-500 mb-3">
                                {{ $item->created_at->translatedFormat('d F Y') }}
                            </time>
                        @endif

                        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-[#0A2540] mb-5 leading-tight">
                            {{ $item->title }}
                        </h2>

                        <p class="text-gray-600 text-base leading-relaxed mb-8 max-w-xl">
                            {{ $item->excerpt }}
                        </p>

                        <a href="{{ route('news.show', $item->slug) }}"
                           class="inline-block bg-teal-600 hover:bg-teal-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-teal-600 text-white text-sm font-semibold px-7 py-3.5 rounded-lg shadow-sm transition-colors">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>

                </article>
            @empty
                <div class="text-center py-20 bg-white rounded-2xl border border-gray-200 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-700">No news found</h3>
                    <p class="text-sm text-gray-500 mt-1">Latest updates and announcements will appear here soon.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination (aktifkan jika $newsList memakai paginate()) --}}
        @if(method_exists($newsList, 'links'))
            <div class="mt-16">
                {{ $newsList->links() }}
            </div>
        @endif
    </div>
</section>

@endsection