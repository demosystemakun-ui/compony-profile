@extends('layouts.app')

@section('title', 'Our Services — PT Patimban International Car Terminal')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Manrope:wght@700;800&display=swap" rel="stylesheet">
<style>
    /* ═══ DESIGN SYSTEM — PICT PREMIUM LIGHT LUXURY ═══ */
    :root {
        --color-navy:      #071E3D;
        --color-ocean:     #0F4C81;
        --color-steel:     #2563EB;
        --color-signal:    #D62828;
        --color-paper:     #F8FAFC;
        --color-ink:       #0F172A;
        --color-muted:     #64748B;
        --color-line:      #E2E8F0;
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

    /* ═══ EYEBROW LABEL — konsisten di semua section ═══ */
    .eyebrow {
        display: inline-block;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.18em;
        text-transform: uppercase;
    }
    .eyebrow.steel  { color: var(--color-steel); }
    .eyebrow.signal { color: var(--color-signal); }

    /* ═══ GLASS CARD ═══ */
    .glass-card {
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(226, 232, 240, 0.85);
        box-shadow: 0 10px 30px -5px rgba(15, 23, 42, 0.05);
    }

    /* ═══ SCROLLBAR ═══ */
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: var(--color-paper); }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>
@endpush

@section('content')

{{-- ═══════════════════════════════════════════════════════════════
     1. HERO SECTION
═══════════════════════════════════════════════════════════════ --}}
<section class="relative min-h-[75vh] w-full flex flex-col justify-between overflow-hidden bg-slate-900 pt-32 pb-16">
    <div class="absolute inset-0 bg-cover bg-center transform scale-105 opacity-45"
         style="background-image: url('{{ secure_asset("assets/images/patimban-yard-3.jpeg") }}');"
         data-aos="zoom-out" data-aos-duration="1500"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/70 to-slate-950/40"></div>
    <div class="pointer-events-none absolute -top-32 -right-32 h-96 w-96 rounded-full bg-[#2563EB]/15 blur-3xl"></div>

    <div class="relative max-w-7xl mx-auto px-6 z-10 w-full my-auto">
        <div class="max-w-4xl">

            <h1 class="text-5xl sm:text-7xl font-extrabold text-white tracking-tight font-heading leading-none mb-6"
                data-aos="fade-up" data-aos-delay="300">
                Enterprise Port<br class="hidden sm:block">
                <span class="text-[#D62828]">Portfolio</span>
            </h1>

            <p class="text-lg sm:text-2xl text-slate-200 font-light leading-relaxed max-w-3xl"
               data-aos="fade-up" data-aos-delay="400">
                Specialized marine, stevedoring, and multi-modal logistics solutions engineered for global automotive manufacturers.
            </p>
        </div>
    </div>

    {{-- Credential strip --}}
    <div class="relative max-w-7xl mx-auto px-6 w-full z-10 pt-8 border-t border-white/15 mt-12" data-aos="fade-up" data-aos-delay="600">
        @php
            $credentials = [
                ['label' => 'Tariff Transparency',     'accent' => 'blue'],
                ['label' => 'Dedicated Account Team',  'accent' => 'blue'],
                ['label' => 'Custom SLA Guarantee',    'accent' => 'red'],
                ['label' => '24/7 Commercial Desk',    'accent' => 'blue'],
            ];
        @endphp

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @foreach($credentials as $c)
                @php
                    $accentBg   = $c['accent'] === 'red' ? 'bg-red-500/20' : 'bg-blue-500/20';
                    $accentText = $c['accent'] === 'red' ? 'text-red-400'  : 'text-blue-400';
                @endphp
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full {{ $accentBg }} flex items-center justify-center {{ $accentText }} font-bold text-xs shrink-0">
                        ★
                    </div>
                    <span class="text-xs font-medium text-slate-200">{{ $c['label'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     2. COMMERCIAL TARIFF HIGHLIGHTS (floating card)
═══════════════════════════════════════════════════════════════ --}}
<section class="relative z-20 max-w-7xl mx-auto px-6 -mt-8 sm:-mt-12 mb-28" data-aos="fade-up">
    @php
        $tariffs = [
            ['label' => 'Berthage Rate',       'value' => 'Competitive',   'desc' => 'Based on GT per 24 hours block',         'accent' => 'steel'],
            ['label' => 'Staging Yard Tariff', 'value' => 'Tiered Slabs',  'desc' => 'Optimized for volume manufacturers',     'accent' => 'steel'],
            ['label' => 'Handling SLA',        'value' => '< 2 Minutes',   'desc' => 'Average unit discharge turnaround',      'accent' => 'signal'],
        ];
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        @foreach($tariffs as $i => $t)
            @php
                $isRed = $t['accent'] === 'signal';
                $labelColor  = $isRed ? 'text-[#D62828]' : 'text-[#2563EB]';
                $borderHover = $isRed ? 'hover:border-red-400' : 'hover:border-blue-400';
            @endphp
            <div class="glass-card rounded-3xl p-8 text-center transition-all duration-500 shadow-xl {{ $borderHover }}">
                <div class="eyebrow {{ $isRed ? 'signal' : 'steel' }} mb-2">{{ $t['label'] }}</div>
                <div class="text-3xl font-extrabold text-[#071E3D] font-heading tracking-tight mb-2">
                    {!! $t['value'] === '< 2 Minutes' ? '&lt; 2 Minutes' : $t['value'] !!}
                </div>
                <div class="text-xs text-slate-500">{{ $t['desc'] }}</div>
            </div>
        @endforeach
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     3. COMPREHENSIVE SERVICE MATRIX
═══════════════════════════════════════════════════════════════ --}}
<section id="commercial-matrix" class="max-w-7xl mx-auto px-6 py-12 bg-white text-slate-800" data-aos="fade-up">
    <div class="text-center mb-16">
        <span class="eyebrow signal block mb-2">Commercial Portfolio</span>
        <h2 class="text-3xl sm:text-5xl font-extrabold text-[#071E3D] tracking-tight font-heading">
            Core Service Matrix
        </h2>
        <p class="text-slate-600 max-w-2xl mx-auto mt-4 text-base">
            Detailed breakdown of our operational divisions designed to accommodate diverse automotive manufacturing needs.
        </p>
    </div>

    @php
        $matrix = [
            [
                'img'   => 'vessel-2.jpeg',
                'title' => 'Wharfage & Marine',
                'desc'  => 'Berth allocation, tugboat coordination, and harbor clearance management for scheduled car carriers.',
                'items' => ['300m Dedicated Ro-Ro Pier', 'Mooring & Unmooring Teams', 'Fresh Water Bunkering Support'],
                'delay' => 100,
            ],
            [
                'img'   => 'vessel-1.jpeg',
                'title' => 'Stevedoring & Discharge',
                'desc'  => 'High-speed vehicle offloading via vessel ramps with rigorous damage prevention protocols.',
                'items' => ['Certified Driver Pool', 'Ramp Safety Supervision', 'Lashing & Unlashing Audit'],
                'delay' => 200,
            ],
            [
                'img'   => 'patimban-yard-1.jpeg',
                'title' => 'Cargodoring & Staging',
                'desc'  => 'Secure vehicle marshalling, digital slot allocation, and inventory reporting via TMS.',
                'items' => ['200K+ Annual Capacity Slots', 'Automated RFID Bay Mapping', '24/7 CCTV & Security Patrol'],
                'delay' => 300,
            ],
        ];
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($matrix as $item)
            <div class="bg-slate-50 rounded-3xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group"
                 data-aos="fade-up" data-aos-delay="{{ $item['delay'] }}">
                <div class="relative h-56 overflow-hidden">
                    <img src="{{ secure_asset('assets/images/' . $item['img']) }}"
                         alt="{{ $item['title'] }}"
                         class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 to-transparent"></div>
                    <div class="absolute bottom-4 left-6 right-6 text-white font-bold text-lg font-heading">
                        {{ $item['title'] }}
                    </div>
                </div>
                <div class="p-8 flex-grow flex flex-col">
                    <p class="text-slate-600 text-xs sm:text-sm leading-relaxed mb-6">
                        {{ $item['desc'] }}
                    </p>
                    <ul class="space-y-2 text-xs text-slate-700 font-medium mt-auto">
                        @foreach($item['items'] as $feat)
                            <li class="flex items-start gap-2">
                                <span class="text-[#D62828] font-bold leading-none mt-0.5">•</span>
                                <span>{{ $feat }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     4. VALUE-ADDED SERVICE ADD-ONS
═══════════════════════════════════════════════════════════════ --}}
<section class="py-24 bg-[#F8FAFC] relative overflow-hidden border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center max-w-3xl mx-auto mb-20" data-aos="fade-up">
            <span class="eyebrow steel block mb-3">Customized Packages</span>
            <h2 class="text-3xl sm:text-5xl font-extrabold text-[#071E3D] tracking-tight font-heading">
                Value-Added Solutions
            </h2>
            <p class="mt-4 text-slate-600 text-base">
                Enhance your supply chain with specialized pre-delivery inspections and washing services.
            </p>
        </div>

        @php
            $addOns = [
                [
                    'img'   => 'car-5.jpeg',
                    'title' => 'Pre-Delivery Inspection (PDI)',
                    'desc'  => 'Comprehensive physical audits, battery health checks, and fluid level verifications performed prior to domestic or export release.',
                    'delay' => 100,
                ],
                [
                    'img'   => 'car-3.jpeg',
                    'title' => 'Washing',
                    'desc'  => 'High-pressure automated exterior washing and salt-residue removal facilities to maintain showroom perfection upon vessel arrival.',
                    'delay' => 200,
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($addOns as $addon)
                <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm flex flex-col sm:flex-row items-stretch"
                     data-aos="fade-up" data-aos-delay="{{ $addon['delay'] }}">
                    <div class="w-full sm:w-1/2 h-48 sm:h-auto relative shrink-0">
                        <img src="{{ secure_asset('assets/images/' . $addon['img']) }}"
                             alt="{{ $addon['title'] }}"
                             class="absolute inset-0 w-full h-full object-cover">
                    </div>
                    <div class="w-full sm:w-1/2 p-8 flex flex-col justify-center">
                        <h3 class="text-xl font-bold text-[#071E3D] mb-2 font-heading">
                            {{ $addon['title'] }}
                        </h3>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            {{ $addon['desc'] }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     5. CALL TO ACTION
═══════════════════════════════════════════════════════════════ --}}
<section class="py-24 relative overflow-hidden bg-cover bg-center"
         style="background-image: url('{{ secure_asset("assets/images/background.jpeg") }}')">
    <div class="absolute inset-0 bg-[#071E3D]/90"></div>
    <div class="pointer-events-none absolute -top-32 -right-32 h-96 w-96 rounded-full bg-[#D62828]/15 blur-3xl"></div>

    <div class="max-w-5xl mx-auto px-6 text-center relative z-10" data-aos="fade-up">
        <span class="eyebrow block mb-4" style="color: rgba(255,255,255,0.6);">Get in touch</span>
        <h2 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight font-heading mb-6">
            Ready to Move Your Automotive Logistics to the Next Level?
        </h2>
        <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto mb-10">
            Connect with our commercial and operations team to discuss berth reservation, cargo handling, and long-term partnership opportunities.
        </p>

        <div class="flex flex-wrap items-center justify-center gap-4">
            <a href="{{ url('/contact') }}"
               class="group inline-flex items-center gap-2 px-8 py-4 rounded-full bg-[#D62828] text-white font-semibold tracking-wide text-sm hover:bg-red-700 transition-all shadow-lg shadow-red-600/30">
                Contact Commercial Team
                <svg class="h-4 w-4 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
            <a href="{{ url('/our-tariffs') }}"
               class="px-8 py-4 rounded-full bg-white/10 backdrop-blur-md text-white font-semibold tracking-wide text-sm hover:bg-white/20 transition-all border border-white/25">
                View Tariff Structure
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    AOS.init({
        duration: 900,
        easing: 'ease-out-cubic',
        once: true,
        offset: 100
    });
});
</script>
@endpush