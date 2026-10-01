@extends('layouts.app')

@section('title', 'PT Patimban International Car Terminal — PICT')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
<style>
    /* ═══ DESIGN SYSTEM — PICT HOME ═══ */
    :root {
        --color-navy:   #26347a;
        --color-signal: #ec2029;
        --color-ink:    #0f172a;
        --color-muted:  #64748b;
        --color-line:   #cbd5e1;
    }

    body, .pict-hero, .pict-hero *, h1, h2, h3, h4, h5, p, span, div, a {
        font-family: 'Century Gothic', 'CenturyGothic', 'Poppins', sans-serif !important;
    }

    /* ═══ HERO BASE ═══ */
    .pict-hero {
        position: relative;
        overflow: hidden;
    }

    .hero-bg-img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: 0;
        transform: scale(1);
        transition: transform 12s cubic-bezier(0.25, 1, 0.5, 1);
    }
    .pict-hero:hover .hero-bg-img {
        transform: scale(1.06);
    }

    /* Sophisticated navy gradient overlay with atmospheric horizon */
 .hero-overlay-gradient {
    position: absolute;
    inset: 0;
    z-index: 1;
    pointer-events: none;
    background:
        radial-gradient(circle at 80% 65%, rgba(255, 180, 100, 0.10) 0%, transparent 45%),
        linear-gradient(90deg, rgba(15, 23, 60, 0.55) 0%, rgba(26, 38, 96, 0.35) 50%, rgba(15, 23, 60, 0.15) 100%),
        linear-gradient(180deg, rgba(10, 15, 35, 0.25) 0%, transparent 60%, rgba(10, 15, 35, 0.45) 100%);
}
    /* Light particle / dust effect */
    .hero-particles {
        position: absolute;
        inset: 0;
        z-index: 2;
        pointer-events: none;
        background-image: radial-gradient(rgba(255, 255, 255, 0.2) 1px, transparent 1px);
        background-size: 50px 50px;
        opacity: 0.35;
        animation: floatParticles 25s linear infinite;
    }
    @keyframes floatParticles {
        0%   { background-position: 0 0; }
        100% { background-position: 100px 100px; }
    }

    /* ═══ SHINY TEXT ═══ */
    .shiny-text {
        background-size: 200% auto;
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: shiny-animation 3s linear infinite;
        display: inline-block;
    }
    .shiny-text:hover { animation-play-state: paused; }

    .shiny-text-light {
        background-image: linear-gradient(120deg, #cbd5e1 0%, #cbd5e1 35%, #ffffff 50%, #cbd5e1 65%, #cbd5e1 100%);
    }
    .shiny-text-brand {
        background-image: linear-gradient(120deg, #ec2029 0%, #ec2029 35%, #ff858a 50%, #ec2029 65%, #ec2029 100%);
    }
    @keyframes shiny-animation {
        0%   { background-position: 150% center; }
        100% { background-position: -50% center; }
    }

    @media (prefers-reduced-motion: reduce) {
        .shiny-text { animation: none !important; }
        .hero-bg-img { transform: none !important; }
        .hero-particles { animation: none !important; }
    }

    /* ═══ HERO CONTENT ═══ */
    .hero-content {
        animation: fadeUp 1s cubic-bezier(.22, 1, .36, 1) both;
    }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(28px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .glass-description-card {
        background: rgba(20, 35, 90, 0.35);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        border-radius: 1.25rem;
    }

    /* ═══ BUTTONS ═══ */
    .btn-primary-pict {
        position: relative;
        overflow: hidden;
        background-color: var(--color-signal);
        color: #ffffff;
        border: 2px solid var(--color-signal);
        transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 4px 15px rgba(236, 32, 41, 0.4);
    }
    .btn-primary-pict::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -60%;
        width: 50%;
        height: 200%;
        background: rgba(255, 255, 255, 0.25);
        transform: rotate(30deg);
        transition: transform 0.7s ease-in-out;
    }
    .btn-primary-pict:hover::after {
        transform: translate(350%, 0) rotate(30deg);
    }
    .btn-primary-pict:hover {
        background-color: #d11922;
        border-color: #d11922;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(236, 32, 41, 0.6);
    }

    .btn-secondary-pict {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: #ffffff;
        transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .btn-secondary-pict:hover {
        background: rgba(255, 255, 255, 0.18);
        border-color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 255, 255, 0.15);
    }

    /* ═══ STATS CARD ═══ */
    .stats-strip-container {
        margin-top: -80px;
        position: relative;
        z-index: 30;
    }
    .stats-card-main {
        background: linear-gradient(135deg, #ffffff 0%, #fcfdfd 100%);
        border-radius: 1.5rem;
        box-shadow: 0 20px 45px -10px rgba(15, 23, 42, 0.12), 0 0 1px 1px rgba(255, 255, 255, 0.8) inset;
        position: relative;
        overflow: hidden;
    }
    .stats-card-main::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--color-signal) 0%, var(--color-navy) 100%);
    }
    .stat-item {
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), background-color 0.3s ease;
        border-radius: 1rem;
        padding: 1rem 0.5rem;
    }
    .stats-strip.is-visible .stat-item:hover {
        background-color: rgba(38, 52, 122, 0.03);
        transform: translateY(-6px);
    }
    .stat-divider {
        background: linear-gradient(to bottom, transparent, rgba(203, 213, 225, 0.8), transparent);
    }

    /* ═══ ABOUT SECTION ═══ */
    .about-section { position: relative; overflow: hidden; }
    .about-copy { border-left: 3px solid var(--color-signal); padding-left: 1.25rem; }
    .about-values { position: relative; padding-left: 1.75rem; }
    .about-values::before {
        content: "";
        position: absolute;
        left: .35rem;
        top: .8rem;
        bottom: .8rem;
        width: 1px;
        background: linear-gradient(to bottom, var(--color-signal), var(--color-navy));
    }
    .about-value-item { position: relative; padding-bottom: 1.5rem; }
    .about-value-item:last-child { padding-bottom: 0; }
    .about-value-item::before {
        content: "";
        position: absolute;
        left: -1.75rem;
        top: .35rem;
        width: .75rem;
        height: .75rem;
        border: 3px solid #ffffff;
        border-radius: 9999px;
        background: var(--color-signal);
        box-shadow: 0 0 0 1px var(--color-signal);
    }

    /* ═══ LOCATION REVEAL ═══ */
    .location-reveal {
        opacity: 0;
        animation: locationFadeUp .8s ease-out forwards;
    }
    @keyframes locationFadeUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ═══ EYEBROW ═══ */
    .eyebrow {
        display: inline-block;
        font-size: 0.75rem;
        font-weight: 800;
        letter-spacing: 0.22em;
        text-transform: uppercase;
        color: var(--color-signal);
    }

    /* ═══ ROUTE MAP BUTTONS ═══ */
    .route-legend-btn {
        color: var(--color-muted);
    }
    .route-legend-btn.is-active {
        background: #ffffff;
        color: var(--color-ink);
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.08);
    }
    .route-legend-btn.is-active span:first-child {
        box-shadow: 0 0 0 3px rgba(236, 32, 41, 0.15);
    }

    .route-line { transition: opacity .35s ease, stroke-width .35s ease; }
    .route-line.is-active { opacity: 1 !important; stroke-width: 2.6; }
    .route-line.is-dim { opacity: 0.12 !important; }
    .route-marker { transition: opacity .35s ease; }
    .route-marker.is-dim { opacity: 0.1 !important; }
    .dest-marker { cursor: pointer; }
    .dest-marker .visible-dot { transition: r .3s ease, filter .3s ease; }
    .dest-marker:hover .visible-dot,
    .dest-marker.is-active .visible-dot {
        r: 5.5;
        filter: drop-shadow(0 0 4px currentColor);
    }
    .origin-marker .visible-dot { transition: r .3s ease; }

    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endpush

