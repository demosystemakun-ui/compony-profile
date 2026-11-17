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
        background-color: #ffffff; /* solid, supaya benar-benar menutupi kartu di bawahnya */
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
            height: 70vh;
            flex-direction: row;
            align-items: center;
            padding: 3rem;
            gap: 3rem;
            margin-bottom: 4rem; /* jarak scroll sebelum kartu berikutnya naik */
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
        margin-bottom: 1.5rem;
    }

    .news-card-title {
        font-size: 2.25rem;
        font-weight: 800;
        line-height: 1.1;
        color: #0f172a;
        margin-bottom: 1rem;
        letter-spacing: -0.02em;
    }

    .news-card-excerpt {
        font-size: 1.125rem;
        line-height: 1.6;
        color: #475569;
        margin-bottom: 2rem;
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
        padding: 1rem 2rem;
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

    @media (max-width: 1023px) {
        .news-card-image {
            height: 250px;
            order: -1;
            flex: none;
            border-radius: 0;
        }
    }

    .news-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
@endpush

@section('content')

{{-- ============ HERO ============ --}}
<section class="relative bg-[#0A2540] text-white pt-32 pb-16 sm:pt-40 sm:pb-24 overflow-hidden z-20">
    <div class="relative max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 text-center md:text-left">
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold leading-tight max-w-3xl">
            News &amp; Announcements
        </h1>
        <p class="mt-5 text-base sm:text-lg text-white/70 max-w-2xl leading-relaxed mx-auto md:mx-0">
            Latest information about operations, services, and activities at Patimban International Car Terminal.
        </p>
    </div>
</section>

{{-- ============ STACKED CARDS ============ --}}
<section class="news-scroll-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 mb-8">
        @auth
            <div class="flex justify-end mb-6 relative z-20">
                <a href="{{ route('admin.news.index') }}"
                   class="inline-flex items-center gap-2 bg-[#0A2540] hover:bg-[#0A2540]/90 text-white text-sm font-semibold px-5 py-2.5 rounded-lg shadow-sm transition-colors">
                    Manage News
                </a>
            </div>
        @endauth
    </div>

    @if($newsList->count() > 0)
        <div class="news-stack-container">
            @foreach($newsList as $index => $item)
                <article class="news-card-sticky" style="--stack-top: calc(12vh + {{ $index * 14 }}px);">

                    <div class="news-card-content">
                        @if(!empty($item->category))
                            <div class="news-card-tag">
                                <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                {{ $item->category }}
                            </div>
                        @endif

                        @if($item->published_at)
                            <time datetime="{{ $item->published_at->toDateString() }}" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">
                                {{ $item->published_at->translatedFormat('d F Y') }}
                            </time>
                        @endif

                        <h2 class="news-card-title">{{ $item->title }}</h2>
                        <p class="news-card-excerpt">{{ $item->excerpt }}</p>

                        <a href="{{ route('news.show', $item->slug) }}" class="news-card-btn">
                            Read Full Article
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>

                    <div class="news-card-image">
                        @if($item->image_url)
                            <img src="{{ $item->image_url }}" alt="{{ $item->title }}" loading="{{ $index === 0 ? 'eager' : 'lazy' }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-slate-200 text-slate-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                    </div>

                </article>
            @endforeach
        </div>

        <div class="mt-14 flex justify-center relative z-20">
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
    // Bersihkan listener lama (penting saat navigasi Swup bolak-balik)
    if (window.__newsStackCleanup) window.__newsStackCleanup();

    const cards = Array.from(document.querySelectorAll('.news-card-sticky'));
    if (!cards.length) return;

    const desktop = window.matchMedia('(min-width: 1024px)');
    let ticking = false;

    function update() {
        ticking = false;

        cards.forEach((card, i) => {
            const next = cards[i + 1];

            // Mobile atau kartu terakhir: tanpa efek
            if (!desktop.matches || !next) {
                card.style.transform = '';
                return;
            }

            // 0 = kartu berikutnya baru muncul di bawah layar
            // 1 = kartu berikutnya sudah menempel menutupi kartu ini
            const nextStuckTop = parseFloat(getComputedStyle(next).top) || 0;
            const nextTop = next.getBoundingClientRect().top;
            const vh = window.innerHeight;

            const progress = Math.min(1, Math.max(0, (vh - nextTop) / (vh - nextStuckTop)));

            // Hanya scale (tanpa opacity) supaya kartu di belakang tidak tembus pandang
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