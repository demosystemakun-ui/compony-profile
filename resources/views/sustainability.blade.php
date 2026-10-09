@extends('layouts.app')

@section('title', 'Sustainability — PT Patimban International Car Terminal')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
<style>
    /* ═══ DESIGN SYSTEM — PICT SUSTAINABILITY ═══ */
    :root {
        --color-navy:   #0A2540;
        --color-signal: #EC2029;
        --color-paper:  #F5F3EE;
        --color-ink:    #16232E;
        --color-muted:  #5B6672;
        --color-line:   #D8D4C8;
    }

    body, * {
        font-family: 'Century Gothic', 'CenturyGothic', 'Poppins', sans-serif !important;
    }

    /* ═══ HERO BACKGROUND ═══ */
    .hero-bg-sustainability {
        background-image:
            linear-gradient(rgba(15, 23, 42, 0.78), rgba(15, 23, 42, 0.72)),
            url('{{ asset("assets/images/background.jpeg") }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }

    /* ═══ PILLAR CARD ═══ */
    .pillar-card {
        transition: transform .3s cubic-bezier(0.4, 0, 0.2, 1),
                    border-color .3s ease,
                    box-shadow .3s ease;
    }
    .pillar-card:hover {
        transform: translateY(-4px);
        border-color: var(--color-signal);
        box-shadow: 0 16px 32px -8px rgba(15, 23, 42, 0.15);
    }
    .pillar-card .pillar-icon {
        transition: transform .3s ease;
    }
    .pillar-card:hover .pillar-icon {
        transform: scale(1.08);
    }

    /* ═══ EYEBROW LABEL ═══ */
    .eyebrow {
        display: inline-block;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: var(--color-signal);
    }
</style>
@endpush

@section('content')

{{-- ═══════════════════════════════════════════════════════════════
     1. HERO SECTION
═══════════════════════════════════════════════════════════════ --}}
<section class="hero-bg-sustainability relative flex items-center min-h-[480px] px-6 md:px-16 pt-32 pb-16 overflow-hidden">
    {{-- Decorative grid --}}
    <div class="pointer-events-none absolute inset-0 opacity-[0.04]">
        <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
            <defs>
                <pattern id="grid-sus" width="8" height="8" patternUnits="userSpaceOnUse">
                    <path d="M 8 0 L 0 0 0 8" fill="none" stroke="white" stroke-width="0.4"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid-sus)"/>
        </svg>
    </div>
    {{-- Accent glow --}}
    <div class="pointer-events-none absolute -top-32 -right-32 h-96 w-96 rounded-full bg-[#EC2029]/15 blur-3xl"></div>

    <div class="relative max-w-4xl" data-aos="fade-down">
       

        <h1 class="text-white text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight leading-[1.1] max-w-3xl">
            Committed to Responsible Operations
        </h1>

        <p class="text-slate-200 max-w-2xl mt-6 leading-relaxed text-sm sm:text-base lg:text-lg">
            PICT manages terminal operations with strict adherence to environmental stewardship, occupational safety, and active community engagement.
        </p>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     2. SUSTAINABILITY PILLARS
═══════════════════════════════════════════════════════════════ --}}
<section class="max-w-7xl mx-auto px-6 py-20 bg-white text-slate-800">
    <div class="text-center mb-14" data-aos="fade-up">
        <span class="eyebrow block mb-2">Our Focus</span>
        <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">
            Our Sustainability Pillars
        </h2>
        <div class="mt-4 h-1 w-16 bg-[#EC2029] rounded-full mx-auto"></div>
    </div>

    @php
        $pillars = [
            [
                'title' => 'Environment',
                'desc'  => 'Operational waste management, energy efficiency initiatives, and regular air and water quality monitoring around the terminal zone to minimize environmental impact.',
                'color' => 'emerald',
                'icon'  => 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z',
                'delay' => 100,
            ],
            [
                'title' => 'Occupational Health & Safety',
                'desc'  => 'Implementation of strict Health, Safety, and Environment (HSE) standards for all employees, logistics partners, and visitors within the terminal zone.',
                'color' => 'red',
                'icon'  => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
                'delay' => 200,
            ],
            [
                'title' => 'Society & Community',
                'desc'  => 'Community empowerment programs around Patimban Port, including local skills training and initiatives supporting the regional economy.',
                'color' => 'blue',
                'icon'  => 'M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4',
                'delay' => 300,
            ],
        ];

        $colorMap = [
            'emerald' => ['bg' => 'bg-emerald-600/10', 'text' => 'text-emerald-600'],
            'red'     => ['bg' => 'bg-red-600/10',     'text' => 'text-red-600'],
            'blue'    => ['bg' => 'bg-blue-600/10',    'text' => 'text-blue-600'],
        ];
    @endphp

    <div class="grid md:grid-cols-3 gap-6">
        @foreach($pillars as $p)
            @php $c = $colorMap[$p['color']]; @endphp
            <div class="pillar-card bg-slate-50 border border-slate-200 rounded-2xl p-7"
                 data-aos="fade-up" data-aos-delay="{{ $p['delay'] }}">
                <div class="pillar-icon w-14 h-14 rounded-xl {{ $c['bg'] }} {{ $c['text'] }} flex items-center justify-center mb-5">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="{{ $p['icon'] }}"/>
                    </svg>
                </div>
                <h3 class="font-bold text-slate-900 text-lg mb-2.5 leading-snug">
                    {!! $p['title'] !!}
                </h3>
                <p class="text-slate-600 text-sm leading-relaxed">
                    {{ $p['desc'] }}
                </p>
            </div>
        @endforeach
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     3. COMMITMENT STATEMENT
═══════════════════════════════════════════════════════════════ --}}
<section class="bg-slate-100 py-20 border-t border-slate-200 text-slate-800">
    <div class="max-w-4xl mx-auto px-6 text-center" data-aos="fade-up">
        <span class="eyebrow block mb-3">Our Commitment</span>
        <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6 tracking-tight leading-tight">
            Supporting Sustainable Industry Growth
        </h2>
        <div class="h-1 w-16 bg-[#EC2029] rounded-full mx-auto mb-8"></div>
        <p class="text-slate-600 leading-relaxed text-sm sm:text-base max-w-3xl mx-auto">
            As an integral part of the national automotive logistics ecosystem, PICT is dedicated to balancing commercial growth with environmental and social responsibilities, aligning with the comprehensive development of Patimban Port as Indonesia's premier automotive gateway.
        </p>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     4. CTA STRIP
