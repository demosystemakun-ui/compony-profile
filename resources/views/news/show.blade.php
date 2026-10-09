@extends('layouts.app')

@section('title', $news->title . ' — PT Patimban International Car Terminal')

@section('content')

<section class="bg-slate-50 py-24 sm:py-32">
    <div class="max-w-4xl mx-auto px-6 sm:px-8 lg:px-12">

        {{-- Tombol kembali --}}
        <a href="{{ route('news.index') }}"
           class="inline-flex items-center gap-1.5 text-sm font-semibold text-gray-500 hover:text-[#0A2540] transition-colors mb-8">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Berita
        </a>

        {{-- Kategori & tanggal --}}
        <div class="flex flex-wrap items-center gap-3 mb-5">
            @if($news->category)
                <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 border border-red-100 text-xs font-semibold px-2.5 py-1 rounded-md">
                    {{ $news->category }}
                </span>
            @endif
            @if($news->published_at)
                <time datetime="{{ $news->published_at->toDateString() }}"
                      class="text-xs text-gray-500 uppercase tracking-wider">
                    {{ $news->published_at->translatedFormat('d F Y') }}
                </time>
            @endif
        </div>

        {{-- Judul --}}
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-[#0A2540] leading-tight mb-8">
            {{ $news->title }}
        </h1>

        {{-- Gambar utama --}}
        @if($news->image_url)
            <div class="aspect-[16/9] rounded-2xl overflow-hidden bg-gray-100 shadow-lg ring-1 ring-gray-200/60 mb-10">
                <img src="{{ $news->image_url }}"
                     alt="{{ $news->title }}"
                     class="w-full h-full object-cover">
            </div>
        @endif

        {{-- Excerpt --}}
        @if($news->excerpt)
            <p class="text-lg text-gray-600 leading-relaxed font-medium mb-8 pb-8 border-b border-gray-200">
                {{ $news->excerpt }}
            </p>
        @endif

        {{-- Konten --}}
        <div class="prose prose-lg prose-slate max-w-none
                    prose-headings:text-[#0A2540] prose-headings:font-bold
                    prose-a:text-red-700 prose-a:no-underline hover:prose-a:underline
                    prose-img:rounded-xl prose-img:shadow-md">
            {!! $news->content !!}
        </div>

    </div>
</section>

@endsection