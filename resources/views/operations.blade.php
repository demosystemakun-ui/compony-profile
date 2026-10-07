@extends('layouts.app')

@section('title', 'Operations — PT Patimban International Car Terminal')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Manrope:wght@700;800&display=swap" rel="stylesheet">
<style>
    /* ═══ DESIGN SYSTEM — PICT TERMINAL DOSSIER ═══ */
    :root {
        --color-navy:   #0A2540;
        --color-steel:  #1D4E74;
        --color-signal: #EC2029;
        --color-paper:  #F5F3EE;
        --color-ink:    #16232E;
        --color-muted:  #5B6672;
        --color-line:   #D8D4C8;
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: var(--color-paper);
        color: var(--color-ink);
        overflow-x: hidden;
    }

    h1, h2, h3, h4, h5, h6, .font-heading {
        font-family: 'Manrope', sans-serif;
    }

    /* ═══ INDEX LABEL (konsisten di semua section) ═══ */
    .index-label {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .index-label .num {
        font-family: 'Manrope', sans-serif;
        font-weight: 700;
        color: var(--color-signal);
        font-size: 0.85rem;
    }
    .index-label .rule {
        height: 1px;
        width: 2rem;
        background: var(--color-line);
        flex-shrink: 0;
    }
    .index-label .lbl {
        color: var(--color-muted);
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }
    .index-label.on-dark .rule { background: rgba(255,255,255,0.25); }
    .index-label.on-dark .lbl  { color: rgba(255,255,255,0.6); }

    /* ═══ UTILITIES ═══ */
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

    .grid-texture {
        background-image:
            linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px);
        background-size: 48px 48px;
    }

    /* ═══ HERO SLIDESHOW ═══ */
    .hero-slide {
        position: absolute;
        inset: 0;
        background-size: cover;
        background-position: center;
        opacity: 0;
        transition: opacity 1.2s ease-in-out;
    }
    .hero-slide.active { opacity: 1; }

    /* ═══ FLOW STEPS ═══ */
    .flow-btn.active .node-indicator {
        background-color: var(--color-signal);
        border-color: var(--color-signal);
        color: white;
        box-shadow: 0 0 0 4px rgba(236, 32, 41, 0.2);
    }
    .flow-btn.active h3 { color: var(--color-signal); }
    .flow-btn.active .arrow-indicator {
        opacity: 1;
        transform: translateY(0);
    }

    /* ═══ FADE CONTENT ═══ */
    .fade-content { animation: fadeInData 0.4s ease-out forwards; }
    @keyframes fadeInData {
        0%   { opacity: 0; transform: translateY(10px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    /* ═══ SCROLLBAR ═══ */
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: var(--color-paper); }
    ::-webkit-scrollbar-thumb { background: #c3bda9; border-radius: 4px; }
    ::-webkit-scrollbar-thumb:hover { background: #a89f84; }
</style>
@endpush

@section('content')

{{-- ═══════════════════════════════════════════════════════════════
     1. HERO
═══════════════════════════════════════════════════════════════ --}}
<section class="relative min-h-[85vh] w-full flex flex-col justify-between overflow-hidden bg-slate-900 pt-28 pb-0">
    <div id="hero-slideshow"
         data-images='{{ json_encode([
             secure_asset("assets/images/background.jpeg"),
             secure_asset("assets/images/patimban-yard-1.jpeg"),
             secure_asset("assets/images/vessel-5.jpeg"),
             secure_asset("assets/images/car-4.jpeg")
         ]) }}'
         class="absolute inset-0 z-0"></div>

    <div class="absolute inset-0 bg-gradient-to-b from-slate-950/75 via-slate-950/45 to-slate-950/85 z-[1] pointer-events-none"></div>

    <div class="relative max-w-7xl mx-auto px-5 sm:px-6 z-10 w-full my-auto py-8">
        <div class="max-w-3xl" data-aos="fade-up" data-aos-duration="900">
          
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight font-heading leading-[1.1] mb-4 sm:mb-6">
                A Ro-Ro terminal built to move vehicles, not just words.
            </h1>
            <p class="text-sm sm:text-lg text-slate-200 font-light leading-relaxed max-w-2xl">
                From vessel arrival to gate-out, every unit that crosses our berth is tracked, inspected, and handled to a zero-scratch standard.
            </p>
        </div>
    </div>

    <div class="relative max-w-7xl mx-auto px-5 sm:px-6 w-full z-10 border-t border-white/15">
        <div class="grid grid-cols-2 sm:grid-cols-4">
            @php
                $credentials = ['Smart Terminal', 'ISO Standards', 'Zero Scratch Policy', 'Real-Time Monitoring'];
            @endphp
            @foreach($credentials as $i => $cred)
                <div class="flex items-center gap-2 py-4 px-2 sm:px-6 {{ $i > 0 ? 'border-l border-white/15' : '' }}">
                    <svg viewBox="0 0 16 16" class="w-3.5 h-3.5 text-white/70 flex-shrink-0" aria-hidden="true">
                        <path d="M2 8.5L6 12L14 3" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="text-xs sm:text-sm font-medium text-white/90">{{ $cred }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     2. TERMINAL AT A GLANCE
═══════════════════════════════════════════════════════════════ --}}
<section class="relative z-20 bg-white border-b border-[var(--color-line)]">
    <div class="max-w-7xl mx-auto px-5 sm:px-6">
        @php
            $glanceStats = [
                ['value' => '218', 'label' => 'Thousand units, annual capacity',   'color' => 'navy',   'counter' => true],
                ['value' => '300', 'label' => 'Metres of Ro-Ro berth',              'color' => 'navy',   'counter' => true],
                ['value' => '24/7','label' => 'Continuous operations',              'color' => 'navy',   'counter' => false],
                ['value' => 'Zero','label' => 'Scratch tolerance policy',           'color' => 'signal', 'counter' => false],
            ];
        @endphp

        <div class="grid grid-cols-2 lg:grid-cols-4">
            @foreach($glanceStats as $i => $s)
                <div class="py-8 {{ $i === 0 ? 'pr-4 lg:border-r' : '' }} {{ $i === 1 ? 'pl-4 lg:pl-8 lg:pr-6 lg:border-r' : '' }} {{ $i === 2 ? 'pr-4 pl-4 lg:pl-8 lg:border-r border-t lg:border-t-0' : '' }} {{ $i === 3 ? 'pl-4 lg:pl-8 border-t lg:border-t-0' : '' }} border-[var(--color-line)]">
                    <div class="text-3xl sm:text-5xl font-extrabold font-heading tracking-tight mb-1
                                {{ $s['color'] === 'signal' ? 'text-[#EC2029]' : 'text-[#0A2540]' }}
                                {{ $s['counter'] ? 'counter' : '' }}"
                         @if($s['counter']) data-target="{{ $s['value'] }}" @endif>
                        {{ $s['counter'] ? '0' : $s['value'] }}
                    </div>
                    <div class="text-xs sm:text-sm text-[var(--color-muted)]">{{ $s['label'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     3. LIVE WEATHER & MARINE CONDITIONS
═══════════════════════════════════════════════════════════════ --}}
<section class="py-10 sm:py-16 bg-slate-900 text-white relative overflow-hidden">
    <div class="pointer-events-none absolute -top-32 -right-32 h-96 w-96 rounded-full bg-[#EC2029]/10 blur-3xl"></div>

    <div class="max-w-7xl mx-auto px-5 sm:px-6 relative z-10">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 sm:mb-8 gap-4" data-aos="fade-up">
            <div>
                <span class="text-[#EC2029] font-bold tracking-[0.2em] text-[11px] sm:text-xs uppercase block mb-2">
                    Safety &amp; Operations
                </span>
                <h2 class="text-xl sm:text-3xl font-extrabold tracking-tight font-heading">
                    Patimban Port Marine &amp; Weather Conditions
                </h2>
            </div>
            <div class="flex items-center gap-2.5 bg-slate-800/80 px-3.5 py-2 rounded-xl border border-slate-700 text-xs text-slate-300">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span id="live-clock" class="font-mono font-medium text-slate-200">Loading time...</span>
            </div>
        </div>

        @php
            $weatherCards = [
                ['id' => 'weather-temp',     'label' => 'Temperature',  'default' => '-- °C',    'sub' => 'Patimban Harbor Area',   'iconColor' => 'text-amber-400',   'icon' => 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z'],
                ['id' => 'weather-wind',     'label' => 'Wind Speed',   'default' => '-- km/h',  'sub' => 'Safe for Berthing',      'iconColor' => 'text-sky-400',     'icon' => 'M14 5l7 7m0 0l-7 7m7-7H3'],
                ['id' => 'weather-humidity', 'label' => 'Humidity',     'default' => '-- %',     'sub' => 'Atmospheric Moisture',   'iconColor' => 'text-blue-400',    'icon' => 'M19 14l-7 7m0 0l-7-7m7 7V3'],
                ['id' => null,               'label' => 'Berth Status', 'default' => 'OPTIMAL',  'sub' => 'Normal Ro-Ro Condition', 'iconColor' => 'text-emerald-400', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'isStatus' => true],
            ];
        @endphp

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-8 sm:mb-10" data-aos="fade-up" data-aos-delay="100">
            @foreach($weatherCards as $w)
                <div class="bg-slate-800/60 border border-slate-700/80 rounded-2xl p-3.5 sm:p-6 backdrop-blur-md">
                    <div class="flex items-center justify-between text-slate-400 mb-2 sm:mb-4">
                        <span class="text-[11px] sm:text-sm font-semibold uppercase tracking-wider">{{ $w['label'] }}</span>
                        <svg class="w-4 h-4 sm:w-6 sm:h-6 {{ $w['iconColor'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $w['icon'] }}"/>
                        </svg>
                    </div>
                    <p @if($w['id']) id="{{ $w['id'] }}" @endif
                       class="text-xl sm:text-3xl font-extrabold {{ !empty($w['isStatus']) ? 'text-lg sm:text-2xl text-emerald-400' : 'text-white' }}">
                        {{ $w['default'] }}
                    </p>
                    <p class="text-slate-400 text-[10px] sm:text-xs mt-1">{{ $w['sub'] }}</p>
                </div>
            @endforeach
        </div>

        <h3 class="text-base sm:text-lg font-bold text-slate-200 tracking-tight font-heading mb-3">
            7-Day Weather Forecast
        </h3>
        <div id="weather-forecast-container" class="flex items-stretch gap-3 overflow-x-auto pb-4 pt-1 snap-x hide-scrollbar">
            <div class="text-center py-6 text-slate-400 text-xs w-full">Loading forecast data...</div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     4. WHY PICT
═══════════════════════════════════════════════════════════════ --}}
<section class="py-14 sm:py-20 bg-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 relative z-10">
        <div class="max-w-2xl mb-10 sm:mb-14" data-aos="fade-up">
            <div class="index-label mb-4">
                <span class="rule"></span>
                <span class="lbl">Why PICT</span>
            </div>
            <h2 class="text-2xl sm:text-4xl font-extrabold text-[#0A2540] tracking-tight font-heading leading-tight">
                Three things a shipping line checks before choosing a terminal
            </h2>
            <p class="mt-3 text-[var(--color-muted)] text-sm sm:text-base leading-relaxed">
                Digital visibility, certified safety, and a location that shortens the distance between the factory and the ship.
            </p>
        </div>

        @php
            $whyPict = [
                [
                    'img'   => 'smart-icon.png',
                    'alt'   => 'Smart Terminal',
                    'title' => 'Smart terminal technology',
                    'desc'  => 'A Terminal Management System, automated gate controls, and RFID tracking give operators instant visibility of every vessel and yard position.',
                ],
                [
                    'img'   => 'internet-icon.png',
                    'alt'   => 'International Safety',
                    'title' => 'International safety standard',
                    'desc'  => 'We hold to the ISPS Code and relevant ISO certifications, with safety protocols that protect personnel and cargo on every shift.',
                ],
                [
                    'img'   => 'ekskapator-icon.png',
                    'alt'   => 'Efficient Logistics',
                    'title' => 'Efficient automotive logistics',
                    'desc'  => 'Positioned on the north coast of West Java, close to manufacturing hubs and on direct international shipping routes, cutting turnaround time.',
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 border-t border-[var(--color-line)]">
            @foreach($whyPict as $i => $item)
                <div class="py-8 border-t md:border-t-0 border-[var(--color-line)] {{ $i === 0 ? 'md:pr-8 md:border-r' : '' }} {{ $i === 1 ? 'md:px-8 md:border-r' : '' }} {{ $i === 2 ? 'md:pl-8' : '' }}">
                    <div class="w-16 h-16 mb-5 mx-auto flex items-center justify-center">
                        <img src="{{ secure_asset('assets/images/' . $item['img']) }}" alt="{{ $item['alt'] }}" class="w-full h-full object-contain">
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-[#0A2540] mb-2 font-heading text-center">
                        {{ $item['title'] }}
                    </h3>
                    <p class="text-[var(--color-muted)] text-xs sm:text-sm leading-relaxed text-center">
                        {{ $item['desc'] }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     5. TERMINAL OPERATION FLOW
═══════════════════════════════════════════════════════════════ --}}
<section id="operations-flow" class="py-14 sm:py-20 bg-[var(--color-paper)] relative overflow-hidden border-t border-[var(--color-line)]">
    <div class="max-w-7xl mx-auto px-5 sm:px-6">
        <div class="max-w-2xl mb-10 sm:mb-14" data-aos="fade-up">
            <div class="index-label mb-4">
                <span class="rule"></span>
                <span class="lbl">Operation Flow</span>
            </div>
            <h2 class="text-2xl sm:text-4xl font-extrabold text-[#0A2540] tracking-tight font-heading leading-tight mt-2">
                Seven stages, from ship arrival to gate-out
            </h2>
            <p class="mt-2.5 text-[var(--color-muted)] text-sm">
                Select a stage below to explore its timing, equipment, safety standard, and assigned division.
            </p>
        </div>

        @php
            $steps = [
                ['title' => 'Ship Arrival',        'time' => '1–2 Hours Prior',   'equip' => 'Vessel Traffic Services (VTS)',   'safety' => 'ISPS Code Compliance',   'div' => 'Marine Operations',   'desc' => 'Coordination with maritime authorities to ensure safe entry into the port limits before docking procedures begin.'],
                ['title' => 'Berthing',            'time' => '45–60 Minutes',     'equip' => 'Tugboats & Mooring Lines',        'safety' => 'Port Safety Clearance',  'div' => 'Harbor Master Team',  'desc' => 'Securing the vessel to the terminal dock using specialized tugs and heavy-duty mooring systems.'],
                ['title' => 'Vehicle Inspection',  'time' => '10 Min / Unit',     'equip' => 'Digital Handheld Scanners',       'safety' => 'Zero-Scratch Protocol',  'div' => 'Quality Assurance',   'desc' => 'Pre-discharge visual and digital scanning of units to document condition and ensure zero damage.'],
                ['title' => 'Ro-Ro Discharge',     'time' => '2–4 Hours Total',   'equip' => 'Hydraulic Ramps & Lashing',       'safety' => 'PPE & Traffic Control',  'div' => 'Stevedoring Division','desc' => 'Safe and systematic driving of vehicles from the vessel decks down the ramps into the initial staging area.'],
                ['title' => 'Yard Management',     'time' => 'Immediate Staging', 'equip' => 'Automated Yard Locator (TMS)',    'safety' => 'Speed Limit 20 km/h',    'div' => 'Yard Control Center', 'desc' => 'Routing and parking units in designated zones utilizing our proprietary Terminal Management System.'],
                ['title' => 'Quality Check',       'time' => 'Final Audit',       'equip' => 'High-Resolution Cameras',         'safety' => 'Pre-Delivery Inspection','div' => 'Inspection Team',    'desc' => 'Comprehensive post-discharge inspection to verify VIN numbers, accessories, and overall vehicle integrity.'],
                ['title' => 'Distribution',        'time' => 'On-Demand Gate Out', 'equip' => 'Car Carriers / Transporters',    'safety' => 'Gate Security Check',    'div' => 'Logistics & Delivery','desc' => 'Loading units onto commercial transporters and finalizing documentation for domestic or international dispatch.'],
            ];
        @endphp

        {{-- Timeline Navigation --}}
        <div class="relative z-10" data-aos="fade-up" data-aos-delay="100">
            <div class="hidden md:block absolute top-[24px] left-[7%] right-[7%] h-[2px] bg-slate-200 -z-10"></div>
            <div class="flex overflow-x-auto md:grid md:grid-cols-7 gap-3 md:gap-2 pb-4 md:pb-0 hide-scrollbar" id="flow-navigation">
                @foreach($steps as $index => $step)
                    <button type="button"
                            onclick="activateFlowStep({{ $index }})"
                            class="flow-btn group relative flex flex-col items-center min-w-[100px] md:min-w-0 text-center transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#EC2029] rounded-lg"
                            data-index="{{ $index }}">
                        <div class="node-indicator w-11 h-11 md:w-12 md:h-12 rounded-full bg-white border-2 border-slate-200 flex items-center justify-center text-[#0A2540] font-bold text-xs md:text-sm shadow-sm transition-all duration-300 group-hover:border-[#EC2029] group-hover:text-[#EC2029] mb-2.5 relative z-10">
                            0{{ $index + 1 }}
                        </div>
                        <h3 class="text-[#0A2540] font-bold text-xs leading-tight group-hover:text-[#EC2029] transition-colors h-8 flex items-start justify-center">
                            {{ $step['title'] }}
                        </h3>
                        <div class="arrow-indicator opacity-0 transform -translate-y-2 transition-all duration-300 mt-1 text-[#EC2029]">
                            <svg class="w-4 h-4 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                            </svg>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Detail Panel --}}
        <div class="mt-6 relative" data-aos="fade-up" data-aos-delay="200">
            <div class="bg-white border border-[var(--color-line)] rounded-xl shadow-sm overflow-hidden">
                <div class="p-4 sm:p-6 flex flex-col lg:flex-row gap-4 lg:gap-8 items-center">
                    <div class="w-full lg:flex-1 border-b lg:border-b-0 lg:border-r border-slate-100 pb-4 lg:pb-0 lg:pr-6">
                        <div class="flex items-center gap-3 lg:block">
                            <span class="text-[#EC2029] font-extrabold text-3xl sm:text-4xl opacity-15 font-heading lg:mb-1" id="detail-number">01</span>
                            <h3 class="text-lg sm:text-2xl font-bold text-[#0A2540] font-heading lg:mb-2" id="detail-title">Ship Arrival</h3>
                        </div>
                        <p class="text-[var(--color-muted)] text-xs sm:text-sm leading-relaxed mt-2 lg:mt-0" id="detail-desc">
                            Coordination with maritime authorities to ensure safe entry into the port limits before docking procedures begin.
                        </p>
                    </div>

                    <div class="w-full lg:flex-1 grid grid-cols-2 gap-2.5 sm:gap-3">
                        @foreach([
                            ['label' => 'Est. Time',  'id' => 'detail-time',   'value' => '1–2 Hours Prior',       'class' => 'text-[#0A2540]'],
                            ['label' => 'Equipment',  'id' => 'detail-equip',  'value' => 'Vessel Traffic Services','class' => 'text-[#0A2540]'],
                            ['label' => 'Safety',     'id' => 'detail-safety', 'value' => 'ISPS Code Compliance',   'class' => 'text-[#EC2029]'],
                            ['label' => 'Division',   'id' => 'detail-div',    'value' => 'Marine Operations',      'class' => 'text-[#0A2540]'],
                        ] as $field)
                            <div class="bg-slate-50 p-2.5 sm:p-3 rounded-lg border border-slate-100">
                                <span class="block text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">
                                    {{ $field['label'] }}
                                </span>
                                <span class="block {{ $field['class'] }} text-xs sm:text-sm font-semibold truncate" id="{{ $field['id'] }}">
                                    {{ $field['value'] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     6. WORLD-CLASS SERVICES
═══════════════════════════════════════════════════════════════ --}}
<section class="py-14 sm:py-20 bg-white relative overflow-hidden border-t border-[var(--color-line)]">
    <div class="max-w-7xl mx-auto px-5 sm:px-6">
        <div class="max-w-2xl mb-10 sm:mb-14" data-aos="fade-up">
            <div class="index-label mb-4">
                <span class="rule"></span>
                <span class="lbl">Services</span>
            </div>
            <h2 class="text-2xl sm:text-4xl font-extrabold text-[#0A2540] tracking-tight font-heading leading-tight">
                Two capabilities, one terminal
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            {{-- Ro-Ro Vessel Handling --}}
            <div class="group relative h-80 sm:h-[380px] rounded-xl overflow-hidden bg-slate-900">
                <div class="absolute inset-0 bg-cover bg-center transform group-hover:scale-105 transition-transform duration-700"
                     style="background-image: url('{{ secure_asset("assets/images/background.jpeg") }}')"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/35 to-transparent"></div>
                <div class="absolute inset-0 p-6 sm:p-8 flex flex-col justify-end">
                    <span class="text-[11px] font-medium text-white/60 mb-1">Maritime solutions</span>
                    <h3 class="text-xl sm:text-2xl font-bold text-white mb-2 font-heading">Ro-Ro vessel handling</h3>
                    <p class="text-slate-200 text-xs sm:text-sm max-w-md">
                        Deep-water berth facilities and experienced mooring teams for a fast, safe vessel turnaround.
                    </p>
                </div>
            </div>

            {{-- Yard Management --}}
            <div class="group relative h-80 sm:h-[380px] rounded-xl overflow-hidden bg-slate-900">
                <div class="absolute inset-0 bg-cover bg-center transform group-hover:scale-105 transition-transform duration-700"
                     id="yard-slideshow"
                     data-images="{{ json_encode([
                         secure_asset('assets/images/patimban-yard-1.jpeg'),
                         secure_asset('assets/images/car.jpeg'),
                         secure_asset('assets/images/vessel-5.jpeg'),
                         secure_asset('assets/images/car-4.jpeg')
                     ]) }}"
                     style="background-image: url('{{ secure_asset('assets/images/patimban-yard-1.jpeg') }}');"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/35 to-transparent"></div>
                <div class="absolute inset-0 p-6 sm:p-8 flex flex-col justify-end">
                    <span class="text-[11px] font-medium text-white/60 mb-1">Storage facility</span>
                    <h3 class="text-xl sm:text-2xl font-bold text-white mb-2 font-heading">Advanced yard management</h3>
                    <p class="text-slate-200 text-xs sm:text-sm max-w-md">
                        High-capacity staging yards with automated tracking, surveillance, and weather protection.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     7. VEHICLE CARGO TYPES
