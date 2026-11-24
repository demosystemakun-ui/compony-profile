
@extends('layouts.app')

@section('title', 'Operations — PT Patimban International Car Terminal')

@php
    $steps = [
        ['title' => 'Ship Arrival', 'time' => '1–2 Hours Prior', 'equip' => 'Vessel Traffic Services (VTS)', 'safety' => 'ISPS Code Compliance', 'div' => 'Example Division', 'desc' => 'Coordination with maritime authorities to ensure safe entry into the port limits before docking procedures begin.'],
        ['title' => 'Berthing', 'time' => '45–60 Minutes', 'equip' => 'Tugboats & Mooring Lines', 'safety' => 'Port Safety Clearance', 'div' => 'Example Division', 'desc' => 'Securing the vessel to the terminal dock using specialized tugs and heavy-duty mooring systems.'],
        ['title' => 'Vehicle Inspection', 'time' => '10 Min / Unit', 'equip' => 'Digital Handheld Scanners', 'safety' => 'Zero-Scratch Protocol', 'div' => 'Example Division', 'desc' => 'Pre-discharge visual and digital scanning of units to document condition and ensure zero damage.'],
        ['title' => 'Ro-Ro Discharge', 'time' => '2–4 Hours Total', 'equip' => 'Hydraulic Ramps & Lashing', 'safety' => 'PPE & Traffic Control', 'div' => 'Example Division', 'desc' => 'Safe and systematic driving of vehicles from the vessel decks down the ramps into the initial staging area.'],
        ['title' => 'Yard Management', 'time' => 'Immediate Staging', 'equip' => 'Automated Yard Locator (TMS)', 'safety' => 'Speed Limit 20 km/h', 'div' => 'Example Division', 'desc' => 'Routing and parking units in designated zones utilizing our proprietary Terminal Management System.'],
        ['title' => 'Customs Clearance', 'time' => 'Varies by Shipment', 'equip' => 'E-Customs Portal', 'safety' => 'Regulatory Compliance', 'div' => 'Example Division', 'desc' => 'Submission of required documentation and inspection for customs approval before units can be released for delivery.'],
        ['title' => 'Distribution', 'time' => 'On-Demand Gate Out', 'equip' => 'Car Carriers / Transporters', 'safety' => 'Gate Security Check', 'div' => 'Example Division', 'desc' => 'Loading units onto commercial transporters and finalizing documentation for domestic or international dispatch.'],
    ];

    $yardImages = [
        secure_asset('assets/images/patimban-yard-1.jpeg'),
        secure_asset('assets/images/car.jpeg'),
        secure_asset('assets/images/vessel-5.jpeg'),
        secure_asset('assets/images/car-4.jpeg'),
    ];
