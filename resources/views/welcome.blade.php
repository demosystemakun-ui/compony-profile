@extends('layouts.app')

@section('title', 'PT Patimban International Car Terminal — PICT')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
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

    /* ═══ HERO BASE (Split Layout Putih / Foto) ═══ */
    .pict-hero { 
        position: relative; 
        overflow: hidden; 
        background-color: #ffffff; /* PUTIH MURNI agar Navbar terlihat kontras */
        min-height: 100vh;
        display: flex;
        align-items: center;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .hero-split-wrapper {
        position: absolute;
        top: 0; right: 0; bottom: 0; left: 0;
        width: 100%; height: 100%;
        z-index: 0;
    }

    /* Desktop: Gambar di kanan dengan potongan diagonal */
    @media (min-width: 1024px) {
        .hero-split-wrapper {
            width: 65%;
            left: auto;
            /* Potongan miring dari atas-tengah ke kiri-bawah */
            clip-path: polygon(25% 0, 100% 0, 100% 100%, 0% 100%);
        }
    }

    .hero-bg-img {
        position: absolute; inset: 0; width: 100%; height: 100%;
        object-fit: cover; z-index: 0;
        object-position: center;
    }

    /* Mobile overlay agar teks terbaca */
    @media (max-width: 1023px) {
        .hero-split-wrapper { 
            opacity: 0.15; 
            width: 100%;
        }
    }

    .hero-content-wrap {
        position: relative;
        z-index: 10;
        width: 100%;
    }

    /* ═══ STATS CARD ═══ */
    .stats-strip-container { margin-top: -60px; position: relative; z-index: 30; }
    .stats-card-main {
        background: linear-gradient(135deg, #ffffff 0%, #fcfdfd 100%);
        border-radius: 1.5rem;
        box-shadow: 0 20px 45px -10px rgba(15, 23, 42, 0.12), 0 0 1px 1px rgba(255, 255, 255, 0.8) inset;
        position: relative; overflow: hidden;
    }
    .stats-card-main::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px;
        background: linear-gradient(90deg, var(--color-signal) 0%, var(--color-navy) 100%);
    }
    .stat-item {
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), background-color 0.3s ease;
        border-radius: 1rem; padding: 1rem 0.5rem;
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
        content: ""; position: absolute; left: .35rem; top: .8rem; bottom: .8rem;
        width: 1px; background: linear-gradient(to bottom, var(--color-signal), var(--color-navy));
    }
    .about-value-item { position: relative; padding-bottom: 1.5rem; }
    .about-value-item:last-child { padding-bottom: 0; }
    .about-value-item::before {
        content: ""; position: absolute; left: -1.75rem; top: .35rem;
        width: .75rem; height: .75rem; border: 3px solid #ffffff;
        border-radius: 9999px; background: var(--color-signal);
        box-shadow: 0 0 0 1px var(--color-signal);
    }

    /* ═══ EYEBROW ═══ */
    .eyebrow {
        display: inline-block; font-size: 0.75rem; font-weight: 800;
        letter-spacing: 0.22em; text-transform: uppercase; color: var(--color-signal);
    }

    /* ═══ ROUTE FILTER BUTTONS ═══ */
    .route-filter-btn { color: var(--color-muted); }
    .route-filter-btn.is-active {
        background: #ffffff; color: var(--color-ink);
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.08);
    }

    /* ═══ LEAFLET CUSTOM POPUP ═══ */
    .leaflet-popup-content-wrapper {
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.15);
    }
    .leaflet-popup-content { margin: 12px 16px; }

    /* ═══ LEAFLET PULSE ANIMATION ═══ */
    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.4; }
        50%      { transform: scale(1.5); opacity: 0; }
    }

    /* ═══ GALLERY EDITORIAL ═══ */
    .gallery-editorial {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    @media (min-width: 768px) {
        .gallery-editorial {
            grid-template-columns: repeat(3, 1fr);
            grid-auto-rows: 250px;
        }
        .gallery-editorial > *:first-child {
            grid-column: span 2;
            grid-row: span 2;
        }
    }
    .gallery-editorial-item {
        position: relative;
        overflow: hidden;
        border-radius: 1rem;
    }
</style>
@endpush

@section('content')

{{-- ═══════════════════════════════════════════════════════════════
     1. HERO SECTION — SPLIT WHITE / DIAGONAL IMAGE
═══════════════════════════════════════════════════════════════ --}}
{{-- pt-32 memastikan teks turun ke bawah navbar yang melayang --}}
<section class="pict-hero pt-32 pb-16 lg:pt-0 lg:pb-0">
    {{-- Gambar dengan potongan diagonal --}}
    <div class="hero-split-wrapper">
        <img src="{{ asset('assets/images/harmoni.png') }}"
             alt="Patimban Port terminal"
             class="hero-bg-img"
             fetchpriority="high">
    </div>

    {{-- Konten Teks --}}
    <div class="hero-content-wrap max-w-7xl mx-auto px-6 sm:px-8 lg:px-10 py-12 lg:py-0">
        <div class="grid lg:grid-cols-12 gap-8 items-center">
            
            {{-- Kiri: Teks --}}
            <div class="lg:col-span-6 xl:col-span-5 flex flex-col justify-center space-y-6">
                


                {{-- Judul Utama --}}
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 leading-[1.1] tracking-tight">
                    PATIMBAN<br>
                    INTERNATIONAL<br>
                    <span class="text-[#ec2029]">CAR TERMINAL</span>
                </h1>

                {{-- Deskripsi --}}
                <p class="text-slate-600 text-base sm:text-lg leading-relaxed max-w-md">
                    Providing professional Cargo Handling services at Patimban Port with world-class smart logistics capabilities, operational excellence, and unmatched safety standards.
                </p>

                {{-- Tombol CTA --}}
                <div class="pt-2">
                    <a href="{{ url('/about') }}" class="inline-flex items-center gap-3 bg-[#ec2029] hover:bg-[#d11922] text-white px-6 py-3.5 text-sm font-bold transition-all duration-300 shadow-md hover:shadow-lg">
                        Learn More About PICT
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Kanan: Kosong (Area Gambar) --}}
            <div class="hidden lg:block lg:col-span-6 xl:col-span-7"></div>
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
     4. TERMINAL GALLERY (EDITORIAL STYLE)
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

        <div class="gallery-editorial">
            @forelse($terminalGallery as $index => $item)
                <article class="gallery-editorial-item group relative">
                    <img src="{{ $item->image_url }}"
                         alt="{{ $item->title }}"
                         loading="lazy"
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/40 to-transparent opacity-90 flex flex-col justify-end p-6">
                        <h3 class="text-xl font-bold text-white mb-2">{{ $item->title }}</h3>
                        <p class="text-slate-200 text-sm leading-relaxed line-clamp-2">
                            {{ $item->description }}
                        </p>
                    </div>
                </article>
            @empty
                <div class="col-span-full text-center py-12 text-slate-400 text-sm">
                    Belum ada gambar galeri untuk halaman Home. Silakan tambahkan melalui Admin Panel.
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     5. SHIPPING ROUTE NETWORK — LEAFLET.JS
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
            {{-- Filter Buttons --}}
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 pb-5 mb-5 border-b border-slate-100">
                <div id="routeLegend" class="inline-flex p-1 bg-slate-100 rounded-xl gap-1 self-start sm:self-auto" role="tablist">
                    <button type="button" data-route="all"
                            class="route-filter-btn is-active flex items-center gap-2 text-xs font-bold rounded-lg px-4 py-2 transition-all duration-200">
                        <span class="w-2 h-2 rounded-full bg-red-600"></span>
                        <span>All Routes</span>
                    </button>
                    <button type="button" data-route="international"
                            class="route-filter-btn flex items-center gap-2 text-xs font-bold rounded-lg px-4 py-2 transition-all duration-200">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        <span>International</span>
                    </button>
                    <button type="button" data-route="domestic"
                            class="route-filter-btn flex items-center gap-2 text-xs font-bold rounded-lg px-4 py-2 transition-all duration-200">
                        <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                        <span>Domestic</span>
                    </button>
                </div>
            </div>

            {{-- Peta Leaflet --}}
            <div id="routeMap" class="w-full h-[500px] rounded-xl border border-slate-100 overflow-hidden"></div>

            {{-- Panel Info --}}
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
        <div class="lg:col-span-5 location-reveal space-y-6" data-aos="fade-right">
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

      <div class="lg:col-span-7 location-reveal rounded-2xl overflow-hidden shadow-lg border border-slate-200 h-80 md:h-[420px] bg-slate-100" data-aos="fade-left">
            <iframe
                src="https://www.google.com/maps?q=Pelabuhan+Patimban,+Subang,+Jawa+Barat&z=15&t=k&output=embed"
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
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/i18n-iso-countries@7.7.0/dist/i18n-iso-countries.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/i18n-iso-countries@7.7.0/langs/en.min.js"></script>