@section('content')

{{-- ═══════════════════════════════════════════════════════════════
     1. HERO SECTION
═══════════════════════════════════════════════════════════════ --}}
<section class="pict-hero relative w-full min-h-[92vh] flex items-center overflow-hidden border-b border-white/10 pt-[env(safe-area-inset-top)]">
    <img src="{{ asset('assets/images/background.jpeg') }}"
         alt="Patimban Port terminal"
         class="hero-bg-img"
         fetchpriority="high">

    <div class="hero-overlay-gradient"></div>
    <div class="hero-particles"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 sm:px-8 lg:px-10 py-24 lg:py-32 w-full">
        <div class="hero-content space-y-6 flex flex-col items-center text-center" data-aos="fade-up">
        <h1 class="text-3xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight leading-[1.15] drop-shadow-lg">
    <span class="shiny-text shiny-text-light">
        PATIMBAN<br>
        INTERNATIONAL
    </span>
    <br>
    <span class="shiny-text shiny-text-brand" style="text-shadow: 0 4px 20px rgba(236, 32, 41, 0.4);">
        CAR TERMINAL
    </span>
</h1>

            <div class="glass-description-card mx-auto max-w-2xl px-6 sm:px-8 py-5 text-slate-100 text-base sm:text-lg leading-relaxed">
                Providing professional Cargo Handling services at Patimban Port with world-class smart logistics capabilities, operational excellence, and unmatched safety standards.
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     2. STATS STRIP
═══════════════════════════════════════════════════════════════ --}}
@php
    $homeStats = [
        ['img' => 'vehicle-car.png', 'target' => '200', 'suffix' => 'k', 'suffixColor' => 'text-[#ec2029]', 'label' => 'Vehicle Capacity'],
        ['img' => 'vehicle.png',     'target' => '600', 'suffix' => 'k', 'suffixColor' => 'text-[#ec2029]', 'label' => 'Expansion Target'],
        ['img' => 'berth.png',       'target' => '300', 'suffix' => 'm', 'suffixColor' => 'text-slate-400', 'label' => 'Berth Length'],
        ['img' => 'terminal.png',    'target' => '800', 'suffix' => 'k', 'suffixColor' => 'text-slate-400', 'label' => 'Terminal Infrastructure', 'prefix' => '±'],
    ];
