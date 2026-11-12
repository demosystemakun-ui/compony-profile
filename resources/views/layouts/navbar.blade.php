@php
    $navLinks = [
        'home'           => ['label' => 'Home',           'url' => '/'],
        'about'          => ['label' => 'About Us',       'url' => '/about'],
        'our-tariffs'    => ['label' => 'Our Tariffs',    'url' => '/our-tariffs'],
        'operations'     => ['label' => 'Operations',     'url' => '/operations'],
        'services'       => ['label' => 'Our Services',   'url' => '/services'],
        'sustainability' => ['label' => 'Sustainability', 'url' => '/sustainability'],
        'news'           => ['label' => 'News',            'url' => '/news'],
        'contact'        => ['label' => 'Contact Us',     'url' => '/contact'],
    ];

    $currentPath = trim(request()->path(), '/');

    /* Helper: cek apakah link aktif */
    $isLinkActive = function (string $url) use ($currentPath): bool {
        $target = trim($url, '/');
        if ($target === '') return $currentPath === '';
        return request()->is($target . '*');
    };
@endphp

@push('styles')
<style>
    /* ═══ NAVBAR FONT ═══ */
    #mobileMenu, #mobileMenu *,
    header, header * {
        font-family: 'Century Gothic', 'CenturyGothic', 'Poppins', sans-serif !important;
    }

    /* ═══ MOBILE MENU TRANSITION ═══ */
    #mobileMenu {
        transition: opacity 0.25s ease, transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        transform-origin: top center;
    }
    #mobileMenu.is-closed {
        opacity: 0;
        transform: scaleY(0.95) translateY(-10px);
        pointer-events: none;
    }

    /* ═══ SLIDING PILL ═══ */
    #navSlider {
        transition: all 280ms cubic-bezier(0.25, 1, 0.5, 1);
        will-change: left, top, width, height;
    }

    /* ═══ NAV LINK BASE ═══ */
    .nav-tab {
        transition: color 0.2s ease;
    }

    /* ═══ SHRINK ON SCROLL (PENDEKATAN BARU: TRANSFORM & ABSOLUTE) ═══ */
    #navbarWrapper {
        transition: width 400ms cubic-bezier(0.4, 0, 0.2, 1), 
                    border-radius 400ms ease,
                    background-color 400ms ease,
                    box-shadow 400ms ease,
                    transform 400ms cubic-bezier(0.4, 0, 0.2, 1);
        width: 100%;
        /* Gunakan animasi transform, bukan width/height */
        transform-origin: top center;
    }

    #navbarWrapper.is-shrunk {
        /* Kunci lebar menjadi seukuran lingkaran logo saja */
        width: 48px !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        cursor: pointer;
        border-radius: 50% !important; /* Jadi bulat sempurna */
        background-color: rgba(255, 255, 255, 0.95);
        box-shadow: 0 10px 34px rgba(15, 23, 42, 0.15);
    }

    /* Sembunyikan nav & actions & teks dengan menyusutkannya */
    #navContainer,
    #rightActions,
    #brandText {
        transition: opacity 200ms ease, transform 200ms ease, width 200ms ease;
        transform-origin: top center;
    }

    #navbarWrapper.is-shrunk #navContainer,
    #navbarWrapper.is-shrunk #rightActions,
    #navbarWrapper.is-shrunk #brandText {
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        width: 0 !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow: hidden;
        transform: scaleY(0);
    }

    /* Logo di tengah */
    #brandLogo {
        transition: transform 300ms cubic-bezier(0.4, 0, 0.2, 1);
    }

    #navbarWrapper.is-shrunk #brandLogo {
        transform: scale(0.9);
    }

    /* Mobile menu ikut tertutup saat shrunk */
    #navbarWrapper.is-shrunk ~ #mobileMenu {
        opacity: 0;
        pointer-events: none;
    }

    @media (prefers-reduced-motion: reduce) {
        #mobileMenu,
        #navSlider,
        .nav-tab,
        #navbarWrapper,
        #navContainer,
        #rightActions,
        #brandText,
        #brandLogo {
            transition: none !important;
        }
    }
