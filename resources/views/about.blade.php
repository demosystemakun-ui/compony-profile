@extends('layouts.app')

@section('title', 'About PICT — PT Patimban International Car Terminal')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
<style>
    /* ═══ GLOBAL FONT ═══ */
    body, * {
        font-family: 'Century Gothic', 'CenturyGothic', 'Poppins', sans-serif !important;
    }

    /* ═══ HERO BACKGROUND ═══ */
    .hero-bg-about {
        background-image:
            linear-gradient(rgba(15, 23, 42, 0.78), rgba(15, 23, 42, 0.65)),
            url('{{ asset("assets/images/background.jpeg") }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }

    /* ═══ STAT CARD ═══ */
    .stat-card {
        transition: transform .3s cubic-bezier(0.4, 0, 0.2, 1),
                    border-color .3s ease,
                    box-shadow .3s ease;
    }
    .stat-card:hover {
        transform: translateY(-4px);
        border-color: #ec2029;
        box-shadow: 0 16px 32px -8px rgba(15, 23, 42, 0.15);
    }
    .stat-card .stat-icon {
        transition: transform .3s ease, background-color .3s ease;
    }
    .stat-card:hover .stat-icon {
        transform: scale(1.08);
    }

    /* ═══ PIE CHART INTERACTION ═══ */
    .chart-container {
        transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .pie-segment {
        transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1),
                    filter 0.35s ease,
                    opacity 0.35s ease;
        transform-origin: center;
        cursor: pointer;
    }

    /* ═══ SHAREHOLDER CARD ═══ */
    .shareholder-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }
    .shareholder-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%) scaleY(0);
        width: 3px;
        height: 60%;
        background: currentColor;
        border-radius: 0 4px 4px 0;
        transition: transform 0.3s ease;
    }
    .shareholder-card:hover::before {
        transform: translateY(-50%) scaleY(1);
    }

    /* ═══ TIMELINE DOT PULSE ═══ */
    .timeline-dot {
        position: relative;
    }
    .timeline-dot::after {
        content: '';
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        background: rgba(236, 32, 41, 0.3);
        opacity: 0;
        animation: pulse-ring 2.5s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    @keyframes pulse-ring {
        0% { transform: scale(0.9); opacity: 0.7; }
        80%, 100% { transform: scale(1.6); opacity: 0; }
    }
</style>
@endpush

@section('content')

{{-- ═══════════════════════════════════════════════════════════════
     1. HERO SECTION
═══════════════════════════════════════════════════════════════ --}}
<section class="hero-bg-about relative flex items-center min-h-[520px] px-6 sm:px-12 md:px-16 pt-32 pb-16 border-b border-slate-800 overflow-hidden">
    {{-- Decorative grid overlay --}}
    <div class="pointer-events-none absolute inset-0 opacity-[0.04]">
        <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
            <defs>
                <pattern id="grid-about" width="8" height="8" patternUnits="userSpaceOnUse">
                    <path d="M 8 0 L 0 0 0 8" fill="none" stroke="white" stroke-width="0.4"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid-about)"/>
        </svg>
    </div>
    {{-- Accent glow --}}
    <div class="pointer-events-none absolute -top-32 -right-32 h-96 w-96 rounded-full bg-[#ec2029]/15 blur-3xl"></div>

    <div class="relative max-w-5xl" data-aos="fade-down">
      

        <h1 class="text-white text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight leading-[1.1] max-w-3xl">
            A Modern Vehicle Terminal at the Heart of
            <span class="text-[#ec2029]">Indonesia's</span> Automotive Industry
        </h1>

        <p class="mt-6 text-slate-300 text-sm sm:text-base max-w-2xl leading-relaxed">
            Strategic gateway for Indonesia's automotive logistics — operated by a consortium of Japan's leading enterprises.
        </p>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     2. COMPANY PROFILE
