
@extends('layouts.app')

@section('title', 'PT Patimban International Car Terminal — PICT')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Space+Grotesk:wght@500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    /* ═══ DESIGN SYSTEM — PICT INDUSTRIAL EDITORIAL ═══ */
    :root {
        --color-navy:   #26347a;
        --color-navy-dark: #1a2554;
        --color-signal: #ec2029;
        --color-ink:    #0f172a;
        --color-muted:  #64748b;
        --color-line:   #e2e8f0;
        --color-bg:     #f8fafc;
    }

    /* Typography */
    body {
        font-family: 'Inter', sans-serif;
        color: var(--color-ink);
        background-color: #ffffff;
        -webkit-font-smoothing: antialiased;
    }
    
    h1, h2, h3, h4, h5, h6, .font-display, .stat-number {
        font-family: 'Space Grotesk', sans-serif !important;
        letter-spacing: -0.02em;
    }

    .font-mono-label {
        font-family: 'Space Grotesk', monospace;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-size: 0.75rem;
        font-weight: 700;
    }

    /* ═══ HERO SECTION ═══ */
    .hero-editorial {
        position: relative;
        background-color: var(--color-navy-dark);
        min-height: 90vh;
        display: flex;
        align-items: center;
    }

    .hero-image-wrapper {
        position: absolute;
        top: 0;
        right: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
    }

    /* Diagonal clip-path for desktop */
    @media (min-width: 1024px) {
        .hero-image-wrapper {
            width: 60%;
            clip-path: polygon(15% 0, 100% 0, 100% 100%, 0% 100%);
        }
    }

    .hero-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center 30%;
    }

    /* Subtle gradient to ensure text readability over image */
    .hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, var(--color-navy-dark) 0%, rgba(26, 37, 84, 0.85) 40%, transparent 100%);
        z-index: 1;
    }

    @media (max-width: 1023px) {
        .hero-overlay {
            background: linear-gradient(180deg, var(--color-navy-dark) 0%, rgba(26, 37, 84, 0.8) 60%, rgba(26, 37, 84, 0.9) 100%);
        }
    }

    .hero-content-wrap {
        position: relative;
        z-index: 10;
        width: 100%;
    }

    /* ═══ SECTION DIVIDERS & LABELS ═══ */
    .section-label {
        display: flex;
        align-items: center;
        gap: 1rem;
        color: var(--color-signal);
        margin-bottom: 2rem;
    }
    .section-label::before {
        content: '';
        display: block;
        width: 2rem;
        height: 2px;
        background-color: var(--color-signal);
    }

    /* ═══ STATS EDITORIAL ═══ */
    .stat-box {
        border-left: 1px solid rgba(255,255,255,0.15);
        padding-left: 1.5rem;
    }
    @media (max-width: 768px) {
        .stat-box {
            border-left: none;
            border-top: 1px solid rgba(255,255,255,0.15);
            padding-left: 0;
            padding-top: 1.5rem;
        }
    }

    /* ═══ GALLERY ASYMMETRIC ═══ */
    .gallery-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    @media (min-width: 768px) {
        .gallery-grid {
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: repeat(2, 300px);
        }
        /* First item takes 2 cols and 2 rows */
        .gallery-item:nth-child(1) {
            grid-column: span 2;
            grid-row: span 2;
        }
        /* If there are more than 3 items, let them flow */
        .gallery-item:nth-child(4) {
            grid-column: span 1;
            grid-row: span 1;
        }
    }

    .gallery-item {
        position: relative;
        overflow: hidden;
        background: #000;
    }
    
    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.7s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.3s ease;
        opacity: 0.9;
    }

    .gallery-item:hover img {
        transform: scale(1.05);
        opacity: 1;
    }

    .gallery-caption {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 2rem 1.5rem 1.5rem;
        background: linear-gradient(to top, rgba(15, 23, 42, 0.95) 0%, rgba(15, 23, 42, 0) 100%);
        color: white;
        z-index: 10;
    }

    /* ═══ LEAFLET CUSTOM ═══ */
    .leaflet-container {
        font-family: 'Inter', sans-serif !important;
        border-radius: 0;
    }
    .leaflet-popup-content-wrapper {
        border-radius: 2px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.15);
        padding: 0;
    }
    .leaflet-popup-content {
        margin: 0;
        padding: 16px;
    }

    .route-filter-btn {
        color: var(--color-muted);
        border-bottom: 2px solid transparent;
        border-radius: 0;
        padding: 0.75rem 1rem;
        transition: all 0.2s ease;
    }
    .route-filter-btn.is-active {
        color: var(--color-ink);
        border-bottom-color: var(--color-signal);
        font-weight: 700;
    }
    .route-filter-btn:hover {
        color: var(--color-ink);
    }

    /* ═══ MISC ═══ */
    .bg-grid-pattern {
        background-size: 40px 40px;
        background-image: linear-gradient(to right, rgba(255, 255, 255, 0.05) 1px, transparent 1px),
                          linear-gradient(to bottom, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
    }

    @media (prefers-reduced-motion: reduce) {
        .gallery-item img { transition: none !important; }
        [data-aos] { transition: none !important; transform: none !important; }
    }
</style>
@endpush

@section('content')

{{-- ═══════════════════════════════════════════════════════════════
     01. HERO SECTION — ASYMMETRIC SPLIT / DIAGONAL CROP
═══════════════════════════════════════════════════════════════ --}}
<section class="hero-editorial pt-20 pb-16 lg:pt-0 lg:pb-0">
    {{-- Background Image with Diagonal Cut --}}
    <div class="hero-image-wrapper">
        <img src="{{ asset('assets/images/background.jpeg') }}" 
             alt="Patimban Port Facility" 
             class="hero-img" 
             fetchpriority="high">
    </div>
    <div class="hero-overlay"></div>

    <div class="hero-content-wrap max-w-7xl mx-auto px-6 sm:px-8 lg:px-10 py-12 lg:py-0">
        <div class="grid lg:grid-cols-12 gap-12 items-center">
            
            {{-- Left: Editorial Text --}}
            <div class="lg:col-span-7 xl:col-span-6 relative" data-aos="fade-right" data-aos-duration="1000">
                
                {{-- Metadata Label --}}
                <div class="flex items-center gap-4 mb-8">
                    <span class="text-white/60 font-mono-label text-xs">01 / HERO</span>
                    <div class="h-px w-12 bg-white/20"></div>
                    <span class="text-[#ec2029] font-mono-label text-xs">PATIMBAN PORT</span>
                </div>

                {{-- Main Heading --}}
                <h1 class="text-white text-5xl sm:text-6xl lg:text-7xl font-bold leading-[1.05] mb-6">
                    PATIMBAN<br>
                    INTERNATIONAL<br>
                    <span class="text-white/80">CAR TERMINAL</span>
                </h1>

                {{-- Subtitle / Description --}}
                <p class="text-slate-300 text-base sm:text-lg max-w-lg leading-relaxed mb-10 font-light">
                    Providing professional Cargo Handling services at Patimban Port with world-class smart logistics capabilities, operational excellence, and unmatched safety standards.
                </p>

                {{-- Call to Action --}}
                <div class="flex flex-wrap items-center gap-6">
                    <a href="#about" class="inline-flex items-center justify-center px-8 py-4 bg-[#ec2029] text-white text-sm font-bold hover:bg-[#d11922] transition-colors group">
                        Discover PICT
                        <svg class="w-4 h-4 ml-3 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                    <a href="#network" class="inline-flex items-center justify-center px-8 py-4 border border-white/30 text-white text-sm font-bold hover:bg-white hover:text-[#1a2554] transition-colors">
                        Route Network
                    </a>
                </div>
            </div>

            {{-- Right: Empty space on desktop so image shows, Metadata on Mobile --}}
            <div class="lg:col-span-5 hidden lg:block relative z-10 text-right">
                 <div class="inline-block text-right">
                    <p class="text-white/50 text-xs font-mono mb-1 tracking-widest">LOCATION</p>
                    <p class="text-white font-bold text-sm">Subang, West Java<br>Indonesia</p>
                 </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     02. STATISTICS SECTION — INDUSTRIAL DATA PANEL
═══════════════════════════════════════════════════════════════ --}}
@php
    $homeStats = [
        ['img' => 'vehicle-car.png', 'target' => '200', 'suffix' => 'k', 'suffixColor' => 'text-[#ec2029]', 'label' => 'Vehicle Capacity'],
        ['img' => 'vehicle.png',     'target' => '600', 'suffix' => 'k', 'suffixColor' => 'text-[#ec2029]', 'label' => 'Expansion Target'],
        ['img' => 'berth.png',       'target' => '300', 'suffix' => 'm', 'suffixColor' => 'text-slate-400', 'label' => 'Berth Length'],
        ['img' => 'terminal.png',    'target' => '800', 'suffix' => 'k', 'suffixColor' => 'text-slate-400', 'label' => 'Terminal Infrastructure', 'prefix' => '±'],
    ];
