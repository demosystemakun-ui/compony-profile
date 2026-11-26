@extends('layouts.app')

@section('title', 'News & Announcements — PT Patimban International Car Terminal')

@push('styles')
<style>
    .news-scroll-section {
        background-color: #f8fafc;
        padding-top: 5rem;
        padding-bottom: 6rem;
    }

    /* Semua kartu HARUS jadi anak langsung dari container ini */
    .news-stack-container {
        position: relative;
        width: 100%;
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .news-card-sticky {
        position: relative;
        margin-bottom: 2rem;
        border-radius: 2rem;
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        box-shadow: 0 -15px 35px rgba(0,0,0,0.08), 0 5px 15px rgba(0,0,0,0.03);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        transform-origin: top center;
    }

    .news-card-sticky:last-child { margin-bottom: 0; }

    /* Efek menumpuk hanya di desktop */
    @media (min-width: 1024px) {
        .news-card-sticky {
            position: sticky;
            top: var(--stack-top, 12vh);
            min-height: 70vh;
            height: auto;
            flex-direction: row;
            align-items: center;
            padding: 2.5rem 3rem;
            gap: 3rem;
            margin-bottom: 4rem;
        }
        .news-card-sticky:last-child { margin-bottom: 0; }
    }

    /* -- KONTEN TEKS -- */
    .news-card-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 2rem;
    }

    @media (min-width: 1024px) {
        .news-card-content { padding: 0; max-width: 500px; }
    }

    .news-card-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(90deg, #ec2029 0%, #b91c1c 100%);
        color: white;
        font-size: 0.7rem;
        font-weight: 800;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        padding: 0.5rem 1.25rem;
        border-radius: 9999px;
        align-self: flex-start;
        margin-bottom: 1.25rem;
    }

    .news-card-date {
        display: block;
        font-size: 0.75rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 0.75rem;
    }

    .news-card-title {
        font-size: 2.25rem;
        font-weight: 800;
        line-height: 1.1;
        color: #0f172a;
        margin-bottom: 1rem;
        letter-spacing: -0.02em;
    }

    @media (min-width: 1024px) {
        .news-card-title {
            font-size: 1.875rem;
            line-height: 1.2;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    }

    .news-card-excerpt {
        font-size: 1.125rem;
        line-height: 1.6;
        color: #475569;
        margin-bottom: 1.75rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .news-card-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background-color: #0f172a;
        color: white;
        font-size: 0.875rem;
        font-weight: 700;
        padding: 0.9rem 1.85rem;
        border-radius: 9999px;
        text-decoration: none;
        align-self: flex-start;
        transition: all 0.3s ease;
    }

    .news-card-btn:hover {
        background-color: #ec2029;
        transform: translateY(-2px);
    }

    /* -- GAMBAR -- */
    .news-card-image {
        flex: 1.2;
        width: 100%;
        height: 100%;
        border-radius: 1.5rem;
        overflow: hidden;
        position: relative;
        background-color: #e2e8f0;
    }

    @media (min-width: 1024px) {
        .news-card-image {
            height: 24rem;
            align-self: stretch;
        }
    }

    .news-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* ═══════════════════════════════════════════════════════════
       MOBILE & TABLET (< 1024px): kartu ringkas
    ═══════════════════════════════════════════════════════════ */
    @media (max-width: 1023px) {
        .news-scroll-section {
            padding-top: 1.5rem;
            padding-bottom: 3rem;
        }
        .news-stack-container { padding: 0 0.875rem; }

        .news-card-sticky {
            flex-direction: row;
            align-items: stretch;
            margin-bottom: 0.75rem;
            border-radius: 1.25rem;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.06);
        }

        .news-card-image {
            order: -1;
            flex: 0 0 6.75rem;
            width: 6.75rem;
            height: auto;
            min-height: 7.5rem;
            border-radius: 0;
        }

        .news-card-content {
            min-width: 0;
            padding: 0.75rem 0.875rem;
            justify-content: center;
        }

        .news-card-tag {
            font-size: 0.625rem;
            letter-spacing: 0.06em;
            padding: 0.2rem 0.6rem;
            gap: 0.3rem;
            margin-bottom: 0.4rem;
        }

        .news-card-date {
            font-size: 0.6875rem;
            letter-spacing: 0.04em;
            margin-bottom: 0.3rem;
        }

        .news-card-title {
            font-size: 1.0625rem;
            line-height: 1.3;
            letter-spacing: -0.01em;
            margin-bottom: 0.35rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .news-card-excerpt { display: none; }

        .news-card-btn {
            background: transparent;
            color: #b91c1c;
            padding: 0;
            font-size: 0.8125rem;
            gap: 0.25rem;
            border-radius: 0;
        }
        .news-card-btn:hover {
            background: transparent;
            color: #ec2029;
            transform: none;
        }
        .news-card-btn::after {
            content: '';
            position: absolute;
            inset: 0;
        }
        .news-card-btn svg { width: 0.875rem; height: 0.875rem; }
    }

    @media (min-width: 640px) and (max-width: 1023px) {
        .news-stack-container { padding: 0 1.5rem; }
        .news-card-image { flex-basis: 11rem; width: 11rem; min-height: 10rem; }
        .news-card-content { padding: 1rem 1.25rem; }
        .news-card-title { font-size: 1.25rem; }
        .news-card-excerpt {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            font-size: 0.9375rem;
            line-height: 1.5;
            margin-bottom: 0.5rem;
        }
    }
</style>
@endpush

@section('content')

@php
    $resolveNewsImg = function ($item) {
        if (empty($item->image)) {
            return $item->image_url ?? null;
        }
        if (\Illuminate\Support\Str::startsWith($item->image, ['http://', 'https://'])) {
            return $item->image;
        }
        return \Illuminate\Support\Facades\Storage::disk('public')->url($item->image);
    };
@endphp

{{-- ============ HERO ============ --}}
<section class="relative bg-[#0A2540] text-white pt-28 pb-10 sm:pt-40 sm:pb-24 overflow-hidden z-20">
    <div class="relative max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 text-center md:text-left">
        <h1 class="text-3xl sm:text-5xl md:text-6xl font-bold leading-tight max-w-3xl">
            News &amp; Announcements
        </h1>
        <p class="mt-3 sm:mt-5 text-sm sm:text-lg text-white/70 max-w-2xl leading-relaxed mx-auto md:mx-0">
            Latest information about operations, services, and activities at Patimban International Car Terminal.
        </p>
    </div>
</section>

{{-- ============ NEWS CONTENT ============ --}}
<section class="news-scroll-section">

    @if($newsList->count() > 0)
        @php
            $isFirstPage  = $newsList->currentPage() === 1;
            $featuredNews = $isFirstPage ? $newsList->take(3) : collect();
            $gridNews     = $isFirstPage ? $newsList->skip(3) : $newsList;
        @endphp

        {{-- 1. STACKED CARDS (3 Berita Terbaru di Halaman 1) --}}
        @if($featuredNews->count() > 0)
            <div class="news-stack-container">
                @foreach($featuredNews as $index => $item)
                    @php $imgSrc = $resolveNewsImg($item); @endphp
                    <article class="news-card-sticky" style="--stack-top: calc(12vh + {{ $index * 14 }}px);">

                        <div class="news-card-content">
                            @if(!empty($item->category))
                                <div class="news-card-tag">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                    {{ $item->category }}
                                </div>
                            @endif

                            @if($item->published_at)
                                <time datetime="{{ $item->published_at->toDateString() }}" class="news-card-date">
                                    {{ $item->published_at->translatedFormat('d F Y') }}
                                </time>
                            @endif

                            <h2 class="news-card-title">{{ $item->title }}</h2>
                            <p class="news-card-excerpt">{{ $item->excerpt }}</p>

                            <a href="{{ route('news.show', $item->slug) }}" class="news-card-btn">
                                Read Full Article
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>

                        <div class="news-card-image">
                            @if($imgSrc)
                                <img src="{{ $imgSrc }}" alt="{{ $item->title }}" loading="{{ $index === 0 ? 'eager' : 'lazy' }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-slate-200 text-slate-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                    </article>
                @endforeach
            </div>
        @endif

        {{-- 2. GRID KOTAK-KOTAK (Berita ke-4 dst & Halaman 2+) --}}
        @if($gridNews->count() > 0)
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 {{ $featuredNews->count() > 0 ? 'mt-16 lg:mt-24 pt-12 border-t border-slate-200' : '' }} relative z-20">
                @if($featuredNews->count() > 0)
                    <h2 class="text-xl sm:text-2xl font-bold text-[#0A2540] mb-6 sm:mb-8">More News &amp; Updates</h2>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                    @foreach($gridNews as $item)
                        @php $imgSrc = $resolveNewsImg($item); @endphp
                        <article class="group bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition-all flex flex-col">
                            <a href="{{ route('news.show', $item->slug) }}" class="block aspect-[16/10] bg-slate-100 overflow-hidden">
                                @if($imgSrc)
                                    <img src="{{ $imgSrc }}"
                                         alt="{{ $item->title }}"
                                         loading="lazy"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-400">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </a>

                            <div class="p-5 flex flex-col flex-1">
                                <h3 class="text-base sm:text-lg font-bold text-[#0A2540] leading-snug line-clamp-2 group-hover:text-[#ec2029] transition-colors">
                                    <a href="{{ route('news.show', $item->slug) }}">{{ $item->title }}</a>
                                </h3>

                                <div class="mt-auto pt-4">
                                    <a href="{{ route('news.show', $item->slug) }}"
                                       class="inline-flex items-center gap-1.5 text-sm font-bold text-[#0A2540] group-hover:text-[#ec2029] transition-colors">
                                        Read Full Article
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mt-10 lg:mt-14 flex justify-center relative z-20 px-4">
            {{ $newsList->links() }}
        </div>
    @else
        <div class="max-w-7xl mx-auto px-4 text-center py-20 bg-white rounded-2xl border border-gray-200 shadow-sm relative z-20">
            <h3 class="text-lg font-bold text-gray-700">No News Found</h3>
            <p class="text-sm text-gray-500 mt-1">New news will appear here.</p>
        </div>
    @endif
</section>

@endsection

@push('scripts')
<script>
(function () {
    if (window.__newsStackCleanup) window.__newsStackCleanup();

    const cards = Array.from(document.querySelectorAll('.news-card-sticky'));
    if (!cards.length) return;

    const desktop = window.matchMedia('(min-width: 1024px)');
    let ticking = false;

    function update() {
        ticking = false;

        cards.forEach((card, i) => {
            const next = cards[i + 1];

            if (!desktop.matches || !next) {
                card.style.transform = '';
                return;
            }

            const nextStuckTop = parseFloat(getComputedStyle(next).top) || 0;
            const nextTop = next.getBoundingClientRect().top;
            const vh = window.innerHeight;

            const progress = Math.min(1, Math.max(0, (vh - nextTop) / (vh - nextStuckTop)));

            card.style.transform = `scale(${1 - progress * 0.06})`;
        });
    }

    function onScroll() {
        if (!ticking) {
            requestAnimationFrame(update);
            ticking = true;
        }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', update);
    window.__newsStackCleanup = () => {
        window.removeEventListener('scroll', onScroll);
        window.removeEventListener('resize', update);
    };

    update();
})();
</script>
@endpush