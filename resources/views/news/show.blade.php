
@extends('layouts.app')

@section('title', $news->title . ' — PT Patimban International Car Terminal')

@section('content')

<section class="bg-slate-50 py-24 sm:py-32">
    <div class="max-w-4xl mx-auto px-6 sm:px-8 lg:px-12">

        {{-- 1. GAMBAR UTAMA DI ATAS --}}
        @if($news->image_url)
            <div class="aspect-[16/9] rounded-2xl overflow-hidden bg-gray-100 shadow-lg ring-1 ring-gray-200/60 mb-8">
                <img src="{{ $news->image_url }}"
                     alt="{{ $news->title }}"
                     class="w-full h-full object-cover">
            </div>
        @endif

        {{-- 2. BREADCRUMB & KATEGORI --}}
        <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
            <nav aria-label="Breadcrumb" class="flex flex-wrap items-center gap-2 text-xs sm:text-sm text-gray-500">
                <a href="{{ url('/') }}" class="hover:text-[#0A2540] font-medium transition-colors">
                    Home
                </a>
                <span>/</span>
                <a href="{{ route('news') }}" class="hover:text-[#0A2540] font-medium transition-colors">
                    News
                </a>
                @if($news->category)
                    <span>/</span>
                    <span class="text-[#0A2540] font-semibold">{{ $news->category }}</span>
                @endif
            </nav>

            @if($news->category)
                <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 border border-red-100 text-xs font-semibold px-2.5 py-1 rounded-md">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                    {{ $news->category }}
                </span>
            @endif
        </div>

        {{-- 3. JUDUL --}}
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-[#0A2540] leading-tight mb-3">
            {{ $news->title }}
        </h1>

        {{-- 4. META PENULIS & TANGGAL --}}
        <div class="flex flex-wrap items-center gap-2 text-xs sm:text-sm text-gray-500 pb-6 mb-8 border-b border-gray-200">
            <span>
                Written by <strong class="font-semibold text-[#0A2540]">{{ $news->updatedBy->name ?? 'Admin' }}</strong>
            </span>
            @if($news->published_at)
                <span>/</span>
                <time datetime="{{ $news->published_at->toDateString() }}"
                      class="uppercase tracking-wider">
                    {{ $news->published_at->translatedFormat('d F Y') }}
                </time>
            @endif
        </div>

        {{-- 5. EXCERPT & KONTEN DI BAWAHNYA --}}
        @if($news->excerpt)
            <p class="text-lg text-gray-600 leading-relaxed font-medium mb-6">
                {{ $news->excerpt }}
            </p>
        @endif

        <div class="prose prose-lg prose-slate max-w-none
                    prose-headings:text-[#0A2540] prose-headings:font-bold
                    prose-a:text-red-700 prose-a:no-underline hover:prose-a:underline
                    prose-img:rounded-xl prose-img:shadow-md">
            {!! $news->content !!}
        </div>

        <div class="mt-12 pt-8 border-t border-gray-200">
            <a href="{{ route('news') }}"
               class="inline-flex items-center gap-1.5 text-sm font-semibold text-gray-500 hover:text-[#0A2540] transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to News List
            </a>
        </div>

    </div>
</section>

@endsection

