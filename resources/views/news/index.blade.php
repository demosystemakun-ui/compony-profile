@extends('layouts.app')

@section('title', 'News | PT Patimban International Car Terminal')
@section('meta_description', 'Latest information about operations, services, and activities at Patimban International Car Terminal.')

@section('content')

@include('partials.page-header', [
    'index' => '01',
    'eyebrow' => 'Newsroom',
    'title' => 'News and announcements.',
    'lede' => 'Updates from the terminal: operational notices, service changes, and activity at Patimban Port.',
])

<section class="section section--paper">
    <div class="shell">
        @if ($newsList->count() > 0)
            <div class="news-toolbar">
                <p class="small">
                    Showing {{ $newsList->firstItem() }} to {{ $newsList->lastItem() }} of {{ $newsList->total() }}
                </p>

                @auth
                    <a class="link small" href="{{ route('admin.news.index') }}">Manage news</a>
                @endauth
            </div>

            <div class="news-list">
                @foreach ($newsList as $item)
                    <article class="news-item{{ $loop->first ? ' news-item--featured' : '' }}{{ $item->image_url ? '' : ' news-item--no-media' }}">
                        <div>
                            <div class="news-item__meta">
                                @if ($item->category)
                                    <span class="news-item__category">{{ $item->category }}</span>
                                @endif
                                @if ($item->published_at)
                                    <time datetime="{{ $item->published_at->toDateString() }}">
                                        {{ $item->published_at->translatedFormat('d F Y') }}
                                    </time>
                                @endif
                            </div>

                            <h2 class="news-item__title">
                                <a href="{{ route('news.show', $item->slug) }}">{{ $item->title }}</a>
                            </h2>

                            @if ($item->excerpt)
                                <p class="news-item__excerpt">{{ $item->excerpt }}</p>
                            @endif

                            <p class="mt-4">
                                <a class="link small" href="{{ route('news.show', $item->slug) }}">
                                    Read article <span aria-hidden="true">&rarr;</span>
                                </a>
                            </p>
                        </div>

                        @if ($item->image_url)
                            <figure class="news-item__media">
                                <a href="{{ route('news.show', $item->slug) }}">
                                    <img src="{{ $item->image_url }}"
                                         alt="{{ $item->title }}"
                                         width="1280"
                                         height="800"
                                         loading="lazy"
                                         decoding="async">
                                </a>
                            </figure>
                        @endif
                    </article>
                @endforeach
            </div>

            {{ $newsList->links('partials.pagination') }}
        @else
            <div class="empty-state">
                <h3>No news yet</h3>
                <p>Announcements will appear here once they are published. For current operational information, contact the terminal team.</p>
                <p class="mt-4"><a class="link" href="{{ url('/contact') }}">Contact the terminal team</a></p>
            </div>
        @endif
    </div>
</section>

@endsection
