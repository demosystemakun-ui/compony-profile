@extends('layouts.app')

@section('title', 'Terminal Service Tariffs — PT Patimban International Car Terminal')

@php
    /* ═══ DATA TARIF (dari database via TariffController@index) ═══ */
    $tariffs = $tariffs->map(fn ($t) => [
        'tag'      => $t->tag,
        'title'    => $t->title,
        'desc'     => $t->description,
        'icon'     => $t->iconPath(),
        'exists'   => $t->hasPdf(),
        'url'      => $t->pdfUrl(),
        'download' => route('tarif.download', $t),
        'modal'    => $t->title,
    ])->all();
@endphp

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
<style>
    /* ═══ DESIGN SYSTEM — PICT TARIFFS ═══ */
    :root {
        --color-navy:   #0f172a;
        --color-signal: #ec2029;
        --color-paper:  #f8fafc;
        --color-ink:    #0f172a;
        --color-muted:  #64748b;
        --color-line:   #e2e8f0;
    }

    [x-cloak] { display: none !important; }

    .page-transition {
        animation: pageMorphIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    @keyframes pageMorphIn {
        from { opacity: 0; transform: translateY(16px) scale(0.99); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* ═══ PDF MODAL ═══ */
    body.pdf-modal-open { overflow: hidden; }

    #pdf-page-wrap { line-height: 0; }

    #pdf-draw-canvas { touch-action: none; }
    #pdf-draw-canvas.tool-pan    { pointer-events: none; }
    #pdf-draw-canvas.tool-pen    { cursor: crosshair; }
    #pdf-draw-canvas.tool-eraser { cursor: cell; }

    .pdf-tool-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2.25rem;
        height: 2.25rem;
        border-radius: 0.375rem;
        color: rgba(255, 255, 255, 0.7);
        transition: all 0.15s ease;
        flex-shrink: 0;
    }
    .pdf-tool-btn:hover  { background: rgba(255, 255, 255, 0.08); color: #ffffff; }
    .pdf-tool-btn.active { background: var(--color-signal); color: #ffffff; }
    .pdf-tool-btn:disabled { opacity: 0.3; pointer-events: none; }

    /* ═══ TARIFF CARD ═══ */
    .tariff-card {
        transition: box-shadow .3s ease, transform .3s ease;
    }
    .tariff-card:hover {
        box-shadow: 0 20px 40px -12px rgba(15, 23, 42, 0.12);
        transform: translateY(-4px);
    }

    /* ═══ SCROLLBAR (Webkit) ═══ */
    .pdf-scroll::-webkit-scrollbar { width: 10px; height: 10px; }
    .pdf-scroll::-webkit-scrollbar-track { background: #1a1c23; }
    .pdf-scroll::-webkit-scrollbar-thumb { background: #334155; border-radius: 5px; }
    .pdf-scroll::-webkit-scrollbar-thumb:hover { background: #475569; }
</style>
@endpush

@section('content')
<div class="page-transition bg-slate-50 min-h-screen">

    {{-- ═══════════════════════════════════════════════════════════════
         NOTIFICATION TOAST
    ═══════════════════════════════════════════════════════════════ --}}
    <div id="pdfNotification"
         class="fixed bottom-6 right-6 z-50 transform translate-y-32 opacity-0 transition-all duration-300 ease-out pointer-events-none">
        <div class="pointer-events-auto bg-slate-900 rounded-xl border border-slate-700 shadow-2xl flex items-start gap-4 max-w-sm overflow-hidden">
            <div class="bg-[#ec2029] w-1.5 self-stretch"></div>
            <div class="flex-1 py-4 pr-2">
                <p class="text-[11px] font-bold uppercase tracking-wider text-red-500 mb-1">System Notice</p>
                <p id="notificationText" class="text-sm text-slate-200 leading-relaxed">
                    Document not available.
                </p>
            </div>
            <button type="button" onclick="hideNotification()"
                    class="p-4 text-slate-400 hover:text-white transition-colors cursor-pointer"
                    aria-label="Close notification">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         HERO SECTION
    ═══════════════════════════════════════════════════════════════ --}}
    <section class="relative w-full min-h-[420px] flex flex-col justify-center text-left px-6 sm:px-12 md:px-16 lg:px-24 py-16 pt-28 sm:pt-32 md:pt-36 border-b border-slate-800 bg-slate-900 overflow-hidden">
        <div class="absolute inset-0 z-0 bg-cover bg-center"
             style="background-image: url('{{ asset("assets/images/background.jpeg") }}');"></div>
        <div class="absolute inset-0 z-0 bg-gradient-to-r from-slate-950 via-slate-900/90 to-slate-900/40"></div>
        <div class="pointer-events-none absolute -top-32 -right-32 h-96 w-96 rounded-full bg-[#ec2029]/10 blur-3xl"></div>

        <div class="relative z-10 max-w-7xl w-full mx-auto" data-aos="fade-down">
            <h1 class="text-white text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight leading-[1.1] max-w-3xl">
                Terminal Service Tariffs
            </h1>
            <p class="text-slate-300 max-w-xl mt-4 sm:mt-6 leading-relaxed text-sm sm:text-base md:text-lg font-light">
                Official fee structure for domestic, international, and other vehicle handling services at Patimban Terminal.
            </p>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════════
         TARIFF CARDS
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="max-w-7xl mx-auto px-6 py-16 -mt-8 relative z-20" data-aos="fade-up" data-aos-delay="100">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($tariffs as $tariff)
                <div class="tariff-card bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden relative group flex flex-col">

                    {{-- Accent bar --}}
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-slate-200 group-hover:bg-[#ec2029] transition-colors duration-300"></div>

                    {{-- Header (clickable) --}}
                    <div data-tariff-toggle
                         class="p-6 sm:p-8 cursor-pointer select-none ml-2 flex-1 flex flex-col">
                        <div class="flex items-start justify-between gap-3 mb-4">
                            <div class="flex items-start gap-4">
                                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-slate-50 border border-slate-100 text-slate-400 group-hover:text-[#ec2029] group-hover:bg-red-50 transition-colors shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $tariff['icon'] }}"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="bg-slate-100 text-slate-600 px-2.5 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider mb-1 inline-block">
                                        {{ $tariff['tag'] }}
                                    </span>
                                    <h2 class="text-xl font-bold text-slate-900 group-hover:text-[#ec2029] transition-colors">
                                        {{ $tariff['title'] }}
                                    </h2>
                                </div>
                            </div>

                            {{-- Mobile toggle chevron --}}
                            <svg data-tariff-chevron class="w-5 h-5 text-slate-400 transition-transform duration-300 shrink-0 mt-2 md:hidden"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>

                        <p class="text-sm text-slate-500 leading-relaxed">
                            {{ $tariff['desc'] }}
                        </p>
                    </div>

                    {{-- Actions (mobile collapsible, desktop always visible) --}}
                    <div data-tariff-actions class="hidden md:block px-6 sm:px-8 pb-6 sm:pb-8 ml-2 border-t border-slate-100">
                        <div class="flex flex-row gap-2.5 w-full pt-4">
                            @if($tariff['exists'])
                                <a href="{{ $tariff['url'] }}"
                                        class="flex-1 bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 hover:text-slate-900 rounded-xl px-3 py-2.5 text-xs font-semibold transition-all shadow-sm flex items-center justify-center gap-1.5 group/btn">
                                    <svg class="w-4 h-4 text-slate-400 group-hover/btn:text-[#ec2029] transition-colors shrink-0"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <span class="truncate">View</span>
                                </a>

                                <a href="{{ $tariff['download'] }}" download
                                   class="flex-1 bg-slate-900 hover:bg-slate-800 text-white rounded-xl px-3 py-2.5 text-xs font-semibold transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-1.5">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    <span class="truncate">Download</span>
                                </a>
                            @else
                                <button type="button"
                                        onclick="showNotification(@js('The ' . $tariff['title'] . ' PDF document is not yet available on the server.'))"
                                        class="w-full bg-slate-100 text-slate-400 rounded-xl px-4 py-2.5 text-xs font-semibold cursor-not-allowed flex items-center justify-center gap-2">
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
                <div class="md:col-span-3 text-center py-16 bg-white rounded-2xl border border-slate-200 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-700">No tariff documents yet</h3>
                    <p class="text-sm text-slate-500 mt-1">Tariff documents will appear here once published.</p>
                </div>
            @endforelse
        </div>

        {{-- Disclaimer --}}
        <div class="mt-12 text-center">
            <p class="text-sm text-slate-500 max-w-2xl mx-auto bg-white px-6 py-4 rounded-xl border border-slate-200/60 shadow-sm">
                <span class="font-semibold text-slate-700">Disclaimer:</span>
                Tariffs are subject to change at any time in accordance with company policy.
                For further inquiries, please contact
                <a href="mailto:info@pict.co.id" class="text-[#ec2029] hover:underline font-medium">info@pict.co.id</a>
                to confirm the latest rates.
            </p>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════
     IN-PAGE PDF VIEWER MODAL
══════════════════════════════════════════════════════════════ --}}
<div id="pdf-viewer-modal" class="fixed inset-0 z-[200] hidden">
    <div id="pdf-modal-backdrop" class="absolute inset-0 bg-slate-900/90 backdrop-blur-sm transition-opacity"></div>

    <div class="relative z-10 w-full h-full flex flex-col">
        {{-- Toolbar --}}
        <div class="flex items-center justify-between gap-3 px-4 sm:px-6 py-3 bg-slate-900 shadow-lg flex-wrap">
            <div class="flex items-center gap-3 min-w-0">
                <svg class="w-4 h-4 text-white/40 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 3H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V8l-6-5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 3v5h5"/>
                </svg>
                <div class="flex flex-col">
                    <span id="pdf-modal-title" class="font-bold text-sm text-white truncate max-w-[40vw]">Document</span>
                    <span id="pdf-page-info" class="text-[10px] text-white/50 whitespace-nowrap uppercase tracking-wider hidden sm:block">Page 1 / 1</span>
                </div>
            </div>

            <div class="flex items-center gap-1 flex-wrap justify-end">
                <button id="pdf-prev-page" class="pdf-tool-btn" title="Previous page" aria-label="Previous page">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button id="pdf-next-page" class="pdf-tool-btn" title="Next page" aria-label="Next page">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </button>

                <span class="w-px h-6 bg-white/15 mx-1.5"></span>

                <button id="pdf-zoom-out" class="pdf-tool-btn" title="Zoom out" aria-label="Zoom out">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M8 11h6"/></svg>
                </button>
                <span id="pdf-zoom-level" class="text-xs text-white/70 w-11 text-center select-none">100%</span>
                <button id="pdf-zoom-in" class="pdf-tool-btn" title="Zoom in" aria-label="Zoom in">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M11 8v6M8 11h6"/></svg>
                </button>
                <button id="pdf-zoom-reset" class="pdf-tool-btn text-[10px] font-bold" title="Reset zoom" aria-label="Reset zoom">1:1</button>

                <span class="w-px h-6 bg-white/15 mx-1.5"></span>

                <button id="pdf-tool-pan" class="pdf-tool-btn active" title="Pan / scroll" aria-label="Pan tool">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8 11V6a2 2 0 114 0v5m0-3V4a2 2 0 114 0v7m0-2a2 2 0 114 0v6a8 8 0 01-8 8h-1a8 8 0 01-6.29-3.05l-2.3-3.5a1.5 1.5 0 012.4-1.8L7 15.5V6a2 2 0 114 0v5"/></svg>
                </button>
                <button id="pdf-tool-pen" class="pdf-tool-btn" title="Draw / mark up" aria-label="Pen tool">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/><path stroke-linecap="round" stroke-linejoin="round" d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </button>
                <input type="color" id="pdf-pen-color" value="#DC2626" title="Pen color" aria-label="Pen color"
                       class="w-7 h-7 border border-white/20 bg-transparent cursor-pointer p-0.5 mx-1">
                <button id="pdf-tool-eraser" class="pdf-tool-btn" title="Eraser" aria-label="Eraser tool">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M20 20H8l-6-6a2 2 0 010-2.8L13.6 2 22 10.4 13.6 18.8"/></svg>
                </button>
                <button id="pdf-undo" class="pdf-tool-btn" title="Undo last stroke" aria-label="Undo">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 14l-4-4 4-4M5 10h9a5 5 0 010 10h-1"/></svg>
                </button>
                <button id="pdf-clear" class="pdf-tool-btn text-[10px] font-bold" title="Clear markup on this page" aria-label="Clear markup">CLR</button>

                <span class="w-px h-6 bg-white/15 mx-1.5"></span>

                <a id="pdf-download" href="#" download class="pdf-tool-btn" title="Download PDF" aria-label="Download PDF">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/></svg>
                </a>
                <button id="pdf-modal-close" class="pdf-tool-btn hover:bg-white/10" title="Close" aria-label="Close viewer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        {{-- Canvas area --}}
        <div id="pdf-canvas-container" class="pdf-scroll flex-1 overflow-auto bg-[#1a1c23] flex items-start justify-center p-6 sm:p-10 scroll-smooth relative">
            <div id="pdf-page-wrap" class="relative bg-white shadow-[0_0_40px_rgba(0,0,0,0.5)] transition-transform duration-200">
                <canvas id="pdf-render-canvas"></canvas>
                <canvas id="pdf-draw-canvas" class="absolute inset-0 tool-pan"></canvas>
            </div>

            <div id="pdf-loading-msg" class="hidden absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex flex-col items-center gap-4">
                <div class="w-10 h-10 border-4 border-slate-700 border-t-[#ec2029] rounded-full animate-spin"></div>
                <p class="text-white/70 text-sm font-medium tracking-wide">Rendering Document...</p>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    /* ═══════════════════════════════════════════════════════════════
       AOS
    ═══════════════════════════════════════════════════════════════ */
    if (typeof AOS !== 'undefined') {
        AOS.init({ duration: 800, once: true });
    }

    /* ═══════════════════════════════════════════════════════════════
       CARD TOGGLE (mobile) — tanpa Alpine
    ═══════════════════════════════════════════════════════════════ */
    document.querySelectorAll('[data-tariff-toggle]').forEach(header => {
        header.addEventListener('click', () => {
            const card = header.closest('.tariff-card');
            card.querySelector('[data-tariff-actions]')?.classList.toggle('hidden');
            card.querySelector('[data-tariff-chevron]')?.classList.toggle('rotate-180');
        });
    });

    /* ═══════════════════════════════════════════════════════════════
       NOTIFICATION TOAST
    ═══════════════════════════════════════════════════════════════ */
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

    /* ═══════════════════════════════════════════════════════════════
       PDF VIEWER
    ═══════════════════════════════════════════════════════════════ */
    if (window['pdfjsLib']) {
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
    }

    const modal         = document.getElementById('pdf-viewer-modal');
    const backdrop      = document.getElementById('pdf-modal-backdrop');
    const titleEl       = document.getElementById('pdf-modal-title');
    const pageInfoEl    = document.getElementById('pdf-page-info');
    const container     = document.getElementById('pdf-canvas-container');
    const pageWrap      = document.getElementById('pdf-page-wrap');
    const renderCanvas  = document.getElementById('pdf-render-canvas');
    const drawCanvas    = document.getElementById('pdf-draw-canvas');
    const zoomLevelEl   = document.getElementById('pdf-zoom-level');
    const loadingMsg    = document.getElementById('pdf-loading-msg');
    const errorMsg      = document.getElementById('pdf-error-msg');
    const downloadLink  = document.getElementById('pdf-download');

    const prevBtn       = document.getElementById('pdf-prev-page');
    const nextBtn       = document.getElementById('pdf-next-page');
    const zoomInBtn     = document.getElementById('pdf-zoom-in');
    const zoomOutBtn    = document.getElementById('pdf-zoom-out');
    const zoomResetBtn  = document.getElementById('pdf-zoom-reset');
    const panBtn        = document.getElementById('pdf-tool-pan');
    const penBtn        = document.getElementById('pdf-tool-pen');
    const eraserBtn     = document.getElementById('pdf-tool-eraser');
    const penColorInput = document.getElementById('pdf-pen-color');
    const undoBtn       = document.getElementById('pdf-undo');
    const clearBtn      = document.getElementById('pdf-clear');
    const closeBtn      = document.getElementById('pdf-modal-close');

    const BASE_SCALE = 1.25;
    const MIN_SCALE  = 0.5;
    const MAX_SCALE  = 3.5;

    let pdfDoc          = null;
    let currentPage     = 1;
    let currentScale    = BASE_SCALE;
    let currentTool     = 'pan';
    let strokesByPage   = {};
    let activeStroke    = null;
    let isPointerDown   = false;
    let renderToken     = 0;

    function setTool(tool) {
        currentTool = tool;
        [panBtn, penBtn, eraserBtn].forEach(b => b.classList.remove('active'));
        drawCanvas.classList.remove('tool-pan', 'tool-pen', 'tool-eraser');
        if (tool === 'pan')    { panBtn.classList.add('active');    drawCanvas.classList.add('tool-pan'); }
        if (tool === 'pen')    { penBtn.classList.add('active');    drawCanvas.classList.add('tool-pen'); }
        if (tool === 'eraser') { eraserBtn.classList.add('active'); drawCanvas.classList.add('tool-eraser'); }
    }

    function clampScale(s) {
        return Math.min(MAX_SCALE, Math.max(MIN_SCALE, s));
    }

    function updateZoomLabel() {
        zoomLevelEl.textContent = Math.round((currentScale / BASE_SCALE) * 100) + '%';
    }

    function updateNavButtons() {
        if (!pdfDoc) return;
        prevBtn.disabled = currentPage <= 1;
        nextBtn.disabled = currentPage >= pdfDoc.numPages;
        pageInfoEl.textContent = 'PAGE ' + currentPage + ' / ' + pdfDoc.numPages;
    }

    function normalizedPointFromEvent(e) {
        const rect = drawCanvas.getBoundingClientRect();
        const x = (e.clientX - rect.left) / rect.width;
        const y = (e.clientY - rect.top)  / rect.height;
        return { x: Math.min(1, Math.max(0, x)), y: Math.min(1, Math.max(0, y)) };
    }

    function redrawAnnotations() {
        const ctx = drawCanvas.getContext('2d');
        ctx.clearRect(0, 0, drawCanvas.width, drawCanvas.height);
        (strokesByPage[currentPage] || []).forEach(s => drawStroke(ctx, s));
    }

    function drawStroke(ctx, stroke) {
        if (!stroke.points || stroke.points.length < 1) return;
        ctx.save();
        ctx.globalCompositeOperation = stroke.erase ? 'destination-out' : 'source-over';
        ctx.strokeStyle = stroke.color;
        ctx.lineWidth   = stroke.width;
        ctx.lineCap     = 'round';
        ctx.lineJoin    = 'round';
        ctx.beginPath();
        stroke.points.forEach((p, i) => {
            const x = p.x * drawCanvas.width;
            const y = p.y * drawCanvas.height;
            if (i === 0) ctx.moveTo(x, y); else ctx.lineTo(x, y);
        });
        ctx.stroke();
        ctx.restore();
    }

    function renderPage(num) {
        if (!pdfDoc) return;
        const myToken = ++renderToken;
        pageWrap.style.opacity = '0.5';

        pdfDoc.getPage(num).then(page => {
            if (myToken !== renderToken) return;
            const viewport = page.getViewport({ scale: currentScale });
            renderCanvas.width  = viewport.width;
            renderCanvas.height = viewport.height;
            drawCanvas.width    = viewport.width;
            drawCanvas.height   = viewport.height;
            pageWrap.style.width  = viewport.width + 'px';
            pageWrap.style.height = viewport.height + 'px';

            const ctx = renderCanvas.getContext('2d');
            page.render({ canvasContext: ctx, viewport }).promise.then(() => {
                if (myToken !== renderToken) return;
                pageWrap.style.opacity = '1';
                loadingMsg.classList.add('hidden');
                redrawAnnotations();
                updateZoomLabel();
                updateNavButtons();
            });
        }).catch(() => {
            loadingMsg.classList.add('hidden');
            errorMsg.classList.remove('hidden');
        });
    }

    window.openPdfViewer = function (url, title) {
        if (!url || url === '#') {
            showNotification('This document is not yet available on the server.');
            return;
        }
        if (!window['pdfjsLib']) {
            window.open(url, '_blank');
            return;
        }
        currentPage   = 1;
        currentScale  = BASE_SCALE;
        strokesByPage = {};
        titleEl.textContent  = title || 'Document';
        downloadLink.href    = url;
        errorMsg.classList.add('hidden');
        loadingMsg.classList.remove('hidden');
        pageWrap.style.opacity = '0';

        modal.classList.remove('hidden');
        document.body.classList.add('pdf-modal-open');
        setTool('pan');

        pdfjsLib.getDocument(url).promise.then(doc => {
            pdfDoc = doc;
            renderPage(currentPage);
        }).catch(() => {
            loadingMsg.classList.add('hidden');
            errorMsg.classList.remove('hidden');
        });
    };

    function closePdfViewer() {
        modal.classList.add('hidden');
        document.body.classList.remove('pdf-modal-open');
        pdfDoc = null;
        renderToken++;
    }

    closeBtn.addEventListener('click', closePdfViewer);
    backdrop.addEventListener('click', closePdfViewer);
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) closePdfViewer();
    });

    prevBtn.addEventListener('click', () => {
        if (currentPage > 1) { currentPage--; renderPage(currentPage); }
    });
    nextBtn.addEventListener('click', () => {
        if (pdfDoc && currentPage < pdfDoc.numPages) { currentPage++; renderPage(currentPage); }
    });

    zoomInBtn.addEventListener('click', () => {
        currentScale = clampScale(currentScale + 0.25);
        renderPage(currentPage);
    });
    zoomOutBtn.addEventListener('click', () => {
        currentScale = clampScale(currentScale - 0.25);
        renderPage(currentPage);
    });
    zoomResetBtn.addEventListener('click', () => {
        currentScale = BASE_SCALE;
        renderPage(currentPage);
    });

    container.addEventListener('wheel', e => {
        if (!e.ctrlKey) return;
        e.preventDefault();
        currentScale = clampScale(currentScale + (e.deltaY < 0 ? 0.15 : -0.15));
        renderPage(currentPage);
    }, { passive: false });

    panBtn.addEventListener('click', () => setTool('pan'));
    penBtn.addEventListener('click', () => setTool('pen'));
    eraserBtn.addEventListener('click', () => setTool('eraser'));

    undoBtn.addEventListener('click', () => {
        const strokes = strokesByPage[currentPage] || [];
        strokes.pop();
        redrawAnnotations();
    });
    clearBtn.addEventListener('click', () => {
        strokesByPage[currentPage] = [];
        redrawAnnotations();
    });

    drawCanvas.addEventListener('pointerdown', e => {
        if (currentTool === 'pan') return;
        isPointerDown = true;
        drawCanvas.setPointerCapture(e.pointerId);
        activeStroke = {
            color:  currentTool === 'eraser' ? '#000000' : penColorInput.value,
            width:  currentTool === 'eraser' ? 22 : 3,
            erase:  currentTool === 'eraser',
            points: [normalizedPointFromEvent(e)],
        };
    });

    drawCanvas.addEventListener('pointermove', e => {
        if (!isPointerDown || !activeStroke) return;
        activeStroke.points.push(normalizedPointFromEvent(e));
        const ctx = drawCanvas.getContext('2d');
        redrawAnnotations();
        drawStroke(ctx, activeStroke);
    });

    function finishStroke() {
        if (activeStroke && activeStroke.points.length > 1) {
            strokesByPage[currentPage] = strokesByPage[currentPage] || [];
            strokesByPage[currentPage].push(activeStroke);
        }
        activeStroke  = null;
        isPointerDown = false;
        redrawAnnotations();
    }

    drawCanvas.addEventListener('pointerup', finishStroke);
    drawCanvas.addEventListener('pointerleave', function () {
        if (isPointerDown) finishStroke();
    });
});
</script>
@endpush