@endphp

<section class="stats-strip stats-strip-container max-w-7xl mx-auto px-4 sm:px-6 relative z-20" data-aos="fade-up">
    <div class="stats-card-main p-6 sm:p-10 grid grid-cols-2 md:grid-cols-4 gap-y-8 sm:gap-y-0">
        @foreach($homeStats as $i => $s)
            @if($i > 0)
                <div class="hidden md:block absolute top-1/4 bottom-1/4 w-[1px] stat-divider" style="left: {{ 25 * $i }}%;"></div>
            @endif

            <div class="stat-item text-center px-3 sm:px-4 relative flex flex-col items-center">
                <div class="w-12 h-12 rounded-xl {{ $i % 2 === 0 ? 'bg-[#26347a]/10' : 'bg-[#ec2029]/10' }} flex items-center justify-center mb-3 shadow-inner">
                    <img src="{{ asset('assets/images/' . $s['img']) }}" alt="" class="w-6 h-6 object-contain">
                </div>
                <p class="text-3xl sm:text-5xl font-extrabold text-[#26347a] mb-1 tracking-tight">
                    @if(!empty($s['prefix']))
                        <span class="text-slate-400 text-2xl mr-0.5">{{ $s['prefix'] }}</span>
                    @endif
                    <span class="stat-number" data-target="{{ $s['target'] }}">{{ $s['target'] }}</span>
                    <span class="{{ $s['suffixColor'] }} text-xl sm:text-2xl font-bold ml-0.5">{{ $s['suffix'] }}</span>
                </p>
                <p class="text-slate-500 text-xs sm:text-sm font-semibold uppercase tracking-wider">{{ $s['label'] }}</p>
            </div>
        @endforeach
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     3. ABOUT US
═══════════════════════════════════════════════════════════════ --}}
<section class="about-section py-20 bg-white" data-aos="fade-up">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 pb-4 border-b border-slate-200 gap-4">
            <div>
                <span class="eyebrow block mb-2">Company Profile</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">About PICT</h2>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <div class="about-copy lg:col-span-6 space-y-6" data-aos="fade-right">
                <h3 class="text-2xl font-bold text-blue-950">
                    Indonesia's Strategic Gateway for Automotive Export and Import
                </h3>
                <p class="text-slate-600 leading-relaxed">
                    PT Patimban International Car Terminal (PICT) is a vehicle terminal operator at Patimban Port, Subang Regency, West Java approximately 120 kilometers east of central Jakarta. Established in November 2021 by the Toyota Tsusho Group, PICT began operations in December 2021.
                </p>
                <p class="text-slate-600 leading-relaxed">
                    Backed by a consortium of leading Japanese enterprises in automotive logistics and shipping, PICT is committed to delivering world-class vehicle handling services to support Indonesia's growing automotive industry.
                </p>
            </div>

            <div class="about-values lg:col-span-6" data-aos="fade-left">
                <div class="about-value-item">
                    <h4 class="text-lg font-bold text-blue-950 mb-2">Vision</h4>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Becoming the best vehicle port in Asia.
                    </p>
                </div>

                <div class="about-value-item">
                    <h4 class="text-lg font-bold text-blue-950 mb-2">Mission</h4>
                    <ul class="text-slate-600 text-sm space-y-2 list-disc list-inside">
                        <li>Delivering customers' vehicles to end users with the highest quality and to their satisfaction.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     4. TERMINAL GALLERY