@endphp

<section class="bg-[#1a2554] py-16 relative overflow-hidden border-b border-white/10">
    <div class="absolute inset-0 bg-grid-pattern opacity-20"></div>
    <div class="max-w-7xl mx-auto px-6 sm:px-8 relative z-10">
        <div class="flex flex-col md:flex-row items-start md:items-end justify-between mb-12 gap-6">
            <div>
                <div class="section-label text-white/80">
                    <span class="font-mono-label">02 / METRICS</span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-bold text-white tracking-tight">Operational Scale</h2>
            </div>
            <p class="text-slate-400 text-sm max-w-md">
                Key performance indicators and infrastructure capacity of PT Patimban International Car Terminal.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-0">
            @foreach($homeStats as $i => $s)
            <div class="stat-box flex flex-col justify-center {{ $i === 0 ? 'lg:border-l-0 lg:pl-0' : '' }}" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('assets/images/' . $s['img']) }}" alt="" class="w-5 h-5 object-contain opacity-60 invert">
                    <span class="text-slate-400 font-mono-label text-xs">{{ $s['label'] }}</span>
                </div>
                <div class="flex items-baseline">
                    @if(!empty($s['prefix']))
                        <span class="text-slate-400 text-2xl mr-1 font-light">{{ $s['prefix'] }}</span>
                    @endif
                    <span class="text-5xl sm:text-6xl font-bold text-white stat-number" data-target="{{ $s['target'] }}">{{ $s['target'] }}</span>
                    <span class="{{ $s['suffixColor'] }} text-2xl font-bold ml-1">{{ $s['suffix'] }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     03. ABOUT PICT — EDITORIAL LAYOUT
═══════════════════════════════════════════════════════════════ --}}
<section id="about" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6 sm:px-8">
        <div class="grid lg:grid-cols-12 gap-16 lg:gap-8">
            
            {{-- Left: Sticky Heading --}}
            <div class="lg:col-span-4">
                <div class="sticky top-24" data-aos="fade-right">
                    <div class="section-label">
                        <span class="font-mono-label">03 / COMPANY PROFILE</span>
                    </div>
                    <h2 class="text-4xl sm:text-5xl font-bold text-slate-900 leading-[1.1] mb-6">
                        About<br>PICT
                    </h2>
                    <div class="w-16 h-1 bg-[#ec2029]"></div>
                </div>
            </div>

            {{-- Right: Content --}}
            <div class="lg:col-span-8 lg:pl-12">
                <div class="mb-12" data-aos="fade-up">
                    <h3 class="text-2xl sm:text-3xl font-bold text-[#26347a] mb-6">
                        Indonesia's Strategic Gateway for Automotive Export and Import
                    </h3>
                    <p class="text-slate-600 leading-relaxed text-lg mb-4">
                        PT Patimban International Car Terminal (PICT) is a vehicle terminal operator at Patimban Port, Subang Regency, West Java approximately 120 kilometers east of central Jakarta. Established in November 2021 by the Toyota Tsusho Group, PICT began operations in December 2021.
                    </p>
                    <p class="text-slate-600 leading-relaxed text-lg">
                        Backed by a consortium of leading Japanese enterprises in automotive logistics and shipping, PICT is committed to delivering world-class vehicle handling services to support Indonesia's growing automotive industry.
                    </p>
                </div>

                <div class="grid sm:grid-cols-2 gap-10 pt-10 border-t border-slate-200" data-aos="fade-up" data-aos-delay="100">
                    <div>
                        <h4 class="font-mono-label text-[#ec2029] mb-3">Vision</h4>
                        <p class="text-slate-700 font-medium text-lg leading-snug">
                            "Becoming the best vehicle port in Asia."
                        </p>
                    </div>
                    <div>
                        <h4 class="font-mono-label text-[#ec2029] mb-3">Mission</h4>
                        <ul class="text-slate-600 space-y-3 list-disc list-outside ml-4 marker:text-slate-300">
                            <li>Delivering customers' vehicles to end users with the highest quality and to their satisfaction.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     04. TERMINAL GALLERY — ASYMMETRIC EDITORIAL GALLERY
