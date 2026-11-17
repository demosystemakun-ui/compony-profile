@extends('layouts.app')

@section('title', 'About PICT | PT Patimban International Car Terminal')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    /* Scoped to this page so icons, form controls and other components are untouched. */
    .pict-about {
        --pict-red: #ec2029;
        --pict-red-deep: #b91c1c;
        --pict-navy: #0c1c36;
        font-family: 'Plus Jakarta Sans', 'Century Gothic', system-ui, sans-serif;
        color: #0f172a;
        -webkit-font-smoothing: antialiased;
    }

    .pict-about a:focus-visible,
    .pict-about button:focus-visible {
        outline: 2px solid var(--pict-navy);
        outline-offset: 3px;
    }

    .pict-about .on-dark:focus-visible { outline-color: #ffffff; }

    /* Hero: quay line along the bottom edge */
    .pict-about .quay-line {
        height: 6px;
        background: repeating-linear-gradient(90deg, var(--pict-red) 0 56px, transparent 56px 64px);
    }

    /* Capacity bar */
    .pict-about .capacity-track { background: #e2e8f0; }
    .pict-about .capacity-fill { background: var(--pict-red); }

    /* Timeline */
    .pict-about .timeline { position: relative; }
    .pict-about .timeline::before {
        content: '';
        position: absolute;
        left: 7px;
        top: 8px;
        bottom: 8px;
        width: 2px;
        background: #cbd5e1;
    }
    .pict-about .timeline-dot {
        position: absolute;
        left: 0;
        top: 6px;
        width: 16px;
        height: 16px;
        border-radius: 9999px;
        background: var(--pict-navy);
        box-shadow: 0 0 0 4px #f8fafc;
    }
    .pict-about .timeline-dot.is-open {
        background: #f8fafc;
        border: 2px solid var(--pict-red);
    }

    /* Ownership chart */
    .pict-about .pie-segment {
        transition: stroke-width 0.2s ease, opacity 0.2s ease;
    }
    .pict-about .pie-segment.is-active { stroke-width: 7.5; }
    .pict-about #ownershipChart.has-active .pie-segment:not(.is-active) { opacity: 0.25; }

    /* Shareholder rows */
    .pict-about .shareholder-row {
        position: relative;
        transition: background-color 0.2s ease;
    }
    .pict-about .shareholder-row:hover,
    .pict-about .shareholder-row:focus-visible,
    .pict-about .shareholder-row.is-active { background-color: #f1f5f9; }

    .pict-about .shareholder-logo {
        filter: grayscale(1);
        opacity: 0.75;
        transition: filter 0.2s ease, opacity 0.2s ease;
    }
    .pict-about .shareholder-row:hover .shareholder-logo,
    .pict-about .shareholder-row:focus-visible .shareholder-logo,
    .pict-about .shareholder-row.is-active .shareholder-logo {
        filter: grayscale(0);
        opacity: 1;
    }

    .pict-about .share-bar { height: 4px; background: #e2e8f0; }
    .pict-about .share-bar > span { display: block; height: 100%; }

    @media (prefers-reduced-motion: reduce) {
        .pict-about .pie-segment,
        .pict-about .shareholder-row,
        .pict-about .shareholder-logo { transition: none; }
    }
</style>
@endpush

@section('content')
<div class="pict-about">

    {{-- 1. Hero --}}
    <section class="relative isolate overflow-hidden bg-[#0c1c36]">
        <img src="{{ asset('assets/images/background.jpeg') }}"
             alt=""
             width="1920"
             height="1280"
             fetchpriority="high"
             decoding="async"
             class="absolute inset-0 -z-10 h-full w-full object-cover">
        <div class="absolute inset-0 -z-10 bg-gradient-to-t from-[#0c1c36] via-[#0c1c36]/80 to-[#0c1c36]/60"></div>

        <div class="mx-auto flex min-h-[600px] max-w-6xl flex-col justify-end px-6 pb-32 pt-40 sm:px-8 lg:min-h-[680px] lg:pb-40">
            <p class="text-sm font-semibold text-slate-300">Pusakanagara, Subang, West Java</p>

            <h1 class="mt-5 max-w-3xl text-4xl font-extrabold leading-[1.08] tracking-tight text-white sm:text-5xl lg:text-6xl">
                The vehicle terminal at Patimban Port
            </h1>

            <p class="mt-6 max-w-xl text-base leading-relaxed text-slate-200">
                PT Patimban International Car Terminal (PICT) has operated the terminal since December 2021, handling vehicle imports and exports for Indonesia's automotive industry.
            </p>
        </div>

        <div class="quay-line absolute inset-x-0 bottom-0" aria-hidden="true"></div>
    </section>

    {{-- 2. Key figures: overlaps the hero --}}
    {{-- Figures provided with this page. Confirm them against PICT's latest official report before publishing. --}}
    @php
        $facts = [
            ['label' => 'Handling capacity', 'value' => '200,000', 'unit' => 'units/year'],
            ['label' => 'Planned capacity', 'value' => '800,000', 'unit' => 'units/year'],
            ['label' => 'Berth length', 'value' => '300', 'unit' => 'metres'],
            ['label' => 'Distance from Jakarta', 'value' => '120', 'unit' => 'km'],
        ];
    @endphp

    <section class="relative z-10 -mt-20 px-6 sm:px-8 lg:-mt-24">
        <dl class="mx-auto grid max-w-6xl grid-cols-2 overflow-hidden rounded-lg bg-white shadow-xl shadow-slate-900/10 ring-1 ring-slate-200 lg:grid-cols-4">
            @foreach($facts as $fact)
                <div class="border-slate-200 p-6 sm:p-8 {{ $loop->odd ? 'border-r' : '' }} {{ $loop->index < 2 ? 'border-b lg:border-b-0' : '' }} {{ $loop->index < 3 ? 'lg:border-r' : 'lg:border-r-0' }}">
                    <dd class="text-3xl font-extrabold tabular-nums tracking-tight text-slate-900 sm:text-4xl">{{ $fact['value'] }}</dd>
                    <dd class="mt-1 text-xs font-medium text-slate-500">{{ $fact['unit'] }}</dd>
                    <dt class="mt-4 text-sm font-semibold text-slate-700">{{ $fact['label'] }}</dt>
                </div>
            @endforeach
        </dl>
    </section>

    {{-- 3. Company profile --}}
    <section class="bg-white">
        <div class="mx-auto grid max-w-6xl gap-12 px-6 py-20 sm:px-8 lg:grid-cols-12 lg:gap-16 lg:py-28">
            <div class="lg:col-span-5">
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Who we are</h2>

                <div class="mt-10">
                    <div class="flex items-baseline justify-between gap-4">
                        <p class="text-sm font-semibold text-slate-900">Capacity today vs. planned</p>
                        <p class="text-sm font-bold tabular-nums text-[#b91c1c]">25%</p>
                    </div>
                    <div class="capacity-track mt-3 h-3 overflow-hidden rounded-full"
                         role="img"
                         aria-label="Current handling capacity of 200,000 units per year is 25 percent of the planned 800,000 units per year">
                        <div class="capacity-fill h-full rounded-full" style="width: 25%"></div>
                    </div>
                    <div class="mt-2 flex justify-between text-xs tabular-nums text-slate-500">
                        <span>200,000 now</span>
                        <span>800,000 planned</span>
                    </div>
                </div>
            </div>

            <div class="space-y-5 text-base leading-8 text-slate-600 lg:col-span-7 lg:pt-2">
                <p class="text-lg leading-8 text-slate-800">
                    PT Patimban International Car Terminal (PICT) is a vehicle terminal operator at Patimban Port, Pusakanagara, Subang Regency, West Java, about 120 kilometres east of central Jakarta.
                </p>
                <p>
                    The company was established in November 2021 by the Toyota Tsusho Group and began operating the terminal in December 2021.
                </p>
                <p>
                    Patimban Port is a National Strategic Project of the Government of Indonesia, built in phases since 2018 with support from an Official Development Assistance loan. PT Pelabuhan Indonesia (Pelindo) managed the vehicle terminal temporarily until responsibility was transferred to PICT, a company capitalised by a consortium of Japanese enterprises.
                </p>
            </div>
        </div>
    </section>

    {{-- 4. History --}}
    <section class="bg-slate-50">
        <div class="mx-auto max-w-6xl px-6 py-20 sm:px-8 lg:py-28">
            <div class="grid gap-6 lg:grid-cols-12 lg:items-end">
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl lg:col-span-7">History</h2>
                <p class="text-base leading-7 text-slate-600 lg:col-span-5">
                    Patimban Port is a National Strategic Project, built in phases since 2018. PICT has run the vehicle terminal since operations began in December 2021.
                </p>
            </div>

            @php
                $timeline = [
                    [
                        'date'  => '2018',
                        'title' => 'Construction of Patimban Port begins',
                        'desc'  => 'Construction started in phases as a National Strategic Project of the Government of Indonesia, financed through an Official Development Assistance loan.',
                    ],
                    [
                        'date'  => 'November 2021',
                        'title' => 'PICT established',
                        'desc'  => 'PT Patimban International Car Terminal was established by the Toyota Tsusho Group to operate the port\'s vehicle terminal.',
                    ],
                    [
                        'date'  => 'December 2021',
                        'title' => 'Terminal operations begin',
                        'desc'  => 'PICT took over terminal operations from PT Pelabuhan Indonesia (Pelindo), which had managed the facility temporarily.',
                    ],
                    [
                        'date'  => '30 June 2023',
                        'title' => 'Shareholding expanded',
                        'desc'  => 'Toyota Tsusho transferred part of its stake to Toyofuji Shipping, NYK Line and Kamigumi, bringing three specialised shipping and terminal operators into the ownership structure.',
                    ],
                    [
                        'date'  => 'Ongoing',
                        'title' => 'Capacity expansion',
                        'desc'  => 'PICT is expanding terminal facilities as later phases of Patimban Port are completed.',
                    ],
                ];
            @endphp

            <ol class="timeline mt-14 space-y-10">
                @foreach($timeline as $entry)
                    <li class="relative grid gap-2 pl-10 sm:grid-cols-[11rem_1fr] sm:gap-10">
                        <span class="timeline-dot {{ $loop->last ? 'is-open' : '' }}" aria-hidden="true"></span>
                        <p class="text-sm font-bold tabular-nums text-[#b91c1c] sm:pt-1">{{ $entry['date'] }}</p>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">{{ $entry['title'] }}</h3>
                            <p class="mt-1.5 max-w-2xl text-base leading-7 text-slate-600">{{ $entry['desc'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- 5. Shareholders --}}
    <section class="bg-white">
        <div class="mx-auto max-w-6xl px-6 py-20 sm:px-8 lg:py-28">
            <div class="grid gap-6 lg:grid-cols-12 lg:items-end">
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl lg:col-span-7">Shareholders</h2>
                <p class="text-base leading-7 text-slate-600 lg:col-span-5">
                    Four Japanese companies own PICT. Point at a row to see that company's share of the terminal.
                </p>
            </div>

            @php
                $shareholders = [
                    [
                        'id'     => 'toyota',
                        'name'   => 'Toyota Tsusho Corporation',
                        'sector' => 'General trading',
                        'share'  => 34,
                        'color'  => '#0c1c36',
                        'logo'   => 'assets/images/logo-toyota.png',
                        'url'    => 'https://www.toyota-tsusho.com/',
                    ],
                    [
                        'id'     => 'toyofuji',
                        'name'   => 'Toyofuji Shipping Co., Ltd.',
                        'sector' => 'Marine transport',
                        'share'  => 26,
                        'color'  => '#334e7a',
                        'logo'   => 'assets/images/toyofuji-logo.jpg',
                        'url'    => 'https://www.toyofuji.co.jp/en/english/company/company.html',
                    ],
                    [
                        'id'     => 'nyk',
                        'name'   => 'Nippon Yusen Kabushiki Kaisha (NYK Line)',
                        'sector' => 'Global shipping',
                        'share'  => 25,
                        'color'  => '#6f8fbd',
                        'logo'   => 'assets/images/nyk-logo.jpg',
                        'url'    => 'https://www.nyk.com/english/',
                    ],
                    [
                        'id'     => 'kamigumi',
                        'name'   => 'Kamigumi Co., Ltd.',
                        'sector' => 'Port and warehousing',
                        'share'  => 15,
                        'color'  => '#b4c6df',
                        'logo'   => 'assets/images/logo-kamigumi.png',
                        'url'    => 'https://www.kamigumi.co.jp/english/',
                    ],
                ];

                // Donut geometry: circumference of r=15.9155 is 100, so shares map 1:1 to arc length.
                $gap = 0.8;
                $offset = 0;
            @endphp

            <div class="mt-14 grid items-center gap-12 lg:grid-cols-12 lg:gap-16">
                <div class="order-2 lg:order-1 lg:col-span-5">
                    {{-- Decorative: every figure in the chart is also in the list, so the chart is hidden from assistive technology. --}}
                    <div id="ownershipChart" class="relative mx-auto aspect-square w-full max-w-[300px]" aria-hidden="true">
                        <svg viewBox="0 0 42 42" class="h-full w-full -rotate-90">
                            <circle cx="21" cy="21" r="15.9155" fill="transparent" stroke="#e2e8f0" stroke-width="5.5"></circle>
                            @foreach($shareholders as $company)
                                <circle cx="21" cy="21" r="15.9155" fill="transparent"
                                        stroke="{{ $company['color'] }}" stroke-width="5.5"
                                        stroke-dasharray="{{ $company['share'] - $gap }} {{ 100 - $company['share'] + $gap }}"
                                        stroke-dashoffset="{{ -$offset }}"
                                        class="pie-segment" data-segment="{{ $company['id'] }}"></circle>
                                @php $offset += $company['share']; @endphp
                            @endforeach
                        </svg>

                        <div class="pointer-events-none absolute inset-0 flex flex-col items-center justify-center px-10 text-center">
                            <span id="chartLabel" class="text-xs font-semibold text-slate-500">Ownership</span>
                            <span id="chartValue" class="mt-1 text-4xl font-extrabold tabular-nums tracking-tight text-slate-900">100%</span>
                            <span id="chartNote" class="mt-1 text-xs text-slate-500">4 shareholders</span>
                        </div>
                    </div>
                </div>

                <div class="order-1 lg:order-2 lg:col-span-7">
                    <ul id="shareholderList" class="border-t border-slate-200">
                        @foreach($shareholders as $company)
                            <li>
                                <a href="{{ $company['url'] }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="shareholder-row block border-b border-slate-200 px-2 py-5"
                                   data-shareholder="{{ $company['id'] }}"
                                   data-name="{{ $company['name'] }}"
                                   data-share="{{ $company['share'] }}">
                                    <span class="flex items-center gap-4">
                                        <span class="flex h-10 w-16 shrink-0 items-center justify-center">
                                            <img src="{{ asset($company['logo']) }}"
                                                 alt=""
                                                 width="112"
                                                 height="32"
                                                 loading="lazy"
                                                 decoding="async"
                                                 class="shareholder-logo max-h-8 w-auto max-w-full object-contain">
                                        </span>
                                        <span class="min-w-0 flex-1">
                                            <span class="block truncate text-sm font-bold text-slate-900">{{ $company['name'] }}</span>
                                            <span class="block text-xs text-slate-500">{{ $company['sector'] }}</span>
                                        </span>
                                        <span class="shrink-0 text-xl font-extrabold tabular-nums text-slate-900">{{ $company['share'] }}%</span>
                                    </span>
                                    <span class="share-bar mt-3 block rounded-full" aria-hidden="true">
                                        <span class="rounded-full" style="width: {{ $company['share'] }}%; background: {{ $company['color'] }}"></span>
                                    </span>
                                    <span class="sr-only">Opens in a new tab.</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- 6. Contact --}}
    <section class="bg-[#b91c1c] text-white">
        <div class="mx-auto flex max-w-6xl flex-col gap-8 px-6 py-16 sm:px-8 lg:flex-row lg:items-center lg:justify-between lg:py-20">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight sm:text-3xl">Contact the terminal</h2>
                <p class="mt-3 max-w-xl text-base leading-7 text-red-100">
                    Patimban Port, Pusakanagara, Subang Regency, West Java. For terminal services, shipping schedules or a site visit, contact the PICT team.
                </p>
            </div>

            <a href="/contact"
               class="on-dark inline-flex shrink-0 items-center justify-center rounded-md bg-white px-7 py-3.5 text-sm font-bold text-[#b91c1c] transition-colors hover:bg-red-50">
                Contact PICT
            </a>
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const chart = document.getElementById('ownershipChart');
    const list = document.getElementById('shareholderList');
    if (!chart || !list) return;

    const label = document.getElementById('chartLabel');
    const value = document.getElementById('chartValue');
    const note = document.getElementById('chartNote');
    const rows = list.querySelectorAll('[data-shareholder]');
    const segments = chart.querySelectorAll('.pie-segment');

    function show(row) {
        const id = row.dataset.shareholder;

        chart.classList.add('has-active');
        segments.forEach(segment => {
            segment.classList.toggle('is-active', segment.dataset.segment === id);
        });
        rows.forEach(r => r.classList.toggle('is-active', r === row));

        label.textContent = row.dataset.name.replace(/\s*\(.*\)$/, '');
        value.textContent = row.dataset.share + '%';
        note.textContent = 'of PICT';
    }

    function reset() {
        chart.classList.remove('has-active');
        segments.forEach(segment => segment.classList.remove('is-active'));
        rows.forEach(r => r.classList.remove('is-active'));
        label.textContent = 'Ownership';
        value.textContent = '100%';
        note.textContent = '4 shareholders';
    }

    rows.forEach(row => {
        row.addEventListener('pointerenter', () => show(row));
        row.addEventListener('focus', () => show(row));
    });

    list.addEventListener('pointerleave', reset);
    list.addEventListener('focusout', event => {
        if (!list.contains(event.relatedTarget)) reset();
    });
});
</script>
@endpush