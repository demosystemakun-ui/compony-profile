@extends('layouts.app')

@section('title', 'News & Announcements — PT Patimban International Car Terminal')

@push('styles')
<style>
    /* ═══ WEBFLOW STYLE NEWS LAYOUT ═══ */
    .news-split-layout {
        display: flex;
        flex-direction: column;
        gap: 4rem;
        padding: 4rem 0;
    }

    @media (min-width: 1024px) {
        .news-split-layout {
            flex-direction: row;
            gap: 6rem;
            align-items: flex-start;
        }
    }

    /* Kolom Kiri (Teks) */
    .news-text-col {
        flex: 1;
        position: sticky;
        top: 150px; /* Jarak dari atas layar saat di-scroll */
        max-width: 600px;
    }

    /* Kolom Kanan (Gambar) */
    .news-image-col {
        flex: 1.2;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    /* Kartu Gambar Webflow */
    .news-image-card {
        position: relative;
        border-radius: 2rem;
        overflow: hidden;
        background-color: #e2e8f0;
        box-shadow: 0 20px 40px -10px rgba(15, 23, 42, 0.1);
        aspect-ratio: 4/5; /* Rasio potret memanjang ke bawah */
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease;
    }

    @media (min-width: 1024px) {
        .news-image-card {
            aspect-ratio: 1/1; /* Kotak sempurna di desktop */
            height: 600px;
        }
    }

    .news-image-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 30px 60px -15px rgba(15, 23, 42, 0.15);
    }

    .news-image-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .news-image-card:hover img {
        transform: scale(1.05);
    }

    /* Gradient overlay di gambar */
    .news-image-gradient {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(10, 37, 64, 0.9) 0%, rgba(10, 37, 64, 0) 50%);
        pointer-events: none;
    }

    /* Teks di atas gambar (opsional, untuk judul) */
    .news-image-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 2.5rem;
        color: white;
        z-index: 2;
    }

    /* List Berita di Kolom Kiri */
    .news-list-item {
        display: flex;
        flex-direction: column;
        padding: 1.5rem 0;
        border-bottom: 1px solid #e2e8f0;
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .news-list-item:hover {
        padding-left: 1rem;
        border-bottom-color: #0A2540;
    }

    .news-list-item.active {
        border-bottom-color: #0A2540;
        padding-left: 1rem;
    }

    .news-list-item h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.5rem;
        transition: color 0.3s ease;
    }

    .news-list-item:hover h3,
    .news-list-item.active h3 {
        color: #ec2029;
    }

    .news-list-item p {
        color: #64748b;
        font-size: 0.95rem;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .news-list-item time {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #ec2029;
        margin-bottom: 0.5rem;
    }
    
    /* Mobile: Matikan Sticky */
    @media (max-width: 1023px) {
        .news-text-col {
            position: relative;
            top: 0;
        }
        .news-image-card {
            aspect-ratio: 16/9;
            height: auto;
        }
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

{{-- ============ CONTENT ============ --}}
<section class="bg-white py-10 sm:py-16 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">

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
            <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-200">
                <p class="text-sm text-gray-500">
                    Showing
                    <span class="font-semibold text-[#0A2540]">{{ $newsList->firstItem() }}</span>–<span class="font-semibold text-[#0A2540]">{{ $newsList->lastItem() }}</span>
                    of
                    <span class="font-semibold text-[#0A2540]">{{ $newsList->total() }}</span>
                    news
                </p>
            </div>

            <div class="news-split-layout">
                {{-- KOLOM KIRI: Daftar Teks Berita --}}
                <div class="news-text-col">
                    @foreach($newsList as $index => $item)
                        <a href="{{ route('news.show', $item->slug) }}" 
                           class="news-list-item {{ $index === 0 ? 'active' : '' }}"
                           data-index="{{ $index }}">
                            @if($item->published_at)
                                <time datetime="{{ $item->published_at->toDateString() }}">
                                    {{ $item->published_at->translatedFormat('d F Y') }}
                                </time>
                            @endif
                            <h3>{{ $item->title }}</h3>
                            <p>{{ $item->excerpt }}</p>
                        </a>
                    @endforeach
                </div>

                {{-- KOLOM KANAN: Gambar Besar (Sticky) --}}
                <div class="news-image-col">
                    @foreach($newsList as $index => $item)
                        <div class="news-image-card {{ $index === 0 ? 'block' : 'hidden' }}" data-image-index="{{ $index }}">
                            @if($item->image_url)
                                <img src="{{ $item->image_url }}" alt="{{ $item->title }}">
                            @else
                                <div class="flex items-center justify-center h-full bg-slate-200 text-slate-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="news-image-gradient"></div>
                            <div class="news-image-content">
                                @if(!empty($item->category))
                                    <span class="inline-block bg-[#ec2029] text-white text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-full mb-3 shadow-sm">
                                        {{ $item->category }}
                                    </span>
                                @endif
                                <h4 class="text-2xl sm:text-3xl font-bold leading-tight line-clamp-2">{{ $item->title }}</h4>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-14 flex justify-center">
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
    const listItems = document.querySelectorAll('.news-list-item');
    const imageCards = document.querySelectorAll('.news-image-card');

    // Fungsi untuk mengganti gambar saat kursor menyentuh judul
    listItems.forEach(item => {
        item.addEventListener('mouseenter', () => {
            const index = item.getAttribute('data-index');

            // Hapus kelas 'active' dari semua list
            listItems.forEach(li => li.classList.remove('active'));
            item.classList.add('active');

            // Sembunyikan semua gambar, tampilkan yang dipilih
            imageCards.forEach(card => card.classList.add('hidden'));
            const activeCard = document.querySelector(`.news-image-card[data-image-index="${index}"]`);
            if (activeCard) {
                activeCard.classList.remove('hidden');
            }
        });
    });
});
</script>
@endpush