═══════════════════════════════════════════════════════════════ --}}
<section class="py-24 bg-[#f8fafc] border-y border-slate-200">
    <div class="max-w-7xl mx-auto px-6 sm:px-8">
        <div class="mb-12" data-aos="fade-up">
            <div class="section-label">
                <span class="font-mono-label">04 / GALLERY</span>
            </div>
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <h2 class="text-4xl sm:text-5xl font-bold text-slate-900 max-w-xl leading-tight">
                    Operational Excellence in Action
                </h2>
                <p class="text-slate-600 text-sm max-w-xs md:text-right">
                    Direct documentation of vehicle loading and unloading activities, staging yard capacity, and high safety standards.
                </p>
            </div>
        </div>

        <div class="gallery-grid" data-aos="fade-up" data-aos-delay="100">
            @forelse($terminalGallery as $item)
                <div class="gallery-item group">
                    <img src="{{ $item->image_url }}" alt="{{ $item->title }}" loading="lazy">
                    <div class="gallery-caption">
                        <h3 class="text-xl font-bold text-white mb-1">{{ $item->title }}</h3>
                        <p class="text-slate-300 text-sm leading-relaxed line-clamp-2">{{ $item->description }}</p>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center border border-dashed border-slate-300 bg-white">
                    <p class="text-slate-500">Belum ada gambar galeri untuk halaman Home. Silakan tambahkan melalui Admin Panel.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     05. SHIPPING ROUTE NETWORK — FUNCTIONAL MAP LAYOUT
