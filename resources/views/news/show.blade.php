@extends('layouts.app')

@section('title', $news->title . ' — PT Patimban International Car Terminal')

@section('content')

<section class="bg-white py-24 sm:py-32">
    <div class="max-w-4xl mx-auto px-6 sm:px-8 lg:px-12">

        @if($news->image_url)
            <div class="aspect-[16/9] rounded-2xl overflow-hidden bg-gray-100 ring-1 ring-gray-200 mb-7">
                <img src="{{ $news->image_url }}"
                     alt="{{ $news->title }}"
                     class="w-full h-full object-cover">
            </div>
        @endif

        <h1 class="text-2xl sm:text-4xl font-bold text-[#0A2540] leading-snug mb-2">
            {{ $news->title }}
        </h1>

        @if($news->published_at)
            <div class="text-xs sm:text-sm text-gray-500 pb-6 mb-7 border-b border-gray-200">
                <time datetime="{{ $news->published_at->toDateString() }}">
                    {{ $news->published_at->translatedFormat('F d, Y') }}
                </time>
            </div>
        @endif

        @if($news->excerpt)
            <p class="text-base sm:text-lg font-medium text-gray-700 leading-relaxed mb-5">
                {{ $news->excerpt }}
            </p>
        @endif

        <div class="prose prose-slate max-w-none
                    prose-headings:text-[#0A2540] prose-headings:font-bold
                    prose-a:text-[#0A2540] prose-a:underline
                    prose-img:rounded-xl">
            {!! $news->content !!}
        </div>

    </div>
</section>

@endsection