</style>
@endpush

{{-- ═══════════════════════════════════════════════════════════════
     FLOATING COMPACT NAVBAR (LIGHT THEME) — SHRINK ON SCROLL
══════════════════════════════════════════════════════════════ --}}
<header class="fixed top-0 inset-x-0 z-50 px-4 pointer-events-none"
        style="padding-top: max(0.75rem, env(safe-area-inset-top));">

    <div id="navbarWrapper"
         class="max-w-6xl mx-auto flex items-center justify-between pointer-events-auto bg-white/90 backdrop-blur-xl border border-slate-200/90 rounded-full px-4 sm:px-5 py-2 shadow-xl shadow-slate-900/5 gap-4 relative z-50">

        {{-- ═══ BRAND ═══ --}}
        <a href="{{ url('/') }}"
           id="brandLink"
           class="flex items-center gap-2.5 shrink-0 group h-9"
           aria-label="PICT Home">
            <img src="{{ asset('assets/images/pict.png') }}"
                 id="brandLogo"
                 alt="PICT Logo"
                 class="relative z-10 h-7 sm:h-8 w-auto object-contain transition-transform duration-300 group-hover:scale-105 shrink-0">
            <span id="brandText" class="leading-tight hidden sm:block whitespace-nowrap">
                <span class="text-slate-900 font-extrabold text-[13px] tracking-tight block">
                    Patimban International Car Terminal
                </span>
            </span>
        </a>

        {{-- ═══ DESKTOP NAV ═══ --}}
        <nav id="navContainer"
             class="relative hidden lg:flex items-center p-1 rounded-full bg-slate-100/90 border border-slate-200/60"
             aria-label="Primary navigation">
            <span id="navSlider" aria-hidden="true"
                  class="absolute rounded-full bg-gradient-to-r from-red-600 to-rose-600 shadow-md shadow-red-600/30 pointer-events-none opacity-0 z-0"></span>
            <div class="relative flex items-center z-10">
                @foreach($navLinks as $key => $link)
                    @php $isCurrent = $isLinkActive($link['url']); @endphp
                    <a href="{{ url($link['url']) }}"
                       data-nav-key="{{ $key }}"
                       @if($key === 'contact') data-no-swup @endif
                       @if($isCurrent) aria-current="page" @endif
                       class="nav-tab relative inline-flex items-center justify-center px-3.5 py-1.5 rounded-full text-xs font-medium transition-colors duration-200 select-none whitespace-nowrap
                              {{ $isCurrent ? 'active-tab text-white font-bold' : 'text-slate-600 hover:text-slate-900' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>
        </nav>

        {{-- ═══ RIGHT ACTIONS ═══ --}}
        <div id="rightActions" class="flex items-center gap-2 shrink-0 h-9">

            {{-- Mobile Menu Toggle --}}
            <button id="mobileMenuBtn"
                    type="button"
                    aria-label="Toggle navigation menu"
                    aria-expanded="false"
                    aria-controls="mobileMenu"
                    class="relative z-50 flex lg:hidden w-9 h-9 rounded-full items-center justify-center text-slate-700 hover:text-slate-900 bg-slate-100 border border-slate-200 active:scale-90 transition shrink-0 cursor-pointer">
                <svg class="w-4 h-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- ═══ MOBILE MENU ═══ --}}
    <div id="mobileMenu"
         class="lg:hidden mt-3 pointer-events-auto max-w-xs mx-auto is-closed relative z-50">
        <div class="bg-white/95 backdrop-blur-2xl border border-slate-200 rounded-3xl p-4 shadow-2xl shadow-slate-900/10 space-y-2">

            {{-- PICTOS Login (Mobile) --}}
            <a href="https://patimbancarterminal.com/login"
               target="_blank"
               rel="noopener noreferrer"
               class="flex items-center justify-between px-4 py-3 rounded-2xl text-xs font-bold bg-[#0A2540] text-white shadow-sm mb-2">
                <span class="flex items-center gap-2">
                    <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    PICTOS Login
                </span>
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

            {{-- Nav Links --}}
            <div class="border-t border-slate-100 pt-2 space-y-1">
                @foreach($navLinks as $key => $link)
                    @php $isCurrent = $isLinkActive($link['url']); @endphp
                    <a href="{{ url($link['url']) }}"
                       @if($key === 'contact') data-no-swup @endif
                       @if($isCurrent) aria-current="page" @endif
                       class="flex items-center justify-between px-4 py-2.5 rounded-2xl text-xs font-medium transition active:scale-95
                              {{ $isCurrent
                                 ? 'bg-gradient-to-r from-red-600 to-rose-600 text-white font-bold shadow-md shadow-red-600/20'
                                 : 'text-slate-700 bg-slate-50 hover:bg-slate-100' }}">
                        <span>{{ $link['label'] }}</span>
                        @if($isCurrent)
                            <span class="w-1.5 h-1.5 rounded-full bg-white inline-block" aria-hidden="true"></span>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</header>

{{-- ═══════════════════════════════════════════════════════════════
     NAVBAR BEHAVIOR SCRIPT
══════════════════════════════════════════════════════════════ --}}
@push('scripts')
<script>
(function () {
    'use strict';

    if (window.__pictNavLoaded) {
        if (typeof window.__pictNavInit === 'function') window.__pictNavInit();
        return;
    }
    window.__pictNavLoaded = true;

    let activeTab = null;

    function closeMobileMenu() {
        document.getElementById('mobileMenu')?.classList.add('is-closed');
        document.getElementById('mobileMenuBtn')?.setAttribute('aria-expanded', 'false');
    }

    /* ── Sliding Pill ─────────────────────────────────────────── */
    function setupSlidingPill() {
        const container = document.getElementById('navContainer');
        const slider    = document.getElementById('navSlider');
        if (!container || !slider) return;

        const tabs = Array.from(container.querySelectorAll('.nav-tab'));
        if (tabs.length === 0) return;

        const currentPath = window.location.pathname.replace(/\/$/, '') || '/';
        activeTab = null;

        tabs.forEach(tab => {
            const tabPath = new URL(tab.href, window.location.origin).pathname.replace(/\/$/, '') || '/';
            if (tabPath === currentPath) {
                activeTab = tab;
            } else if (!activeTab && tabPath !== '/' && currentPath.startsWith(tabPath)) {
                activeTab = tab;
            }
        });

        if (!activeTab) activeTab = tabs[0];

        function applyTabStyles(target) {
            tabs.forEach(tab => {
                const isActive = tab === target;
                tab.classList.toggle('text-white',     isActive);
                tab.classList.toggle('font-bold',      isActive);
                tab.classList.toggle('text-slate-600', !isActive);
            });
        }

        function moveTo(target, instant = false) {
            if (!target) {
                slider.style.opacity = '0';
                applyTabStyles(activeTab);
                return;
            }

            const cRect = container.getBoundingClientRect();
            const tRect = target.getBoundingClientRect();

            slider.style.transition = instant ? 'none' : '';
            slider.style.left    = (tRect.left - cRect.left) + 'px';
            slider.style.top     = (tRect.top  - cRect.top)  + 'px';
            slider.style.width   = tRect.width  + 'px';
            slider.style.height  = tRect.height + 'px';
            slider.style.opacity = '1';

            applyTabStyles(target);
        }

        window.__pictNavMoveTo = moveTo;

        moveTo(activeTab, true);

        tabs.forEach(tab => {
            if (tab.dataset.bound === '1') return;
            tab.dataset.bound = '1';

            tab.addEventListener('click', function () {
                activeTab = this;
                moveTo(this);
            });

            tab.addEventListener('mouseenter', function () {
                moveTo(this);
            });
        });

        if (container.dataset.bound !== '1') {
            container.dataset.bound = '1';
            container.addEventListener('mouseleave', () => moveTo(activeTab));
        }
    }

    /* ── Shrink on Scroll ─────────────────────────────────────── */
    function setupShrinkOnScroll() {
        const wrapper   = document.getElementById('navbarWrapper');
        const brandLink = document.getElementById('brandLink');
        if (!wrapper || wrapper.dataset.shrinkBound === '1') return;
        wrapper.dataset.shrinkBound = '1';

        const SCROLL_THRESHOLD = 120;
        let isShrunk    = false;
        let userExpanded = false;

        function applyShrink(shrunk) {
            if (isShrunk === shrunk) return;
            isShrunk = shrunk;
            wrapper.classList.toggle('is-shrunk', shrunk);

            if (shrunk) {
                closeMobileMenu();
                wrapper.setAttribute('role', 'button');
                wrapper.setAttribute('tabindex', '0');
                wrapper.setAttribute('aria-label', 'Expand navigation');
            } else {
                wrapper.removeAttribute('role');
                wrapper.removeAttribute('tabindex');
                wrapper.removeAttribute('aria-label');
            }
        }

        function onScroll() {
            const y = window.scrollY || document.documentElement.scrollTop;
            if (y > SCROLL_THRESHOLD) {
                if (!userExpanded) applyShrink(true);
            } else {
                userExpanded = false;
                applyShrink(false);
            }
        }

        function expand() {
            if (!isShrunk) return;
            userExpanded = true;
            applyShrink(false);
        }

        // Klik logo saat shrunk → expand
        if (brandLink.dataset.shrinkBound !== '1') {
            brandLink.dataset.shrinkBound = '1';
            brandLink.addEventListener('click', function (e) {
                if (isShrunk) {
                    e.preventDefault();
                    expand();
                }
            });
        }

        // Klik area wrapper saat shrunk → expand
        wrapper.addEventListener('click', function (e) {
            if (isShrunk && !e.target.closest('#brandLink')) {
                expand();
            }
        });

        // Keyboard accessibility
        wrapper.addEventListener('keydown', function (e) {
            if (isShrunk && (e.key === 'Enter' || e.key === ' ')) {
                e.preventDefault();
                expand();
            }
        });

        if (!window.__pictNavScrollBound) {
            window.__pictNavScrollBound = true;
            window.addEventListener('scroll', () => {
                if (typeof window.__pictNavOnScroll === 'function') window.__pictNavOnScroll();
            }, { passive: true });
        }
        window.__pictNavOnScroll = onScroll;

        onScroll(); // initial
    }

    /* ── Resize handler ───────────────────────────────────────── */
    let resizeTimer = null;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            if (typeof window.__pictNavMoveTo === 'function' && activeTab) {
                window.__pictNavMoveTo(activeTab, true);
            }
        }, 100);
    });

    /* ── Mobile menu toggle ───────────────────────────────────── */
    document.addEventListener('click', (e) => {
        const menu = document.getElementById('mobileMenu');
        if (!menu) return;

        const btn = e.target.closest('#mobileMenuBtn');

        if (btn) {
            e.preventDefault();
            const isClosed = menu.classList.contains('is-closed');
            if (isClosed) {
                menu.classList.remove('is-closed');
                btn.setAttribute('aria-expanded', 'true');
            } else {
                menu.classList.add('is-closed');
                btn.setAttribute('aria-expanded', 'false');
            }
            return;
        }

        if (e.target.closest('#mobileMenu a') || !menu.contains(e.target)) {
            closeMobileMenu();
        }
    });

    /* ── Init ─────────────────────────────────────────────────── */
    function initNavbar() {
        setupSlidingPill();
        setupShrinkOnScroll();
    }
    window.__pictNavInit = initNavbar;

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initNavbar);
    } else {
        initNavbar();
    }

    /* ── Swup binding ─────────────────────────────────────────── */
    function bindSwup() {
        if (window.__pictSwupBound) return true;
        if (window.swup && typeof window.swup.hooks?.on === 'function') {
            window.__pictSwupBound = true;
            window.swup.hooks.on('page:view', () => {
                closeMobileMenu();
                setTimeout(initNavbar, 50);
            });
            return true;
        }
        return false;
    }

    if (!bindSwup()) {
        let attempts = 0;
        const swupCheck = setInterval(() => {
            attempts++;
            if (bindSwup() || attempts > 20) clearInterval(swupCheck);
        }, 250);
    }
})();
</script>
@endpush