═══════════════════════════════════════════════════════════════ --}}
<section id="network" class="py-24 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-6 sm:px-8">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-6">
            <div data-aos="fade-up">
                <div class="section-label">
                    <span class="font-mono-label">05 / NETWORK</span>
                </div>
                <h2 class="text-4xl sm:text-5xl font-bold text-slate-900 tracking-tight">Shipping Route Network</h2>
            </div>
            <p class="text-slate-600 text-sm max-w-md" data-aos="fade-up" data-aos-delay="100">
                Patimban Port is seamlessly linked to domestic feeder channels and international deep-sea lanes connecting major Asian automotive hubs.
            </p>
        </div>

        {{-- Map Container --}}
        <div class="border border-slate-200 bg-white shadow-sm" data-aos="fade-up" data-aos-delay="200">
            {{-- Filter Header --}}
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between border-b border-slate-200 px-4 sm:px-6">
                <div id="routeLegend" class="flex gap-4 overflow-x-auto" role="tablist">
                    <button type="button" data-route="all" class="route-filter-btn is-active flex items-center gap-2 text-xs font-bold transition-all duration-200 whitespace-nowrap py-4">
                        <span class="w-2 h-2 rounded-full bg-[#ec2029]"></span>
                        <span>All Routes</span>
                    </button>
                    <button type="button" data-route="international" class="route-filter-btn flex items-center gap-2 text-xs font-bold transition-all duration-200 whitespace-nowrap py-4">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        <span>International</span>
                    </button>
                    <button type="button" data-route="domestic" class="route-filter-btn flex items-center gap-2 text-xs font-bold transition-all duration-200 whitespace-nowrap py-4">
                        <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                        <span>Domestic</span>
                    </button>
                </div>
                <div class="hidden sm:flex items-center gap-2 text-xs text-slate-400 font-mono">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>INTERACTIVE MAP</span>
                </div>
            </div>

            {{-- Leaflet Map --}}
            <div id="routeMap" class="w-full h-[500px]"></div>

            {{-- Info Panel --}}
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-start sm:items-center gap-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#ec2029] mt-1.5 sm:mt-0 shrink-0"></span>
                    <div>
                        <span id="routeInfoTitle" class="block text-sm font-bold text-slate-900">
                            Patimban Port Comprehensive Network
                        </span>
                        <p id="routeInfoDesc" class="text-xs text-slate-500 mt-0.5">
                            Displaying all combined active international deep-sea lanes and domestic feeder channels.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     06. TERMINAL SPECIFICATIONS — TECHNICAL DATA SHEET
