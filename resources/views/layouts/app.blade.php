<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">

    {{-- ═══ NATIVE APP-LIKE EXPERIENCE ═══ --}}
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="PICT">
    <meta name="theme-color" content="#ffffff">

    {{-- ═══ SEO ═══ --}}
    <title>@yield('title', 'PT Patimban International Car Terminal — PICT')</title>
    <meta name="description" content="@yield('meta_description', 'PT Patimban International Car Terminal (PICT) — Indonesia\'s premier automotive gateway and modern roll-on/roll-off (Ro-Ro) terminal at Patimban Port, West Java.')">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- ═══ ICONS ═══ --}}
    <link rel="icon" type="image/png" href="{{ asset('assets/images/pict.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/pict.png') }}">

    {{-- ═══ FONTS ═══ --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- ═══ TAILWIND ═══
         CATATAN: CDN ini lambat (kompilasi di browser). Idealnya diganti
         dengan CSS hasil build (lihat panduan). Sementara dipertahankan. --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- ═══ STYLESHEETS ═══ --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanilla-cookieconsent@3.0.1/dist/cookieconsent.css">

    <style>
        /* ═══ GLOBAL FONT: CENTURY GOTHIC ═══ */
        body,
        body *,
        h1, h2, h3, h4, h5, h6,
        p, span, a, button {
            font-family: 'Century Gothic', 'CenturyGothic', 'Poppins', sans-serif !important;
        }

        .tap-highlight-transparent { -webkit-tap-highlight-color: transparent; }

        /* ═══ GOLD/BROWN ACCENTS ═══ */
        .text-gold   { color: #b45309; }
        .bg-gold     { background-color: #d97706; }
        .border-gold { border-color: #d97706; }

        /* ═══ FOOTER COMPACT OVERRIDES ═══ */
        footer { margin-top: auto; }
        footer .py-12 { padding-top: 2.5rem !important; padding-bottom: 2rem !important; }
        footer .py-10 { padding-top: 2rem !important;   padding-bottom: 1.5rem !important; }
        footer .py-8  { padding-top: 1.5rem !important; padding-bottom: 1.25rem !important; }

        footer .gap-8,
        footer .gap-10,
        footer .gap-12 { gap: 1.5rem !important; }

        footer .space-y-6 > :not([hidden]) ~ :not([hidden]) { margin-top: .75rem !important; }
        footer .space-y-4 > :not([hidden]) ~ :not([hidden]) { margin-top: .5rem !important; }

        footer h2,
        footer h3,
        footer h4 { margin-bottom: .75rem !important; line-height: 1.3 !important; }

        footer .border-t { margin-top: 1.5rem !important; padding-top: 1rem !important; }

        @media (max-width: 640px) {
            footer .py-12,
            footer .py-10 {
                padding-top: 2rem !important;
                padding-bottom: 1.5rem !important;
            }
            footer .grid { row-gap: 1.25rem !important; }
        }

        /* ═══ NAVBAR (dipindah dari navbar.blade.php) ═══ */
        #mobileMenu, #mobileMenu *,
        header, header * {
            font-family: 'Century Gothic', 'CenturyGothic', 'Poppins', sans-serif !important;
        }
        #mobileMenu {
            transition: opacity 0.25s ease, transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            transform-origin: top center;
        }
        #mobileMenu.is-closed {
            opacity: 0;
            transform: scaleY(0.95) translateY(-10px);
            pointer-events: none;
        }
        #navSlider {
            transition: all 280ms cubic-bezier(0.25, 1, 0.5, 1);
            will-change: left, top, width, height;
        }
        .nav-tab { transition: color 0.2s ease; }
        header { transition: transform 0.3s ease; }
        @media (prefers-reduced-motion: reduce) {
            #mobileMenu, #navSlider, .nav-tab, header { transition: none !important; }
        }

        /* ═══ PAGE TRANSITIONS (Swup) ═══ */
        .transition-slide {
            transition: transform 0.35s cubic-bezier(0.25, 1, 0.5, 1),
                        opacity 0.3s ease;
            will-change: transform, opacity;
        }
        html.is-animating .transition-slide {
            opacity: 0;
            transform: translateX(-35px);
        }
        html.is-rendering .transition-slide {
            opacity: 0;
            transform: translateX(35px);
        }
        @media (prefers-reduced-motion: reduce) {
            .transition-slide,
            html.is-animating .transition-slide,
            html.is-rendering .transition-slide {
                transition: none;
                transform: none;
                opacity: 1;
            }
        }
    </style>

    @stack('styles')
</head>

<body class="bg-slate-50 text-slate-800 flex flex-col min-h-screen antialiased tap-highlight-transparent">

    {{-- ═══ SKIP TO CONTENT (a11y) ═══ --}}
    <a href="#swup"
       class="sr-only focus:not-sr-only focus:fixed focus:top-2 focus:left-2 focus:z-[100] focus:bg-white focus:text-red-700 focus:px-4 focus:py-2 focus:rounded-lg focus:shadow-lg">
        Skip to main content
    </a>

    {{-- ═══ NAVBAR (menu mobile & pill dikelola oleh navbar.blade.php) ═══ --}}
    @include('layouts.navbar')

    {{-- ═══ MAIN CONTENT ═══ --}}
    <main id="swup" class="transition-slide flex-grow w-full overflow-hidden pt-0" role="main">
        @yield('content')
    </main>

    {{-- ═══ BACK TO TOP ═══ --}}
    <button id="backToTop"
            type="button"
            aria-label="Back to top"
            class="fixed bottom-6 right-4 md:bottom-6 md:right-6 w-11 h-11 md:w-12 md:h-12 rounded-full bg-red-900 text-amber-400 border border-amber-500/30 shadow-xl hover:bg-red-800 transition duration-300 hidden z-50 items-center justify-center focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-900 active:scale-90"
            style="margin-bottom: env(safe-area-inset-bottom);">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </button>

    {{-- ═══ FOOTER ═══ --}}
    @include('layouts.footer')

    {{-- ═══════════════════════════════════════════════════════════════
         GLOBAL SCRIPTS
    ═══════════════════════════════════════════════════════════════ --}}
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

    {{-- Swup + plugin (urutan penting: core dulu, baru plugin) --}}
    <script src="https://unpkg.com/swup@4"></script>
    <script src="https://unpkg.com/@swup/head-plugin@2"></script>
    <script src="https://unpkg.com/@swup/scripts-plugin@2"></script>

    <script>
    (function () {
        'use strict';

        /* ═══════════════════════════════════════════════════════════════
           AOS (global — dipakai semua halaman)
        ═══════════════════════════════════════════════════════════════ */
        function initAOS() {
            if (typeof AOS === 'undefined') return;
            AOS.init({
                duration: 900,
                easing: 'ease-out-cubic',
                once: true,
                offset: 120
            });
            AOS.refreshHard();
        }

        /* ═══════════════════════════════════════════════════════════════
           NAVBAR HIDE/SHOW ON SCROLL (target: <header>)
        ═══════════════════════════════════════════════════════════════ */
        function initNavbarScroll() {
            const header = document.querySelector('header');
            if (!header) return;

            let lastScrollTop = window.pageYOffset || 0;

            /* Hapus listener lama supaya tidak menumpuk */
            if (window._navbarScrollHandler) {
                window.removeEventListener('scroll', window._navbarScrollHandler);
            }

            window._navbarScrollHandler = function () {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                const menu = document.getElementById('mobileMenu');
                const menuOpen = menu && !menu.classList.contains('is-closed');

                if (scrollTop > lastScrollTop && scrollTop > 100 && !menuOpen) {
                    header.style.transform = 'translateY(-130%)';   /* scroll turun → sembunyi */
                } else if (scrollTop < lastScrollTop || scrollTop <= 100) {
                    header.style.transform = 'translateY(0)';       /* scroll naik → tampil */
                }
                lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
            };

            window.addEventListener('scroll', window._navbarScrollHandler, { passive: true });
        }

        /* ═══════════════════════════════════════════════════════════════
           BACK TO TOP (listener dipasang sekali)
        ═══════════════════════════════════════════════════════════════ */
        const backToTop = document.getElementById('backToTop');

        function updateBackToTop() {
            if (!backToTop) return;
            const show = window.scrollY > 300;
            backToTop.classList.toggle('hidden', !show);
            backToTop.classList.toggle('flex', show);
        }

        window.addEventListener('scroll', updateBackToTop, { passive: true });
        backToTop?.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
        updateBackToTop();

        /* ═══════════════════════════════════════════════════════════════
           SWUP PAGE TRANSITIONS
        ═══════════════════════════════════════════════════════════════ */
        if (typeof Swup !== 'undefined' && !window.swup) {
            const plugins = [];
            if (typeof SwupHeadPlugin    !== 'undefined') plugins.push(new SwupHeadPlugin());
            if (typeof SwupScriptsPlugin !== 'undefined') plugins.push(new SwupScriptsPlugin({ head: true, body: true }));

            window.swup = new Swup({
                /* #page-scripts = tempat @stack('scripts'), supaya script halaman jalan ulang */
                containers: ['#swup', '#page-scripts'],
                plugins: plugins,

                /* Halaman yang dibuka dengan load penuh (tanpa Swup) */
                ignoreVisit: (url, { el } = {}) => {
                    if (el?.closest('[data-no-swup]')) return true;
                    if (el?.target === '_blank') return true;
                    return /^\/(contact|pict-internal-admin-portal|tarif\/|media\/|api\/)/.test(url)
                        || /\.(pdf|zip|docx?|xlsx?)(\?|$)/i.test(url);
                }
            });

            window.swup.hooks.on('page:view', () => {
                window.scrollTo({ top: 0, behavior: 'instant' });
                updateBackToTop();
                initAOS();
                initNavbarScroll();
            });
        }

        /* Load pertama */
        initAOS();
        initNavbarScroll();
    })();
    </script>

    {{-- Script per-halaman (ikut diganti oleh Swup lewat #page-scripts) --}}
    <div id="page-scripts">
        @stack('scripts')
    </div>

    {{-- ═══ AI CHATBOT WIDGET ═══ --}}
    @include('layouts.ai-chat')

    {{-- ═══ COOKIE CONSENT ═══ --}}
    @include('layouts.cookie-banner')

    <script src="https://cdn.jsdelivr.net/npm/vanilla-cookieconsent@3.0.1/dist/cookieconsent.umd.js"></script>
    <script src="{{ asset('assets/js/cookie-consent.js') }}"></script>
</body>
</html>