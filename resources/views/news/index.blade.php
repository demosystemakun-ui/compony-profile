@extends('layouts.app')

@section('title', 'News & Announcements — PT Patimban International Car Terminal')

@push('styles')
<style>
    /* ═══ STACKED CARDS (OVERLAP EFFECT - CLAY STYLE) ═══ */
    .news-scroll-section {
        background-color: #f8fafc;
        padding-top: 5rem;
        padding-bottom: 10rem;
    }

    .news-stack-container {
        position: relative;
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .news-card-wrapper {
        position: sticky;
        /* Kartu akan menempel 10% dari atas layar */
        top: 15vh; 
        width: 100%;
        height: 70vh; /* Tinggi kartu visual */
        
        /* KUNCI EFEK OVERLAP: Margin negatif sebesar tinggi kartu 
           agar kartu berikutnya langsung berada di belakang kartu sebelumnya */
        margin-bottom: -70vh; 
        
        /* Memberikan ruang kosong terakhir di paling bawah */
        padding-bottom: 70vh; 
        
        display: flex;
        align-items: flex-start;
        justify-content: center;
        
        transform-origin: top center;
        will-change: transform;
    }

    /* Menghapus padding bawah pada wrapper terakhir agar tidak ada ruang kosong ekstra */
    .news-card-wrapper:last-child {
        padding-bottom: 0;
        margin-bottom: 0;
    }

    /* Desain Kartu Utama */
    .news-card {
        width: 100%;
        height: 100%;
        border-radius: 2rem;
        background-color: #ffffff;
        box-shadow: 0 -20px 40px rgba(0,0,0,0.1); /* Shadow ke atas agar terlihat menumpuk */
        border: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        
        /* Transisi halus jika ada penyesuaian */
        transition: transform 0.1s ease-out;
    }

    @media (min-width: 1024px) {
        .news-card {
            flex-direction: row;
            align-items: center;
            padding: 3rem;
            gap: 4rem;
        }
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
        box-shadow: 0 4px 10px rgba(236, 32, 41, 0.2);
    }

    .news-card-title {
        font-size: 2.5rem;
        font-weight: 800;
        line-height: 1.1;
        color: #0f172a;
        margin-bottom: 1.5rem;
        letter-spacing: -0.02em;
    }

    @media (max-width: 768px) {
        .news-card-title { font-size: 2rem; }
    }

    .news-card-excerpt {
        font-size: 1.125rem;
        line-height: 1.6;
        color: #475569;
        margin-bottom: 2rem;
        display: -webkit-box;
        -webkit-line-clamp: 4;
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
            height: 300px;
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

    .news-card-no-image {
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
<section class="relative bg-[#0A2540] text-white pt-32 pb-16 sm:pt-40 sm:pb-24 overflow-hidden z-20">
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

        @if($newsList->count() > 0)
            <div class="flex items-center justify-between pb-4 border-b border-gray-200 relative z-20">
                <p class="text-sm text-gray-500">
                    Showing {{ $newsList->firstItem() }}–{{ $newsList->lastItem() }} of {{ $newsList->total() }} news
                </p>
            </div>
        @endif
    </div>

    @if($newsList->count() > 0)
        <div class="news-stack-container">
            @foreach($newsList as $index => $item)
                {{-- Setiap kartu memiliki wrapper sticky --}}
                <div class="news-card-wrapper" style="z-index: {{ $index + 10 }};">
                    <article class="news-card">
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
                                <div class="news-card-no-image">
                                    <svg class="w-16 h-16 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </article>
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
    const cards = document.querySelectorAll('.news-card');
    const wrappers = document.querySelectorAll('.news-card-wrapper');
    
    function updateStack() {
        // Hanya jalankan efek di Desktop
        if (window.innerWidth < 1024) {
            cards.forEach(card => {
                card.style.transform = 'scale(1)';
                card.style.opacity = '1';
            });
            return;
        }

        const stickyTop = window.innerHeight * 0.15; // 15vh

        wrappers.forEach((wrapper, index) => {
            const card = wrapper.querySelector('.news-card');
            if (!card) return;

            const rect = wrapper.getBoundingClientRect();
            
            // Jika wrapper sudah melewati batas sticky (sedang tertutup)
            if (rect.top <= stickyTop) {
                // Hitung seberapa jauh user telah scroll melewati wrapper ini
                // Gunakan tinggi layar sebagai patokan
                const scrollDistance = stickyTop - rect.top;
                const maxScroll = window.innerHeight * 0.7; 

                // Persentase 0.0 sampai 1.0
                const progress = Math.min(1, Math.max(0, scrollDistance / maxScroll));
                
                // Efek: Kartu yang tertutup mengecil dan meredup perlahan
                const scale = 1 - (progress * 0.1); // Menyusut maksimal 10%
                const opacity = 1 - (progress * 0.5); // Meredup maksimal 50%
                
                card.style.transform = `scale(${scale})`;
                card.style.opacity = opacity;
            } else {
                // Jika belum menempel, kembalikan normal
                card.style.transform = 'scale(1)';
                card.style.opacity = '1';
            }
        });
    }

    // Jalankan saat scroll dan saat load
    window.addEventListener('scroll', updateStack, { passive: true });
    updateStack();
});
</script>
@endpush