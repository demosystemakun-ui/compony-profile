@extends('layouts.app')

@section('title', 'News & Announcements — PT Patimban International Car Terminal')

@push('styles')
<style>
    /* ═══ STACKED CARDS (OVERLAP EFFECT - FINAL FIX) ═══ */
    .news-scroll-section {
        background-color: #f8fafc;
        padding-top: 5rem;
        padding-bottom: 10rem;
    }

    .news-stack-container {
        position: relative;
        width: 100%;
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    /* Pembungkus luar untuk setiap item berita */
    .news-item-wrapper {
        position: relative;
        /* Jarak antar kartu secara natural */
        margin-bottom: 2rem; 
    }

    /* Bagian lengket (sticky) */
    .news-card-sticky {
        position: sticky;
        top: 15vh; /* Jarak dari atas layar */
        width: 100%;
        height: 70vh;
        border-radius: 2rem;
        
        /* Background solid agar benar-benar menutupi kartu di bawahnya */
        background-color: #ffffff;
        box-shadow: 0 -15px 35px rgba(0,0,0,0.08), 0 5px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
        
        display: flex;
        flex-direction: column;
        overflow: hidden;
        transform-origin: top center;
        will-change: transform, opacity;
        
        /* Transisi halus untuk efek JS */
        transition: transform 0.1s ease-out, opacity 0.1s ease-out;
    }

    @media (min-width: 1024px) {
        .news-card-sticky {
            flex-direction: row;
            align-items: center;
            padding: 3rem;
            gap: 3rem;
        }
    }

    /* SPACER: Memberikan ruang scroll tambahan agar kartu berikutnya bisa "naik" */
    .news-item-spacer {
        height: 10vh;
    }

    /* -- KONTEN KIRI (TEKS) -- */
    .news-card-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 2rem;
    }

    @media (min-width: 1024px) {
        .news-card-content {
            padding: 0;
            max-width: 500px;
        }
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

    /* -- KONTEN KANAN (GAMBAR) -- */
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
            margin-bottom: 1.5rem;
            flex: none;
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

{{-- ============ STACKED CARDS CONTENT ============ --}}
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
                {{-- Pembungkus setiap item --}}
                <div class="news-item-wrapper" style="z-index: {{ $index + 10 }};">
                    
                    {{-- Bagian yang menempel (sticky) --}}
                    <article class="news-card-sticky">
                        
                        {{-- Konten Teks --}}
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

                            <h2 class="news-card-title">
                                {{ $item->title }}
                            </h2>
                            
                            <p class="news-card-excerpt">
                                {{ $item->excerpt }}
                            </p>

                            <a href="{{ route('news.show', $item->slug) }}" class="news-card-btn">
                                Read Full Article
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>

                        {{-- Konten Gambar --}}
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
                    
                    {{-- Spacer untuk memberikan jarak scroll --}}
                    <div class="news-item-spacer"></div>
                </div>
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
document.addEventListener('DOMContentLoaded', () => {
    const cards = document.querySelectorAll('.news-card-sticky');
    const wrappers = document.querySelectorAll('.news-item-wrapper');
    
    function updateStack() {
        // Hanya jalankan efek di Desktop (layar > 1024px)
        if (window.innerWidth < 1024) {
            cards.forEach(card => {
                card.style.transform = 'scale(1)';
                card.style.opacity = '1';
            });
            return;
        }

        const stickyTop = window.innerHeight * 0.15; // 15vh

        wrappers.forEach((wrapper, index) => {
            const card = wrapper.querySelector('.news-card-sticky');
            if (!card) return;

            const rect = wrapper.getBoundingClientRect();
            
            // Jika kartu ini sudah "menempel" di posisi stickyTop dan sedang tertutup oleh scroll
            if (rect.top <= stickyTop) {
                // Hitung seberapa jauh user telah scroll melewati pembungkusnya
                // maxScroll adalah tinggi maksimal sebelum kartu benar-benar hilang
                const scrollDistance = stickyTop - rect.top;
                const maxScroll = window.innerHeight * 0.5; 

                // Persentase progress (0.0 sampai 1.0)
                const progress = Math.min(1, Math.max(0, scrollDistance / maxScroll));
                
                // Efek: Kartu menyusut perlahan dan meredup
                const scale = 1 - (progress * 0.15); // Menyusut maksimal 15%
                const opacity = 1 - (progress * 0.6); // Meredup maksimal 60%
                
                card.style.transform = `scale(${scale})`;
                card.style.opacity = opacity;
            } else {
                // Jika belum menempel, kembalikan normal
                card.style.transform = 'scale(1)';
                card.style.opacity = '1';
            }
        });
    }

    window.addEventListener('scroll', updateStack, { passive: true });
    updateStack();
});
</script>
@endpush