═══════════════════════════════════════════════════════════════ --}}
<section class="relative overflow-hidden bg-gradient-to-br from-[#EC2029] to-[#b91c1c] py-16 text-white">
    {{-- Decorative pattern --}}
    <div class="pointer-events-none absolute inset-0 opacity-[0.06]">
        <svg class="h-full w-full" viewBox="0 0 400 200" preserveAspectRatio="none">
            <path d="M0 200 L120 40 L240 200 Z" fill="white"></path>
            <path d="M180 200 L320 20 L400 200 Z" fill="white"></path>
        </svg>
    </div>
    <div class="pointer-events-none absolute -top-24 -right-24 h-72 w-72 rounded-full bg-white/10 blur-3xl"></div>

    <div class="max-w-7xl mx-auto px-6 relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6" data-aos="fade-up">
        <div class="max-w-2xl">
            <span class="eyebrow block mb-3" style="color: rgba(255,255,255,0.7);">Get in touch</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight leading-tight">
                Would You Like to Learn More?
            </h2>
            <p class="text-red-100 text-sm sm:text-base mt-2">
                Get in touch with us for further information on PICT's sustainability framework and initiatives.
            </p>
        </div>

        <a href="{{ url('/contact') }}"
           class="group inline-flex items-center gap-2 shrink-0 px-7 py-3.5 bg-[#0A2540] text-white text-sm font-bold rounded-full border-2 border-[#0A2540] hover:bg-transparent hover:border-white transition-all duration-300 shadow-lg hover:shadow-xl">
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
document.addEventListener('DOMContentLoaded', function () {
    AOS.init({
        duration: 900,
        easing: 'ease-out-cubic',
        once: true,
        offset: 120
    });
});
</script>
@endpush