═══════════════════════════════════════════════════════════════ --}}
<section class="max-w-7xl mx-auto px-6 py-20 bg-white text-slate-800">
    <div class="grid lg:grid-cols-12 gap-14 items-start">
        {{-- Left: Narrative --}}
        <div class="lg:col-span-6 space-y-6" data-aos="fade-right">
            <div>
                <span class="text-[#ec2029] font-bold tracking-[0.2em] text-xs uppercase block mb-2">
                    Company Profile
                </span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    Who We Are
                </h2>
                <div class="mt-4 h-1 w-16 bg-[#ec2029] rounded-full"></div>
            </div>

            <p class="text-slate-600 leading-relaxed text-sm">
                PT Patimban International Car Terminal (PICT) is a vehicle terminal operator located at Patimban Port, Pusakanagara, Subang Regency, West Java approximately 120 kilometers east of central Jakarta. The company was established in November 2021 by the Toyota Tsusho Group and officially commenced operations in December 2021.
            </p>
            <p class="text-slate-600 leading-relaxed text-sm">
                The development of Patimban Port is a National Strategic Project that has been implemented in phases since 2018 at the initiative of the Government of Indonesia, with financial support provided through an Official Development Assistance (ODA) scheme. After being temporarily managed by PT Pelabuhan Indonesia (Pelindo), responsibility for the vehicle terminal was officially transferred to PICT, a company fully capitalized by a consortium of Japanese enterprises.
            </p>
            <p class="text-slate-600 leading-relaxed text-sm">
                PICT's current shareholders comprise Toyota Tsusho Corporation Group (34%), Toyofuji Shipping Co., Ltd. (26%), Nippon Yusen Kabushiki Kaisha NYK Line (25%), and Kamigumi Co., Ltd. (15%), making PICT a collaboration among leading Japanese companies in the automotive logistics and shipping industries.
            </p>
        </div>

        {{-- Right: Stat Cards --}}
        <div class="lg:col-span-6 space-y-4" data-aos="fade-left">
            @php
                $stats = [
                    [
                        'label' => 'Current Handling Capacity',
                        'value' => '200,000',
                        'unit'  => 'units/year',
                        'color' => 'red',
                        'icon'  => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6',
                    ],
                    [
                        'label' => 'Capacity Expansion Target',
                        'value' => '800,000',
                        'unit'  => 'units/year',
                        'color' => 'blue',
                        'icon'  => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6',
                    ],
                    [
                        'label' => 'Vehicle Terminal Berth Length',
                        'value' => '300',
                        'unit'  => 'meters',
                        'color' => 'emerald',
                        'icon'  => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4',
                    ],
                    [
                        'label' => 'Distance from Central Jakarta',
                        'value' => '±120',
                        'unit'  => 'km',
                        'color' => 'amber',
                        'icon'  => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z',
                    ],
                ];

                $colorMap = [
                    'red'     => ['bg' => 'bg-[#ec2029]/10',   'text' => 'text-[#ec2029]'],
                    'blue'    => ['bg' => 'bg-blue-600/10',    'text' => 'text-blue-600'],
                    'emerald' => ['bg' => 'bg-emerald-600/10', 'text' => 'text-emerald-600'],
                    'amber'   => ['bg' => 'bg-amber-600/10',   'text' => 'text-amber-600'],
                ];
            @endphp

            @foreach($stats as $i => $s)
                @php $c = $colorMap[$s['color']]; @endphp
                <div class="stat-card bg-slate-50 border border-slate-200 rounded-xl p-6 flex items-center justify-between shadow-sm"
                     data-aos="fade-left" data-aos-delay="{{ 100 + ($i * 100) }}">
                    <div>
                        <p class="text-slate-500 text-xs uppercase tracking-wider font-semibold">{{ $s['label'] }}</p>
                        <p class="text-2xl font-extrabold text-slate-900 tracking-tight mt-1.5">
                            {{ $s['value'] }}
                            <span class="text-sm font-medium text-slate-500">{{ $s['unit'] }}</span>
                        </p>
                    </div>
                    <div class="stat-icon w-12 h-12 rounded-xl {{ $c['bg'] }} {{ $c['text'] }} flex items-center justify-center shrink-0">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['icon'] }}" />
                        </svg>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     3. TIMELINE / HISTORY