@endphp

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    :root {
        --color-navy:   #0A2540;
        --color-steel:  #1D4E74;
        --color-signal: #EC2029;
        --color-mist:   #eef5fb;
        --color-blush:  #fff1f1;
        --color-ink:    #16232E;
        --color-muted:  #5B6672;
        --color-line:   #dbe6f2;
    }

    body {
        font-family: 'Plus Jakarta Sans', 'Century Gothic', system-ui, sans-serif;
        background-color: var(--color-mist);
        color: var(--color-ink);
        -webkit-font-smoothing: antialiased;
    }
    h1, h2, h3, h4, h5, h6, .font-heading { font-family: 'Plus Jakarta Sans', 'Century Gothic', system-ui, sans-serif; }

    /* ═══ KUNCI LAYOUT ═══ */
    #swup, main, section {
        position: relative;
        width: 100%;
        max-width: 100vw;
    }
    .prevent-overflow { overflow: hidden !important; }

    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

    /* ═══ PEMISAH GELOMBANG ═══ */
    .divider { line-height: 0; width: 100%; overflow: hidden; margin-bottom: -1px; }
    .divider svg { display: block; width: 100%; height: 42px; margin-bottom: -2px; fill: currentColor; }
    @media (min-width: 640px) { .divider svg { height: 72px; } }
    .divider + section { position: relative; z-index: 1; }
    .wave.flip { transform: scaleX(-1); }

    /* Gelombang hero bergerak pelan */
    .wave-wrap { position: absolute; inset-inline: 0; bottom: -1px; line-height: 0; color: var(--color-mist); z-index: 5; pointer-events: none; overflow: hidden; }
    .wave-track { display: flex; width: 200%; }
    .wave-track svg { width: 50%; height: 56px; flex: none; }
    @media (min-width: 640px) { .wave-track svg { height: 100px; } }
    .wave-back  { position: absolute; inset-inline: 0; bottom: 0; opacity: .4; animation: drift 26s linear infinite; }
    .wave-front { position: relative; animation: drift 38s linear infinite reverse; }
    @keyframes drift { from { transform: translateX(0); } to { transform: translateX(-50%); } }

    /* Hero */
    .hero-in > * { animation: heroIn .9s cubic-bezier(.22,1,.36,1) both; }
    .hero-in > :nth-child(2) { animation-delay: .12s; }
    .hero-in > :nth-child(3) { animation-delay: .24s; }
    @keyframes heroIn { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: none; } }

    .squiggle {
        display: block; margin-top: .9rem; width: 84px; height: 10px;
        background: no-repeat center / contain url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 84 10'%3E%3Cpath d='M2 5 Q12 -1 21 5 T42 5 T63 5 T82 5' fill='none' stroke='%23ec2029' stroke-width='3' stroke-linecap='round'/%3E%3C/svg%3E");
    }
    .squiggle.center { margin-inline: auto; }

    /* Hero slideshow */
    .hero-slide {
        position: absolute; inset: 0;
        background-size: cover; background-position: center;
        opacity: 0; transition: opacity 1.2s ease-in-out;
    }
    .hero-slide.active { opacity: 1; }

    /* Kartu angka */
    .stat-card {
        transition: transform .35s cubic-bezier(.22,1,.36,1), box-shadow .35s ease;
        box-shadow: 0 18px 40px -18px rgba(10,37,64,.3);
    }
    .stat-card:nth-child(1) { border-radius: 2.25rem 1rem 2.25rem 1rem;       background: #fff;               transform: rotate(-1.5deg); }
    .stat-card:nth-child(2) { border-radius: 1rem 2.25rem 1rem 2.25rem;       background: var(--color-blush); transform: translateY(10px) rotate(1deg); }
    .stat-card:nth-child(3) { border-radius: 2.25rem 2.25rem 1rem 2.25rem;    background: #fff;               transform: rotate(1.2deg); }
    .stat-card:nth-child(4) { border-radius: 1rem 2.25rem 2.25rem 2.25rem;    background: #e3eefb;            transform: translateY(10px) rotate(-1deg); }
    .stat-card:hover { transform: translateY(-6px) rotate(0deg); box-shadow: 0 26px 48px -18px rgba(10,37,64,.4); }

    /* Why PICT */
    .why-icon { transition: transform .4s cubic-bezier(.34,1.56,.64,1); }
    .why-item:hover .why-icon { transform: scale(1.08) rotate(-4deg); }
    .why-item:nth-child(1) .why-icon { border-radius: 2rem 2rem .6rem 2rem;   background: var(--color-blush); }
    .why-item:nth-child(2) .why-icon { border-radius: 2rem .6rem 2rem 2rem;   background: #e3eefb; }
    .why-item:nth-child(3) .why-icon { border-radius: .6rem 2rem 2rem 2rem;   background: #fff4e0; }
    @media (min-width: 768px) { .why-item:nth-child(2) { margin-top: 2.5rem; } }

    /* Flow steps */
    .flow-btn { cursor: pointer; }
    .flow-btn .node-indicator { transition: all .3s cubic-bezier(.34,1.56,.64,1); }
    .flow-btn:hover .node-indicator { transform: scale(1.1); }
    .flow-btn.active .node-indicator {
        background-color: var(--color-signal);
        border-color: var(--color-signal);
        color: white;
        transform: scale(1.12);
        box-shadow: 0 0 0 6px rgba(236, 32, 41, 0.18);
    }
    .flow-btn.active h3 { color: var(--color-signal); }
    .flow-btn.active .arrow-indicator { opacity: 1; transform: translateY(0); }
    .fade-content { animation: fadeInData 0.4s ease-out forwards; }
    @keyframes fadeInData {
        0%   { opacity: 0; transform: translateY(10px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    /* Wadah scroll horizontal */
    #flow-navigation, #news-gallery-slider {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    #flow-navigation { padding-top: .5rem; }

    /* Layanan & kargo */
    .service-card.shape-a { border-radius: 2.75rem 1rem 2.75rem 1rem; }
    .service-card.shape-b { border-radius: 1rem 2.75rem 1rem 2.75rem; }
    @media (min-width: 768px) { .service-card.shape-b { margin-top: 2rem; } }

    .cargo-card {
        background: #fff;
        box-shadow: 0 16px 36px -22px rgba(10,37,64,.4);
        transition: transform .35s cubic-bezier(.22,1,.36,1), box-shadow .35s ease;
    }
    .cargo-card:nth-child(4n+1) { border-radius: 2rem 1rem 2rem 1rem; }
    .cargo-card:nth-child(4n+2) { border-radius: 1rem 2rem 1rem 2rem; }
    .cargo-card:nth-child(4n+3) { border-radius: 2rem 2rem 1rem 2rem; }
    .cargo-card:nth-child(4n)   { border-radius: 1rem 2rem 2rem 2rem; }
    @media (min-width: 1024px) { .cargo-card:nth-child(even) { transform: translateY(14px); } }
    .cargo-card:hover { transform: translateY(-6px); box-shadow: 0 26px 46px -22px rgba(10,37,64,.45); }

    /* Galeri */
    .gallery-card {
        box-shadow: 0 16px 36px -22px rgba(10,37,64,.45);
        transition: transform .35s cubic-bezier(.22,1,.36,1), box-shadow .35s ease;
    }
    .gallery-card:nth-child(odd)  { border-radius: 2rem 2rem .75rem 2rem; }
    .gallery-card:nth-child(even) { border-radius: 2rem .75rem 2rem 2rem; }
    .gallery-card:hover { transform: translateY(-6px); box-shadow: 0 26px 46px -22px rgba(10,37,64,.5); }

    /* Tombol */
    .btn-soft { transition: transform .3s cubic-bezier(.34,1.56,.64,1), background-color .2s ease, border-color .2s ease; }
    .btn-soft:hover { transform: translateY(-3px) scale(1.03); }

    ::-webkit-scrollbar { width: 8px; height: 8px; }
    ::-webkit-scrollbar-track { background: var(--color-mist); }
    ::-webkit-scrollbar-thumb { background: #b8c9dc; border-radius: 9999px; }
    ::-webkit-scrollbar-thumb:hover { background: #93abc6; }

    @media (prefers-reduced-motion: reduce) {
        .hero-in > *, .wave-back, .wave-front, .fade-content { animation: none !important; }
        .stat-card, .why-icon, .cargo-card, .gallery-card, .btn-soft, .flow-btn .node-indicator { transition: none !important; }
    }
</style>
@endpush

@section('content')

{{-- 1. HERO --}}
<section class="relative min-h-[75vh] sm:min-h-[88vh] w-full flex flex-col justify-between bg-slate-900 pt-28 pb-0 prevent-overflow">
    <div id="hero-slideshow" class="absolute inset-0 z-0">
        @foreach([
            secure_asset('assets/images/vessel-1.jpeg'),
            secure_asset('assets/images/patimban-yard-2.jpeg'),
            secure_asset('assets/images/vessel-5.jpeg'),
            secure_asset('assets/images/car-4.jpeg'),
        ] as $index => $img)
            <div class="hero-slide {{ $index === 0 ? 'active' : '' }}" style="background-image: url('{{ $img }}');"></div>
        @endforeach
    </div>

    <div class="absolute inset-0 bg-gradient-to-b from-slate-950/75 via-slate-950/45 to-slate-950/85 z-[1] pointer-events-none"></div>

    <div class="hero-in relative max-w-7xl mx-auto px-5 sm:px-6 z-10 w-full my-auto pt-8 pb-32 sm:pb-48">
        <h1 class="max-w-3xl text-3xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-[1.1] mb-4 sm:mb-6">
            A Ro-Ro terminal built to move vehicles, not just words.
        </h1>
        <p class="text-sm sm:text-lg text-slate-200 leading-relaxed max-w-2xl">
            From vessel arrival to gate-out, every unit that crosses our berth is tracked, inspected, and handled to a zero-scratch standard.
        </p>

        @php
            $credentials = ['Smart Terminal', 'ISO Standards', 'Real-Time Monitoring'];
        @endphp
        <div class="mt-8 flex flex-wrap gap-2.5">
            @foreach($credentials as $cred)
                <span class="inline-flex items-center gap-2 rounded-full bg-white/15 px-4 py-2 text-xs sm:text-sm font-semibold text-white ring-1 ring-white/25 backdrop-blur">
                    <svg viewBox="0 0 16 16" class="w-3.5 h-3.5 text-white/80 flex-shrink-0" aria-hidden="true">
                        <path d="M2 8.5L6 12L14 3" stroke="currentColor" stroke-width="1.8" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    {{ $cred }}
                </span>
            @endforeach
        </div>
    </div>

    <div class="wave-wrap" aria-hidden="true">
        <div class="wave-track wave-back">
            <svg viewBox="0 0 1440 120" preserveAspectRatio="none"><path fill="currentColor" d="M0 70 Q360 10 720 70 T1440 70 V120 H0Z"/></svg>
            <svg viewBox="0 0 1440 120" preserveAspectRatio="none"><path fill="currentColor" d="M0 70 Q360 10 720 70 T1440 70 V120 H0Z"/></svg>
        </div>
        <div class="wave-track wave-front">
            <svg viewBox="0 0 1440 120" preserveAspectRatio="none"><path fill="currentColor" d="M0 80 Q360 20 720 80 T1440 80 V120 H0Z"/></svg>
            <svg viewBox="0 0 1440 120" preserveAspectRatio="none"><path fill="currentColor" d="M0 80 Q360 20 720 80 T1440 80 V120 H0Z"/></svg>
        </div>
    </div>
</section>

{{-- 2. TERMINAL AT A GLANCE --}}
<section class="relative z-20 bg-[#eef5fb] px-5 sm:px-6 pb-14 pt-0">
    @php
        $glanceStats = [
            ['value' => '218', 'label' => 'Thousand units, annual capacity', 'color' => 'navy',   'counter' => true],
            ['value' => '300', 'label' => 'Metres of Ro-Ro berth',            'color' => 'navy',   'counter' => true],
            ['value' => '24/7','label' => 'Continuous operations',            'color' => 'navy',   'counter' => false],
        ];
    @endphp

    <div class="max-w-7xl mx-auto -mt-16 sm:-mt-32 grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
        @foreach($glanceStats as $s)
            <div class="stat-card p-5 sm:p-7">
                <div class="text-3xl sm:text-5xl font-extrabold tracking-tight mb-1
                            {{ $s['color'] === 'signal' ? 'text-[#EC2029]' : 'text-[#0A2540]' }}
                            {{ $s['counter'] ? 'counter' : '' }}"
                     @if($s['counter']) data-target="{{ $s['value'] }}" @endif>
                    {{ $s['counter'] ? '0' : $s['value'] }}
                </div>
                <div class="text-xs sm:text-sm text-[var(--color-muted)]">{{ $s['label'] }}</div>
            </div>
        @endforeach
    </div>
</section>

<div class="divider bg-[#eef5fb] text-[#0f172a]" aria-hidden="true">
    <svg viewBox="0 0 1440 80" preserveAspectRatio="none"><path d="M0 40 Q360 -10 720 40 T1440 40 V80 H0Z"/></svg>
</div>

{{-- 3. LIVE WEATHER & MARINE CONDITIONS --}}
<section class="pt-6 pb-10 sm:pb-16 bg-slate-900 text-white relative">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 relative z-10">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 sm:mb-8 gap-4">
            <div>
                <span class="inline-block rounded-full bg-[#EC2029]/20 px-3 py-1 text-xs font-bold text-red-300 mb-3">
                    Safety &amp; operations
                </span>
                <h2 class="text-xl sm:text-3xl font-extrabold tracking-tight">
                    Patimban Port Marine &amp; Weather Conditions
                </h2>
            </div>
            <div class="flex items-center gap-2.5 bg-slate-800/80 px-4 py-2.5 rounded-full ring-1 ring-slate-700 text-xs text-slate-300">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span id="live-clock" class="font-mono font-medium text-slate-200">Loading time...</span>
            </div>
        </div>

        @php
            $weatherCards = [
                ['id' => 'weather-temp',     'subId' => 'weather-temp-sub',     'label' => 'Temperature',  'default' => '-- °C',    'sub' => 'Patimban Harbor Area',   'iconColor' => 'text-amber-400',   'icon' => 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z'],
                ['id' => 'weather-wind',     'subId' => 'weather-wind-sub',     'label' => 'Wind Speed',   'default' => '-- km/h',  'sub' => 'Checking Wind...',       'iconColor' => 'text-sky-400',     'icon' => 'M14 5l7 7m0 0l-7 7m7-7H3'],
                ['id' => 'weather-humidity', 'subId' => 'weather-humidity-sub', 'label' => 'Humidity',     'default' => '-- %',     'sub' => 'Atmospheric Moisture',   'iconColor' => 'text-blue-400',    'icon' => 'M19 14l-7 7m0 0l-7-7m7 7V3'],
                ['id' => 'berth-status',     'subId' => 'berth-status-sub',     'label' => 'Berth Status', 'default' => 'CHECKING', 'sub' => 'Evaluating Conditions',  'iconColor' => 'text-emerald-400', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'isStatus' => true],
            ];
        @endphp

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-6">
            @foreach($weatherCards as $w)
                <div class="bg-slate-800/60 ring-1 ring-slate-700/70 rounded-[1.75rem] p-4 sm:p-6 backdrop-blur-md">
                    <div class="flex items-center justify-between text-slate-400 mb-2 sm:mb-4">
                        <span class="text-xs sm:text-sm font-semibold">{{ $w['label'] }}</span>
                        <span class="flex h-8 w-8 sm:h-10 sm:w-10 items-center justify-center rounded-full bg-white/5">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 {{ $w['iconColor'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $w['icon'] }}"/>
                            </svg>
                        </span>
                    </div>
                    <p id="{{ $w['id'] }}" class="text-xl sm:text-3xl font-extrabold {{ !empty($w['isStatus']) ? 'text-lg sm:text-2xl text-emerald-400' : 'text-white' }}">
                        {{ $w['default'] }}
                    </p>
                    <p id="{{ $w['subId'] }}" class="text-slate-400 text-[11px] sm:text-xs mt-1">{{ $w['sub'] }}</p>
                </div>
            @endforeach
        </div>

        {{-- Parameter Maritim: Gelombang, Arah Angin, Arus, Arah Arus, Jarak Pandang, Pasang Surut --}}
        <div class="bg-slate-800/45 ring-1 ring-slate-700/70 rounded-[1.5rem] p-4 sm:p-5 mb-8 sm:mb-10 backdrop-blur-md">
            <div class="flex flex-wrap items-center justify-between gap-2 mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-300">
                    Marine &amp; Navigation Parameters
                </span>
                <span id="marine-wave-badge" class="inline-flex items-center rounded-full bg-slate-700/50 text-slate-300 ring-1 ring-slate-600 px-2.5 py-0.5 text-[11px] font-semibold">
                    Checking Sea State...
                </span>
            </div>

            <div class="flex flex-wrap gap-2.5 text-xs">
                <div class="inline-flex items-center gap-2 rounded-full bg-slate-900/80 ring-1 ring-slate-700/80 px-3.5 py-2">
                    <span class="text-slate-400">Wave:</span>
                    <strong id="marine-wave-height" class="font-mono text-white">-- m</strong>
                </div>
                <div class="inline-flex items-center gap-2 rounded-full bg-slate-900/80 ring-1 ring-slate-700/80 px-3.5 py-2">
                    <span class="text-slate-400">Wind Dir:</span>
                    <strong id="marine-wind-dir" class="font-mono text-sky-300">--</strong>
                </div>
                <div class="inline-flex items-center gap-2 rounded-full bg-slate-900/80 ring-1 ring-slate-700/80 px-3.5 py-2">
                    <span class="text-slate-400">Current Speed:</span>
                    <strong id="marine-current-speed" class="font-mono text-white">-- knot</strong>
                </div>
                <div class="inline-flex items-center gap-2 rounded-full bg-slate-900/80 ring-1 ring-slate-700/80 px-3.5 py-2">
                    <span class="text-slate-400">Current Dir:</span>
                    <strong id="marine-current-dir" class="font-mono text-sky-300">--</strong>
                </div>
                <div class="inline-flex items-center gap-2 rounded-full bg-slate-900/80 ring-1 ring-slate-700/80 px-3.5 py-2">
                    <span class="text-slate-400">Visibility:</span>
                    <strong id="marine-visibility" class="font-mono text-white">-- km</strong>
                </div>
                <div class="inline-flex items-center gap-2 rounded-full bg-slate-900/80 ring-1 ring-slate-700/80 px-3.5 py-2">
                    <span class="text-slate-400">Tide (MSL):</span>
                    <strong id="marine-tide-level" class="font-mono text-emerald-300">-- m</strong>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between gap-3 mb-3.5">
            <h3 id="weather-forecast-title" class="text-base sm:text-lg font-bold text-slate-200 tracking-tight">
                Weather Forecast
            </h3>
            <span id="weather-window-badge" class="inline-flex items-center rounded-full bg-slate-800 px-3 py-1 text-[11px] font-semibold text-slate-300 ring-1 ring-slate-700">
                BMKG + Open-Meteo
            </span>
        </div>

        <div id="weather-forecast-container" class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-5 pt-1">
            <div class="col-span-full text-center py-6 text-slate-400 text-xs w-full">Loading forecast data...</div>
        </div>

        <p id="weather-source-label" class="text-[11px] text-slate-400 mt-3">
            Source: BMKG &amp; Open-Meteo — Patimban Port (-6.244, 107.9015). Advisory model data; official port &amp; berth decisions follow port authorities &amp; VTS.
        </p>
    </div>
</section>

<div class="divider bg-[#0f172a] text-white" aria-hidden="true">
    <svg viewBox="0 0 1440 80" preserveAspectRatio="none" class="wave flip"><path d="M0 40 Q360 90 720 40 T1440 40 V80 H0Z"/></svg>
</div>

{{-- 4. WHY PICT --}}
<section class="pt-6 pb-14 sm:pb-20 bg-white relative">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 relative z-10">
        <div class="max-w-2xl mb-10 sm:mb-14">
            <h2 class="text-2xl sm:text-4xl font-extrabold text-[#0A2540] tracking-tight leading-tight">
                Three things a shipping line checks before choosing a terminal
            </h2>
            <span class="squiggle" aria-hidden="true"></span>
            <p class="mt-4 text-[var(--color-muted)] text-sm sm:text-base leading-relaxed">
                Digital visibility, certified safety, and a location that shortens the distance between the factory and the ship.
            </p>
        </div>

        @php
            $whyPict = [
                ['img' => 'smart-icon.png', 'alt' => 'Smart Terminal', 'title' => 'Smart terminal technology', 'desc' => 'A Terminal Management System, automated gate controls, and RFID tracking give operators instant visibility of every vessel and yard position.'],
                ['img' => 'internet-icon.png', 'alt' => 'International Safety', 'title' => 'International safety standard', 'desc' => 'We hold to the ISPS Code and relevant ISO certifications, with safety protocols that protect personnel and cargo on every shift.'],
                ['img' => 'ekskapator-icon.png', 'alt' => 'Efficient Logistics', 'title' => 'Efficient automotive logistics', 'desc' => 'Positioned on the north coast of West Java, close to manufacturing hubs and on direct international shipping routes, cutting turnaround time.'],
            ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 md:gap-12">
            @foreach($whyPict as $item)
                <div class="why-item text-center">
                    <div class="why-icon w-24 h-24 mb-6 mx-auto flex items-center justify-center p-5 relative z-10">
                        <img src="{{ secure_asset('assets/images/' . $item['img']) }}" alt="{{ $item['alt'] }}" class="w-full h-full object-contain">
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-[#0A2540] mb-2">{{ $item['title'] }}</h3>
                    <p class="text-[var(--color-muted)] text-sm leading-relaxed">{{ $item['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<div class="divider bg-white text-[#eef5fb]" aria-hidden="true">
    <svg viewBox="0 0 1440 80" preserveAspectRatio="none"><path d="M0 50 Q360 0 720 50 T1440 50 V80 H0Z"/></svg>
</div>

{{-- 5. TERMINAL OPERATION FLOW --}}
<section id="operations-flow" class="pt-6 pb-14 sm:pb-20 bg-[#eef5fb] relative">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 relative">
        <div class="max-w-2xl mb-10 sm:mb-14">
            <h2 class="text-2xl sm:text-4xl font-extrabold text-[#0A2540] tracking-tight leading-tight">
                Seven stages, from ship arrival to gate-out (examples of stages and timing)
            </h2>
            <span class="squiggle" aria-hidden="true"></span>
            <p class="mt-4 text-[var(--color-muted)] text-sm">
                Select a stage below to explore its timing, equipment, safety standard, and assigned division.
            </p>
        </div>

        {{-- Navigasi tahap: tombol 1–7 --}}
        <div class="relative z-10">
            <svg class="hidden md:block absolute inset-x-0 top-5 -z-10 h-10 w-full pointer-events-none" viewBox="0 0 700 40" preserveAspectRatio="none" aria-hidden="true">
                <path d="M50 12 C100 12 100 28 150 28 S200 12 250 12 S300 28 350 28 S400 12 450 12 S500 28 550 28 S600 12 650 12" fill="none" stroke="#b8c9dc" stroke-width="2.5" stroke-dasharray="6 7" stroke-linecap="round" vector-effect="non-scaling-stroke"/>
            </svg>

            <div id="flow-navigation" role="group" aria-label="Operation stages"
                 class="flex overflow-x-auto md:grid md:grid-cols-7 gap-3 md:gap-2 pb-4 md:pb-0 hide-scrollbar w-full">
                @foreach($steps as $index => $step)
                    <button type="button"
                            class="flow-btn group relative flex flex-col items-center min-w-[100px] md:min-w-0 text-center focus:outline-none focus-visible:ring-2 focus-visible:ring-[#EC2029] rounded-2xl {{ $index % 2 === 1 ? 'md:mt-4' : '' }}"
                            data-index="{{ $index }}"
                            aria-pressed="{{ $index === 0 ? 'true' : 'false' }}">
                        <span class="node-indicator w-11 h-11 md:w-12 md:h-12 rounded-full bg-white border-2 border-slate-200 flex items-center justify-center text-[#0A2540] font-bold text-xs md:text-sm shadow-sm group-hover:border-[#EC2029] group-hover:text-[#EC2029] mb-2.5 relative z-10">
                            0{{ $index + 1 }}
                        </span>
                        <span class="block text-[#0A2540] font-bold text-xs leading-tight group-hover:text-[#EC2029] transition-colors h-8">
                            {{ $step['title'] }}
                        </span>
                        <span class="arrow-indicator opacity-0 transform -translate-y-2 transition-all duration-300 mt-1 text-[#EC2029]" aria-hidden="true">
                            <svg class="w-4 h-4 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                            </svg>
                        </span>
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Panel detail: satu saja, isinya berganti sesuai tahap yang dipilih --}}
        <div class="mt-8 relative">
            <div class="bg-white rounded-[2rem_2rem_2rem_0.75rem] shadow-[0_20px_44px_-24px_rgba(10,37,64,.4)] overflow-hidden">
                <div id="flow-panel" class="p-5 sm:p-8 flex flex-col lg:flex-row gap-5 lg:gap-8 items-center" aria-live="polite">
                    <div class="w-full lg:flex-1 border-b lg:border-b-0 lg:border-r border-slate-100 pb-5 lg:pb-0 lg:pr-8" id="detail-text">
                        <div class="flex items-center gap-3 lg:block">
                            <span class="text-[#EC2029] font-extrabold text-3xl sm:text-4xl opacity-20 lg:mb-1" id="detail-number">01</span>
                            <h3 class="text-lg sm:text-2xl font-bold text-[#0A2540] lg:mb-2" id="detail-title">{{ $steps[0]['title'] }}</h3>
                        </div>
                        <p class="text-[var(--color-muted)] text-sm leading-relaxed mt-2 lg:mt-0" id="detail-desc">{{ $steps[0]['desc'] }}</p>
                    </div>

                    <div class="w-full lg:flex-1 grid grid-cols-2 gap-3" id="detail-fields">
                        @foreach([
                            ['label' => 'Est. time', 'id' => 'detail-time',   'value' => $steps[0]['time'],   'class' => 'text-[#0A2540]', 'bg' => 'bg-slate-50'],
                            ['label' => 'Equipment', 'id' => 'detail-equip',  'value' => $steps[0]['equip'],  'class' => 'text-[#0A2540]', 'bg' => 'bg-sky-50'],
                            ['label' => 'Safety',    'id' => 'detail-safety', 'value' => $steps[0]['safety'], 'class' => 'text-[#EC2029]', 'bg' => 'bg-red-50'],
                            ['label' => 'Division',  'id' => 'detail-div',    'value' => $steps[0]['div'],    'class' => 'text-[#0A2540]', 'bg' => 'bg-slate-50'],
                        ] as $field)
                            <div class="{{ $field['bg'] }} px-4 py-3 rounded-2xl">
                                <span class="block text-xs font-semibold text-slate-500 mb-0.5">{{ $field['label'] }}</span>
                                <span class="block {{ $field['class'] }} text-xs sm:text-sm font-bold" id="{{ $field['id'] }}">{{ $field['value'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="divider bg-[#eef5fb] text-white" aria-hidden="true">
    <svg viewBox="0 0 1440 80" preserveAspectRatio="none" class="wave flip"><path d="M0 40 Q360 -10 720 40 T1440 40 V80 H0Z"/></svg>
</div>

{{-- 6. SERVICES --}}
<section class="pt-6 pb-16 sm:pb-24 bg-white relative">
    <div class="max-w-7xl mx-auto px-5 sm:px-6">
        <div class="max-w-2xl mb-10 sm:mb-14">
            <h2 class="text-2xl sm:text-4xl font-extrabold text-[#0A2540] tracking-tight leading-tight">
                Two capabilities, one terminal
            </h2>
            <span class="squiggle" aria-hidden="true"></span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
            <div class="service-card shape-a group relative h-80 sm:h-[400px] overflow-hidden bg-slate-900 shadow-[0_24px_50px_-26px_rgba(10,37,64,.6)]">
                <div class="absolute inset-0 bg-cover bg-center transform group-hover:scale-105 transition-transform duration-700" style="background-image: url('{{ secure_asset('assets/images/background.jpeg') }}')"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/35 to-transparent"></div>
                <div class="absolute inset-0 p-7 sm:p-9 flex flex-col justify-end">
                    <span class="mb-3 inline-block w-fit rounded-full bg-white/15 px-3 py-1 text-xs font-semibold text-white ring-1 ring-white/25 backdrop-blur">Maritime solutions</span>
                    <h3 class="text-xl sm:text-2xl font-bold text-white mb-2">Ro-Ro vessel handling</h3>
                    <p class="text-slate-200 text-sm max-w-md">Deep-water berth facilities and experienced mooring teams for a fast, safe vessel turnaround.</p>
                </div>
            </div>

            <div class="service-card shape-b group relative h-80 sm:h-[400px] overflow-hidden bg-slate-900 shadow-[0_24px_50px_-26px_rgba(10,37,64,.6)]">
                <div class="absolute inset-0 bg-cover bg-center transform group-hover:scale-105 transition-transform duration-700" id="yard-slideshow" style="background-image: url('{{ $yardImages[0] }}');"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/35 to-transparent"></div>
                <div class="absolute inset-0 p-7 sm:p-9 flex flex-col justify-end">
                    <span class="mb-3 inline-block w-fit rounded-full bg-white/15 px-3 py-1 text-xs font-semibold text-white ring-1 ring-white/25 backdrop-blur">Storage facility</span>
                    <h3 class="text-xl sm:text-2xl font-bold text-white mb-2">Advanced yard management</h3>
                    <p class="text-slate-200 text-sm max-w-md">High-capacity staging yards with automated tracking, surveillance, and weather protection.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="divider bg-white text-[#eef5fb]" aria-hidden="true">
    <svg viewBox="0 0 1440 80" preserveAspectRatio="none"><path d="M0 50 Q360 0 720 50 T1440 50 V80 H0Z"/></svg>
</div>

{{-- 7. VEHICLE CARGO TYPES --}}
<section class="pt-6 pb-20 sm:pb-28 bg-[#eef5fb] relative">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 relative">
        <div class="max-w-2xl mb-10 sm:mb-14">
            <h2 class="text-2xl sm:text-4xl font-extrabold text-[#0A2540] tracking-tight leading-tight">
                Handling protocols by vehicle class
            </h2>
            <span class="squiggle" aria-hidden="true"></span>
        </div>

        @php
            $cargoTypes = [
                ['img' => 'vehicle.png', 'alt' => 'Passenger Vehicle', 'title' => 'Passenger vehicle', 'desc' => 'Sedans, SUVs, MPVs, and electric vehicles handled under scratch-free procedures.', 'tag' => 'Light vehicle', 'tagClass' => 'bg-red-50 text-[#b91c1c]'],
                ['img' => 'bus-truck.png', 'alt' => 'Bus & Truck', 'title' => 'Bus & truck', 'desc' => 'Heavy logistics trucks, industrial chassis, and transport vehicles with reinforced ramp pathways.', 'tag' => 'Commercial', 'tagClass' => 'bg-sky-50 text-[#1D4E74]'],
                ['img' => 'ekskapator.png', 'alt' => 'Heavy Equipment', 'title' => 'Heavy equipment', 'desc' => 'Excavators, wheel loaders, and bulldozers destined for mining and agricultural projects.', 'tag' => 'Project cargo', 'tagClass' => 'bg-red-50 text-[#b91c1c]'],
                ['img' => 'cargo.png', 'alt' => 'General Cargo', 'title' => 'General cargo', 'desc' => 'Static cargo and non-vehicle shipments managed under standard warehousing procedures.', 'tag' => 'General cargo', 'tagClass' => 'bg-sky-50 text-[#1D4E74]'],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
            @foreach($cargoTypes as $item)
                <div class="cargo-card p-6 sm:p-8">
                    <div class="w-16 h-16 mb-5 flex items-center justify-center">
                        <img src="{{ secure_asset('assets/images/' . $item['img']) }}" alt="{{ $item['alt'] }}" class="w-full h-full object-contain">
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-[#0A2540] mb-1.5">{{ $item['title'] }}</h3>
                    <p class="text-[var(--color-muted)] text-sm leading-relaxed mb-4">{{ $item['desc'] }}</p>
                    <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold {{ $item['tagClass'] }}">{{ $item['tag'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>

<div class="divider bg-[#eef5fb] text-white" aria-hidden="true">
    <svg viewBox="0 0 1440 80" preserveAspectRatio="none" class="wave flip"><path d="M0 40 Q360 90 720 40 T1440 40 V80 H0Z"/></svg>
</div>

{{-- 8. GALLERY --}}
<section id="gallery" class="pt-6 pb-14 sm:pb-20 bg-white relative">
    <div class="max-w-7xl mx-auto px-5 sm:px-6">
        <div class="mb-8">
            <h2 class="text-2xl sm:text-4xl font-extrabold text-[#0A2540] tracking-tight">
                Inside the terminal
            </h2>
            <span class="squiggle" aria-hidden="true"></span>
        </div>

        <div id="news-gallery-slider" class="flex items-stretch gap-4 sm:gap-6 overflow-x-auto px-1 pb-8 pt-3 snap-x hide-scrollbar w-full max-w-full">
            @forelse($galleries as $index => $item)
                <div class="gallery-card group relative bg-white ring-1 ring-slate-100 overflow-hidden min-w-[300px] sm:min-w-[360px] max-w-[360px] flex-shrink-0 snap-start flex flex-col cursor-pointer" onclick="pauseAutoSlideAndFocus({{ $index }})">
                    <div class="relative h-48 sm:h-56 overflow-hidden bg-slate-900">
                        <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="absolute inset-0 w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                        <span class="absolute left-3 top-3 rounded-full bg-[#EC2029] px-3 py-1 text-xs font-semibold text-white shadow">{{ $item->tag }}</span>
                    </div>
                    <div class="p-5 flex flex-col justify-between flex-grow">
                        <div>
                            <h3 class="text-base sm:text-lg font-bold text-[#0A2540] mb-2 group-hover:text-[#EC2029] transition-colors line-clamp-1">{{ $item->title }}</h3>
                            <p class="text-[var(--color-muted)] text-sm leading-relaxed line-clamp-2 mb-4">{{ $item->description }}</p>
                        </div>
                        <div class="space-y-2 pt-3 text-xs text-[var(--color-muted)]">
                            <div class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-[#EC2029] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span class="font-medium text-slate-700">{{ $item->date_info }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-[#1D4E74] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span class="truncate">{{ $item->location }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="w-full text-center py-10 text-slate-400">Belum ada data galeri. Silakan tambahkan melalui Admin Panel.</div>
            @endforelse
        </div>
    </div>
</section>

<div class="divider bg-white text-[#0A2540]" aria-hidden="true">
    <svg viewBox="0 0 1440 80" preserveAspectRatio="none"><path d="M0 50 Q360 0 720 50 T1440 50 V80 H0Z"/></svg>
</div>

{{-- 9. CALL TO ACTION --}}
<section id="contact" class="pt-6 pb-16 sm:pb-24 relative bg-[#0A2540]">
    <div class="max-w-4xl mx-auto px-5 sm:px-6 text-center relative z-10">
        <h2 class="text-2xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight mb-4 leading-tight">
            Ready to move your cargo through Patimban?
        </h2>
        <span class="squiggle center mb-5" aria-hidden="true"></span>
        <p class="text-slate-300 text-sm sm:text-base max-w-xl mx-auto mb-8">
            Talk to our commercial and operations team about berth reservation, cargo handling, and long-term partnership.
        </p>
        <div class="flex flex-wrap items-center justify-center gap-3.5">
            <a href="{{ url('/contact') }}" class="btn-soft inline-flex items-center gap-2 px-8 py-3.5 rounded-full bg-[#EC2029] text-white font-semibold text-sm shadow-lg shadow-black/20 hover:bg-[#c71a22] group">
                Contact us
                <svg class="h-3.5 w-3.5 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
            </a>
            <a href="{{ url('/services') }}" class="btn-soft px-8 py-3.5 rounded-full text-white font-semibold text-sm bg-white/10 ring-1 ring-white/30 hover:bg-white/20">View services</a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
(function () {
    const STEPS = @json($steps);
    const YARD_IMAGES = @json($yardImages);

    const PATIMBAN_LAT = -6.244;
    const PATIMBAN_LON = 107.9015;
    const MARINE_LAT   = -6.225;
    const MARINE_LON   = 107.905;

    const safe = (name, fn) => { try { fn(); } catch (e) { console.error('[operations] ' + name + ' gagal:', e); } };

    /* ─── 1. Jam ─── */
    function updateRealTimeClock() {
        const el = document.getElementById('live-clock');
        if (!el) return;
        el.innerText = new Date().toLocaleDateString('en-US', {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
            hour: '2-digit', minute: '2-digit', second: '2-digit', timeZoneName: 'short'
        });
    }

    /* ─── 2. Cuaca, Maritim & Berth Status ─── */
    function degToCompassId(deg) {
        if (deg === null || deg === undefined || Number.isNaN(Number(deg))) return '--';
        const dirs = [
            'Utara', 'Timur Laut', 'Timur', 'Tenggara',
            'Selatan', 'Barat Daya', 'Barat', 'Barat Laut'
        ];
        const idx = Math.round((((Number(deg) % 360) + 360) % 360) / 45) % 8;
        return `${dirs[idx]} (${Math.round(Number(deg))}°)`;
    }

    function getSeaStateLabel(waveMeters) {
        const w = Number(waveMeters);
        if (Number.isNaN(w)) return { label: 'Unknown', cls: 'bg-slate-700/50 text-slate-300 ring-slate-600' };
        if (w <= 0.5)  return { label: 'Tenang (0.1–0.5 m)', cls: 'bg-emerald-500/15 text-emerald-300 ring-emerald-400/30' };
        if (w <= 1.25) return { label: 'Rendah (0.5–1.25 m)', cls: 'bg-sky-500/15 text-sky-300 ring-sky-400/30' };
        if (w <= 2.5)  return { label: 'Sedang (1.25–2.5 m)', cls: 'bg-amber-500/15 text-amber-300 ring-amber-400/30' };
        return { label: 'Tinggi (> 2.5 m)', cls: 'bg-red-500/15 text-red-300 ring-red-400/30' };
    }

    function fnGetWeatherDetails(code) {
        if (code === 0) return { icon: '☀️', desc: 'Sunny' };
        if ([1, 2, 3].includes(code)) return { icon: '⛅', desc: 'Partly Cloudy' };
        if ([45, 48].includes(code)) return { icon: '🌫️', desc: 'Foggy' };
        if ([51, 53, 55, 56, 57].includes(code)) return { icon: '🌧️', desc: 'Drizzle' };
        if ([61, 63, 65, 66, 67].includes(code)) return { icon: '🌧️', desc: 'Rain' };
        if ([71, 73, 75, 77].includes(code)) return { icon: '❄️', desc: 'Snow' };
        if ([95, 96, 99].includes(code)) return { icon: '⛈️', desc: 'Thunderstorm' };
        return { icon: '🌤️', desc: 'Fair' };
    }

    function mapBmkgIcon(descEn) {
        const d = (descEn || '').toLowerCase();
        if (d.includes('thunder')) return '⛈️';
        if (d.includes('heavy rain') || d.includes('rain')) return '🌧️';
        if (d.includes('drizzle') || d.includes('light rain')) return '🌦️';
        if (d.includes('fog') || d.includes('haze') || d.includes('mist')) return '🌫️';
        if (d.includes('overcast') || d.includes('cloudy')) return '⛅';
        if (d.includes('clear') || d.includes('sunny')) return '☀️';
        return '🌤️';
    }

    function extractDateAndTime(raw) {
        if (!raw || typeof raw !== 'object') return { date: '', time: '--:--', full: '' };
        const fullStr = String(
            raw.local_datetime ?? raw.datetime ?? raw.date_time ?? raw.waktu ?? raw.time ?? raw.date ?? ''
        ).trim();

        let datePart = String(raw.date ?? '').slice(0, 10);
        let timePart = '';

        const timeMatch = fullStr.match(/(\d{2}:\d{2})/);
        if (timeMatch) timePart = timeMatch[1];

        const dateMatch = fullStr.match(/(\d{4}-\d{2}-\d{2})/);
        if (!datePart && dateMatch) datePart = dateMatch[1];

        return { date: datePart, time: timePart || '--:--', full: fullStr };
    }

    function updateBerthStatus(windSpeed, conditionTextOrCode, waveMeters = 0) {
        const berthEl    = document.getElementById('berth-status');
        const berthSubEl = document.getElementById('berth-status-sub');
        const windSubEl  = document.getElementById('weather-wind-sub');
        if (!berthEl) return;

        const isStorm = typeof conditionTextOrCode === 'number'
            ? [95, 96, 99].includes(conditionTextOrCode)
            : /thunder|storm/i.test(String(conditionTextOrCode));

        const isRain = typeof conditionTextOrCode === 'number'
            ? [61, 63, 65, 66, 67].includes(conditionTextOrCode)
            : /rain/i.test(String(conditionTextOrCode));

        if (windSpeed >= 45 || isStorm || Number(waveMeters) >= 2.0) {
            berthEl.innerText = 'SUSPENDED';
            berthEl.className = 'text-lg sm:text-2xl font-extrabold text-red-400';
            if (berthSubEl) berthSubEl.innerText = 'High Wind / Wave / Storm';
            if (windSubEl)  windSubEl.innerText  = 'Unsafe for Berthing';
        } else if (windSpeed >= 28 || isRain || Number(waveMeters) >= 1.25) {
            berthEl.innerText = 'CAUTION';
            berthEl.className = 'text-lg sm:text-2xl font-extrabold text-amber-400';
            if (berthSubEl) berthSubEl.innerText = 'Monitor Mooring & Ramp';
            if (windSubEl)  windSubEl.innerText  = 'Moderate Wind / Rain / Swell';
        } else {
            berthEl.innerText = 'OPTIMAL';
            berthEl.className = 'text-lg sm:text-2xl font-extrabold text-emerald-400';
            if (berthSubEl) berthSubEl.innerText = 'Normal Ro-Ro Condition';
            if (windSubEl)  windSubEl.innerText  = 'Safe for Berthing';
        }
    }

    async function fetchOpenMeteoForecastAndMarine() {
        const weatherUrl = `https://api.open-meteo.com/v1/forecast?latitude=${PATIMBAN_LAT}&longitude=${PATIMBAN_LON}&current=temperature_2m,relative_humidity_2m,wind_speed_10m,wind_direction_10m,visibility,weather_code&hourly=temperature_2m,wind_speed_10m,weather_code&daily=weathercode,temperature_2m_max,temperature_2m_min,wind_speed_10m_max&timezone=Asia%2FJakarta&forecast_days=3`;
        const marineUrl  = `https://marine-api.open-meteo.com/v1/marine?latitude=${MARINE_LAT}&longitude=${MARINE_LON}&current=wave_height,ocean_current_velocity,ocean_current_direction,sea_level_height_msl&timezone=Asia%2FJakarta&forecast_days=3`;

        const [wRes, mRes] = await Promise.all([
            fetch(weatherUrl),
            fetch(marineUrl).catch(() => null),
        ]);

        const data   = await wRes.json();
        const marine = mRes && mRes.ok ? await mRes.json() : null;

        const slotsByDate = {};
        if (data?.hourly?.time) {
            data.hourly.time.forEach((isoTime, hIdx) => {
                const dateStr = isoTime.slice(0, 10);
                const hourNum = Number(isoTime.slice(11, 13));
                if (hourNum % 3 === 0) {
                    const hw = fnGetWeatherDetails(data.hourly.weather_code[hIdx]);
                    if (!slotsByDate[dateStr]) slotsByDate[dateStr] = [];
                    slotsByDate[dateStr].push({
                        time: isoTime.slice(11, 16),
                        icon: hw.icon,
                        desc: hw.desc,
                        temp: Math.round(data.hourly.temperature_2m[hIdx]),
                        wind: Math.round(data.hourly.wind_speed_10m[hIdx]),
                    });
                }
            });
        }

        return { data, marine, slotsByDate };
    }

    function renderMarineParameters(weatherCurrent, marineCurrent) {
        const waveVal       = marineCurrent?.wave_height;
        const currentKmh    = marineCurrent?.ocean_current_velocity;
        const currentKnots  = currentKmh !== undefined && currentKmh !== null
            ? (Number(currentKmh) / 1.852).toFixed(1)
            : null;
        const currentDirDeg = marineCurrent?.ocean_current_direction;
        const tideVal       = marineCurrent?.sea_level_height_msl;
        const windDirDeg    = weatherCurrent?.wind_direction_10m;
        const visMeters     = weatherCurrent?.visibility;

        const waveEl      = document.getElementById('marine-wave-height');
        const windDirEl   = document.getElementById('marine-wind-dir');
        const curSpeedEl  = document.getElementById('marine-current-speed');
        const curDirEl    = document.getElementById('marine-current-dir');
        const visEl       = document.getElementById('marine-visibility');
        const tideEl      = document.getElementById('marine-tide-level');
        const badgeEl     = document.getElementById('marine-wave-badge');

        if (waveEl)     waveEl.innerText     = waveVal !== undefined && waveVal !== null ? `${Number(waveVal).toFixed(1)} m` : '-- m';
        if (windDirEl)  windDirEl.innerText  = degToCompassId(windDirDeg);
        if (curSpeedEl) curSpeedEl.innerText = currentKnots !== null ? `${currentKnots} knot` : '-- knot';
        if (curDirEl)   curDirEl.innerText   = degToCompassId(currentDirDeg);
        if (visEl)      visEl.innerText      = visMeters !== undefined && visMeters !== null ? `${(Number(visMeters) / 1000).toFixed(1)} km` : '-- km';
        if (tideEl)     tideEl.innerText     = tideVal !== undefined && tideVal !== null ? `${Number(tideVal) >= 0 ? '+' : ''}${Number(tideVal).toFixed(2)} m` : '-- m';

        if (badgeEl) {
            const st = getSeaStateLabel(waveVal);
            badgeEl.innerText = st.label;
            badgeEl.className = `inline-flex items-center rounded-full ring-1 px-2.5 py-0.5 text-[11px] font-semibold ${st.cls}`;
        }

        return Number(waveVal) || 0;
    }

    function renderForecastCards(items, badgeText = 'BMKG + Open-Meteo') {
        const container = document.getElementById('weather-forecast-container');
        const badge     = document.getElementById('weather-window-badge');
        if (!container) return;

        if (badge) badge.innerText = badgeText;
        container.innerHTML = '';

        const now = new Date();
        const nowMinutes = now.getHours() * 60 + now.getMinutes();

        items.forEach((item, index) => {
            const dateObj = new Date(item.date + 'T00:00:00');
            const isValidDate = !Number.isNaN(dateObj.getTime());
            const dayName = index === 0 ? 'Today' : (isValidDate ? dateObj.toLocaleDateString('en-US', { weekday: 'short' }) : `Day ${index + 1}`);
            const formattedDate = isValidDate ? dateObj.toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) : item.date;

            let slots = Array.isArray(item.slots) ? [...item.slots] : [];

            if (index === 0 && slots.length > 0) {
                const upcoming = slots.filter(s => {
                    const parts = String(s.time || '').split(':');
                    if (parts.length < 2) return true;
                    const mins = Number(parts[0]) * 60 + Number(parts[1]);
                    return mins >= nowMinutes - 90;
                });
                if (upcoming.length > 0) {
                    slots = upcoming;
                }
            }

            const slotsHtml = slots.length > 0
                ? `<div class="mt-4 pt-3 border-t border-slate-700/60">
                        <div class="flex items-center justify-between text-[10px] font-semibold uppercase tracking-wider text-slate-400 mb-2">
                            <span>3-Hour Window</span>
                            <span>${index === 0 ? 'Next Slots' : 'All Slots'}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-1.5 max-h-48 overflow-y-auto pr-0.5">
                            ${slots.map((s, sIdx) => `
                                <div class="flex items-center justify-between rounded-xl ${index === 0 && sIdx === 0 ? 'bg-sky-500/15 ring-1 ring-sky-400/40' : 'bg-slate-900/70'} px-2.5 py-1.5 text-[11px]">
                                    <div class="flex items-center gap-1.5 min-w-0">
                                        <span class="font-mono font-bold text-slate-200">${s.time}</span>
                                        <span class="text-sm leading-none shrink-0">${s.icon}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 font-mono shrink-0">
                                        <span class="font-bold text-white">${s.temp}°</span>
                                        <span class="text-sky-400">${s.wind}k</span>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                   </div>`
                : '';

            container.innerHTML += `
                <div class="bg-slate-800/70 ${index === 0 ? 'ring-2 ring-[#EC2029]/70' : 'ring-1 ring-slate-700/80'} rounded-[1.75rem] p-4 sm:p-5 flex flex-col justify-between backdrop-blur-md transition hover:-translate-y-1 hover:ring-slate-500">
                    <div>
                        <div class="flex items-center justify-between pb-3 border-b border-slate-700/60">
                            <div>
                                <p class="text-sm font-bold text-slate-100">${dayName}</p>
                                <p class="text-[11px] text-slate-400">${formattedDate}</p>
                            </div>
                            <div class="flex items-center gap-2.5 text-right">
                                <div>
                                    <span class="text-xs font-semibold text-slate-200 block">${item.desc}</span>
                                    <span class="text-[11px] text-sky-400">Peak ${item.maxWind} km/h</span>
                                </div>
                                <span class="text-3xl leading-none">${item.icon}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2 mt-3 text-xs text-center">
                            <div class="bg-red-500/20 text-red-300 font-bold py-1.5 px-2 rounded-full text-[11px]">Max: ${item.maxTemp} °C</div>
                            <div class="bg-amber-500/20 text-amber-300 font-bold py-1.5 px-2 rounded-full text-[11px]">Min: ${item.minTemp} °C</div>
                        </div>
                    </div>

                    ${slotsHtml}
                </div>`;
        });
    }

    async function fetchPatimbanWeatherCombined() {
        const sourceLabel = document.getElementById('weather-source-label');

        try {
            const [bmkgRes, omBundle] = await Promise.all([
                fetch("{{ route('api.patimban.weather') }}").catch(() => null),
                fetchOpenMeteoForecastAndMarine().catch(() => ({ data: null, marine: null, slotsByDate: {} })),
            ]);

            const bmkg = bmkgRes && bmkgRes.ok ? await bmkgRes.json() : null;
            const { data: omData, marine: omMarine, slotsByDate } = omBundle;

            const waveMeters = renderMarineParameters(omData?.current, omMarine?.current);

            if (bmkg && bmkg.source !== 'FALLBACK' && bmkg.current) {
                document.getElementById('weather-temp').innerText = bmkg.current.temp + ' °C';
                document.getElementById('weather-wind').innerText = bmkg.current.wind + ' km/h';
                document.getElementById('weather-humidity').innerText = bmkg.current.humidity + ' %';
                updateBerthStatus(Number(bmkg.current.wind), bmkg.current.desc_en, waveMeters);

                const rawHourly = Array.isArray(bmkg.hourly)
                    ? bmkg.hourly
                    : (Array.isArray(bmkg.slots) ? bmkg.slots : (Array.isArray(bmkg.forecasts) ? bmkg.forecasts : []));

                const hasAnyBmkgSlots = rawHourly.length > 0 || (bmkg.daily || []).some(d =>
                    (Array.isArray(d.hourly) && d.hourly.length > 0) ||
                    (Array.isArray(d.slots) && d.slots.length > 0) ||
                    (Array.isArray(d.forecasts) && d.forecasts.length > 0)
                );

                const mappedDaily = (bmkg.daily || []).slice(0, 3).map(d => {
                    const dateStr = String(d.date ?? '').slice(0, 10);
                    const inlineSlots = d.hourly || d.slots || d.forecasts || rawHourly.filter(h => {
                        const dt = extractDateAndTime(h);
                        return dt.date === dateStr || dt.full.startsWith(dateStr);
                    });

                    let normalizedSlots = (inlineSlots || []).map(h => {
                        const dt = extractDateAndTime(h);
                        const descText = h.desc_en || h.weather_desc_en || h.desc || d.desc_en;
                        return {
                            time: dt.time,
                            icon: mapBmkgIcon(descText),
                            desc: descText,
                            temp: Math.round(h.temp ?? h.t ?? d.temp_max),
                            wind: Math.round(h.wind ?? h.ws ?? d.wind_max),
                        };
                    });

                    if (normalizedSlots.length === 0 && slotsByDate[dateStr]) {
                        normalizedSlots = slotsByDate[dateStr];
                    }

                    return {
                        date: dateStr || d.date,
                        icon: mapBmkgIcon(d.desc_en),
                        desc: d.desc_en,
                        maxTemp: Math.round(d.temp_max),
                        minTemp: Math.round(d.temp_min),
                        maxWind: Math.round(d.wind_max),
                        slots: normalizedSlots,
                    };
                });

                renderForecastCards(mappedDaily, 'BMKG + Open-Meteo');
                if (sourceLabel) {
                    sourceLabel.innerText = `Source: BMKG (adm4: 32.13.10.2008) & Open-Meteo Marine — Patimban Port (${PATIMBAN_LAT}, ${PATIMBAN_LON}). Advisory model data; official port & berth decisions follow port authorities & VTS.`;
                }
                return;
            }

            if (omData?.current) {
                document.getElementById('weather-temp').innerText = omData.current.temperature_2m + ' °C';
                document.getElementById('weather-wind').innerText = omData.current.wind_speed_10m + ' km/h';
                document.getElementById('weather-humidity').innerText = omData.current.relative_humidity_2m + ' %';
                updateBerthStatus(omData.current.wind_speed_10m, omData.current.weather_code ?? 0, waveMeters);
            }

            if (omData?.daily) {
                const mappedFallback = omData.daily.time.slice(0, 3).map((dateStr, index) => {
                    const w = fnGetWeatherDetails(omData.daily.weathercode[index]);
                    return {
                        date: dateStr,
                        icon: w.icon,
                        desc: w.desc,
                        maxTemp: Math.round(omData.daily.temperature_2m_max[index]),
                        minTemp: Math.round(omData.daily.temperature_2m_min[index]),
                        maxWind: Math.round(omData.daily.wind_speed_10m_max[index]),
                        slots: slotsByDate[dateStr] || [],
                    };
                });
                renderForecastCards(mappedFallback, 'Open-Meteo · Patimban Port');
            }

            if (sourceLabel) {
                sourceLabel.innerText = `Source: Open-Meteo Weather & Marine — Patimban Port (${PATIMBAN_LAT}, ${PATIMBAN_LON}). Advisory model data; official port & berth decisions follow port authorities & VTS.`;
            }
        } catch (error) {
            console.error('Failed to load weather data:', error);
        }
    }

    /* ─── 3. Tahap operasi 01–07 (bisa diklik) ─── */
    function initFlow() {
        const nav = document.getElementById('flow-navigation');
        if (!nav || nav.dataset.bound === '1') return;
        nav.dataset.bound = '1';

        const $ = id => document.getElementById(id);
        const buttons = nav.querySelectorAll('.flow-btn');
        const panel   = $('flow-panel');
        const fields  = $('detail-fields');
        const text    = $('detail-text');

        function activate(index) {
            const data = STEPS[index];
            if (!data) return;

            buttons.forEach(btn => {
                const on = Number(btn.dataset.index) === index;
                btn.classList.toggle('active', on);
                btn.setAttribute('aria-pressed', on ? 'true' : 'false');
            });

            [text, fields].forEach(el => el && el.classList.remove('fade-content'));
            if (panel) void panel.offsetWidth;

            $('detail-number').textContent = '0' + (index + 1);
            $('detail-title').textContent  = data.title;
            $('detail-desc').textContent   = data.desc;
            $('detail-time').textContent   = data.time;
            $('detail-equip').textContent  = data.equip;
            $('detail-safety').textContent = data.safety;
            $('detail-div').textContent    = data.div;

            [text, fields].forEach(el => el && el.classList.add('fade-content'));
        }

        nav.addEventListener('click', e => {
            const btn = e.target.closest('.flow-btn');
            if (!btn || !nav.contains(btn)) return;
            activate(Number(btn.dataset.index));
        });

        window.activateFlowStep = activate;
        activate(0);
    }

    /* ─── 4. Galeri auto-slide ─── */
    let isAutoSlideActive = true;
    let resumeTimeout = null;

    function pauseAutoSlide() {
        isAutoSlideActive = false;
        clearTimeout(resumeTimeout);
        resumeTimeout = setTimeout(() => { isAutoSlideActive = true; }, 7000);
    }
    window.pauseAutoSlideAndFocus = pauseAutoSlide;

    function initGallery() {
        const slider = document.getElementById('news-gallery-slider');
        if (!slider || slider.dataset.bound === '1') return;
        slider.dataset.bound = '1';

        setInterval(() => {
            if (!isAutoSlideActive) return;
            const card = slider.querySelector('.gallery-card');
            if (!card) return;
            const cardWidth = card.offsetWidth + 24;
            const maxScrollLeft = slider.scrollWidth - slider.clientWidth;
            let next = slider.scrollLeft + cardWidth;
            if (next > maxScrollLeft + 5) next = 0;
            slider.scrollTo({ left: next, behavior: 'smooth' });
        }, 3500);

        ['mousedown', 'touchstart'].forEach(type => slider.addEventListener(type, pauseAutoSlide, { passive: true }));
    }

    /* ─── 5. Slideshow hero & yard ─── */
    function initSlideshows() {
        const hero = document.getElementById('hero-slideshow');
        if (hero && hero.dataset.bound !== '1') {
            hero.dataset.bound = '1';
            const slides = hero.querySelectorAll('.hero-slide');
            let i = 0;
            if (slides.length > 1) {
                setInterval(() => {
                    slides[i].classList.remove('active');
                    i = (i + 1) % slides.length;
                    slides[i].classList.add('active');
                }, 5000);
            }
        }

        const yard = document.getElementById('yard-slideshow');
        if (yard && yard.dataset.bound !== '1' && YARD_IMAGES.length > 1) {
            yard.dataset.bound = '1';
            let j = 0;
            setInterval(() => {
                j = (j + 1) % YARD_IMAGES.length;
                yard.style.backgroundImage = "url('" + YARD_IMAGES[j] + "')";
            }, 4000);
        }
    }

    /* ─── 6. Counter angka ─── */
    function initCounters() {
        document.querySelectorAll('.counter').forEach(counter => {
            if (counter.dataset.bound === '1') return;
            counter.dataset.bound = '1';

            const target = +counter.getAttribute('data-target');
            const step = () => {
                const count = +counter.innerText.replace(/,/g, '');
                if (count < target) {
                    counter.innerText = Math.ceil(count + target / 200).toLocaleString();
                    setTimeout(step, 15);
                } else {
                    counter.innerText = target.toLocaleString();
                }
            };
            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) { step(); obs.unobserve(entry.target); }
                });
            }, { threshold: 0.5 });
            observer.observe(counter);
        });
    }

    function boot() {
        safe('flow', initFlow);
        safe('gallery', initGallery);
        safe('slideshows', initSlideshows);
        safe('counters', initCounters);
        safe('clock', () => { updateRealTimeClock(); setInterval(updateRealTimeClock, 1000); });
        safe('weather', () => {
            fetchPatimbanWeatherCombined();
            setInterval(fetchPatimbanWeatherCombined, 15 * 60 * 1000);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }
})();
</script>
@endpush
