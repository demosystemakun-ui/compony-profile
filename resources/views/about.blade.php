@extends('layouts.app')

@section('title', 'About PICT | PT Patimban International Car Terminal')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500..800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    /* Scoped to this page so icons, form controls and other components are untouched. */
    .pict-about {
        --red: #ec2029;
        --red-deep: #c4161c;
        --asphalt: #1c2025;
        --concrete: #eceeef;
        font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
        color: var(--asphalt);
        -webkit-font-smoothing: antialiased;
    }
    .pict-about .display {
        font-family: 'Bricolage Grotesque', 'Plus Jakarta Sans', system-ui, sans-serif;
        letter-spacing: -0.02em;
    }

    .pict-about a:focus-visible { outline: 2px solid var(--asphalt); outline-offset: 3px; }
    .pict-about .on-dark:focus-visible { outline-color: #fff; }

    /* The one slightly tilted thing on the page: a sign board stuck on the hero photo. */
    .pict-about .sign-board { transform: rotate(-2.5deg); }

    /* Ownership bar */
    .pict-about .own-seg {
        transition: background-color 0.2s ease, color 0.2s ease, opacity 0.2s ease;
    }
    .pict-about #ownBar.has-active .own-seg:not(.is-active) { opacity: 0.35; }
    .pict-about .own-seg.is-active { background-color: var(--red) !important; color: #fff !important; }

    .pict-about .own-row { transition: background-color 0.2s ease; }
    .pict-about .own-row:hover,
    .pict-about .own-row:focus-visible,
    .pict-about .own-row.is-active { background-color: #fff; }

    .pict-about .own-logo { filter: grayscale(1); opacity: .7; transition: filter .2s ease, opacity .2s ease; }
    .pict-about .own-row:hover .own-logo,
    .pict-about .own-row:focus-visible .own-logo,
    .pict-about .own-row.is-active .own-logo { filter: none; opacity: 1; }

    @media (prefers-reduced-motion: reduce) {
        .pict-about .own-seg,
        .pict-about .own-row,
        .pict-about .own-logo { transition: none; }
    }
</style>
@endpush

@section('content')
<div class="pict-about">

    {{-- 1. Hero: say what we do, then give the visitor something to do --}}
    <section class="bg-[#1c2025] text-white lg:grid lg:grid-cols-[1.15fr_1fr]">
        <div class="px-6 pb-16 pt-36 sm:px-10 lg:py-44 lg:pl-16 lg:pr-14">
            <h1 class="display max-w-2xl text-5xl font-extrabold leading-[1.02] sm:text-6xl xl:text-7xl">
                A terminal built for one thing: cars.
            </h1>

            <p class="mt-8 max-w-lg text-lg leading-8 text-slate-300">
                PT Patimban International Car Terminal (PICT) runs the vehicle terminal at Patimban Port in Subang, West Java, 120 km east of Jakarta. Since December 2021 we have handled vehicle imports and exports for Indonesia's automotive industry.
            </p>

            <div class="mt-10 flex flex-wrap items-center gap-x-8 gap-y-4">
                <a href="/contact"
                   class="on-dark inline-flex items-center rounded-md bg-[#ec2029] px-6 py-3.5 text-sm font-bold text-white transition-colors hover:bg-[#d41a22]">
                    Talk to the PICT team
                </a>
                <a href="#owners"
                   class="on-dark text-sm font-semibold text-white underline decoration-white/40 underline-offset-4 transition-colors hover:decoration-white">
                    See who owns PICT
                </a>
            </div>
        </div>

        <div class="relative min-h-[340px] lg:min-h-0">
            <img src="{{ asset('assets/images/background.jpeg') }}"
                 alt="Vehicles at the Patimban Port vehicle terminal"
                 width="1920"
                 height="1280"
                 fetchpriority="high"
                 decoding="async"
                 class="absolute inset-0 h-full w-full object-cover">

            <p class="sign-board display absolute bottom-8 left-6 max-w-[15rem] bg-[#ec2029] px-5 py-3 text-lg font-bold leading-tight text-white shadow-lg lg:-left-10 lg:bottom-14">
                Operating since December 2021
            </p>
        </div>
    </section>

    {{-- 2. Capacity: the numbers as a sentence, plus the page's one memorable visual --}}
    {{-- Figures provided with this page. Confirm them against PICT's latest official report before publishing. --}}
    <section class="bg-[#eceeef]">
        <div class="mx-auto max-w-6xl px-6 py-20 sm:px-8 lg:py-28">
            <h2 class="display max-w-4xl text-3xl font-semibold leading-snug sm:text-4xl lg:text-[2.75rem] lg:leading-[1.2]">
                Today the terminal is set up for <strong class="font-extrabold">200,000</strong> vehicles a year, from a <strong class="font-extrabold">300-metre</strong> berth, <strong class="font-extrabold">120 km</strong> from Jakarta. As later phases of the port open, the plan is <strong class="font-extrabold">800,000</strong>.
            </h2>

            {{-- Eight parking bays: two filled (200,000 of 800,000). Text in the figure is also in the caption below. --}}
            <figure class="mt-14">
                <svg viewBox="0 0 800 130" class="block w-full rounded-lg bg-[#1c2025]" role="img"
                     aria-label="Eight parking bays, two of them filled with cars, showing 200,000 units of capacity today out of 800,000 planned">
                    <line x1="0" y1="14" x2="800" y2="14" stroke="#fff" stroke-width="3" opacity=".55"/>
                    @for($i = 0; $i <= 8; $i++)
                        <line x1="{{ $i * 100 }}" y1="14" x2="{{ $i * 100 }}" y2="130"
                              stroke="#fff" stroke-width="3" {{ $i > 2 ? 'stroke-dasharray=10 8 opacity=.4' : 'opacity=.55' }}/>
                    @endfor
                    @for($i = 0; $i < 2; $i++)
                        <g transform="translate({{ $i * 100 }} 0)">
                            <rect x="20" y="34" width="60" height="86" rx="12" fill="#ec2029"/>
                            <rect x="28" y="46" width="44" height="18" rx="4" fill="#1c2025" opacity=".55"/>
                            <rect x="28" y="92" width="44" height="14" rx="4" fill="#1c2025" opacity=".35"/>
                        </g>
                    @endfor
                </svg>
                <figcaption class="mt-4 flex flex-wrap justify-between gap-x-6 gap-y-1 text-sm text-slate-600">
                    <span><strong class="font-bold text-slate-900">200,000</strong> units a year today</span>
                    <span><strong class="font-bold text-slate-900">800,000</strong> units a year planned</span>
                </figcaption>
            </figure>
        </div>
    </section>

    {{-- 3. What you get: plain claims, no cards --}}
    <section class="bg-white">
        <div class="mx-auto grid max-w-6xl gap-10 px-6 py-20 sm:px-8 lg:grid-cols-12 lg:gap-16 lg:py-28">
            <h2 class="display text-3xl font-extrabold sm:text-4xl lg:col-span-4">What you get at Patimban</h2>

            <div class="lg:col-span-8">
                @php
                    $reasons = [
                        ['A car terminal, not a general port.', 'Vehicle imports and exports for Indonesia\'s automotive industry are what PICT does.'],
                        ['Close to Jakarta.', 'The terminal sits in Pusakanagara, Subang Regency, about 120 km east of central Jakarta.'],
                        ['Room to grow.', 'Capacity is planned to rise from 200,000 to 800,000 units a year as later phases of Patimban Port are completed.'],
                        ['Owners who know shipping.', 'Toyota Tsusho, Toyofuji Shipping, NYK Line and Kamigumi, four Japanese companies in trading, shipping and port operations, own PICT.'],
                    ];
                @endphp

                <ul class="divide-y divide-dashed divide-slate-300 border-y border-dashed border-slate-300">
                    @foreach($reasons as [$title, $body])
                        <li class="grid gap-2 py-7 sm:grid-cols-[minmax(0,15rem)_1fr] sm:gap-10">
                            <h3 class="display text-xl font-bold leading-snug">{{ $title }}</h3>
                            <p class="text-base leading-7 text-slate-600">{{ $body }}</p>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    {{-- 4. History: a logbook --}}
    <section class="bg-[#eceeef]">
        <div class="mx-auto grid max-w-6xl gap-10 px-6 py-20 sm:px-8 lg:grid-cols-12 lg:gap-16 lg:py-28">
            <div class="lg:col-span-4">
                <h2 class="display text-3xl font-extrabold sm:text-4xl">How we got here</h2>
                <p class="mt-4 max-w-xs text-base leading-7 text-slate-600">
                    Patimban Port is a National Strategic Project of the Government of Indonesia. PICT came in to run its vehicle terminal.
                </p>
            </div>

            @php
                $log = [
                    ['2018', 'Port construction begins', 'Built in phases, financed through an Official Development Assistance loan.'],
                    ['Nov 2021', 'PICT is established', 'The Toyota Tsusho Group sets up the company to operate the vehicle terminal.'],
                    ['Dec 2021', 'Terminal opens for business', 'PICT takes over from PT Pelabuhan Indonesia (Pelindo), which had managed the facility temporarily.'],
                    ['30 Jun 2023', 'Three new shareholders join', 'Toyota Tsusho transfers part of its stake to Toyofuji Shipping, NYK Line and Kamigumi.'],
                    ['Now', 'Still expanding', 'Terminal facilities grow as later phases of the port are completed.'],
                ];
            @endphp

            <ol class="divide-y divide-dashed divide-slate-400 border-y border-dashed border-slate-400 lg:col-span-8">
                @foreach($log as [$date, $title, $desc])
                    <li class="grid gap-1 py-6 sm:grid-cols-[8rem_1fr] sm:gap-8">
                        <p class="display text-lg font-bold tabular-nums text-[#c4161c]">{{ $date }}</p>
                        <div>
                            <h3 class="text-base font-bold">{{ $title }}</h3>
                            <p class="mt-1 max-w-xl text-base leading-7 text-slate-600">{{ $desc }}</p>
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- 5. Owners --}}
    <section id="owners" class="scroll-mt-8 bg-white">
        <div class="mx-auto max-w-6xl px-6 py-20 sm:px-8 lg:py-28">
            <h2 class="display text-3xl font-extrabold sm:text-4xl">Who owns PICT</h2>
            <p class="mt-4 max-w-md text-base leading-7 text-slate-600">
                Four Japanese companies, one terminal. Point at a name to see its share.
            </p>

            @php
                $owners = [
                    ['id' => 'toyota',   'name' => 'Toyota Tsusho Corporation',                      'sector' => 'General trading',      'share' => 34, 'bg' => '#1c2025', 'fg' => '#ffffff', 'logo' => 'assets/images/logo-toyota.png',    'url' => 'https://www.toyota-tsusho.com/'],
                    ['id' => 'toyofuji', 'name' => 'Toyofuji Shipping Co., Ltd.',                    'sector' => 'Marine transport',     'share' => 26, 'bg' => '#4b5560', 'fg' => '#ffffff', 'logo' => 'assets/images/toyofuji-logo.jpg',  'url' => 'https://www.toyofuji.co.jp/en/english/company/company.html'],
                    ['id' => 'nyk',      'name' => 'Nippon Yusen Kabushiki Kaisha (NYK Line)',       'sector' => 'Global shipping',      'share' => 25, 'bg' => '#9aa3ab', 'fg' => '#1c2025', 'logo' => 'assets/images/nyk-logo.jpg',       'url' => 'https://www.nyk.com/english/'],
                    ['id' => 'kamigumi', 'name' => 'Kamigumi Co., Ltd.',                             'sector' => 'Port and warehousing', 'share' => 15, 'bg' => '#d3d8dc', 'fg' => '#1c2025', 'logo' => 'assets/images/logo-kamigumi.png', 'url' => 'https://www.kamigumi.co.jp/english/'],
                ];
            @endphp

            {{-- Decorative: every figure is also in the list below, so the bar is hidden from assistive technology. --}}
            <div id="ownBar" class="mt-12 flex gap-1.5" aria-hidden="true">
                @foreach($owners as $o)
                    <div class="own-seg display flex h-16 items-end rounded-md px-3 pb-2 text-xl font-extrabold tabular-nums sm:h-20 sm:px-4"
                         style="width: {{ $o['share'] }}%; background: {{ $o['bg'] }}; color: {{ $o['fg'] }}"
                         data-segment="{{ $o['id'] }}">
                        {{ $o['share'] }}%
                    </div>
                @endforeach
            </div>

            <ul id="ownList" class="mt-8 border-t border-dashed border-slate-300">
                @foreach($owners as $o)
                    <li>
                        <a href="{{ $o['url'] }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="own-row flex items-center gap-4 border-b border-dashed border-slate-300 px-2 py-4 sm:gap-6"
                           data-owner="{{ $o['id'] }}">
                            <span class="h-3 w-3 shrink-0 rounded-sm" style="background: {{ $o['bg'] }}" aria-hidden="true"></span>
                            <span class="flex h-10 w-16 shrink-0 items-center justify-center">
                                <img src="{{ asset($o['logo']) }}"
                                     alt=""
                                     width="112"
                                     height="32"
                                     loading="lazy"
                                     decoding="async"
                                     class="own-logo max-h-8 w-auto max-w-full object-contain">
                            </span>
                            <span class="min-w-0 flex-1">
                                <span class="block truncate text-sm font-bold">{{ $o['name'] }}</span>
                                <span class="block text-xs text-slate-500">{{ $o['sector'] }}</span>
                            </span>
                            <span class="display shrink-0 text-xl font-extrabold tabular-nums">{{ $o['share'] }}%</span>
                            <span class="sr-only">Opens in a new tab.</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- 6. Contact: talk like a person --}}
    <section class="bg-[#c4161c] text-white">
        <div class="mx-auto flex max-w-6xl flex-col gap-8 px-6 py-16 sm:px-8 lg:flex-row lg:items-center lg:justify-between lg:py-24">
            <div>
                <h2 class="display max-w-2xl text-3xl font-extrabold leading-tight sm:text-4xl lg:text-5xl">
                    Got vehicles to ship, or want to see the terminal?
                </h2>
                <p class="mt-4 max-w-xl text-base leading-7 text-red-100">
                    Ask the PICT team about terminal services, shipping schedules or a site visit at Patimban Port, Pusakanagara, Subang Regency.
                </p>
            </div>

            <a href="/contact"
               class="on-dark inline-flex shrink-0 items-center justify-center rounded-md bg-white px-7 py-4 text-sm font-bold text-[#c4161c] transition-colors hover:bg-red-50">
                Talk to the PICT team
            </a>
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const bar = document.getElementById('ownBar');
    const list = document.getElementById('ownList');
    if (!bar || !list) return;

    const segments = bar.querySelectorAll('[data-segment]');
    const rows = list.querySelectorAll('[data-owner]');

    function show(id) {
        bar.classList.add('has-active');
        segments.forEach(s => s.classList.toggle('is-active', s.dataset.segment === id));
        rows.forEach(r => r.classList.toggle('is-active', r.dataset.owner === id));
    }

    function reset() {
        bar.classList.remove('has-active');
        segments.forEach(s => s.classList.remove('is-active'));
        rows.forEach(r => r.classList.remove('is-active'));
    }

    rows.forEach(row => {
        row.addEventListener('pointerenter', () => show(row.dataset.owner));
        row.addEventListener('focus', () => show(row.dataset.owner));
    });
    segments.forEach(seg => {
        seg.addEventListener('pointerenter', () => show(seg.dataset.segment));
        seg.addEventListener('pointerleave', reset);
    });

    list.addEventListener('pointerleave', reset);
    list.addEventListener('focusout', e => {
        if (!list.contains(e.relatedTarget)) reset();
    });
});
</script>
@endpush