═══════════════════════════════════════════════════════════════ --}}
<section class="py-20 bg-slate-50 border-y border-slate-200 overflow-hidden" data-aos="fade-up">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-6 pb-4 border-b border-slate-200 gap-4">
            <div>
                <span class="eyebrow block mb-2">Terminal Gallery</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Operational Excellence in Action</h2>
            </div>
        </div>

        <p class="text-slate-600 text-sm max-w-xl mb-12">
            Direct documentation of vehicle loading and unloading activities, staging yard capacity, and high safety standards at PT Patimban International Car Terminal.
        </p>

        @php
            $gallery = [
                [
                    'img'   => 'vessel-1.jpeg',
                    'alt'   => 'Ro-Ro Vessel at Patimban Port',
                    'title' => 'Deep-Sea Ro-Ro Handling',
                    'desc'  => 'International vehicle carrier berthing services with high technology and efficiency at Patimban terminal.',
                    'gradient' => true,
                ],
                [
                    'img'   => 'patimban-yard-1.jpeg',
                    'alt'   => 'Patimban Staging Yard',
                    'title' => 'Wide Capacity Staging Yard',
                    'desc'  => 'A spacious, neatly organized, and secure CBU vehicle stacking area designed to support both domestic distribution and exports.',
                    'gradient' => false,
                ],
                [
                    'img'   => 'car-5.jpeg',
                    'alt'   => 'Vehicle Inspection Process',
                    'title' => 'Strict Quality Inspection',
                    'desc'  => 'A thorough physical and engine inspection process to ensure zero-defect quality standards before vehicles are distributed.',
                    'gradient' => true,
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($gallery as $item)
                <article class="group relative rounded-2xl overflow-hidden shadow-md bg-white border border-slate-200 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                    <div class="relative h-64 overflow-hidden">
                        <img src="{{ asset('assets/images/' . $item['img']) }}"
                             alt="{{ $item['alt'] }}"
                             loading="lazy"
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @if($item['gradient'])
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent opacity-90"></div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-red-600 transition-colors">
                            {{ $item['title'] }}
                        </h3>
                        <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                            {{ $item['desc'] }}
                        </p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     5. SHIPPING ROUTE NETWORK
═══════════════════════════════════════════════════════════════ --}}
<section class="py-20 bg-slate-50 relative overflow-hidden border-b border-slate-200" data-aos="fade-up">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-6 pb-4 border-b border-slate-200 gap-4">
            <div>
                <span class="eyebrow block mb-2">Global Connectivity</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Shipping Route Network</h2>
            </div>
        </div>

        <p class="text-slate-600 text-sm max-w-xl leading-relaxed mb-10">
            Patimban Port is seamlessly linked to domestic feeder channels and international deep-sea lanes connecting major Asian automotive hubs.
        </p>

        <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-6 shadow-sm">
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 pb-5 mb-5 border-b border-slate-100">
                <div id="routeLegend" class="inline-flex p-1 bg-slate-100 rounded-xl gap-1 self-start sm:self-auto" role="tablist" aria-label="Filter rute pelayaran">
                    @php
                        $legend = [
                            ['route' => 'all',           'color' => 'bg-red-600',   'label' => 'All Routes'],
                            ['route' => 'international', 'color' => 'bg-amber-500', 'label' => 'International'],
                            ['route' => 'domestic',      'color' => 'bg-sky-500',   'label' => 'Domestic'],
                        ];
                    @endphp
                    @foreach($legend as $l)
                        <button type="button"
                                data-route="{{ $l['route'] }}"
                                role="tab"
                                aria-selected="{{ $l['route'] === 'all' ? 'true' : 'false' }}"
                                class="route-legend-btn {{ $l['route'] === 'all' ? 'is-active' : '' }} flex items-center gap-2 text-xs font-bold rounded-lg px-4 py-2 transition-all duration-200">
                            <span class="w-2 h-2 rounded-full {{ $l['color'] }}"></span>
                            <span>{{ $l['label'] }}</span>
                        </button>
                    @endforeach
                </div>

                <p class="md:hidden text-[11px] text-slate-400 font-medium flex items-center gap-1 self-center">
                    <span>&larr;</span> Drag or scroll map to explore <span>&rarr;</span>
                </p>
            </div>

            <div class="overflow-x-auto no-scrollbar snap-x snap-mandatory rounded-xl bg-slate-50 border border-slate-100">
                <div class="min-w-[750px] lg:min-w-0">
                    <svg id="routeMapSvg" class="w-full h-auto touch-manipulation snap-center" viewBox="0 0 900 460" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Peta jaringan rute pelayaran Patimban Port">
                        @include('partials.routes._map-defs')
                        @include('partials.routes._map-landmasses')
                        @include('partials.routes._map-domestic-routes')
                        @include('partials.routes._map-international-routes')
                        @include('partials.routes._map-markers')
                    </svg>
                </div>
            </div>

            {{-- Route Info Panel --}}
            <div class="mt-5 pt-5 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                <div class="flex items-center gap-2 shrink-0">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
                    <span id="routeInfoTitle" class="text-xs font-extrabold uppercase tracking-wider text-slate-700">
                        Patimban Port Comprehensive Network
                    </span>
                </div>
                <p id="routeInfoDesc" class="text-xs text-slate-500 leading-relaxed">
                    Displaying all combined active international deep-sea lanes and domestic feeder channels.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     6. LOCATION & FACILITIES