═══════════════════════════════════════════════════════════════ --}}
<section class="bg-slate-100 py-20 border-t border-slate-200 text-slate-800">
    <div class="max-w-5xl mx-auto px-6">
        <div class="text-center mb-14" data-aos="fade-up">
            <span class="text-[#ec2029] font-bold tracking-[0.2em] text-xs uppercase block mb-2">Our Journey</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">
                PICT's Development History
            </h2>
            <div class="mt-4 h-1 w-16 bg-[#ec2029] rounded-full mx-auto"></div>
        </div>

        <div class="relative border-l-2 border-[#ec2029] ml-4 md:ml-0 space-y-12">
            @php
                $timeline = [
                    [
                        'date'  => '2018',
                        'title' => 'Construction of Patimban Port Begins',
                        'desc'  => 'Construction of Patimban Port commenced in phases as a National Strategic Project at the initiative of the Government of Indonesia, supported by funding under an Official Development Assistance (ODA) loan agreement.',
                    ],
                    [
                        'date'  => 'November 2021',
                        'title' => 'PT Patimban International Car Terminal Established',
                        'desc'  => 'PICT was officially established by the Toyota Tsusho Group to manage the vehicle terminal at Patimban Port.',
                    ],
                    [
                        'date'  => 'December 2021',
                        'title' => 'Operations Commence',
                        'desc'  => 'PICT officially commenced vehicle terminal operations, replacing the temporary management previously provided by PT Pelabuhan Indonesia (Pelindo).',
                    ],
                    [
                        'date'  => 'June 30, 2023',
                        'title' => 'Shareholder Consortium Strengthened',
                        'desc'  => 'Toyota Tsusho transferred part of its shareholding to Toyofuji Shipping, NYK Line, and Kamigumi Co., strengthening PICT\'s operational structure with the expertise of leading automotive terminal operators from Japan and around the world.',
                    ],
                    [
                        'date'  => 'Present Future',
                        'title' => 'Capacity Expansion to 600,000 Units per Year',
                        'desc'  => 'With a current handling capacity of 400,000 vehicles per year, PICT continues to expand its facilities to increase capacity to 600,000 units per year, in line with the comprehensive development of Patimban Port as Indonesia\'s leading automotive logistics gateway.',
                    ],
                ];
            @endphp

            @foreach($timeline as $i => $t)
                <div class="relative pl-10 md:pl-14" data-aos="fade-up" data-aos-delay="{{ 100 + ($i * 100) }}">
                    <span class="timeline-dot absolute -left-[9px] top-1 w-4 h-4 bg-[#ec2029] rounded-full border-4 border-slate-100 shadow"></span>
                    <p class="text-[#ec2029] font-mono text-xs mb-1.5 font-bold tracking-wide">{{ $t['date'] }}</p>
                    <h3 class="font-bold text-slate-900 text-lg mb-2 leading-snug">{{ $t['title'] }}</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">{{ $t['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     4. SHAREHOLDERS: INTERACTIVE GRID WITH PIE CHART
