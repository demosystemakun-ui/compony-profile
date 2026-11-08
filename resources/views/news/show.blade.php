@extends('layouts.app')

@section('title', $news->title . ' | PT Patimban International Car Terminal')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($news->excerpt ?: $news->content), 155))

@section('content')

<article class="article">
    <div class="shell">
        <div class="article__inner">
            <a class="article__back" href="{{ route('news') }}">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5M11 18l-6-6 6-6"/>
                </svg>
                Back to news
            </a>

            <header class="article__head">
                <div class="article__meta">
                    @if ($news->category)
                        <span class="article__category">{{ $news->category }}</span>
                    @endif
                    @if ($news->published_at)
                        <time datetime="{{ $news->published_at->toDateString() }}">
                            {{ $news->published_at->translatedFormat('d F Y') }}
                        </time>
                    @endif
                </div>

                <h1 class="article__title">{{ $news->title }}</h1>
            </header>

            @if ($news->image_url)
                <figure class="article__lead">
                    <img src="{{ $news->image_url }}"
                         alt="{{ $news->title }}"
                         width="1280"
                         height="720"
                         fetchpriority="high"
                         decoding="async">
                </figure>
            @endif

            @if ($news->excerpt)
                <p class="article__excerpt">{{ $news->excerpt }}</p>
            @endif

            <div class="article__body">
                {!! $news->content !!}
            </div>

            <footer class="article__foot">
                <a class="article__back" href="{{ route('news') }}">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5M11 18l-6-6 6-6"/>
                    </svg>
                    Back to news
                </a>
                <a class="link small" href="{{ url('/contact') }}">Contact the terminal team</a>
            </footer>
        </div>
    </div>
</article>

@endsection
