@extends('layouts.app')

@section('title', 'About PICT | PT Patimban International Car Terminal')

@push('styles')
<style>
    /*
      Scoped to this page on purpose: a global `*` font rule with !important
      would override icons, form controls and every other component in the app.
    */
    .pict-about {
        --pict-red: #ec2029;
        font-family: 'Century Gothic', 'CenturyGothic', 'Poppins', system-ui, sans-serif;
        color: #0f172a;
    }

    .pict-about a[href] {
        cursor: pointer;
    }

    .pict-about a:focus-visible,
    .pict-about button:focus-visible {
        outline: 2px solid #0f172a;
        outline-offset: 3px;
    }

    .pict-about .on-red:focus-visible {
        outline-color: #ffffff;
    }

    /* Chart: colour encodes share size (darkest = largest), red marks the active row. */
    .pict-about .pie-segment {
        transition: stroke 0.2s ease, stroke-width 0.2s ease, opacity 0.2s ease;
    }

    .pict-about .pie-segment.is-active {
        stroke: var(--pict-red);
        stroke-width: 7;
    }

    .pict-about #ownershipChart.has-active .pie-segment:not(.is-active) {
        opacity: 0.25;
    }

    /* Shareholder rows: neutral until pointed at or focused, so the page keeps one accent. */
    .pict-about .shareholder-row {
        transition: background-color 0.2s ease;
    }

    .pict-about .shareholder-row:hover,
    .pict-about .shareholder-row:focus-visible {
        background-color: #f8fafc;
    }

    .pict-about .shareholder-logo {
        filter: grayscale(1);
        opacity: 0.75;
        transition: filter 0.2s ease, opacity 0.2s ease;
    }

    .pict-about .shareholder-row:hover .shareholder-logo,
    .pict-about .shareholder-row:focus-visible .shareholder-logo {
        filter: grayscale(0);
        opacity: 1;
    }

    @media (prefers-reduced-motion: reduce) {
        .pict-about .pie-segment,
        .pict-about .shareholder-row,
        .pict-about .shareholder-logo {
            transition: none;
        }
    }
</style>
@endpush

