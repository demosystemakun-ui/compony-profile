@extends('layouts.app')

@section('content')
<main class="py-12 px-4 max-w-4xl mx-auto">
    <article class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-10">
        
        <div class="flex flex-wrap items-center gap-3 mb-4">
            <span class="bg-blue-600 text-white text-xs font-semibold px-3 py-1 rounded-full">
                {{ $news->category }}
            </span>
            <span class="text-sm text-gray-500 font-medium">
                {{ $news->published_at ? \Carbon\Carbon::parse($news->published_at)->translatedFormat('d F Y') : $news->created_at->translatedFormat('d F Y') }}
            </span>
        </div>

        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#0A2540] mb-6 leading-tight">
            {{ $news->title }}
        </h1>

        @if($news->image)
            <div class="mb-8 h-64 sm:h-96 overflow-hidden rounded-xl bg-gray-50 border border-gray-100 shadow-sm">
                <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
            </div>
        @endif

        @if($news->excerpt)
            <p class="text-base sm:text-lg font-medium text-gray-700 mb-6 italic border-l-4 border-blue-600 pl-4 py-1 leading-relaxed">
                {{ $news->excerpt }}
            </p>
        @endif

        <div class="prose max-w-none text-gray-700 space-y-4 leading-relaxed text-base sm:text-lg">
            {!! nl2br(e($news->content)) !!}
        </div>

        <div class="mt-10 pt-6 border-t border-gray-100 flex items-center justify-between">
            <a href="{{ route('news') }}" class="inline-flex items-center text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to News List
            </a>
        </div>

    </article>
</main>
@endsection