═══════════════════════════════════════════════════════════════ --}}
<section class="py-20 bg-white" data-aos="fade-up">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="max-w-3xl mb-10">
            <span class="eyebrow block mb-3">Infrastructure Access</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900">
                Terminal Specifications
            </h2>
            <p class="mt-3 text-slate-600 leading-relaxed">
                An integrated vehicle terminal facility engineered to streamline domestic and international automotive supply chains.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
            {{-- Facility Specs --}}
            <div class="lg:col-span-3 bg-slate-50 rounded-2xl border border-slate-200 shadow-sm overflow-hidden" data-aos="fade-right">
                <div class="px-6 py-5 border-b border-slate-200">
                    <h3 class="text-lg font-extrabold text-slate-900">Key Facility Specifications</h3>
                </div>
                <div class="divide-y divide-slate-100">
                    @php
                        $specs = [
                            ['label' => 'Ro-Ro Berth',           'value' => '300 meters'],
                            ['label' => 'Water Depth',           'value' => '-14.0 m'],
                            ['label' => 'Staging Yard Capacity', 'value' => '200,000 CBU units / year'],
                        ];
                    @endphp
                    @foreach($specs as $spec)
                        <div class="grid sm:grid-cols-2 gap-2 px-6 py-4">
                            <span class="text-sm font-semibold text-slate-500">{{ $spec['label'] }}</span>
                            <span class="text-sm font-semibold text-slate-900">{{ $spec['value'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Side Info Cards --}}
            <div class="lg:col-span-2 grid sm:grid-cols-2 lg:grid-cols-1 gap-6" data-aos="fade-left">
                <div class="rounded-2xl bg-blue-950 p-6 text-white shadow-sm">
                    <h3 class="font-extrabold text-lg">Safety &amp; Security</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-300">
                        Compliant with IMO ISPS Code standards and equipped with 24/7 CCTV surveillance across all terminal zones.
                    </p>
                </div>
                <div class="rounded-2xl bg-blue-950 p-6 text-white shadow-sm">
                    <h3 class="font-extrabold text-lg">ISO Certified</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-300">
                        Operating under internationally recognized quality, environmental, and safety management standards.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     7. MAP & GOOGLE ADDRESS
═══════════════════════════════════════════════════════════════ --}}
<section class="max-w-7xl mx-auto px-6 pt-10 pb-20 bg-white text-slate-800" data-aos="fade-up">
    <div class="grid lg:grid-cols-12 gap-14 items-start">
        <div class="lg:col-span-5 location-reveal space-y-6" style="animation-delay:.15s" data-aos="fade-right">
            <div>
                <span class="eyebrow block mb-2">Our Address</span>
                <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">Patimban Port Terminal</h3>
                <div class="mt-4 h-1 w-16 bg-[#ec2029] rounded-full"></div>
            </div>
            <p class="text-slate-600 leading-relaxed text-sm">
                Situated within the Patimban National Strategic Project zone in Subang Regency, offering optimized transit routes for automotive manufacturers.
            </p>
            <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-200 shadow-sm">
                <div class="w-10 h-10 rounded-lg bg-red-600/10 text-red-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h5 class="font-bold text-slate-900 mb-1 text-sm">Port Location</h5>
                    <p class="text-slate-600 text-xs leading-relaxed">Patimban Port, Pusakanagara, Subang Regency, West Java, Indonesia</p>
                </div>
            </div>
        </div>

        <div class="lg:col-span-7 location-reveal rounded-2xl overflow-hidden shadow-lg border border-slate-200 h-80 md:h-[420px] bg-slate-100" style="animation-delay:.3s" data-aos="fade-left">
            <iframe
                src="https://www.google.com/maps?q=Pelabuhan+Patimban,+Subang,+Jawa+Barat&t=k&output=embed"
                class="w-full h-full"
                style="border:0;"
                allowfullscreen
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                title="Peta lokasi Patimban Port">
            </iframe>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     8. ACTION STRIP
