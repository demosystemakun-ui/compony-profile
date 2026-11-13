@extends('layouts.app')

@section('title', 'News & Announcements — PT Patimban International Car Terminal')

@push('styles')
<style>
    /* ═══ STACKED CARDS (WEBFLOW CLAY STYLE) ═══ */
    .news-stack-wrapper {
        position: relative;
        width: 100%;
        /* Padding bawah ekstra untuk ruang scroll terakhir */
        padding-bottom: 10vh; 
    }

    .news-stack-card {
        position: sticky;
        top: 10vh; /* Jarak dari atas layar saat nempel */
        width: 100%;
        max-w: 1200px;
        margin: 0 auto;
        height: 80vh; /* Tinggi setiap kartu */
        border-radius: 2rem;
        background-color: #f8fafc;
        box-shadow: 0 -10px 40px rgba(0,0,0,0.05);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        /* Animasi halus saat JS melakukan scaling */
        transition: transform 0.1s ease-out, opacity 0.1s ease-out;
        transform-origin: top center;
        border: 1px solid #e2e8f0;
    }

    @media (min-width: 1024px) {
        .news-stack-card {
            flex-direction: row;
            align-items: center;
            padding: 3rem;
            gap: 4rem;
        }
    }

    /* Variasi warna background tiap kartu (opsional) */
    .news-stack-card:nth-child(odd) { background-color: #f8fafc; }
    .news-stack-card:nth-child(even) { background-color: #f1f5f9; }

    /* -- KONTEN KIRI (TEKS) -- */
    .news-stack-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 2rem;
    }

    @media (min-width: 1024px) {
        .news-stack-content {
            padding: 0;
            max-width: 500px;
        }
    }

    .news-stack-tag {
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
        box-shadow: 0 4px 10px rgba(236, 32, 41, 0.2);
    }

    .news-stack-title {
        font-size: 2.5rem;
        font-weight: 800;
        line-height: 1.1;
        color: #0f172a;
        margin-bottom: 1.5rem;
        letter-spacing: -0.02em;
    }

    @media (max-width: 768px) {
        .news-stack-title { font-size: 2rem; }
    }

    .news-stack-excerpt {
        font-size: 1.125rem;
        line-height: 1.6;
        color: #475569;
        margin-bottom: 2rem;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .news-stack-btn {
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

    .news-stack-btn:hover {
        background-color: #ec2029;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(236, 32, 41, 0.2);
    }

    /* -- KONTEN KANAN (GAMBAR) -- */
    .news-stack-image-wrapper {
        flex: 1.2;
        width: 100%;
        height: 100%;
        border-radius: 1.5rem;
        overflow: hidden;
        position: relative;
        background-color: #e2e8f0;
    }

    @media (max-width: 1023px) {
        .news-stack-image-wrapper {
            height: 300px;
            order: -1; /* Gambar di atas teks untuk mobile */
            margin-bottom: 1.5rem;
            flex: none;
        }
    }

    .news-stack-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Fallback jika tidak ada gambar */
    .news-stack-no-image {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #cbd5e1 0%, #94a3b8 100%);
        color: #475569;
    }

</style>
@endpush

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

{{-- ============ STACKED CARDS CONTENT ============ --}}
<section class="bg-white pt-10 pb-20 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @auth
            <div class="flex justify-end mb-6">
                <a href="{{ route('admin.news.index') }}"
                   class="inline-flex items-center gap-2 bg-[#0A2540] hover:bg-[#0A2540]/90 text-white text-sm font-semibold px-5 py-2.5 rounded-lg shadow-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Manage News
                </a>
            </div>
        @endauth

        @if($newsList->count() > 0)
            <div class="flex items-center justify-between mb-12 pb-4 border-b border-gray-200">
                <p class="text-sm text-gray-500">
                    Showing
                    <span class="font-semibold text-[#0A2540]">{{ $newsList->firstItem() }}</span>–<span class="font-semibold text-[#0A2540]">{{ $newsList->lastItem() }}</span>
                    of
                    <span class="font-semibold text-[#0A2540]">{{ $newsList->total() }}</span>
                    news
                </p>
            </div>

            {{-- WRAPPER UNTUK EFEK STICKY --}}
            <div class="news-stack-wrapper">
                @foreach($newsList as $index => $item)
                    <article class="news-stack-card" style="top: calc(10vh + {{ $index * 2 }}rem);">
                        {{-- Konten Teks --}}
                        <div class="news-stack-content">
                            @if(!empty($item->category))
                                <div class="news-stack-tag">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                    {{ $item->category }}
                                </div>
                            @endif

                            @if($item->published_at)
                                <time datetime="{{ $item->published_at->toDateString() }}" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">
                                    {{ $item->published_at->translatedFormat('d F Y') }}
                                </time>
                            @endif

                            <h2 class="news-stack-title">
                                {{ $item->title }}
                            </h2>
                            
                            <p class="news-stack-excerpt">
                                {{ $item->excerpt }}
                            </p>

                            <a href="{{ route('news.show', $item->slug) }}" class="news-stack-btn">
                                Read Full Article
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>

                        {{-- Konten Gambar --}}
                        <div class="news-stack-image-wrapper">
                            @if($item->image_url)
                                <img src="{{ $item->image_url }}" alt="{{ $item->title }}" loading="{{ $index === 0 ? 'eager' : 'lazy' }}">
                            @else
                                <div class="news-stack-no-image">
                                    <svg class="w-16 h-16 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-14 flex justify-center relative z-10">
                {{ $newsList->links() }}
            </div>
        @else
            <div class="text-center py-20 bg-slate-50 rounded-2xl border border-gray-200 shadow-sm">
                <h3 class="text-lg font-bold text-gray-700">No News Found</h3>
                <p class="text-sm text-gray-500 mt-1">New news will appear here.</p>
            </div>
        @endif

    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const cards = document.querySelectorAll('.news-stack-card');
    
    function updateStack() {
        // Hanya jalankan efek di Desktop (layar > 1024px)
        if (window.innerWidth < 1024) {
            cards.forEach(card => {
                card.style.transform = 'scale(1)';
                card.style.opacity = '1';
            });
            return;
        }

        cards.forEach((card, index) => {
            // Dapatkan posisi card relatif terhadap viewport
            const rect = card.getBoundingClientRect();
            const cardTop = rect.top;
            
            // Jika card sedang menempel di atas (sticky), hitung seberapa jauh dia tertutup oleh card berikutnya
            if (cardTop <= window.innerHeight * 0.1) { // 10vh adalah jarak sticky
                // Hitung seberapa jauh user telah scroll melewati card ini
                const scrollProgress = Math.max(0, window.innerHeight * 0.1 - cardTop);
                
                // Makin ke bawah, makin kecil ukurannya (efek tertutup)
                // Batas minimal pengecilan adalah 0.9 (90% dari ukuran asli)
                const scale = Math.max(0.9, 1 - (scrollProgress / window.innerHeight) * 0.5);
                const opacity = Math.max(0.5, 1 - (scrollProgress / window.innerHeight) * 1.5);
                
                card.style.transform = `scale(${scale})`;
                card.style.opacity = opacity;
            } else {
                // Jika belum sticky, kembalikan ke ukuran normal
                card.style.transform = 'scale(1)';
                card.style.opacity = '1';
            }
        });
    }

    // Panggil fungsi saat scroll
    window.addEventListener('scroll', updateStack, { passive: true });
    
    // Panggil sekali saat load
    updateStack();
});
</script>
@endpush