═══════════════════════════════════════════════════════════════ --}}
<section class="max-w-7xl mx-auto px-6 py-24 bg-white text-slate-800 overflow-hidden">
    <div class="text-center mb-16" data-aos="fade-up">
        <span class="text-[#ec2029] font-bold tracking-[0.2em] text-xs uppercase block mb-2">Our Shareholders</span>
        <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">
            Shareholder Consortium Composition
        </h2>
        <div class="mt-4 h-1 w-16 bg-[#ec2029] rounded-full mx-auto"></div>
        <p class="text-slate-500 max-w-2xl mx-auto mt-5 text-sm leading-relaxed">
            PICT is powered by a strategic alliance of leading Japanese enterprises.
            Hover over any shareholder card to inspect their segment on the chart.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center max-w-6xl mx-auto">

        {{-- Left: Cards --}}
        <div class="lg:col-span-4 flex flex-col gap-5">
            @php
                $leftCards = [
                    [
                        'name'   => 'Toyota Tsusho',
                        'sub'    => 'General Trading',
                        'pct'    => '34%',
                        'logo'   => 'assets/images/logo-toyota.png',
                        'url'    => 'https://www.toyota-tsusho.com/',
                        'color'  => 'blue',
                        'target' => 'toyota',
                        'shift'  => 'right',
                    ],
                    [
                        'name'   => 'NYK Line',
                        'sub'    => 'Global Maritime',
                        'pct'    => '25%',
                        'logo'   => 'assets/images/nyk-logo.jpg',
                        'url'    => 'https://www.nyk.com/english/',
                        'color'  => 'emerald',
                        'target' => 'nyk',
                        'shift'  => 'right',
                    ],
                ];

                $cardColors = [
                    'blue'    => ['border' => 'hover:border-blue-500',       'text' => 'group-hover:text-blue-600',       'badge' => 'bg-blue-50 text-blue-700 border-blue-200'],
                    'red'     => ['border' => 'hover:border-red-500',        'text' => 'group-hover:text-red-600',        'badge' => 'bg-red-50 text-red-700 border-red-200'],
                    'emerald' => ['border' => 'hover:border-emerald-500',    'text' => 'group-hover:text-emerald-600',    'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
                    'amber'   => ['border' => 'hover:border-amber-500',      'text' => 'group-hover:text-amber-600',      'badge' => 'bg-amber-50 text-amber-700 border-amber-200'],
                ];
            @endphp

            @foreach($leftCards as $i => $card)
                @php $cc = $cardColors[$card['color']]; @endphp
                <a href="{{ $card['url'] }}" target="_blank" rel="noopener noreferrer"
                   class="shareholder-card group bg-white border border-slate-200 {{ $cc['border'] }} p-5 rounded-2xl shadow-sm hover:shadow-md flex items-center justify-between"
                   data-target="{{ $card['target'] }}" data-shift="{{ $card['shift'] }}"
                   data-aos="fade-right" data-aos-delay="{{ 100 + ($i * 100) }}">
                    <div class="flex items-center gap-3.5">
                        <div class="h-10 w-14 flex items-center justify-center shrink-0">
                            <img src="{{ asset($card['logo']) }}" alt="{{ $card['name'] }}"
                                 class="max-h-7 max-w-full object-contain opacity-85 group-hover:opacity-100 transition-opacity">
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-xs {{ $cc['text'] }} transition-colors">
                                {{ $card['name'] }}
                            </h4>
                            <p class="text-slate-500 text-[11px]">{{ $card['sub'] }}</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 rounded-full {{ $cc['badge'] }} font-extrabold text-xs border shrink-0">
                        {{ $card['pct'] }}
                    </span>
                </a>
            @endforeach
        </div>

        {{-- Center: Donut Chart --}}
        <div class="lg:col-span-4 flex flex-col items-center justify-center py-4 chart-container" id="pieChartWrapper"
             data-aos="zoom-in" data-aos-duration="900">
            <div class="relative w-64 h-64 sm:w-72 sm:h-72 flex items-center justify-center">
                <svg viewBox="0 0 42 42" class="w-full h-full transform -rotate-90 drop-shadow-sm">
                    <circle cx="21" cy="21" r="15.9155" fill="transparent" stroke="#2563eb" stroke-width="5.5"
                            stroke-dasharray="34 66" stroke-dashoffset="0" class="pie-segment" data-id="toyota"></circle>
                    <circle cx="21" cy="21" r="15.9155" fill="transparent" stroke="#dc2626" stroke-width="5.5"
                            stroke-dasharray="26 74" stroke-dashoffset="-34" class="pie-segment" data-id="toyofuji"></circle>
                    <circle cx="21" cy="21" r="15.9155" fill="transparent" stroke="#059669" stroke-width="5.5"
                            stroke-dasharray="25 75" stroke-dashoffset="-60" class="pie-segment" data-id="nyk"></circle>
                    <circle cx="21" cy="21" r="15.9155" fill="transparent" stroke="#d97706" stroke-width="5.5"
                            stroke-dasharray="15 85" stroke-dashoffset="-85" class="pie-segment" data-id="kamigumi"></circle>
                </svg>

                <div class="absolute inset-0 flex flex-col items-center justify-center text-center pointer-events-none">
                    <span class="text-[11px] font-bold uppercase tracking-widest text-slate-400" id="chartLabelTop">Consortium</span>
                    <span class="text-3xl font-extrabold text-slate-900 tracking-tight" id="chartValueMain">100%</span>
                    <span class="text-[10px] text-slate-500 font-medium" id="chartLabelSub">Japanese Alliance</span>
                </div>
            </div>
        </div>

        {{-- Right: Cards --}}
        <div class="lg:col-span-4 flex flex-col gap-5">
            @php
                $rightCards = [
                    [
                        'name'   => 'Toyofuji Shipping',
                        'sub'    => 'Marine Logistics',
                        'pct'    => '26%',
                        'logo'   => 'assets/images/toyofuji-logo.jpg',
                        'url'    => 'https://www.toyofuji.co.jp/en/english/company/company.html',
                        'color'  => 'red',
                        'target' => 'toyofuji',
                        'shift'  => 'left',
                    ],
                    [
                        'name'   => 'Kamigumi Co.',
                        'sub'    => 'Terminal & Warehousing',
                        'pct'    => '15%',
                        'logo'   => 'assets/images/logo-kamigumi.png',
                        'url'    => 'https://www.kamigumi.co.jp/english/',
                        'color'  => 'amber',
                        'target' => 'kamigumi',
                        'shift'  => 'left',
                    ],
                ];
            @endphp

            @foreach($rightCards as $i => $card)
                @php $cc = $cardColors[$card['color']]; @endphp
                <a href="{{ $card['url'] }}" target="_blank" rel="noopener noreferrer"
                   class="shareholder-card group bg-white border border-slate-200 {{ $cc['border'] }} p-5 rounded-2xl shadow-sm hover:shadow-md flex items-center justify-between"
                   data-target="{{ $card['target'] }}" data-shift="{{ $card['shift'] }}"
                   data-aos="fade-left" data-aos-delay="{{ 100 + ($i * 100) }}">
                    <div class="flex items-center gap-3.5">
                        <div class="h-10 w-14 flex items-center justify-center shrink-0">
                            <img src="{{ asset($card['logo']) }}" alt="{{ $card['name'] }}"
                                 class="max-h-7 max-w-full object-contain opacity-85 group-hover:opacity-100 transition-opacity">
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-xs {{ $cc['text'] }} transition-colors">
                                {{ $card['name'] }}
                            </h4>
                            <p class="text-slate-500 text-[11px]">{{ $card['sub'] }}</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 rounded-full {{ $cc['badge'] }} font-extrabold text-xs border shrink-0">
                        {{ $card['pct'] }}
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     5. CTA STRIP
═══════════════════════════════════════════════════════════════ --}}
<section class="relative overflow-hidden bg-gradient-to-br from-[#ec2029] to-[#b91c1c] py-16 text-white">
    {{-- Decorative pattern --}}
    <div class="pointer-events-none absolute inset-0 opacity-[0.06]">
        <svg class="h-full w-full" viewBox="0 0 400 200" preserveAspectRatio="none">
            <path d="M0 200 L120 40 L240 200 Z" fill="white"></path>
            <path d="M180 200 L320 20 L400 200 Z" fill="white"></path>
        </svg>
    </div>
    <div class="pointer-events-none absolute -top-24 -right-24 h-72 w-72 rounded-full bg-white/10 blur-3xl"></div>

    <div class="max-w-7xl mx-auto px-6 relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6" data-aos="fade-up">
        <div>
            <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight leading-tight">
                Would You Like to Learn More About Our Strategic Location?
            </h2>
            <p class="text-red-100 text-sm sm:text-base mt-2">
                Patimban Port, Pusakanagara, Subang, West Java, Indonesia
            </p>
        </div>

        <a href="/contact"
           class="group inline-flex items-center gap-2 shrink-0 px-7 py-3.5 bg-[#26347a] text-white text-sm font-bold rounded-full border-2 border-[#26347a] hover:bg-transparent hover:border-white transition-all duration-300 shadow-lg hover:shadow-xl">
            Contact Us
            <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </a>
    </div>