═══════════════════════════════════════════════════════════════ --}}
<section class="relative overflow-hidden bg-gradient-to-br from-[#ec2029] to-[#b91c1c] py-16 text-white">
    <div class="pointer-events-none absolute inset-0 opacity-[0.06]">
        <svg class="h-full w-full" viewBox="0 0 400 200" preserveAspectRatio="none" aria-hidden="true">
            <path d="M0 200 L120 40 L240 200 Z" fill="white"></path>
            <path d="M180 200 L320 20 L400 200 Z" fill="white"></path>
        </svg>
    </div>
    <div class="pointer-events-none absolute -top-24 -right-24 h-72 w-72 rounded-full bg-white/10 blur-3xl"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6" data-aos="fade-up">
        <div class="max-w-2xl">
            <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight leading-tight">Ready to Partner with PICT?</h2>
            <p class="text-red-100 text-sm sm:text-base mt-2">
                Inquire about terminal tariffs, berthing schedules, and automotive handling solutions.
            </p>
        </div>

        <a href="{{ url('/contact') }}"
           class="group inline-flex items-center gap-2 shrink-0 px-7 py-3.5 bg-[#26347a] text-white text-sm font-bold rounded-full border-2 border-[#26347a] hover:bg-transparent hover:border-white transition-all duration-300 shadow-lg hover:shadow-xl">
            Contact Us
            <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </a>
    </div>
