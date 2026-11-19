@extends('layouts.app')

@section('title', 'About PICT | PT Patimban International Car Terminal')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    .pict-about {
        --pict-red: #ec2029;
        --pict-red-deep: #b91c1c;
        --pict-navy: #0c1c36;
        --pict-mist: #eef5fb;
        --pict-blush: #fff1f1;
        font-family: 'Plus Jakarta Sans', 'Century Gothic', system-ui, sans-serif;
        color: #0f172a;
        -webkit-font-smoothing: antialiased;
        overflow-x: clip;
    }

    .pict-about a:focus-visible,
    .pict-about button:focus-visible {
        outline: 2px solid var(--pict-navy);
        outline-offset: 3px;
        border-radius: 12px;
    }
    .pict-about .on-dark:focus-visible { outline-color: #ffffff; }

    /* ---------- Gelombang (pemisah antar-section) ---------- */
    .pict-about .wave { display: block; width: 100%; height: 44px; fill: currentColor; }
    @media (min-width: 640px) { .pict-about .wave { height: 76px; } }
    .pict-about .divider { line-height: 0; margin-bottom: -1px; }

    /* Gelombang hero yang bergerak pelan, seperti air di dermaga */
    .pict-about .wave-wrap { position: absolute; inset-inline: 0; bottom: -1px; line-height: 0; overflow: hidden; }
    .pict-about .wave-track { display: flex; width: 200%; }
    .pict-about .wave-track svg { width: 50%; height: 64px; flex: none; }
    @media (min-width: 640px) { .pict-about .wave-track svg { height: 110px; } }
    .pict-about .wave-back  { position: absolute; inset-inline: 0; bottom: 0; animation: drift 26s linear infinite; }
    .pict-about .wave-front { position: relative; animation: drift 38s linear infinite reverse; }
    @keyframes drift { from { transform: translateX(0); } to { transform: translateX(-50%); } }

    /* ---------- Hero: masuk bertahap satu kali ---------- */
    .pict-about .hero-in > * { animation: heroIn .9s cubic-bezier(.22,1,.36,1) both; }
    .pict-about .hero-in > :nth-child(2) { animation-delay: .12s; }
    .pict-about .hero-in > :nth-child(3) { animation-delay: .24s; }
    @keyframes heroIn { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: none; } }

    /* ---------- Gumpalan dekoratif ---------- */
    .pict-about .blob { position: absolute; border-radius: 9999px; filter: blur(2px); pointer-events: none; }

    /* ---------- Kartu angka: bentuk organik & sedikit miring ---------- */
    .pict-about .stat-card {
        transition: transform .35s cubic-bezier(.22,1,.36,1), box-shadow .35s ease;
        box-shadow: 0 18px 40px -18px rgba(12,28,54,.28);
    }
    .pict-about .stat-card:nth-child(1) { border-radius: 2.25rem 1rem 2.25rem 1rem;  background: #fff;                 transform: rotate(-1.5deg); }
    .pict-about .stat-card:nth-child(2) { border-radius: 1rem 2.25rem 1rem 2.25rem;  background: var(--pict-blush);     transform: translateY(10px) rotate(1deg); }
    .pict-about .stat-card:nth-child(3) { border-radius: 2.25rem 2.25rem 1rem 2.25rem; background: #fff;               transform: rotate(1.2deg); }
    .pict-about .stat-card:nth-child(4) { border-radius: 1rem 2.25rem 2.25rem 2.25rem; background: #e3eefb;            transform: translateY(10px) rotate(-1deg); }
    .pict-about .stat-card:hover { transform: translateY(-6px) rotate(0deg); box-shadow: 0 26px 48px -18px rgba(12,28,54,.35); }

    /* ---------- Kapasitas ---------- */
    .pict-about .capacity-track { background: #dbe6f2; }
    .pict-about .capacity-fill {
        background: linear-gradient(90deg, var(--pict-red), #fb7185);
        transform-origin: left;
        animation: capacityGrow 1.4s cubic-bezier(.22,1,.36,1) both;
        position: relative;
    }
    .pict-about .capacity-fill::after {
        content: ''; position: absolute; right: 3px; top: 50%;
        width: 6px; height: 6px; margin-top: -3px; border-radius: 9999px; background: #fff;
    }
    @keyframes capacityGrow { from { transform: scaleX(0); } to { transform: scaleX(1); } }

    /* ---------- Judul section: garis bergelombang ---------- */
    .pict-about .squiggle {
        display: block; margin-top: .75rem; width: 84px; height: 10px;
        background: no-repeat center / contain url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 84 10'%3E%3Cpath d='M2 5 Q12 -1 21 5 T42 5 T63 5 T82 5' fill='none' stroke='%23ec2029' stroke-width='3' stroke-linecap='round'/%3E%3C/svg%3E");
    }

    /* ---------- Timeline berkelok ---------- */
    .pict-about .timeline { position: relative; }
    .pict-about .timeline::before {
        content: ''; position: absolute; left: 7px; top: 8px; bottom: 8px; width: 0;
        border-left: 3px dashed #c4d3e4;
    }
    .pict-about .timeline-dot {
        position: absolute; left: 0; top: 22px; width: 16px; height: 16px;
        border-radius: 9999px; background: var(--pict-red);
        box-shadow: 0 0 0 5px #fff, 0 0 0 7px #fbd5d7;
        transition: transform .25s cubic-bezier(.34,1.56,.64,1);
    }
    .pict-about .timeline li:hover .timeline-dot { transform: scale(1.35); }
    .pict-about .timeline-dot.is-open { background: #fff; border: 3px solid var(--pict-red); animation: pulseDot 2.4s ease-in-out infinite; }
    @keyframes pulseDot {
        0%, 100% { box-shadow: 0 0 0 5px #fff, 0 0 0 8px rgba(236,32,41,.25); }
        50%      { box-shadow: 0 0 0 5px #fff, 0 0 0 13px rgba(236,32,41,.05); }
    }

    .pict-about .timeline-card {
        background: #fff;
        box-shadow: 0 14px 34px -20px rgba(12,28,54,.35);
        transition: transform .35s cubic-bezier(.22,1,.36,1), box-shadow .35s ease;
    }
    .pict-about .timeline-card.shape-a { border-radius: 1.75rem 1.75rem .5rem 1.75rem; }
    .pict-about .timeline-card.shape-b { border-radius: 1.75rem .5rem 1.75rem 1.75rem; }
    .pict-about .timeline-card:hover { transform: translateY(-4px) rotate(0deg); box-shadow: 0 22px 40px -20px rgba(12,28,54,.4); }

    @media (min-width: 768px) {
        .pict-about .timeline::before { left: 50%; margin-left: -1.5px; }
        .pict-about .timeline-dot { left: 50%; margin-left: -8px; }
        .pict-about .timeline li:nth-child(odd)  .timeline-card { transform: rotate(-.8deg); }
        .pict-about .timeline li:nth-child(even) .timeline-card { transform: rotate(.8deg); }
    }

    /* ---------- Grafik kepemilikan ---------- */
    .pict-about .pie-segment { transition: stroke-width .3s cubic-bezier(.34,1.56,.64,1), opacity .25s ease; cursor: pointer; }
    .pict-about .pie-segment.is-active { stroke-width: 8; }
    .pict-about #ownershipChart.has-active .pie-segment:not(.is-active) { opacity: .25; }

    /* ---------- Baris pemegang saham ---------- */
    .pict-about .shareholder-row {
        position: relative;
        background: #fff;
        border-radius: 1.5rem;
        box-shadow: 0 0 0 1px #e2e8f0;
        transition: background-color .25s ease, transform .3s cubic-bezier(.34,1.56,.64,1), box-shadow .25s ease;
    }
    .pict-about .shareholder-row:hover,
    .pict-about .shareholder-row:focus-visible,
    .pict-about .shareholder-row.is-active {
        background-color: #fff;
        transform: translateX(8px);
        box-shadow: 0 0 0 1px #cbd5e1, 0 16px 30px -18px rgba(12,28,54,.4);
    }
    .pict-about .shareholder-logo { filter: grayscale(1); opacity: .7; transition: filter .25s ease, opacity .25s ease, transform .3s cubic-bezier(.34,1.56,.64,1); }
    .pict-about .shareholder-row:hover .shareholder-logo,
    .pict-about .shareholder-row:focus-visible .shareholder-logo,
    .pict-about .shareholder-row.is-active .shareholder-logo { filter: grayscale(0); opacity: 1; transform: scale(1.08); }

    .pict-about .share-bar { height: 6px; background: #e8eef5; overflow: hidden; }
    .pict-about .share-bar > span { display: block; height: 100%; transition: width .6s cubic-bezier(.22,1,.36,1); }

    /* ---------- Tombol ---------- */
    .pict-about .btn-soft { transition: transform .3s cubic-bezier(.34,1.56,.64,1), box-shadow .25s ease, background-color .2s ease; }
    .pict-about .btn-soft:hover { transform: translateY(-3px) scale(1.03); }

    @media (prefers-reduced-motion: reduce) {
        .pict-about *,
        .pict-about *::before,
        .pict-about *::after { transition: none !important; animation: none !important; }
    }
</style>
@endpush

@section('content')
<div class="pict-about">

    {{-- 1. Hero --}}
    <section class="relative isolate overflow-hidden bg-[#0c1c36]">
        <img src="{{ asset('assets/images/background.jpeg') }}"
             alt=""
             width="1920" height="1280"
             fetchpriority="high" decoding="async"
             class="absolute inset-0 -z-10 h-full w-full object-cover">
        <div class="absolute inset-0 -z-10 bg-gradient-to-t from-[#0c1c36] via-[#0c1c36]/80 to-[#0c1c36]/45"></div>

        <div class="blob -z-10 -right-24 top-10 h-72 w-72 bg-[#ec2029]/25 blur-3xl" aria-hidden="true"></div>
        <div class="blob -z-10 -left-20 bottom-24 h-60 w-60 bg-sky-300/20 blur-3xl" aria-hidden="true"></div>

        <div class="hero-in mx-auto flex min-h-[620px] max-w-6xl flex-col justify-end px-6 pb-40 pt-40 sm:px-8 lg:min-h-[700px] lg:pb-48">
            <span class="inline-flex w-fit items-center gap-2 rounded-full bg-white/15 px-4 py-1.5 text-sm font-semibold text-white ring-1 ring-white/25 backdrop-blur">
                <span class="h-2 w-2 rounded-full bg-[#ec2029]"></span>
                Patimban Port, Subang
            </span>

            <h1 class="mt-6 max-w-3xl text-4xl font-extrabold leading-[1.08] tracking-tight text-white sm:text-5xl lg:text-6xl">
                The vehicle terminal at Patimban Port
            </h1>

            <p class="mt-6 max-w-xl text-base leading-relaxed text-slate-100/90">
                PT Patimban International Car Terminal (PICT) has operated the terminal since December 2021, handling vehicle imports and exports for Indonesia's automotive industry.
            </p>
        </div>

        {{-- Dua lapis ombak yang bergerak pelan --}}
        <div class="wave-wrap text-[#eef5fb]" aria-hidden="true">
            <div class="wave-track wave-back opacity-40">
                <svg viewBox="0 0 1440 120" preserveAspectRatio="none"><path fill="currentColor" d="M0 70 Q360 10 720 70 T1440 70 V120 H0Z"/></svg>
                <svg viewBox="0 0 1440 120" preserveAspectRatio="none"><path fill="currentColor" d="M0 70 Q360 10 720 70 T1440 70 V120 H0Z"/></svg>
            </div>
            <div class="wave-track wave-front">
                <svg viewBox="0 0 1440 120" preserveAspectRatio="none"><path fill="currentColor" d="M0 80 Q360 20 720 80 T1440 80 V120 H0Z"/></svg>
                <svg viewBox="0 0 1440 120" preserveAspectRatio="none"><path fill="currentColor" d="M0 80 Q360 20 720 80 T1440 80 V120 H0Z"/></svg>
            </div>
        </div>
    </section>

    {{-- 2. Key figures --}}
    @php
        $facts = [
            ['label' => 'Handling capacity', 'value' => '200,000', 'unit' => 'units/year'],
            ['label' => 'Planned capacity',  'value' => '800,000', 'unit' => 'units/year'],
            ['label' => 'Berth length',      'value' => '300',     'unit' => 'metres'],
            ['label' => 'From Jakarta',      'value' => '120',     'unit' => 'km'],
        ];
    @endphp

    <section class="relative z-10 bg-[#eef5fb] px-6 pb-8 sm:px-8">
        <div class="mx-auto -mt-28 max-w-6xl lg:-mt-32">
            <dl class="grid grid-cols-2 gap-4 sm:gap-6 lg:grid-cols-4">
                @foreach($facts as $fact)
                    <div class="stat-card p-5 sm:p-7">
                        <dt class="text-sm font-semibold text-slate-600">{{ $fact['label'] }}</dt>
                        <dd class="mt-3 text-3xl font-extrabold tabular-nums tracking-tight text-slate-900 sm:text-4xl">{{ $fact['value'] }}</dd>
                        <dd class="mt-1 text-xs font-medium text-slate-500">{{ $fact['unit'] }}</dd>
                    </div>
                @endforeach
            </dl>
        </div>
    </section>

    {{-- 3. Company profile --}}
    <section class="relative bg-[#eef5fb]">
        <div class="blob -left-24 top-24 h-72 w-72 bg-[#ec2029]/10 blur-2xl" aria-hidden="true"></div>

        <div class="relative mx-auto grid max-w-6xl gap-12 px-6 pb-20 pt-14 sm:px-8 lg:grid-cols-12 lg:gap-16 lg:pb-28">
            <div class="lg:col-span-5">
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Who we are</h2>
                <span class="squiggle" aria-hidden="true"></span>

                <div class="mt-10 rounded-[2rem] bg-white p-6 shadow-[0_18px_40px_-22px_rgba(12,28,54,.35)]">
                    <div class="flex items-baseline justify-between gap-4">
                        <p class="text-sm font-semibold text-slate-900">Capacity today vs. planned</p>
                        <p class="rounded-full bg-red-50 px-3 py-1 text-sm font-bold tabular-nums text-[#b91c1c]">25%</p>
                    </div>
                    <div class="capacity-track mt-4 h-4 overflow-hidden rounded-full"
                         role="img"
                         aria-label="Current handling capacity of 200,000 units per year is 25 percent of the planned 800,000 units per year">
                        <div class="capacity-fill h-full rounded-full" style="width: 25%"></div>
                    </div>
                    <div class="mt-3 flex justify-between text-xs tabular-nums text-slate-500">
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

    <div class="divider bg-[#eef5fb] text-white" aria-hidden="true">
        <svg class="wave" viewBox="0 0 1440 80" preserveAspectRatio="none"><path d="M0 40 Q360 -10 720 40 T1440 40 V80 H0Z"/></svg>
    </div>

    {{-- 4. History --}}
    <section class="relative bg-white">
        <div class="mx-auto max-w-6xl px-6 pb-20 pt-10 sm:px-8 lg:pb-28">
            <div class="grid gap-6 lg:grid-cols-12 lg:items-end">
                <div class="lg:col-span-7">
                    <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">History</h2>
                    <span class="squiggle" aria-hidden="true"></span>
                </div>
                <p class="text-base leading-7 text-slate-600 lg:col-span-5">
                    Patimban Port is a National Strategic Project, built in phases since 2018. PICT has run the vehicle terminal since operations began in December 2021.
                </p>
            </div>

            @php
                $timeline = [
                    ['date' => '2018', 'title' => 'Construction of Patimban Port begins', 'desc' => 'Construction started in phases as a National Strategic Project of the Government of Indonesia, financed through an Official Development Assistance loan.'],
                    ['date' => 'November 2021', 'title' => 'PICT established', 'desc' => 'PT Patimban International Car Terminal was established by the Toyota Tsusho Group to operate the port\'s vehicle terminal.'],
                    ['date' => 'December 2021', 'title' => 'Terminal operations begin', 'desc' => 'PICT took over terminal operations from PT Pelabuhan Indonesia (Pelindo), which had managed the facility temporarily.'],
                    ['date' => '30 June 2023', 'title' => 'Shareholding expanded', 'desc' => 'Toyota Tsusho transferred part of its stake to Toyofuji Shipping, NYK Line and Kamigumi, bringing three specialised shipping and terminal operators into the ownership structure.'],
                    ['date' => 'Ongoing', 'title' => 'Capacity expansion', 'desc' => 'PICT is expanding terminal facilities as later phases of Patimban Port are completed.'],
                ];
            @endphp

            <ol class="timeline mt-14 space-y-8 md:space-y-10">
                @foreach($timeline as $entry)
                    <li class="relative pl-10 md:grid md:grid-cols-2 md:gap-20 md:pl-0">
                        <span class="timeline-dot {{ $loop->last ? 'is-open' : '' }}" aria-hidden="true"></span>
                        <div class="{{ $loop->odd ? 'md:col-start-1' : 'md:col-start-2' }}">
                            <div class="timeline-card {{ $loop->odd ? 'shape-a' : 'shape-b' }} p-6 ring-1 ring-slate-100">
                                <p class="inline-block rounded-full bg-red-50 px-3 py-1 text-sm font-bold tabular-nums text-[#b91c1c]">{{ $entry['date'] }}</p>
                                <h3 class="mt-3 text-lg font-bold text-slate-900">{{ $entry['title'] }}</h3>
                                <p class="mt-1.5 text-base leading-7 text-slate-600">{{ $entry['desc'] }}</p>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    <div class="divider bg-white text-[#eef5fb]" aria-hidden="true">
        <svg class="wave" viewBox="0 0 1440 80" preserveAspectRatio="none"><path d="M0 40 Q360 90 720 40 T1440 40 V80 H0Z"/></svg>
    </div>

    {{-- 5. Shareholders --}}
    <section class="relative bg-[#eef5fb]">
        <div class="blob -right-20 top-16 h-64 w-64 bg-[#0c1c36]/5 blur-2xl" aria-hidden="true"></div>

        <div class="relative mx-auto max-w-6xl px-6 pb-20 pt-10 sm:px-8 lg:pb-28">
            <div class="grid gap-6 lg:grid-cols-12 lg:items-end">
                <div class="lg:col-span-7">
                    <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Shareholders</h2>
                    <span class="squiggle" aria-hidden="true"></span>
                </div>
                <p class="text-base leading-7 text-slate-600 lg:col-span-5">
                    Four Japanese companies own PICT. Point at a row to see that company's share of the terminal.
                </p>
            </div>

            @php
                $shareholders = [
                    ['id' => 'toyota',   'name' => 'Toyota Tsusho Corporation',                'sector' => 'General trading',      'share' => 34, 'color' => '#0c1c36', 'logo' => 'assets/images/logo-toyota.png',    'url' => 'https://www.toyota-tsusho.com/'],
                    ['id' => 'toyofuji', 'name' => 'Toyofuji Shipping Co., Ltd.',              'sector' => 'Marine transport',    'share' => 26, 'color' => '#334e7a', 'logo' => 'assets/images/toyofuji-logo.jpg',  'url' => 'https://www.toyofuji.co.jp/en/english/company/company.html'],
                    ['id' => 'nyk',      'name' => 'Nippon Yusen Kabushiki Kaisha (NYK Line)', 'sector' => 'Global shipping',     'share' => 25, 'color' => '#6f8fbd', 'logo' => 'assets/images/nyk-logo.jpg',       'url' => 'https://www.nyk.com/english/'],
                    ['id' => 'kamigumi', 'name' => 'Kamigumi Co., Ltd.',                       'sector' => 'Port and warehousing', 'share' => 15, 'color' => '#b4c6df', 'logo' => 'assets/images/logo-kamigumi.png',  'url' => 'https://www.kamigumi.co.jp/english/'],
                ];
                // Ujung segmen dibulatkan (stroke-linecap: round), jadi panjang garis
                // dikurangi lebar ujung (5.5) + jarak antar-segmen (1.2), dan titik awal digeser setengah ujung.
                $capWidth = 5.5;
                $spacing = 1.2;
                $offset = 0;
            @endphp

            <div class="mt-14 grid items-center gap-12 lg:grid-cols-12 lg:gap-16">
                <div class="order-2 lg:order-1 lg:col-span-5">
                    <div id="ownershipChart" class="relative mx-auto aspect-square w-full max-w-[300px] rounded-full bg-white p-3 shadow-[0_24px_50px_-24px_rgba(12,28,54,.45)]" aria-hidden="true">
                        <svg viewBox="0 0 42 42" class="h-full w-full -rotate-90">
                            <circle cx="21" cy="21" r="15.9155" fill="transparent" stroke="#e8eef5" stroke-width="{{ $capWidth }}"></circle>
                            @foreach($shareholders as $company)
                                @php $dash = $company['share'] - $capWidth - $spacing; @endphp
                                <circle cx="21" cy="21" r="15.9155" fill="transparent"
                                        stroke="{{ $company['color'] }}" stroke-width="{{ $capWidth }}"
                                        stroke-linecap="round"
                                        stroke-dasharray="{{ $dash }} {{ 100 - $dash }}"
                                        stroke-dashoffset="{{ -($offset + $capWidth / 2) }}"
                                        class="pie-segment" data-segment="{{ $company['id'] }}"></circle>
                                @php $offset += $company['share']; @endphp
                            @endforeach
                        </svg>

                        <div class="pointer-events-none absolute inset-0 flex flex-col items-center justify-center px-12 text-center">
                            <span id="chartLabel" class="text-xs font-semibold text-slate-500">Ownership</span>
                            <span id="chartValue" class="mt-1 text-4xl font-extrabold tabular-nums tracking-tight text-slate-900">100%</span>
                            <span id="chartNote" class="mt-1 text-xs text-slate-500">4 shareholders</span>
                        </div>
                    </div>
                </div>

                <div class="order-1 lg:order-2 lg:col-span-7">
                    <ul id="shareholderList" class="space-y-3">
                        @foreach($shareholders as $company)
                            <li>
                                <a href="{{ $company['url'] }}"
                                   target="_blank" rel="noopener noreferrer"
                                   class="shareholder-row block px-4 py-4 sm:px-5"
                                   data-shareholder="{{ $company['id'] }}"
                                   data-name="{{ $company['name'] }}"
                                   data-share="{{ $company['share'] }}">
                                    <span class="flex items-center gap-4">
                                        <span class="flex h-12 w-16 shrink-0 items-center justify-center rounded-2xl bg-slate-50">
                                            <img src="{{ asset($company['logo']) }}"
                                                 alt="" width="112" height="32"
                                                 loading="lazy" decoding="async"
                                                 class="shareholder-logo max-h-8 w-auto max-w-[3rem] object-contain">
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

    <div class="divider bg-[#eef5fb] text-[#b91c1c]" aria-hidden="true">
        <svg class="wave" viewBox="0 0 1440 80" preserveAspectRatio="none"><path d="M0 50 Q360 0 720 50 T1440 50 V80 H0Z"/></svg>
    </div>

    {{-- 6. Contact --}}
    <section class="relative overflow-hidden bg-[#b91c1c] text-white">
        <div class="blob -left-16 -top-10 h-56 w-56 bg-white/10" aria-hidden="true"></div>
        <div class="blob right-10 -bottom-16 h-72 w-72 bg-[#0c1c36]/20" aria-hidden="true"></div>

        <div class="relative mx-auto flex max-w-6xl flex-col gap-8 px-6 pb-16 pt-6 sm:px-8 lg:flex-row lg:items-center lg:justify-between lg:pb-20">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight sm:text-3xl">Contact the terminal</h2>
                <p class="mt-3 max-w-xl text-base leading-7 text-red-100">
                    Patimban Port, Pusakanagara, Subang Regency, West Java. For terminal services, shipping schedules or a site visit, contact the PICT team.
                </p>
            </div>

            <a href="/contact"
               class="on-dark btn-soft inline-flex shrink-0 items-center justify-center gap-2 rounded-full bg-white px-8 py-4 text-sm font-bold text-[#b91c1c] shadow-lg shadow-black/15 hover:bg-red-50">
                Contact PICT
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4" aria-hidden="true">
                    <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
                </svg>
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
        segments.forEach(seg => seg.classList.toggle('is-active', seg.dataset.segment === id));
        rows.forEach(r => r.classList.toggle('is-active', r === row));
        label.textContent = row.dataset.name.replace(/\s*\(.*\)$/, '');
        value.textContent = row.dataset.share + '%';
        note.textContent = 'of PICT';
    }

    function reset() {
        chart.classList.remove('has-active');
        segments.forEach(seg => seg.classList.remove('is-active'));
        rows.forEach(r => r.classList.remove('is-active'));
        label.textContent = 'Ownership';
        value.textContent = '100%';
        note.textContent = '4 shareholders';
    }

    rows.forEach(row => {
        row.addEventListener('pointerenter', () => show(row));
        row.addEventListener('focus', () => show(row));
        row.addEventListener('click', () => show(row));
    });

    list.addEventListener('pointerleave', reset);
    list.addEventListener('focusout', e => {
        if (!list.contains(e.relatedTarget)) reset();
    });

    // Touch: keep selection sticky until tapping elsewhere
    document.addEventListener('pointerdown', e => {
        if (!list.contains(e.target)) reset();
    });
});
</script>
@endpush