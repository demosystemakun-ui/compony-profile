@extends('layouts.app')

@section('title', 'Terminal Service Tariffs — PT Patimban International Car Terminal')

@php
    /* ═══ DATA TARIF (dari TariffController@publicIndex) ═══
       - hasPdf() hanya cek kolom DB (tanpa request ke Supabase)
       - 'view'     => route stream (domain sendiri, bebas CORS, untuk pdf.js)
       - 'download' => route download (header attachment) */
    $tariffs = $tariffs->map(fn ($t) => [
        'tag'      => $t->tag,
        'title'    => $t->title,
        'desc'     => $t->description,
        'icon'     => $t->iconPath(),
        'exists'   => $t->hasPdf(),
        'view'     => route('tarif.stream', $t),
        'download' => route('tarif.download', $t),
    ])->all();
@endphp

@push('styles')
<style>
    :root {
        --color-navy:   #0f172a;
        --color-signal: #ec2029;
        --color-mist:   #eef5fb;
        --color-blush:  #fff1f1;
        --color-ink:    #0f172a;
        --color-muted:  #64748b;
        --color-line:   #e2e8f0;
    }

    [x-cloak] { display: none !important; }

    /* transform: none di akhir animasi agar elemen fixed (toast) tidak terjebak
       di dalam containing block milik .page-transition */
    .page-transition { animation: pageMorphIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes pageMorphIn {
        from { opacity: 0; transform: translateY(16px) scale(0.99); }
        to   { opacity: 1; transform: none; }
    }

    /* ═══ HERO: gelombang bergerak pelan ═══ */
    .wave-wrap { position: absolute; inset-inline: 0; bottom: -1px; line-height: 0; overflow: hidden; color: var(--color-mist); }
    .wave-track { display: flex; width: 200%; }
    .wave-track svg { width: 50%; height: 56px; flex: none; }
    @media (min-width: 640px) { .wave-track svg { height: 96px; } }
    .wave-back  { position: absolute; inset-inline: 0; bottom: 0; opacity: .4; animation: drift 26s linear infinite; }
    .wave-front { position: relative; animation: drift 38s linear infinite reverse; }
    @keyframes drift { from { transform: translateX(0); } to { transform: translateX(-50%); } }

    .hero-in > * { animation: heroIn .9s cubic-bezier(.22,1,.36,1) both; }
    .hero-in > :nth-child(2) { animation-delay: .12s; }
    @keyframes heroIn { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: none; } }

    .squiggle {
        display: block; margin-top: .9rem; width: 84px; height: 10px;
        background: no-repeat center / contain url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 84 10'%3E%3Cpath d='M2 5 Q12 -1 21 5 T42 5 T63 5 T82 5' fill='none' stroke='%23ec2029' stroke-width='3' stroke-linecap='round'/%3E%3C/svg%3E");
    }

    /* ═══ TARIFF CARD: bentuk organik, sedikit miring ═══ */
    .tariff-card {
        background: #fff;
        box-shadow: 0 18px 40px -22px rgba(15, 23, 42, .4);
        transition: transform .35s cubic-bezier(.22,1,.36,1), box-shadow .35s ease;
    }
    @media (min-width: 768px) {
        .tariff-card:nth-child(3n+1) { border-radius: 2.25rem 1rem 2.25rem 1rem;       transform: rotate(-1deg); }
        .tariff-card:nth-child(3n+2) { border-radius: 1rem 2.25rem 1rem 2.25rem;       transform: translateY(12px) rotate(.8deg); }
        .tariff-card:nth-child(3n)   { border-radius: 2.25rem 2.25rem 1rem 2.25rem;    transform: rotate(1deg); }
    }
    @media (max-width: 767.98px) { .tariff-card { border-radius: 1.75rem; } }
    .tariff-card:hover {
        transform: translateY(-6px) rotate(0deg);
        box-shadow: 0 28px 50px -22px rgba(15, 23, 42, .45);
    }
    .tariff-blob {
        position: absolute; right: -2.5rem; top: -2.5rem; width: 9rem; height: 9rem;
        border-radius: 9999px; background: var(--color-blush);
        transition: transform .5s cubic-bezier(.34,1.56,.64,1);
        pointer-events: none;
    }
    .tariff-card:hover .tariff-blob { transform: scale(1.25); }

    .btn-soft { transition: transform .3s cubic-bezier(.34,1.56,.64,1), box-shadow .25s ease, background-color .2s ease; }
    .btn-soft:hover { transform: translateY(-2px) scale(1.03); }

    /* ═══ PDF MODAL ═══ */
    body.pdf-modal-open { overflow: hidden; }

    /* Di atas navbar situs (modal & toast dipindah ke <body> lewat JS) */
    #pdf-viewer-modal { z-index: 2147483000 !important; height: 100vh; height: 100dvh; }
    #pdfNotification  { z-index: 2147483001 !important; }
    #pdf-page-wrap { line-height: 0; border-radius: .5rem; overflow: hidden; }
    #pdf-draw-canvas { touch-action: none; }
    #pdf-draw-canvas.tool-pan    { pointer-events: none; }
    #pdf-draw-canvas.tool-pen    { cursor: crosshair; }
    #pdf-draw-canvas.tool-eraser { cursor: cell; }

    .pdf-tool-btn {
        display: inline-flex; align-items: center; justify-content: center;
        width: 2.25rem; height: 2.25rem; border-radius: 9999px;
        color: rgba(255, 255, 255, 0.7);
        transition: background-color .15s ease, color .15s ease, transform .25s cubic-bezier(.34,1.56,.64,1);
        flex-shrink: 0;
    }
    .pdf-tool-btn:hover  { background: rgba(255, 255, 255, 0.1); color: #fff; transform: scale(1.08); }
    .pdf-tool-btn.active { background: var(--color-signal); color: #fff; }
    .pdf-tool-btn:disabled { opacity: 0.3; pointer-events: none; }

    .pdf-scroll::-webkit-scrollbar { width: 10px; height: 10px; }
    .pdf-scroll::-webkit-scrollbar-track { background: transparent; }
    .pdf-scroll::-webkit-scrollbar-thumb { background: #334155; border-radius: 9999px; border: 2px solid #1a1c23; }
    .pdf-scroll::-webkit-scrollbar-thumb:hover { background: #475569; }

    @media (prefers-reduced-motion: reduce) {
        .page-transition, .hero-in > *, .wave-back, .wave-front { animation: none !important; }
        .tariff-card, .tariff-blob, .btn-soft, .pdf-tool-btn { transition: none !important; }
    }
</style>
@endpush

@section('content')
<div class="page-transition bg-[#eef5fb] min-h-screen">

    {{-- ═══ NOTIFICATION TOAST ═══ --}}
    <div id="pdfNotification"
         class="fixed bottom-6 right-6 z-50 transform translate-y-32 opacity-0 transition-all duration-300 ease-out pointer-events-none">
        <div class="pointer-events-auto bg-slate-900 rounded-3xl shadow-2xl flex items-start gap-3 max-w-sm px-5 py-4">
            <span class="mt-1.5 h-2.5 w-2.5 shrink-0 rounded-full bg-[#ec2029]"></span>
            <div class="flex-1">
                <p class="text-xs font-bold text-red-400 mb-1">System notice</p>
                <p id="notificationText" class="text-sm text-slate-200 leading-relaxed">Document not available.</p>
            </div>
            <button type="button" onclick="hideNotification()"
                    class="-mr-1 -mt-1 p-2 rounded-full text-slate-400 hover:text-white hover:bg-white/10 transition-colors cursor-pointer"
                    aria-label="Close notification">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- ═══ HERO ═══ --}}
    <section class="relative w-full min-h-[460px] flex flex-col justify-center text-left px-6 sm:px-12 md:px-16 lg:px-24 pt-28 sm:pt-32 md:pt-36 pb-32 bg-slate-900 overflow-hidden">
        <div class="absolute inset-0 z-0 bg-cover bg-center"
             style="background-image: url('{{ asset('assets/images/background.jpeg') }}');"></div>
        <div class="absolute inset-0 z-0 bg-gradient-to-r from-slate-950 via-slate-900/85 to-slate-900/40"></div>
        <div class="pointer-events-none absolute -top-24 -right-24 h-96 w-96 rounded-full bg-[#ec2029]/20 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-10 left-1/4 h-60 w-60 rounded-full bg-sky-300/15 blur-3xl"></div>

        <div class="hero-in relative z-10 max-w-7xl w-full mx-auto">
            <h1 class="text-white text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight leading-[1.1] max-w-3xl">
                Terminal Service Tariffs
            </h1>
            <p class="text-slate-200 max-w-xl mt-4 sm:mt-6 leading-relaxed text-sm sm:text-base md:text-lg">
                Official fee structure for domestic, international, and other vehicle handling services at Patimban Terminal.
            </p>
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

    {{-- ═══ TARIFF CARDS ═══ --}}
    <div class="max-w-7xl mx-auto px-6 pb-20 -mt-14 relative z-20">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
            @forelse($tariffs as $tariff)
                <div class="tariff-card overflow-hidden relative group flex flex-col">

                    <span class="tariff-blob" aria-hidden="true"></span>

                    {{-- Header (clickable di mobile) --}}
                    <div data-tariff-toggle class="relative p-6 sm:p-8 cursor-pointer select-none flex-1 flex flex-col">
                        <div class="flex items-start justify-between gap-3 mb-4">
                            <div class="flex items-start gap-4">
                                <div class="flex items-center justify-center w-14 h-14 rounded-[1.25rem_1.25rem_0.4rem_1.25rem] bg-red-50 text-[#ec2029] group-hover:bg-[#ec2029] group-hover:text-white transition-colors shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $tariff['icon'] }}"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs font-semibold mb-2 inline-block">
                                        {{ $tariff['tag'] }}
                                    </span>
                                    <h2 class="text-xl font-bold text-slate-900">
                                        {{ $tariff['title'] }}
                                    </h2>
                                </div>
                            </div>

                            <svg data-tariff-chevron class="w-5 h-5 text-slate-400 transition-transform duration-300 shrink-0 mt-2 md:hidden"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>

                        <p class="text-sm text-slate-500 leading-relaxed">{{ $tariff['desc'] }}</p>
                    </div>

                    {{-- Actions --}}
                    <div data-tariff-actions class="relative hidden md:block px-6 sm:px-8 pb-6 sm:pb-8">
                        <div class="flex flex-row gap-2.5 w-full">
                            @if($tariff['exists'])
                                {{-- View: buka modal pdf.js --}}
                                <button type="button"
                                        onclick="openPdfViewer(@js($tariff['view']), @js($tariff['title']), @js($tariff['download']))"
                                        class="btn-soft flex-1 bg-slate-100 text-slate-700 hover:bg-slate-200 hover:text-slate-900 rounded-full px-4 py-3 text-xs font-semibold flex items-center justify-center gap-1.5 group/btn cursor-pointer">
                                    <svg class="w-4 h-4 text-slate-500 group-hover/btn:text-[#ec2029] transition-colors shrink-0"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <span class="truncate">View</span>
                                </button>

                                <a href="{{ $tariff['download'] }}"
                                   class="btn-soft flex-1 bg-slate-900 hover:bg-[#ec2029] text-white rounded-full px-4 py-3 text-xs font-semibold shadow-md flex items-center justify-center gap-1.5">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    <span class="truncate">Download</span>
                                </a>
                            @else
                                <button type="button"
                                        onclick="showNotification(@js('The ' . $tariff['title'] . ' PDF document is not yet available on the server.'))"
                                        class="w-full bg-slate-100 text-slate-400 rounded-full px-4 py-3 text-xs font-semibold cursor-not-allowed flex items-center justify-center gap-2">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                    Unavailable
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="md:col-span-3 text-center py-16 bg-white rounded-[2rem] shadow-[0_18px_40px_-22px_rgba(15,23,42,.35)]">
                    <h3 class="text-lg font-bold text-slate-700">No tariff documents yet</h3>
                    <p class="text-sm text-slate-500 mt-1">Tariff documents will appear here once published.</p>
                </div>
            @endforelse
        </div>

        {{-- Disclaimer --}}
        <div class="mt-16 flex justify-center">
            <p class="text-sm text-slate-600 max-w-2xl bg-white px-7 py-5 rounded-[1.75rem_1.75rem_1.75rem_0.5rem] shadow-[0_14px_34px_-22px_rgba(15,23,42,.4)] leading-relaxed">
                <span class="font-semibold text-slate-800">Disclaimer:</span>
                Tariffs are subject to change at any time in accordance with company policy.
                For further inquiries, please contact
                <a href="mailto:info@pict.co.id" class="text-[#b91c1c] hover:underline font-semibold">info@pict.co.id</a>
                to confirm the latest rates.
            </p>
        </div>
    </div>
</div>

{{-- ═══ IN-PAGE PDF VIEWER MODAL ═══ --}}
<div id="pdf-viewer-modal" class="fixed inset-0 z-[200] hidden" role="dialog" aria-modal="true" aria-labelledby="pdf-modal-title">
    <div id="pdf-modal-backdrop" class="absolute inset-0 bg-slate-900/90 backdrop-blur-sm transition-opacity"></div>

    <div class="relative z-10 w-full h-full flex flex-col gap-3 p-3 sm:p-4 pointer-events-none">
        {{-- Toolbar --}}
        <div class="pointer-events-auto flex items-center justify-between gap-3 px-4 sm:px-6 py-3 bg-slate-900 rounded-3xl shadow-xl ring-1 ring-white/10 flex-wrap">
            <div class="flex items-center gap-3 min-w-0">
                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-white/10 flex-shrink-0">
                    <svg class="w-4 h-4 text-white/70" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 3H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V8l-6-5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 3v5h5"/>
                    </svg>
                </span>
                <div class="flex flex-col min-w-0">
                    <span id="pdf-modal-title" class="font-bold text-sm text-white truncate max-w-[40vw]">Document</span>
                    <span id="pdf-page-info" class="text-xs text-white/50 whitespace-nowrap hidden sm:block">Page 1 of 1</span>
                </div>
            </div>

            <div class="flex items-center gap-1 flex-wrap justify-end">
                <button id="pdf-prev-page" class="pdf-tool-btn" title="Previous page" aria-label="Previous page">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button id="pdf-next-page" class="pdf-tool-btn" title="Next page" aria-label="Next page">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </button>

                <span class="w-1 h-1 rounded-full bg-white/25 mx-2"></span>

                <button id="pdf-zoom-out" class="pdf-tool-btn" title="Zoom out" aria-label="Zoom out">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M8 11h6"/></svg>
                </button>
                <span id="pdf-zoom-level" class="text-xs text-white/70 w-11 text-center select-none">100%</span>
                <button id="pdf-zoom-in" class="pdf-tool-btn" title="Zoom in" aria-label="Zoom in">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M11 8v6M8 11h6"/></svg>
                </button>
                <button id="pdf-zoom-reset" class="pdf-tool-btn text-[10px] font-bold" title="Reset zoom" aria-label="Reset zoom">1:1</button>

                <span class="w-1 h-1 rounded-full bg-white/25 mx-2"></span>

                <button id="pdf-tool-pan" class="pdf-tool-btn active" title="Pan / scroll" aria-label="Pan tool">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8 11V6a2 2 0 114 0v5m0-3V4a2 2 0 114 0v7m0-2a2 2 0 114 0v6a8 8 0 01-8 8h-1a8 8 0 01-6.29-3.05l-2.3-3.5a1.5 1.5 0 012.4-1.8L7 15.5V6a2 2 0 114 0v5"/></svg>
                </button>
                <button id="pdf-tool-pen" class="pdf-tool-btn" title="Draw / mark up" aria-label="Pen tool">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/><path stroke-linecap="round" stroke-linejoin="round" d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </button>
                <input type="color" id="pdf-pen-color" value="#DC2626" title="Pen color" aria-label="Pen color"
                       class="w-7 h-7 rounded-full border border-white/20 bg-transparent cursor-pointer p-0.5 mx-1">
                <button id="pdf-tool-eraser" class="pdf-tool-btn" title="Eraser" aria-label="Eraser tool">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M20 20H8l-6-6a2 2 0 010-2.8L13.6 2 22 10.4 13.6 18.8"/></svg>
                </button>
                <button id="pdf-undo" class="pdf-tool-btn" title="Undo last stroke" aria-label="Undo">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 14l-4-4 4-4M5 10h9a5 5 0 010 10h-1"/></svg>
                </button>
                <button id="pdf-clear" class="pdf-tool-btn text-[10px] font-bold" title="Clear markup on this page" aria-label="Clear markup">Clear</button>

                <span class="w-1 h-1 rounded-full bg-white/25 mx-2"></span>

                <a id="pdf-download" href="#" class="pdf-tool-btn" title="Download PDF" aria-label="Download PDF">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/></svg>
                </a>
                <button id="pdf-modal-close" class="pdf-tool-btn hover:bg-white/10" title="Close" aria-label="Close viewer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        {{-- Canvas area --}}
        <div id="pdf-canvas-container" class="pointer-events-auto pdf-scroll flex-1 overflow-auto bg-[#1a1c23] rounded-3xl ring-1 ring-white/10 flex items-start justify-center p-6 sm:p-10 scroll-smooth relative">
            <div id="pdf-page-wrap" class="relative bg-white shadow-[0_0_40px_rgba(0,0,0,0.5)] transition-transform duration-200">
                <canvas id="pdf-render-canvas"></canvas>
                <canvas id="pdf-draw-canvas" class="absolute inset-0 tool-pan"></canvas>
            </div>

            <div id="pdf-loading-msg" class="hidden absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex flex-col items-center gap-4">
                <div class="w-10 h-10 border-4 border-slate-700 border-t-[#ec2029] rounded-full animate-spin"></div>
                <p class="text-white/70 text-sm font-medium tracking-wide">Rendering document...</p>
            </div>

            <div id="pdf-error-msg" class="hidden absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex flex-col items-center gap-3 text-center">
                <div class="w-12 h-12 rounded-full bg-[#ec2029]/20 text-[#ec2029] flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-white text-sm font-medium">Could not load this document.</p>
                <p class="text-slate-400 text-xs">Please try again later or download the file directly.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    /* ═══ Pindahkan modal & toast ke <body> agar lepas dari stacking context layout/navbar ═══ */
    ['pdf-viewer-modal', 'pdfNotification'].forEach(id => {
        const el = document.getElementById(id);
        if (el) document.body.appendChild(el);
    });

    /* ═══ CARD TOGGLE (mobile) ═══ */
    document.querySelectorAll('[data-tariff-toggle]').forEach(header => {
        header.addEventListener('click', () => {
            const card = header.closest('.tariff-card');
            card.querySelector('[data-tariff-actions]')?.classList.toggle('hidden');
            card.querySelector('[data-tariff-chevron]')?.classList.toggle('rotate-180');
        });
    });

    /* ═══ NOTIFICATION TOAST ═══ */
    window.showNotification = function (message) {
        const toast = document.getElementById('pdfNotification');
        const text  = document.getElementById('notificationText');
        if (!toast || !text) return;
        text.textContent = message;
        toast.classList.remove('translate-y-32', 'opacity-0');
        clearTimeout(window._notificationTimeout);
        window._notificationTimeout = setTimeout(hideNotification, 4000);
    };
    window.hideNotification = function () {
        const toast = document.getElementById('pdfNotification');
        if (toast) toast.classList.add('translate-y-32', 'opacity-0');
    };

    /* ═══ PDF VIEWER ═══ */
    if (window['pdfjsLib']) {
        pdfjsLib.GlobalWorkerOptions.workerSrc =
            'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
    }

    const $ = id => document.getElementById(id);
    const modal = $('pdf-viewer-modal'), backdrop = $('pdf-modal-backdrop');
    const titleEl = $('pdf-modal-title'), pageInfoEl = $('pdf-page-info');
    const container = $('pdf-canvas-container'), pageWrap = $('pdf-page-wrap');
    const renderCanvas = $('pdf-render-canvas'), drawCanvas = $('pdf-draw-canvas');
    const zoomLevelEl = $('pdf-zoom-level');
    const loadingMsg = $('pdf-loading-msg'), errorMsg = $('pdf-error-msg');
    const downloadLink = $('pdf-download');
    const prevBtn = $('pdf-prev-page'), nextBtn = $('pdf-next-page');
    const zoomInBtn = $('pdf-zoom-in'), zoomOutBtn = $('pdf-zoom-out'), zoomResetBtn = $('pdf-zoom-reset');
    const panBtn = $('pdf-tool-pan'), penBtn = $('pdf-tool-pen'), eraserBtn = $('pdf-tool-eraser');
    const penColorInput = $('pdf-pen-color');
    const undoBtn = $('pdf-undo'), clearBtn = $('pdf-clear'), closeBtn = $('pdf-modal-close');

    const BASE_SCALE = 1.25, MIN_SCALE = 0.5, MAX_SCALE = 3.5;

    let loadingTask   = null;
    let pdfDoc        = null;
    let currentPage   = 1;
    let currentScale  = BASE_SCALE;
    let currentTool   = 'pan';
    let strokesByPage = {};
    let activeStroke  = null;
    let isPointerDown = false;
    let renderToken   = 0;
    let renderTask    = null;

    function setTool(tool) {
        currentTool = tool;
        [panBtn, penBtn, eraserBtn].forEach(b => b.classList.remove('active'));
        drawCanvas.classList.remove('tool-pan', 'tool-pen', 'tool-eraser');
        ({ pan: panBtn, pen: penBtn, eraser: eraserBtn })[tool].classList.add('active');
        drawCanvas.classList.add('tool-' + tool);
    }

    const clampScale = s => Math.min(MAX_SCALE, Math.max(MIN_SCALE, s));

    function updateZoomLabel() {
        zoomLevelEl.textContent = Math.round((currentScale / BASE_SCALE) * 100) + '%';
    }

    function updateNavButtons() {
        if (!pdfDoc) return;
        prevBtn.disabled = currentPage <= 1;
        nextBtn.disabled = currentPage >= pdfDoc.numPages;
        pageInfoEl.textContent = 'Page ' + currentPage + ' of ' + pdfDoc.numPages;
    }

    function normalizedPoint(e) {
        const r = drawCanvas.getBoundingClientRect();
        return {
            x: Math.min(1, Math.max(0, (e.clientX - r.left) / r.width)),
            y: Math.min(1, Math.max(0, (e.clientY - r.top)  / r.height)),
        };
    }

    function drawStroke(ctx, stroke) {
        if (!stroke.points || stroke.points.length < 1) return;
        ctx.save();
        ctx.globalCompositeOperation = stroke.erase ? 'destination-out' : 'source-over';
        ctx.strokeStyle = stroke.color;
        ctx.lineWidth   = stroke.width;
        ctx.lineCap = ctx.lineJoin = 'round';
        ctx.beginPath();
        stroke.points.forEach((p, i) => {
            const x = p.x * drawCanvas.width, y = p.y * drawCanvas.height;
            i === 0 ? ctx.moveTo(x, y) : ctx.lineTo(x, y);
        });
        ctx.stroke();
        ctx.restore();
    }

    function redrawAnnotations() {
        const ctx = drawCanvas.getContext('2d');
        ctx.clearRect(0, 0, drawCanvas.width, drawCanvas.height);
        (strokesByPage[currentPage] || []).forEach(s => drawStroke(ctx, s));
    }

    function showError() {
        loadingMsg.classList.add('hidden');
        errorMsg.classList.remove('hidden');
        pageWrap.style.opacity = '0';
    }

    function renderPage(num) {
        if (!pdfDoc) return;
        const myToken = ++renderToken;
        if (renderTask) { try { renderTask.cancel(); } catch (_) {} }
        pageWrap.style.opacity = '0.5';

        pdfDoc.getPage(num).then(page => {
            if (myToken !== renderToken) return;
            const viewport = page.getViewport({ scale: currentScale });
            renderCanvas.width  = drawCanvas.width  = viewport.width;
            renderCanvas.height = drawCanvas.height = viewport.height;
            pageWrap.style.width  = viewport.width  + 'px';
            pageWrap.style.height = viewport.height + 'px';

            renderTask = page.render({ canvasContext: renderCanvas.getContext('2d'), viewport });
            return renderTask.promise.then(() => {
                if (myToken !== renderToken) return;
                pageWrap.style.opacity = '1';
                loadingMsg.classList.add('hidden');
                redrawAnnotations();
                updateZoomLabel();
                updateNavButtons();
            });
        }).catch(err => {
            if (err && err.name === 'RenderingCancelledException') return;
            if (myToken === renderToken) showError();
        });
    }

    /** @param {string} url      URL stream (inline, domain sendiri)
     *  @param {string} title    Judul dokumen
     *  @param {string} download URL download (opsional) */
    window.openPdfViewer = function (url, title, download) {
        if (!url || url === '#') {
            showNotification('This document is not yet available on the server.');
            return;
        }
        if (!window['pdfjsLib']) {
            window.open(url, '_blank', 'noopener');
            return;
        }

        currentPage   = 1;
        currentScale  = BASE_SCALE;
        strokesByPage = {};
        titleEl.textContent = title || 'Document';
        downloadLink.href   = download || url;
        errorMsg.classList.add('hidden');
        loadingMsg.classList.remove('hidden');
        pageWrap.style.opacity = '0';

        modal.classList.remove('hidden');
        document.body.classList.add('pdf-modal-open');
        setTool('pan');

        if (loadingTask) { try { loadingTask.destroy(); } catch (_) {} }
        loadingTask = pdfjsLib.getDocument(url);
        const task = loadingTask;

        task.promise.then(doc => {
            if (task !== loadingTask) { doc.destroy(); return; }
            pdfDoc = doc;
            renderPage(currentPage);
        }).catch(() => {
            if (task === loadingTask) showError();
        });
    };

    function closePdfViewer() {
        modal.classList.add('hidden');
        document.body.classList.remove('pdf-modal-open');
        renderToken++;
        if (renderTask)   { try { renderTask.cancel(); }   catch (_) {} renderTask = null; }
        if (loadingTask)  { try { loadingTask.destroy(); } catch (_) {} loadingTask = null; }
        pdfDoc = null;
    }

    closeBtn.addEventListener('click', closePdfViewer);
    backdrop.addEventListener('click', closePdfViewer);
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) closePdfViewer();
    });

    prevBtn.addEventListener('click', () => { if (currentPage > 1) { currentPage--; renderPage(currentPage); } });
    nextBtn.addEventListener('click', () => {
        if (pdfDoc && currentPage < pdfDoc.numPages) { currentPage++; renderPage(currentPage); }
    });

    zoomInBtn.addEventListener('click',   () => { currentScale = clampScale(currentScale + 0.25); renderPage(currentPage); });
    zoomOutBtn.addEventListener('click',  () => { currentScale = clampScale(currentScale - 0.25); renderPage(currentPage); });
    zoomResetBtn.addEventListener('click',() => { currentScale = BASE_SCALE; renderPage(currentPage); });

    container.addEventListener('wheel', e => {
        if (!e.ctrlKey) return;
        e.preventDefault();
        currentScale = clampScale(currentScale + (e.deltaY < 0 ? 0.15 : -0.15));
        renderPage(currentPage);
    }, { passive: false });

    panBtn.addEventListener('click',    () => setTool('pan'));
    penBtn.addEventListener('click',    () => setTool('pen'));
    eraserBtn.addEventListener('click', () => setTool('eraser'));

    undoBtn.addEventListener('click', () => {
        (strokesByPage[currentPage] || []).pop();
        redrawAnnotations();
    });
    clearBtn.addEventListener('click', () => {
        strokesByPage[currentPage] = [];
        redrawAnnotations();
    });

    /* ═══ DRAWING ═══ */
    drawCanvas.addEventListener('pointerdown', e => {
        if (currentTool === 'pan') return;
        isPointerDown = true;
        drawCanvas.setPointerCapture(e.pointerId);
        activeStroke = {
            color:  currentTool === 'eraser' ? '#000000' : penColorInput.value,
            width:  currentTool === 'eraser' ? 22 : 3,
            erase:  currentTool === 'eraser',
            points: [normalizedPoint(e)],
        };
    });

    drawCanvas.addEventListener('pointermove', e => {
        if (!isPointerDown || !activeStroke) return;
        activeStroke.points.push(normalizedPoint(e));
        redrawAnnotations();
        drawStroke(drawCanvas.getContext('2d'), activeStroke);
    });

    function finishStroke() {
        if (activeStroke && activeStroke.points.length > 1) {
            (strokesByPage[currentPage] = strokesByPage[currentPage] || []).push(activeStroke);
        }
        activeStroke  = null;
        isPointerDown = false;
        redrawAnnotations();
    }

    drawCanvas.addEventListener('pointerup', finishStroke);
    drawCanvas.addEventListener('pointercancel', finishStroke);
    drawCanvas.addEventListener('pointerleave', () => { if (isPointerDown) finishStroke(); });
});
</script>
@endpush