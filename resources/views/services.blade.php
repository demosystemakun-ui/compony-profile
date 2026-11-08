@extends('layouts.app')

@section('title', 'Services | PT Patimban International Car Terminal')
@section('meta_description', 'Terminal services at Patimban Port: roll-on/roll-off vessel handling, vehicle discharge, yard staging, inspection, and release through the gate.')

@section('content')

@include('partials.page-header', [
    'index' => '01',
    'eyebrow' => 'Services',
    'title' => 'Terminal services, from berth to gate.',
    'lede' => 'PICT handles roll-on/roll-off vessels and the vehicle movements that follow: discharge, yard staging, inspection, and release through the gate.',
    'image' => 'assets/images/patimban-yard-3.jpeg',
    'alt' => 'Vehicle carrier and staging area at Patimban Port',
    'caption' => 'Vehicle handling area at Patimban Port. Photo: PICT.',
])

<section class="section section--paper">
    <div class="shell">
        <div class="section-head">
            <div>
                <p class="index"><b>02</b><span class="index-rule" aria-hidden="true"></span>Portfolio</p>
                <h2 class="display-l section-head__title">Core terminal services.</h2>
            </div>
            <p class="section-head__aside">
                The service list is maintained by the terminal team, so it reflects what PICT is currently able to handle at Patimban Port.
            </p>
        </div>

        @if ($portfolio->isNotEmpty())
            <div class="card-grid">
                @foreach ($portfolio as $item)
                    <article class="card">
                        @if ($item->image_url)
                            <figure class="card__media">
                                <img src="{{ $item->image_url }}"
                                     alt="{{ $item->title }}"
                                     width="1280"
                                     height="800"
                                     loading="lazy"
                                     decoding="async">
                            </figure>
                        @endif

                        <div class="card__body">
                            @if ($item->tag)
                                <p class="card__kicker">{{ $item->tag }}</p>
                            @endif
                            <h3 class="card__title">{{ $item->title }}</h3>

                            @if ($item->description)
                                <p class="card__text">{{ $item->description }}</p>
                            @endif

                            @if ($item->location)
                                <ul class="tag-list mt-4">
                                    @foreach (explode('|', $item->location) as $feature)
                                        @if (trim($feature))
                                            <li>{{ trim($feature) }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <h3>Service list in preparation</h3>
                <p>The terminal team is updating this page. For a current view of what PICT can handle, contact the commercial desk directly.</p>
                <p class="mt-4"><a class="link" href="{{ url('/contact') }}">Contact the terminal team</a></p>
            </div>
        @endif
    </div>
</section>

<section class="section section--dim">
    <div class="shell">
        <div class="section-head">
            <div>
                <p class="index"><b>03</b><span class="index-rule" aria-hidden="true"></span>Additional handling</p>
                <h2 class="display-l section-head__title">Work requested around the schedule.</h2>
            </div>
            <p class="section-head__aside">
                Value-added work is arranged with the terminal team and fitted around vessel and yard operations.
            </p>
        </div>

        @if ($addOns->isNotEmpty())
            <div>
                @foreach ($addOns as $addon)
                    <article class="split-row">
                        @if ($addon->image_url)
                            <figure class="split-row__media">
                                <img src="{{ $addon->image_url }}"
                                     alt="{{ $addon->title }}"
                                     width="1280"
                                     height="960"
                                     loading="lazy"
                                     decoding="async">
                            </figure>
                        @endif

                        <div class="split-row__body">
                            @if ($addon->tag)
                                <p class="card__kicker">{{ $addon->tag }}</p>
                            @endif
                            <h3 class="split-row__title">{{ $addon->title }}</h3>
                            @if ($addon->description)
                                <p class="split-row__text">{{ $addon->description }}</p>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <h3>Additional services in preparation</h3>
                <p>Pre-delivery inspection, washing, and other requests are coordinated directly with the commercial team.</p>
                <p class="mt-4"><a class="link" href="{{ url('/contact') }}">Ask about additional handling</a></p>
            </div>
        @endif
    </div>
</section>

@include('partials.cta', [
    'index' => '04',
    'eyebrow' => 'Commercial',
    'title' => 'Discuss a terminal service.',
    'copy' => 'For berth schedules, vehicle handling requirements, or pre-delivery work, contact the PICT commercial team.',
    'url' => '/contact',
    'label' => 'Contact PICT',
    'secondaryUrl' => '/our-tariffs',
    'secondaryLabel' => 'View tariffs',
])

@endsection