</section>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
        duration: 900,
        easing: 'ease-out-cubic',
        once: true,
        offset: 120
    });

    const cards         = document.querySelectorAll('.shareholder-card');
    const chartWrapper  = document.getElementById('pieChartWrapper');
    const segments      = document.querySelectorAll('.pie-segment');
    const labelTop      = document.getElementById('chartLabelTop');
    const valueMain     = document.getElementById('chartValueMain');
    const labelSub      = document.getElementById('chartLabelSub');

    const infoData = {
        toyota:   { name: "Toyota Tsusho",     share: "34%" },
        toyofuji: { name: "Toyofuji Shipping", share: "26%" },
        nyk:      { name: "NYK Line",          share: "25%" },
        kamigumi: { name: "Kamigumi Co.",      share: "15%" }
    };

    cards.forEach(card => {
        const targetId = card.getAttribute('data-target');
        const shiftDir = card.getAttribute('data-shift');

        card.addEventListener('mouseenter', () => {
            // Shift chart in opposite direction
            chartWrapper.style.transform = shiftDir === 'right'
                ? 'translateX(28px) scale(1.05)'
                : 'translateX(-28px) scale(1.05)';

            // Update center label
            if (infoData[targetId]) {
                labelTop.textContent  = infoData[targetId].name;
                valueMain.textContent = infoData[targetId].share;
                labelSub.textContent  = "Shareholder";
            }

            // Highlight segment
            segments.forEach(seg => {
                const isTarget = seg.getAttribute('data-id') === targetId;
                seg.style.transform = isTarget ? 'scale(1.08)' : 'scale(1)';
                seg.style.filter    = isTarget ? 'brightness(1.2) drop-shadow(0 0 6px rgba(0,0,0,0.2))' : 'none';
                seg.style.opacity   = isTarget ? '1' : '0.35';
            });
        });

        card.addEventListener('mouseleave', () => {
            chartWrapper.style.transform = 'translateX(0) scale(1)';

            labelTop.textContent  = "Consortium";
            valueMain.textContent = "100%";
            labelSub.textContent  = "Japanese Alliance";

            segments.forEach(seg => {
                seg.style.opacity   = '1';
                seg.style.transform = 'scale(1)';
                seg.style.filter    = 'none';
            });
        });
    });
});
</script>
@endpush