</section>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    AOS.init({ duration: 900, easing: 'ease-out-cubic', once: true, offset: 120 });

    /* ═══════════════════════════════════════════════════════════════
       STATS COUNTER
    ═══════════════════════════════════════════════════════════════ */
    document.querySelectorAll('.stat-number').forEach(el => {
        const target = parseInt(el.dataset.target, 10);
        const duration = 1500;
        const start = performance.now();

        const tick = (now) => {
            const progress = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.floor(eased * target).toLocaleString();
            if (progress < 1) requestAnimationFrame(tick);
            else el.textContent = target.toLocaleString();
        };
        requestAnimationFrame(tick);
    });

    /* ═══════════════════════════════════════════════════════════════
       SHIPPING ROUTE INTERACTIVITY
    ═══════════════════════════════════════════════════════════════ */
    const svg = document.getElementById('routeMapSvg');
    if (!svg) return;

    const ROUTE_INFO = {
        all: {
            title: 'Patimban Port Comprehensive Network',
            desc: 'Displaying all combined active international deep-sea lanes and domestic feeder channels connecting Patimban Port to global and regional markets.'
        },
        international: {
            title: 'International Shipping Routes',
            desc: 'Destinations: Port Klang (Malaysia), Laem Chabang (Thailand), Hong Kong, Guangzhou, Nagoya, Yokohama, Osaka (Japan).'
        },
        domestic: {
            title: 'Domestic Feeder Network',
            desc: 'Connecting major domestic maritime trade pathways across Indonesia: Pontianak, Batam, Belawan, and Banjarmasin.'
        }
    };

    const infoTitle     = document.getElementById('routeInfoTitle');
    const infoDesc      = document.getElementById('routeInfoDesc');
    const legendButtons = svg.parentElement.parentElement.parentElement.querySelectorAll('.route-legend-btn');
    const routeLines    = svg.querySelectorAll('.route-line');
    const routeMarkers  = svg.querySelectorAll('.route-marker');
    const routeHits     = svg.querySelectorAll('.route-hit');
    const destMarkers   = svg.querySelectorAll('.dest-marker');
    const originMarker  = svg.querySelector('.origin-marker');

    function setActiveRoute(route) {
        const target = route || 'all';

        routeLines.forEach(el => {
            const match = el.dataset.route === target;
            el.classList.toggle('is-active', target !== 'all' && match);
            el.classList.toggle('is-dim', target !== 'all' && !match);
        });
        routeMarkers.forEach(el => {
            const match = el.dataset.route === target;
            el.classList.toggle('is-dim', target !== 'all' && !match);
        });
        destMarkers.forEach(el => {
            el.classList.toggle('is-active', target !== 'all' && el.dataset.route === target);
        });
        if (originMarker) {
            originMarker.classList.toggle('is-active', target === 'all');
        }
        legendButtons.forEach(btn => {
            const isActive = btn.dataset.route === target;
            btn.classList.toggle('is-active', isActive);
            btn.setAttribute('aria-selected', String(isActive));
        });

        const info = ROUTE_INFO[target] || ROUTE_INFO.all;
        if (infoTitle) infoTitle.textContent = info.title;
        if (infoDesc)  infoDesc.textContent  = info.desc;
    }

    routeHits.forEach(el => {
        el.style.cursor = 'pointer';
        el.addEventListener('click', () => setActiveRoute(el.dataset.route));
    });
    destMarkers.forEach(el => {
        el.addEventListener('click', () => setActiveRoute(el.dataset.route));
    });
    legendButtons.forEach(btn => {
        btn.addEventListener('click', () => setActiveRoute(btn.dataset.route));
    });

    setActiveRoute('all');
});
</script>
@endpush