<script>
/* ═══ HELPER ═══ */

// Pilih versi longitude yang paling dekat dengan titik acuan (hub).
// Contoh: Meksiko -99 dengan acuan 108 menjadi 261 (digambar di sisi Pasifik).
function nearestLng(lng, ref) {
    while (lng - ref > 180)  lng -= 360;
    while (lng - ref < -180) lng += 360;
    return lng;
}

// Cegah HTML/script nyasar dari data admin masuk ke popup
function escapeHtml(value) {
    return String(value ?? '').replace(/[&<>"']/g, ch => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
    }[ch]));
}

// Emoji bendera -> kode negara 2 huruf (🇲🇽 -> "mx")
function flagCodeFromEmoji(str) {
    const cps = [...str]
        .map(c => c.codePointAt(0))
        .filter(cp => cp >= 0x1F1E6 && cp <= 0x1F1FF);
    if (cps.length < 2) return null;
    return String.fromCharCode(cps[0] - 0x1F1E6 + 65, cps[1] - 0x1F1E6 + 65).toLowerCase();
}

function flagImg(code) {
    return `<img src="https://flagcdn.com/24x18/${code}.png" alt="${code}" style="width:24px;height:auto;border-radius:2px;">`;
}

window.initHomeScripts = function() {
    if (typeof AOS !== 'undefined') {
        AOS.init({ duration: 900, easing: 'ease-out-cubic', once: true, offset: 120 });
    }

    // Stats Counter
    document.querySelectorAll('.stat-number').forEach(el => {
        const target = parseInt(el.dataset.target, 10);
        if (isNaN(target)) return;
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

    // Cegah inisialisasi ganda map saat pindah halaman
    if (window.myRouteMap) {
        window.myRouteMap.remove();
        window.myRouteMap = null;
    }

    const routesData = @json($shippingRoutes ?? []);

    if (!Array.isArray(routesData) || routesData.length === 0) {
        return;
    }

    const mapEl = document.getElementById('routeMap');
    if (!mapEl) {
        setTimeout(window.initHomeScripts, 100);
        return;
    }

    window.myRouteMap = L.map('routeMap', {
        scrollWheelZoom: false,
        worldCopyJump: true,
        minZoom: 2,
    }).setView([10, 120], 3);

    L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles © Esri',
        maxZoom: 19,
    }).addTo(window.myRouteMap);

    // Filter data rusak (latitude/longitude 0 tetap dianggap valid)
    const parsedRoutes = routesData
        .filter(r => r && r.latitude !== null && r.latitude !== '' && r.longitude !== null && r.longitude !== '')
        .map(r => ({
            ...r,
            latitude: parseFloat(r.latitude),
            longitude: parseFloat(r.longitude),
        }))
        .filter(r => !isNaN(r.latitude) && !isNaN(r.longitude));

    if (parsedRoutes.length === 0) return;

    // Hub dipakai sebagai titik acuan: semua rute digambar di sisi peta yang paling dekat dengan hub
    const hubRaw = parsedRoutes.find(r => r.category === 'hub');
    const refLng = hubRaw ? hubRaw.longitude : 108;

    const validRoutes = parsedRoutes.map(r => ({
        ...r,
        mapLng: nearestLng(r.longitude, refLng),   // Meksiko -99 menjadi 261
    }));

    const hub = validRoutes.find(r => r.category === 'hub');
    const linesLayer = L.layerGroup().addTo(window.myRouteMap);
    const markersLayer = L.layerGroup().addTo(window.myRouteMap);

    function markerColor(category) {
        if (category === 'hub') return '#EC2029';
        if (category === 'domestic') return '#0EA5E9';
        return '#F59E0B';
    }

    const markerRefs = [];
    const lineRefs = [];

    if (hub) {
        validRoutes.forEach(route => {
            if (route.category === 'hub') return;
            try {
                const line = L.polyline(
                    [[hub.latitude, hub.mapLng], [route.latitude, route.mapLng]],
                    { color: route.color || markerColor(route.category), weight: 2, dashArray: '6 4', opacity: 0.7 }
                );
                line.addTo(linesLayer);
                lineRefs.push({ line, category: route.category });
            } catch (e) {
                console.warn("Gagal menggambar garis:", e);
            }
        });
    }

    function resolveFlagHtml(route) {
        if (route.flag && typeof route.flag === 'string' && route.flag.trim() !== '') {
            const raw = route.flag.trim();

            // Emoji bendera -> gambar (supaya tampil juga di Windows)
            const emojiCode = flagCodeFromEmoji(raw);
            if (emojiCode) return flagImg(emojiCode);

            if (/^[A-Za-z]{2,3}$/.test(raw)) return flagImg(raw.toLowerCase());
        }

        let flagCode = 'id';
        if (route.country && typeof countries !== 'undefined' && typeof countries.getAlpha2Code === 'function') {
            try {
                const iso = countries.getAlpha2Code(route.country, 'en');
                if (iso) flagCode = iso.toLowerCase();
            } catch (e) {}
        }
        if (flagCode === 'id' && route.country) {
            const c = route.country.toLowerCase();
            if (c.includes('hong kong')) flagCode = 'hk';
            else if (c.includes('malaysia')) flagCode = 'my';
            else if (c.includes('singapore')) flagCode = 'sg';
            else if (c.includes('thailand')) flagCode = 'th';
            else if (c.includes('japan')) flagCode = 'jp';
            else if (c.includes('china')) flagCode = 'cn';
            else if (c.includes('philippines')) flagCode = 'ph';
            else if (c.includes('vietnam')) flagCode = 'vn';
            else if (c.includes('korea')) flagCode = 'kr';
            else if (c.includes('australia')) flagCode = 'au';
            else if (c.includes('united states') || c === 'usa' || c === 'us') flagCode = 'us';
            else if (c.includes('netherlands')) flagCode = 'nl';
            else if (c.includes('united kingdom') || c === 'uk') flagCode = 'gb';
            else if (c.includes('india')) flagCode = 'in';
            else if (c.includes('emirates') || c === 'uae') flagCode = 'ae';
            else if (c.includes('mexico') || c.includes('meksiko')) flagCode = 'mx';
            else if (c.includes('brunei')) flagCode = 'bn';
        }

        return flagImg(flagCode);
    }

    validRoutes.forEach(route => {
        try {
            const color = route.color || markerColor(route.category);
            const isHub = route.category === 'hub';

            const icon = L.divIcon({
                className: 'custom-marker',
                html: `
                    <div style="position:relative;">
                        <div style="width: ${isHub ? 24 : 16}px;height: ${isHub ? 24 : 16}px;background: ${color};border: 3px solid white;border-radius: 50%;box-shadow: 0 2px 8px rgba(0,0,0,0.3);"></div>
                        ${isHub ? `<div style="position: absolute;top: -8px; left: -8px;width: 40px; height: 40px;border-radius: 50%;background: ${color};opacity: 0.2;animation: pulse 2s infinite;"></div>` : ''}
                    </div>
                `,
                iconSize: [16, 16],
                iconAnchor: [8, 8],
            });

            const popupContent = `
                <div style="font-family: 'Poppins', sans-serif; min-width: 180px;">
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom:6px;">
                        ${resolveFlagHtml(route)}
                        <strong style="color:#0A2540; font-size:14px;">${escapeHtml(route.name)}</strong>
                    </div>
                    <p style="color:#64748B; font-size:11px; margin:0 0 4px 0;">${escapeHtml(route.country)}</p>
                    ${route.description ? `<p style="color:#475569; font-size:11px; margin:6px 0;">${escapeHtml(route.description)}</p>` : ''}
                    ${route.transit_days ? `<p style="color:#EC2029; font-size:11px; font-weight:600; margin-top:6px;">⚓ Transit: ${escapeHtml(route.transit_days)} days</p>` : ''}
                </div>
            `;

            const marker = L.marker([route.latitude, route.mapLng], { icon })
                .bindPopup(popupContent, { closeButton: true, maxWidth: 260 })
                .addTo(markersLayer);

            markerRefs.push({ marker, category: route.category });
        } catch (e) {
            console.warn("Gagal menggambar marker untuk: " + route.name, e);
        }
    });

    if (validRoutes.length > 1) {
        try {
            const bounds = L.latLngBounds(validRoutes.map(r => [r.latitude, r.mapLng]));
            window.myRouteMap.fitBounds(bounds, { padding: [50, 50], maxZoom: 5 });
        } catch (e) {}
    }

    const filterButtons = document.querySelectorAll('.route-filter-btn');
    const infoTitle = document.getElementById('routeInfoTitle');
    const infoDesc = document.getElementById('routeInfoDesc');

    const ROUTE_INFO = {
        all: {
            title: 'Patimban Port Comprehensive Network',
            desc: `Displaying all ${validRoutes.length} active routes connecting Patimban Port to global and regional markets.`,
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
};

document.addEventListener('DOMContentLoaded', window.initHomeScripts);
document.addEventListener('swup:page:view', window.initHomeScripts);
</script>
@endpush

<!-- hdajdajhdakj -->