═══════════════════════════════════════════════════════════════ --}}
<section class="py-24 bg-[#f8fafc] border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-6 sm:px-8">
        
        <div class="max-w-2xl mb-16" data-aos="fade-up">
            <div class="section-label">
                <span class="font-mono-label">06 / INFRASTRUCTURE</span>
            </div>
            <h2 class="text-4xl sm:text-5xl font-bold text-slate-900 mb-4 tracking-tight">
                Terminal Specifications
            </h2>
            <p class="text-slate-600 leading-relaxed">
                An integrated vehicle terminal facility engineered to streamline domestic and international automotive supply chains.
            </p>
        </div>

        <div class="grid lg:grid-cols-12 gap-8">
            {{-- Specs Table --}}
            <div class="lg:col-span-8 bg-white border border-slate-200" data-aos="fade-right">
                <div class="px-6 py-5 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
                    <h3 class="font-mono-label text-slate-700">Key Facility Specifications</h3>
                    <span class="text-xs text-slate-400 font-mono">DATASHEET</span>
                </div>
                @php
                    $specs = [
                        ['label' => 'Ro-Ro Berth',           'value' => '300 meters'],
                        ['label' => 'Water Depth',           'value' => '-14.0 m'],
                        ['label' => 'Staging Yard Capacity', 'value' => '200,000 CBU units / year'],
                    ];
                @endphp
                <div class="divide-y divide-slate-100">
                    @foreach($specs as $spec)
                        <div class="grid sm:grid-cols-2 gap-4 px-6 py-6 hover:bg-slate-50 transition-colors">
                            <span class="text-sm font-semibold text-slate-500 font-mono">{{ $spec['label'] }}</span>
                            <span class="text-lg font-bold text-[#26347a]">{{ $spec['value'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Safety & ISO --}}
            <div class="lg:col-span-4 flex flex-col gap-8" data-aos="fade-left">
                <div class="bg-[#1a2554] p-8 text-white h-full relative overflow-hidden flex flex-col justify-center">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L3 7v5c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-9-5zm0 14.5c-2.5 0-4.5-2-4.5-4.5s2-4.5 4.5-4.5 4.5 2 4.5 4.5-2 4.5-4.5 4.5z"/></svg>
                    </div>
                    <h3 class="font-bold text-xl mb-3 relative z-10">Safety & Security</h3>
                    <p class="text-slate-300 text-sm leading-relaxed relative z-10">
                        Compliant with IMO ISPS Code standards and equipped with 24/7 CCTV surveillance across all terminal zones.
                    </p>
                </div>
                <div class="bg-white p-8 border border-slate-200 h-full flex flex-col justify-center">
                    <h3 class="font-bold text-xl text-slate-900 mb-3">ISO Certified</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Operating under internationally recognized quality, environmental, and safety management standards.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     07. LOCATION & MAP
═══════════════════════════════════════════════════════════════ --}}
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6 sm:px-8">
        <div class="grid lg:grid-cols-12 gap-12 lg:gap-8 items-stretch">
            
            {{-- Left: Address Info --}}
            <div class="lg:col-span-5 flex flex-col justify-center" data-aos="fade-right">
                <div class="section-label">
                    <span class="font-mono-label">07 / LOCATION</span>
                </div>
                <h2 class="text-4xl sm:text-5xl font-bold text-slate-900 mb-6 leading-tight">
                    Patimban Port<br>Terminal
                </h2>
                <p class="text-slate-600 leading-relaxed mb-8">
                    Situated within the Patimban National Strategic Project zone in Subang Regency, offering optimized transit routes for automotive manufacturers.
                </p>
                <div class="border-l-2 border-[#ec2029] pl-6 py-2">
                    <h5 class="font-bold text-slate-900 mb-1">Port Location</h5>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Patimban Port, Pusakanagara,<br>
                        Subang Regency, West Java, Indonesia
                    </p>
                </div>
            </div>

            {{-- Right: Google Maps Embed --}}
            <div class="lg:col-span-7 h-[400px] lg:h-auto bg-slate-100 relative" data-aos="fade-left">
                {{-- Design accent line --}}
                <div class="absolute top-0 left-0 w-full h-1 bg-[#26347a] z-10 hidden lg:block"></div>
                <iframe
                    src="https://www.google.com/maps?q=Pelabuhan+Patimban,+Subang,+Jawa+Barat&z=14&t=k&output=embed"
                    class="w-full h-full absolute inset-0"
                    style="border:0;"
                    allowfullscreen
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Peta lokasi Patimban Port">
                </iframe>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     08. CTA SECTION — STRONG & MINIMAL