@section('content')
<div class="pict-about">

    {{-- 1. Hero --}}
    <section class="relative isolate flex min-h-[560px] items-end overflow-hidden bg-[#0f172a] px-6 pb-16 pt-36 sm:px-10 lg:px-16">
        <img src="{{ asset('assets/images/background.jpeg') }}"
             alt=""
             width="1920"
             height="1280"
             fetchpriority="high"
             decoding="async"
             class="absolute inset-0 -z-10 h-full w-full object-cover">
        <div class="absolute inset-0 -z-10 bg-[#0f172a]/85"></div>

        <div class="mx-auto w-full max-w-6xl">
            <p class="text-sm font-semibold text-slate-200">Pusakanagara, Subang, West Java</p>

            <h1 class="mt-4 max-w-3xl text-4xl font-extrabold leading-[1.05] tracking-tight text-white sm:text-5xl lg:text-6xl">
                The vehicle terminal at
                <span class="underline decoration-[#ec2029] decoration-4 underline-offset-8">Patimban Port</span>
            </h1>

            <p class="mt-7 max-w-xl text-base leading-relaxed text-slate-200">
                PT Patimban International Car Terminal (PICT) has operated the terminal since December 2021, handling vehicle imports and exports for Indonesia's automotive industry.
            </p>
        </div>
    </section>

    {{-- 2. Company profile --}}
    <section class="border-t border-slate-200 bg-white">
        <div class="mx-auto grid max-w-6xl gap-12 px-6 py-16 sm:px-8 sm:py-20 lg:grid-cols-12 lg:gap-16 lg:py-24">
            <div class="lg:col-span-5">
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Who we are</h2>

                {{-- Figures provided with this page. Confirm them against PICT's latest official report before publishing. --}}
                @php
                    $facts = [
                        ['label' => 'Handling capacity', 'value' => '200,000', 'unit' => 'units/year'],
                        ['label' => 'Planned capacity', 'value' => '800,000', 'unit' => 'units/year'],
                        ['label' => 'Berth length', 'value' => '300', 'unit' => 'metres'],
                        ['label' => 'Distance from Jakarta', 'value' => '120', 'unit' => 'km'],
                    ];
                @endphp

                <dl class="mt-10 border-t border-slate-200">
                    @foreach($facts as $fact)
                        <div class="flex items-baseline justify-between gap-6 border-b border-slate-200 py-4">
                            <dt class="text-sm font-medium text-slate-500">{{ $fact['label'] }}</dt>
                            <dd class="text-right text-lg font-bold tabular-nums text-slate-900">
                                {{ $fact['value'] }}
                                <span class="text-xs font-medium text-slate-500">{{ $fact['unit'] }}</span>
                            </dd>
                        </div>
                    @endforeach
                </dl>
            </div>

            <div class="space-y-5 text-[15px] leading-7 text-slate-600 lg:col-span-7 lg:pt-2">
                <p>
                    PT Patimban International Car Terminal (PICT) is a vehicle terminal operator at Patimban Port, Pusakanagara, Subang Regency, West Java, about 120 kilometres east of central Jakarta. The company was established in November 2021 by the Toyota Tsusho Group and began operating the terminal in December 2021.
                </p>
                <p>
                    Patimban Port is a National Strategic Project of the Government of Indonesia, built in phases since 2018 with support from an Official Development Assistance loan. PT Pelabuhan Indonesia (Pelindo) managed the vehicle terminal temporarily until responsibility was transferred to PICT, a company capitalised by a consortium of Japanese enterprises.
                </p>
            </div>
        </div>
    </section>

    {{-- 3. History --}}
    <section class="border-t border-slate-200 bg-slate-50">
        <div class="mx-auto max-w-6xl px-6 py-16 sm:px-8 sm:py-20 lg:py-24">
            <div class="grid gap-6 lg:grid-cols-12 lg:items-end">
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl lg:col-span-7">History</h2>
                <p class="text-[15px] leading-7 text-slate-600 lg:col-span-5">
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

            <ol class="mt-12 border-t border-slate-300">
                @foreach($timeline as $entry)
                    <li class="grid gap-3 border-b border-slate-300 py-6 sm:grid-cols-[10rem_1fr] sm:gap-10">
                        <p class="text-sm font-bold tabular-nums text-[#b91c1c]">{{ $entry['date'] }}</p>
                        <div>
                            <h3 class="text-base font-bold text-slate-900">{{ $entry['title'] }}</h3>
                            <p class="mt-1.5 max-w-2xl text-[15px] leading-7 text-slate-600">{{ $entry['desc'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- 4. Shareholders --}}
    <section class="border-t border-slate-200 bg-white">
        <div class="mx-auto max-w-6xl px-6 py-16 sm:px-8 sm:py-20 lg:py-24">
            <div class="grid gap-6 lg:grid-cols-12 lg:items-end">
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl lg:col-span-7">Shareholders</h2>
                <p class="text-[15px] leading-7 text-slate-600 lg:col-span-5">
                    Four Japanese companies own PICT. Highlight a row to see that company's share of the terminal.
                </p>
            </div>

            <div class="mt-12 grid items-center gap-10 lg:grid-cols-12 lg:gap-16">
                <div class="order-2 lg:order-1 lg:col-span-5">
                    {{-- Decorative: every figure in the chart is also in the list, so the chart is hidden from assistive technology. --}}
                    <div id="ownershipChart" class="relative mx-auto aspect-square w-full max-w-[280px]" aria-hidden="true">
                        <svg viewBox="0 0 42 42" class="h-full w-full -rotate-90">
                            <circle cx="21" cy="21" r="15.9155" fill="transparent" stroke="#0f172a" stroke-width="5.5"
                                    stroke-dasharray="34 66" stroke-dashoffset="0"
                                    class="pie-segment" data-segment="toyota"></circle>
                            <circle cx="21" cy="21" r="15.9155" fill="transparent" stroke="#334155" stroke-width="5.5"
                                    stroke-dasharray="26 74" stroke-dashoffset="-34"
                                    class="pie-segment" data-segment="toyofuji"></circle>
                            <circle cx="21" cy="21" r="15.9155" fill="transparent" stroke="#64748b" stroke-width="5.5"
                                    stroke-dasharray="25 75" stroke-dashoffset="-60"
                                    class="pie-segment" data-segment="nyk"></circle>
                            <circle cx="21" cy="21" r="15.9155" fill="transparent" stroke="#94a3b8" stroke-width="5.5"
                                    stroke-dasharray="15 85" stroke-dashoffset="-85"
                                    class="pie-segment" data-segment="kamigumi"></circle>
                        </svg>

                        <div class="pointer-events-none absolute inset-0 flex flex-col items-center justify-center text-center">
                            <span id="chartLabel" class="text-xs font-semibold text-slate-500">Ownership</span>
                            <span id="chartValue" class="mt-1 text-4xl font-extrabold tabular-nums tracking-tight text-slate-900">100%</span>
                            <span id="chartNote" class="mt-1 text-xs text-slate-500">4 shareholders</span>
                        </div>
                    </div>
                </div>

                <div class="order-1 lg:order-2 lg:col-span-7">
                    @php
                        $shareholders = [
                            [
                                'id'     => 'toyota',
                                'name'   => 'Toyota Tsusho Corporation',
                                'sector' => 'General trading',
                                'share'  => '34%',
                                'logo'   => 'assets/images/logo-toyota.png',
                                'url'    => 'https://www.toyota-tsusho.com/',
                            ],
                            [
                                'id'     => 'toyofuji',
                                'name'   => 'Toyofuji Shipping Co., Ltd.',
                                'sector' => 'Marine transport',
                                'share'  => '26%',
                                'logo'   => 'assets/images/toyofuji-logo.jpg',
                                'url'    => 'https://www.toyofuji.co.jp/en/english/company/company.html',
                            ],
                            [
                                'id'     => 'nyk',
                                'name'   => 'Nippon Yusen Kabushiki Kaisha (NYK Line)',
                                'sector' => 'Global shipping',
                                'share'  => '25%',
                                'logo'   => 'assets/images/nyk-logo.jpg',
                                'url'    => 'https://www.nyk.com/english/',
                            ],
                            [
                                'id'     => 'kamigumi',
                                'name'   => 'Kamigumi Co., Ltd.',
                                'sector' => 'Port and warehousing',
                                'share'  => '15%',
                                'logo'   => 'assets/images/logo-kamigumi.png',
                                'url'    => 'https://www.kamigumi.co.jp/english/',
                            ],
                        ];
                    @endphp

                    <ul id="shareholderList" class="border-t border-slate-200">
                        @foreach($shareholders as $company)
                            <li>
                                <a href="{{ $company['url'] }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="shareholder-row flex items-center gap-4 border-b border-slate-200 px-1 py-4"
                                   data-shareholder="{{ $company['id'] }}">
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
                                    <span class="shrink-0 text-lg font-extrabold tabular-nums text-slate-900">{{ $company['share'] }}</span>
                                    <span class="sr-only">Opens in a new tab.</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- 5. Contact --}}
    <section class="border-t border-[#991b1b] bg-[#b91c1c] text-white">
        <div class="mx-auto flex max-w-6xl flex-col gap-8 px-6 py-14 sm:px-8 lg:flex-row lg:items-center lg:justify-between lg:py-16">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight sm:text-3xl">Contact the terminal</h2>
                <p class="mt-3 max-w-xl text-[15px] leading-7 text-red-100">
                    Patimban Port, Pusakanagara, Subang Regency, West Java. For terminal services, shipping schedules or a site visit, contact the PICT team.
                </p>
            </div>

            <a href="/contact"
               class="on-red inline-flex shrink-0 items-center justify-center rounded-md bg-white px-6 py-3 text-sm font-bold text-[#b91c1c] transition-colors hover:bg-red-50">
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

    const shares = {
        toyota:   { name: 'Toyota Tsusho', share: '34%' },
        toyofuji: { name: 'Toyofuji Shipping', share: '26%' },
        nyk:      { name: 'NYK Line', share: '25%' },
        kamigumi: { name: 'Kamigumi', share: '15%' }
    };

    function show(id) {
        const info = shares[id];
        if (!info) return;

        chart.classList.add('has-active');
        segments.forEach(segment => {
            segment.classList.toggle('is-active', segment.dataset.segment === id);
        });

        label.textContent = info.name;
        value.textContent = info.share;
        note.textContent = 'of PICT';
    }

    function reset() {
        chart.classList.remove('has-active');
        segments.forEach(segment => segment.classList.remove('is-active'));
        label.textContent = 'Ownership';
        value.textContent = '100%';
        note.textContent = '4 shareholders';
    }

    rows.forEach(row => {
        row.addEventListener('mouseenter', () => show(row.dataset.shareholder));
        row.addEventListener('focus', () => show(row.dataset.shareholder));
    });

    list.addEventListener('mouseleave', reset);
    list.addEventListener('focusout', event => {
        if (!list.contains(event.relatedTarget)) reset();
    });
});
</script>
@endpush