═══════════════════════════════════════════════════════════════ --}}
<section class="py-14 sm:py-20 bg-[var(--color-paper)] relative overflow-hidden border-t border-[var(--color-line)]">
    <div class="max-w-7xl mx-auto px-5 sm:px-6">
        <div class="max-w-2xl mb-10 sm:mb-14" data-aos="fade-up">
            <div class="index-label mb-4">
                <span class="rule"></span>
                <span class="lbl">Cargo specifications</span>
            </div>
            <h2 class="text-2xl sm:text-4xl font-extrabold text-[#0A2540] tracking-tight font-heading leading-tight">
                Handling protocols by vehicle class
            </h2>
        </div>

        @php
            $cargoTypes = [
                ['img' => 'vehicle.png',      'alt' => 'Passenger Vehicle', 'title' => 'Passenger vehicle', 'desc' => 'Sedans, SUVs, MPVs, and electric vehicles handled under scratch-free procedures.', 'tag' => 'Light vehicle', 'tagColor' => 'text-[#EC2029]'],
                ['img' => 'bus-truck.png',    'alt' => 'Bus & Truck',       'title' => 'Bus & truck',       'desc' => 'Heavy logistics trucks, industrial chassis, and transport vehicles with reinforced ramp pathways.', 'tag' => 'Commercial', 'tagColor' => 'text-[#1D4E74]'],
                ['img' => 'ekskapator.png',   'alt' => 'Heavy Equipment',   'title' => 'Heavy equipment',   'desc' => 'Excavators, wheel loaders, and bulldozers destined for mining and agricultural projects.', 'tag' => 'Project cargo', 'tagColor' => 'text-[#EC2029]'],
                ['img' => 'cargo.png',        'alt' => 'General Cargo',     'title' => 'General cargo',     'desc' => 'Static cargo and non-vehicle shipments managed under standard warehousing procedures.', 'tag' => 'General cargo', 'tagColor' => 'text-[#1D4E74]'],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-px bg-[var(--color-line)] border border-[var(--color-line)]">
            @foreach($cargoTypes as $item)
                <div class="bg-white p-6 sm:p-8 hover:bg-slate-50/50 transition-colors">
                    <div class="w-14 h-14 mb-5 flex items-center justify-center">
                        <img src="{{ secure_asset('assets/images/' . $item['img']) }}" alt="{{ $item['alt'] }}" class="w-full h-full object-contain">
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-[#0A2540] mb-1.5 font-heading">{{ $item['title'] }}</h3>
                    <p class="text-[var(--color-muted)] text-xs leading-relaxed mb-4">{{ $item['desc'] }}</p>
                    <span class="text-[11px] font-semibold {{ $item['tagColor'] }} uppercase tracking-wider">{{ $item['tag'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     8. OPERATION GALLERY
═══════════════════════════════════════════════════════════════ --}}
<section id="gallery" class="py-12 sm:py-20 bg-white relative overflow-hidden border-t border-[var(--color-line)]">
    <div class="max-w-7xl mx-auto px-5 sm:px-6">
        <div class="flex items-end justify-between mb-8" data-aos="fade-up">
            <div>
                <div class="index-label mb-2">
                    <span class="rule"></span>
                    <span class="lbl">Visual record</span>
                </div>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-[#0A2540] tracking-tight font-heading">
                    Inside the terminal
                </h2>
            </div>
        </div>

        @php
            $gallery = [
                ['img' => 'car-1.jpeg',    'title' => 'Ready for Export',     'tag' => 'Staging',       'date' => 'Active Operation', 'location' => 'Stacking Yard PICT', 'desc' => 'Vehicles are neatly arranged in the stacking yard before loading onto the vessel.'],
                ['img' => 'car-3.jpeg',    'title' => 'Vehicle Lineup',       'tag' => 'CBU Units',     'date' => 'Quality Control',  'location' => 'Inspection Area',    'desc' => 'A thorough physical inspection process to ensure factory quality standards are met.'],
                ['img' => 'car-5.jpeg',    'title' => 'Quality Check',        'tag' => 'Inspection',    'date' => 'Final Audit',      'location' => 'Gate & Port Zone',   'desc' => 'Final audit before vehicles are cleared to proceed to the distribution line.'],
                ['img' => 'vessel-1.jpeg', 'title' => 'Port Activity',        'tag' => 'Terminal Area', 'date' => '24/7 Operations',  'location' => 'Berth Side',         'desc' => 'Vehicle loading and unloading activities in the berth area under strict supervision.'],
                ['img' => 'vessel-2.jpeg', 'title' => 'Vessel Berthing',      'tag' => 'Ro-Ro Ship',    'date' => 'Docking Schedule', 'location' => 'Deep-Water Berth',   'desc' => 'The transport vessel is securely docked at the deep-water berth facility.'],
                ['img' => 'vessel-3.jpeg', 'title' => 'Ramp Loading',         'tag' => 'Logistics',     'date' => 'Loading Process',  'location' => 'Hydraulic Ramps',    'desc' => 'Vehicles are loaded onto the ship through a specialized Ro-Ro hydraulic ramp.'],
            ];
        @endphp

        <div id="news-gallery-slider"
             class="flex items-stretch gap-4 sm:gap-6 overflow-x-auto pb-4 pt-1 snap-x hide-scrollbar"
             data-aos="fade-up" data-aos-delay="100">
            @foreach($gallery as $index => $item)
                <div class="gallery-card group relative bg-white border border-[var(--color-line)] rounded-2xl overflow-hidden min-w-[300px] sm:min-w-[360px] max-w-[360px] flex-shrink-0 snap-start flex flex-col shadow-sm hover:shadow-lg transition-all cursor-pointer p-3 bg-slate-50/50"
                     onclick="pauseAutoSlideAndFocus({{ $index }})">
                    
                    {{-- Card Top Header (Mirip Banner Kartu Referensi) --}}
                    <div class="bg-white border border-[var(--color-line)] rounded-xl overflow-hidden shadow-sm flex flex-col h-full">
                        <div class="bg-[#0A2540] px-4 py-2.5 flex items-center justify-between">
                            <span class="text-white font-heading font-bold text-xs tracking-wider uppercase">PICT DOSSIER</span>
                            <span class="bg-[#EC2029] text-white text-[10px] font-semibold px-2 py-0.5 rounded">{{ $item['tag'] }}</span>
                        </div>

                        {{-- Image Container --}}
                        <div class="relative h-48 sm:h-52 overflow-hidden bg-slate-900">
                            <img src="{{ secure_asset('assets/images/' . $item['img']) }}"
                                 alt="{{ $item['title'] }}"
                                 class="absolute inset-0 w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                        </div>

                        {{-- Card Body --}}
                        <div class="p-4 sm:p-5 flex flex-col justify-between flex-grow bg-white">
                            <div>
                                <h3 class="text-base sm:text-lg font-bold text-[#0A2540] font-heading mb-2 group-hover:text-[#EC2029] transition-colors line-clamp-1">
                                    {{ $item['title'] }}
                                </h3>
                                <p class="text-[var(--color-muted)] text-xs leading-relaxed line-clamp-2 mb-4">
                                    {{ $item['desc'] }}
                                </p>
                            </div>

                            {{-- Meta Info (Tanggal & Lokasi ala Kartu Referensi) --}}
                            <div class="space-y-2 pt-3 border-t border-slate-100 text-xs text-[var(--color-muted)]">
                                <div class="flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-[#EC2029] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="font-medium text-slate-700">{{ $item['date'] }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-[#1D4E74] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span class="truncate">{{ $item['location'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     9. CALL TO ACTION
═══════════════════════════════════════════════════════════════ --}}
<section id="contact" class="py-16 sm:py-24 relative overflow-hidden bg-[#0A2540]">
    <div class="absolute inset-0 grid-texture opacity-40"></div>
    <div class="pointer-events-none absolute -top-32 -right-32 h-96 w-96 rounded-full bg-[#EC2029]/10 blur-3xl"></div>

    <div class="max-w-4xl mx-auto px-5 sm:px-6 text-center relative z-10" data-aos="fade-up">
        <div class="index-label justify-center mb-4 on-dark">
            <span class="rule"></span>
            <span class="lbl">Get in touch</span>
        </div>
        <h2 class="text-2xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight font-heading mb-4 leading-tight">
            Ready to move your cargo through Patimban?
        </h2>
        <p class="text-slate-300 text-sm sm:text-base max-w-xl mx-auto mb-8">
            Talk to our commercial and operations team about berth reservation, cargo handling, and long-term partnership.
        </p>
        <div class="flex flex-wrap items-center justify-center gap-3.5">
            <a href="{{ url('/contact') }}"
               class="inline-flex items-center gap-2 px-7 py-3 rounded-md bg-[#EC2029] text-white font-semibold tracking-wide text-xs sm:text-sm hover:bg-[#961c22] transition-colors group">
                Contact us
                <svg class="h-3.5 w-3.5 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
            <a href="{{ url('/services') }}"
               class="px-7 py-3 rounded-md text-white font-semibold tracking-wide text-xs sm:text-sm border border-white/25 hover:border-white/50 transition-colors">
                View services
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
/* ═══════════════════════════════════════════════════════════════
   LIVE CLOCK
═══════════════════════════════════════════════════════════════ */
function updateRealTimeClock() {
    const el = document.getElementById('live-clock');
    if (!el) return;
    const now = new Date();
    el.innerText = now.toLocaleDateString('en-US', {
        weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
        hour: '2-digit', minute: '2-digit', second: '2-digit', timeZoneName: 'short'
    });
}
setInterval(updateRealTimeClock, 1000);
updateRealTimeClock();

/* ═══════════════════════════════════════════════════════════════
   WEATHER — Open-Meteo
═══════════════════════════════════════════════════════════════ */
function fnGetWeatherDetails(code) {
    if (code === 0)                     return { icon: '☀️', desc: 'Sunny' };
    if ([1, 2, 3].includes(code))       return { icon: '⛅', desc: 'Partly Cloudy' };
    if ([45, 48].includes(code))        return { icon: '🌫️', desc: 'Foggy' };
    if ([51, 53, 55, 56, 57].includes(code)) return { icon: '🌧️', desc: 'Drizzle' };
    if ([61, 63, 65, 66, 67].includes(code)) return { icon: '🌧️', desc: 'Rain' };
    if ([71, 73, 75, 77].includes(code)) return { icon: '❄️', desc: 'Snow' };
    if ([95, 96, 99].includes(code))    return { icon: '⛈️', desc: 'Thunderstorm' };
    return { icon: '🌤️', desc: 'Fair' };
}

async function fetchPatimbanWeatherAll() {
    try {
        const res  = await fetch('https://api.open-meteo.com/v1/forecast?latitude=-6.23&longitude=107.85&current=temperature_2m,relative_humidity_2m,wind_speed_10m&daily=weathercode,temperature_2m_max,temperature_2m_min,wind_speed_10m_max&timezone=auto');
        const data = await res.json();

        if (data?.current) {
            document.getElementById('weather-temp').innerText     = data.current.temperature_2m + ' °C';
            document.getElementById('weather-wind').innerText     = data.current.wind_speed_10m + ' km/h';
            document.getElementById('weather-humidity').innerText = data.current.relative_humidity_2m + ' %';
        }

        if (data?.daily) {
            const container = document.getElementById('weather-forecast-container');
            container.innerHTML = '';

            data.daily.time.forEach((dateStr, index) => {
                const dateObj       = new Date(dateStr);
                const dayName       = index === 0 ? 'Today' : dateObj.toLocaleDateString('en-US', { weekday: 'short' });
                const formattedDate = dateObj.toLocaleDateString('en-US', { month: 'numeric', day: 'numeric' });
                const maxTemp       = Math.round(data.daily.temperature_2m_max[index]);
                const minTemp       = Math.round(data.daily.temperature_2m_min[index]);
                const maxWind       = Math.round(data.daily.wind_speed_10m_max[index]);
                const weather       = fnGetWeatherDetails(data.daily.weathercode[index]);

                container.innerHTML += `
                    <div class="bg-slate-800/70 border ${index === 0 ? 'border-[#EC2029] ring-2 ring-[#EC2029]/20' : 'border-slate-700/80'} rounded-2xl p-3.5 flex flex-col items-center justify-between text-center backdrop-blur-md min-w-[130px] sm:min-w-[150px] shrink-0 snap-start transition hover:border-slate-500">
                        <div class="w-full pb-2.5 border-b border-slate-700/60">
                            <p class="text-[11px] sm:text-xs font-bold uppercase tracking-wider text-slate-300">${dayName}</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">${formattedDate}</p>
                        </div>
                        <div class="py-3">
                            <span class="text-2xl sm:text-3xl block mb-1">${weather.icon}</span>
                            <span class="text-[10px] sm:text-[11px] text-slate-300 font-medium block">${weather.desc}</span>
                        </div>
                        <div class="w-full space-y-1.5 pt-2 border-t border-slate-700/60 text-xs">
                            <div class="bg-red-500/20 text-red-300 font-bold py-0.5 px-2 rounded text-[11px]">Max: ${maxTemp} °C</div>
                            <div class="bg-amber-500/20 text-amber-300 font-bold py-0.5 px-2 rounded text-[11px]">Min: ${minTemp} °C</div>
                            <div class="text-slate-400 text-[10px] pt-0.5 flex items-center justify-center gap-1">
                                <svg class="w-3 h-3 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                <span>${maxWind} km/h</span>
                            </div>
                        </div>
                    </div>`;
            });
        }
    } catch (error) {
        console.error('Failed to load weather data:', error);
    }
}
fetchPatimbanWeatherAll();

/* ═══════════════════════════════════════════════════════════════
   OPERATION FLOW
═══════════════════════════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', function () {
    const stepsData = @json($steps);
    const buttons   = document.querySelectorAll('.flow-btn');
    const elNum     = document.getElementById('detail-number');
    const elTitle   = document.getElementById('detail-title');
    const elDesc    = document.getElementById('detail-desc');
    const elTime    = document.getElementById('detail-time');
    const elEquip   = document.getElementById('detail-equip');
    const elSafety  = document.getElementById('detail-safety');
    const elDiv     = document.getElementById('detail-div');

    window.activateFlowStep = function (index) {
        buttons.forEach(btn => btn.classList.remove('active'));
        const activeBtn = document.querySelector(`.flow-btn[data-index="${index}"]`);
        if (activeBtn) activeBtn.classList.add('active');

        const panel = elTitle.closest('.flex-col');
        const grid  = elTime.closest('.grid');

        panel.classList.remove('fade-content');
        grid.classList.remove('fade-content');
        void panel.offsetWidth;

        const data = stepsData[index];
        elNum.textContent    = '0' + (index + 1);
        elTitle.textContent  = data.title;
        elDesc.textContent   = data.desc;
        elTime.textContent   = data.time;
        elEquip.textContent  = data.equip;
        elSafety.textContent = data.safety;
        elDiv.textContent    = data.div;

        panel.classList.add('fade-content');
        grid.classList.add('fade-content');
    };
    activateFlowStep(0);
});

/* ═══════════════════════════════════════════════════════════════
   GALLERY AUTO-SLIDE
═══════════════════════════════════════════════════════════════ */
let galleryInterval = null;
let resumeTimeout   = null;
let isAutoSlideActive = true;

function startAutoGallerySlide() {
    const slider = document.getElementById('news-gallery-slider');
    if (!slider) return;

    galleryInterval = setInterval(() => {
        if (!isAutoSlideActive) return;

        const card = slider.querySelector('.gallery-card');
        if (!card) return;

        const cardWidth     = card.offsetWidth + 24;
        const maxScrollLeft = slider.scrollWidth - slider.clientWidth;

        if (slider.scrollLeft >= maxScrollLeft - 10) {
            slider.scrollTo({ left: 0, behavior: 'smooth' });
        } else {
            slider.scrollBy({ left: cardWidth, behavior: 'smooth' });
        }
    }, 3500);
}

function pauseAutoSlideAndFocus(index) {
    isAutoSlideActive = false;
    clearTimeout(resumeTimeout);

    const slider = document.getElementById('news-gallery-slider');
    const cards  = slider.querySelectorAll('.gallery-card');
    if (cards[index]) {
        cards[index].scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
    }

    resumeTimeout = setTimeout(() => { isAutoSlideActive = true; }, 7000);
}

document.addEventListener('DOMContentLoaded', function () {
    startAutoGallerySlide();

    const slider = document.getElementById('news-gallery-slider');
    if (slider) {
        ['mousedown', 'touchstart'].forEach(eventType => {
            slider.addEventListener(eventType, () => {
                isAutoSlideActive = false;
                clearTimeout(resumeTimeout);
                resumeTimeout = setTimeout(() => { isAutoSlideActive = true; }, 7000);
            });
        });
    }
});

/* ═══════════════════════════════════════════════════════════════
   AOS + HERO SLIDESHOW + YARD SLIDESHOW + COUNTERS
═══════════════════════════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', function () {
    AOS.init({
        duration: 800,
        easing: 'ease-out-cubic',
        once: true,
        offset: 80
    });

    // Hero slideshow
    const heroSlideshow = document.getElementById('hero-slideshow');
    if (heroSlideshow) {
        const images = JSON.parse(heroSlideshow.dataset.images);
        let currentIndex = 0;

        images.forEach((imgUrl, index) => {
            const slide = document.createElement('div');
            slide.className = `hero-slide ${index === 0 ? 'active' : ''}`;
            slide.style.backgroundImage = `url('${imgUrl}')`;
            heroSlideshow.appendChild(slide);
        });

        const slides = heroSlideshow.querySelectorAll('.hero-slide');
        if (slides.length > 1) {
            setInterval(() => {
                slides[currentIndex].classList.remove('active');
                currentIndex = (currentIndex + 1) % slides.length;
                slides[currentIndex].classList.add('active');
            }, 5000);
        }
    }

    // Yard slideshow
    const yardSlideshow = document.getElementById('yard-slideshow');
    if (yardSlideshow) {
        const images = JSON.parse(yardSlideshow.dataset.images);
        let currentImage = 0;
        setInterval(() => {
            currentImage = (currentImage + 1) % images.length;
            yardSlideshow.style.backgroundImage = `url('${images[currentImage]}')`;
        }, 4000);
    }

    // Counters
    const counters = document.querySelectorAll('.counter');
    const speed = 200;
    counters.forEach(counter => {
        const updateCount = () => {
            const target = +counter.getAttribute('data-target');
            const count  = +counter.innerText.replace(/,/g, '');
            const inc    = target / speed;
            if (count < target) {
                counter.innerText = Math.ceil(count + inc).toLocaleString();
                setTimeout(updateCount, 15);
            } else {
                counter.innerText = target.toLocaleString();
            }
        };
        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    updateCount();
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        observer.observe(counter);
    });
});
</script>
@endpush