═══════════════════════════════════════════════════════════════ --}}
<section class="bg-[#ec2029] relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 py-20 relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-10" data-aos="fade-up">
        <div class="max-w-2xl">
            <div class="flex items-center gap-4 mb-4">
                <div class="h-px w-8 bg-white/50"></div>
                <span class="text-white/80 font-mono-label text-xs">PARTNERSHIP</span>
            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white tracking-tight leading-tight">
                Ready to Partner<br>with PICT?
            </h2>
            <p class="text-red-100 text-base mt-4 font-light max-w-lg">
                Inquire about terminal tariffs, berthing schedules, and automotive handling solutions.
            </p>
        </div>

        <a href="{{ url('/contact') }}"
           class="group inline-flex items-center justify-center gap-3 px-8 py-4 bg-[#1a2554] text-white text-sm font-bold hover:bg-white hover:text-[#1a2554] transition-colors shrink-0">
            Contact Us
            <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </a>
    </div>
    
    {{-- Subtle background pattern --}}
    <div class="absolute inset-0 opacity-10 pointer-events-none bg-grid-pattern"></div>
</section>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/i18n-iso-countries@7.7.0/dist/i18n-iso-countries.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/i18n-iso-countries@7.7.0/langs/en.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize AOS
    AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 100 });

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
       SHIPPING ROUTE — LEAFLET.JS
    ═══════════════════════════════════════════════════════════════ */
    const routesData = @json($shippingRoutes ?? []);

    if (routesData.length === 0) {
        console.warn('No shipping routes available.');
        return;
    }

    if (typeof countries !== 'undefined') {
        countries.registerLocale(require("i18n-iso-countries/langs/en.json"));
    }

    // Inisialisasi peta dengan gaya minimalis
    const map = L.map('routeMap', {
        scrollWheelZoom: false,
        worldCopyJump: true,
        attributionControl: false,
    }).setView([10, 100], 3);

    // Basemap CartoDB Positron (lebih bersih untuk corporate)
    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        maxZoom: 19,
    }).addTo(map);

    const hub = routesData.find(r => r.category === 'hub');
    const linesLayer = L.layerGroup().addTo(map);
    const markersLayer = L.layerGroup().addTo(map);

    function markerColor(category) {
        if (category === 'hub') return '#EC2029';
        if (category === 'domestic') return '#0EA5E9';
        return '#F59E0B';
    }

    const markerRefs = [];
    const lineRefs = [];

    if (hub) {
        routesData.forEach(route => {
            if (route.category === 'hub') return;
            const line = L.polyline(
                [[hub.latitude, hub.longitude], [route.latitude, route.longitude]],
                {
                    color: route.color || markerColor(route.category),
                    weight: 2,
                    dashArray: '5 5',
                    opacity: 0.8,
                }
            );
            line.addTo(linesLayer);
            lineRefs.push({ line, category: route.category });
        });
    }

    routesData.forEach(route => {
        const color = route.color || markerColor(route.category);
        const isHub = route.category === 'hub';

        const icon = L.divIcon({
            className: 'custom-marker',
            html: `
                <div style="position:relative; display:flex; justify-content:center; align-items:center;">
                    <div style="
                        width: ${isHub ? 20 : 12}px;
                        height: ${isHub ? 20 : 12}px;
                        background: ${color};
                        border: 2px solid white;
                        border-radius: 50%;
                        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
                        z-index: 2;
                    "></div>
                    ${isHub ? `<div style="
                        position: absolute;
                        top: 50%; left: 50%;
                        transform: translate(-50%, -50%);
                        width: 40px; height: 40px;
                        border-radius: 50%;
                        background: ${color};
                        opacity: 0.2;
                        animation: pulse 2s infinite;
                        z-index: 1;
                    "></div>` : ''}
                </div>
            `,
            iconSize: [16, 16],
            iconAnchor: [8, 8],
        });

        let flagCode = 'id'; 
        if (route.country && typeof countries !== 'undefined') {
            let isoCode = countries.getAlpha2Code(route.country, 'en');
            if (isoCode) {
                flagCode = isoCode.toLowerCase();
            } else {
                let countryName = route.country.toLowerCase();
                if (countryName.includes('hong kong')) flagCode = 'hk';
                else if (countryName.includes('malaysia')) flagCode = 'my';
                else if (countryName.includes('singapore')) flagCode = 'sg';
                else if (countryName.includes('thailand')) flagCode = 'th';
                else if (countryName.includes('japan')) flagCode = 'jp';
                else if (countryName.includes('china')) flagCode = 'cn';
            }
        }

        const flagImg = `<img src="https://flagcdn.com/24x18/${flagCode}.png" alt="${flagCode}" style="width: 20px; height: auto; border-radius: 2px; box-shadow: 0 1px 2px rgba(0,0,0,0.1); object-fit: cover;">`;

        const popupContent = `
            <div style="font-family: 'Inter', sans-serif; min-width: 180px;">
                <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                    ${flagImg}
                    <strong style="color:#0f172a; font-size:13px; font-family:'Space Grotesk', sans-serif;">${route.name}</strong>
                </div>
                <p style="color:#64748B; font-size:11px; margin:0 0 6px 0;">${route.country}</p>
                ${route.description ? `<p style="color:#475569; font-size:11px; margin:8px 0; line-height:1.4;">${route.description}</p>` : ''}
                ${route.transit_days ? `<div style="display:inline-block; padding:4px 8px; background:#f1f5f9; color:#EC2029; font-size:10px; font-weight:700; margin-top:4px;">TRANSIT: ${route.transit_days} DAYS</div>` : ''}
            </div>
        `;

        const marker = L.marker([route.latitude, route.longitude], { icon })
            .bindPopup(popupContent, { closeButton: false, maxWidth: 260, offset: [0, -5] })
            .addTo(markersLayer);

        markerRefs.push({ marker, category: route.category });
    });

    if (routesData.length > 1) {
        const bounds = L.latLngBounds(routesData.map(r => [r.latitude, r.longitude]));
        map.fitBounds(bounds, { padding: [50, 50], maxZoom: 5 });
    }

    // ═══ FILTER LOGIC ═══
    const filterButtons = document.querySelectorAll('.route-filter-btn');
    const infoTitle = document.getElementById('routeInfoTitle');
    const infoDesc = document.getElementById('routeInfoDesc');

    const ROUTE_INFO = {
        all: {
            title: 'Patimban Port Comprehensive Network',
            desc: `Displaying all ${routesData.length} active routes connecting Patimban Port to global and regional markets.`,
        },
        international: {
            title: 'International Shipping Routes',
            desc: 'Active international deep-sea lanes connecting Patimban to major global automotive hubs.',
        },
        domestic: {
            title: 'Domestic Feeder Network',
            desc: 'Connecting major domestic maritime trade pathways across Indonesia.',
        },
    };

    function setActiveRoute(category) {
        filterButtons.forEach(btn => {
            const isActive = btn.dataset.route === category;
            btn.classList.toggle('is-active', isActive);
        });

        markerRefs.forEach(({ marker, category: cat }) => {
            if (category === 'all' || cat === category || cat === 'hub') {
                if (!markersLayer.hasLayer(marker)) markersLayer.addLayer(marker);
            } else {
                markersLayer.removeLayer(marker);
            }
        });

        lineRefs.forEach(({ line, category: cat }) => {
            if (category === 'all' || cat === category) {
                if (!linesLayer.hasLayer(line)) linesLayer.addLayer(line);
            } else {
                linesLayer.removeLayer(line);
            }
        });

        const info = ROUTE_INFO[category] || ROUTE_INFO.all;
        if (infoTitle) infoTitle.textContent = info.title;
        if (infoDesc) infoDesc.textContent = info.desc;
    }

    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => setActiveRoute(btn.dataset.route));
    });

    setActiveRoute('all');
});
</script>
<style>
@keyframes pulse {
    0% { transform: translate(-50%, -50%) scale(0.8); opacity: 0.4; }
    70% { transform: translate(-50%, -50%) scale(1.5); opacity: 0; }
    100% { transform: translate(-50%, -50%) scale(1.5); opacity: 0; }
}
</style>
@endpush