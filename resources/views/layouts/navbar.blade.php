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

    /* ─── Bottom tab bar (mobile) ─── */
    $bottomTabs = ['home', 'our-tariffs', 'operations', 'news'];
    $moreKeys   = ['about', 'services', 'sustainability', 'contact'];

    $isMoreActive = collect($moreKeys)->contains(fn ($k) => $isLinkActive($navLinks[$k]['url']));

    /* Icon (Heroicons outline, path "d") */
    $icons = [
        'home'           => 'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25',
        'our-tariffs'    => 'M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z M6 6h.008v.008H6V6z',
        'operations'     => 'M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12',
        'news'           => 'M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z',
        'more'           => 'M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z',
        'about'          => 'M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z',
        'services'       => 'M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z',
        'sustainability' => 'M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418',
        'contact'        => 'M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75',
    ];
@endphp

{{-- ═══════════════════════════════════════════════════════════════
     STYLES
══════════════════════════════════════════════════════════════ --}}
<style>
    :root { --tab-h: 64px; }

    /* "More" sheet (mobile) */
    #moreSheet {
        transition: opacity 0.25s ease, transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        transform-origin: bottom center;
    }
    #moreSheet.is-closed {
        opacity: 0;
        transform: scale(0.96) translateY(12px);
        pointer-events: none;
    }

    @media (prefers-reduced-motion: reduce) {
        #moreSheet { transition: none !important; }
    }

    /* Di mobile: beri ruang untuk tab bar bawah */
    @media (max-width: 1023px) {
        body {
            padding-bottom: calc(var(--tab-h) + 1.75rem + env(safe-area-inset-bottom, 0px));
        }
        /* Tombol Back to Top naik di atas tab bar */
        #backToTop {
            bottom: calc(var(--tab-h) + 2rem + env(safe-area-inset-bottom, 0px)) !important;
            margin-bottom: 0 !important;
        }
    }
</style>

{{-- ═══════════════════════════════════════════════════════════════
     DESKTOP NAVBAR (FLOATING) — SHRINK ON SCROLL
     (Disembunyikan sepenuhnya di tampilan Mobile)
══════════════════════════════════════════════════════════════ --}}
<header class="hidden lg:block fixed top-0 inset-x-0 z-50 px-4 pointer-events-none"
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
             class="relative flex items-center p-1 rounded-full bg-slate-100/90 border border-slate-200/60"
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
    </div>
</header>

{{-- ═══════════════════════════════════════════════════════════════
     MOBILE LOGO HEADER (STATIS)
     Hanya menampilkan Logo tanpa menu dan tombol Login.
══════════════════════════════════════════════════════════════ --}}
<div class="lg:hidden w-full bg-white border-b border-slate-200 px-4 py-3 flex items-center justify-center"
     style="padding-top: max(1rem, env(safe-area-inset-top));">
    <a href="{{ url('/') }}" class="inline-flex items-center gap-2" aria-label="PICT Home">
        <img src="{{ asset('assets/images/pict.png') }}"
             alt="PICT Logo"
             class="h-8 w-auto object-contain">
        <span class="text-slate-900 font-extrabold text-sm tracking-tight">
            Patimban International Car Terminal
        </span>
    </a>
</div>

{{-- ═══════════════════════════════════════════════════════════════
     MOBILE: "MORE" SHEET + BOTTOM TAB BAR
══════════════════════════════════════════════════════════════ --}}
<div id="moreSheet"
     class="lg:hidden fixed inset-x-0 z-50 px-4 is-closed pointer-events-auto"
     style="bottom: calc(max(0.75rem, env(safe-area-inset-bottom, 0px)) + var(--tab-h) + 0.5rem);">
    <div class="max-w-md mx-auto bg-white/95 backdrop-blur-2xl border border-slate-200 rounded-3xl p-3 shadow-2xl shadow-slate-900/15">
        <div class="grid grid-cols-2 gap-2">
            @foreach($moreKeys as $key)
                @php
                    $link = $navLinks[$key];
                    $isCurrent = $isLinkActive($link['url']);
                @endphp
                <a href="{{ url($link['url']) }}"
                   @if($key === 'contact') data-no-swup @endif
                   @if($isCurrent) aria-current="page" @endif
                   class="flex items-center gap-2.5 px-3 py-3 rounded-2xl text-xs font-semibold transition active:scale-95
                          {{ $isCurrent
                             ? 'bg-gradient-to-r from-red-600 to-rose-600 text-white shadow-md shadow-red-600/20'
                             : 'text-slate-700 bg-slate-50 hover:bg-slate-100' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons[$key] }}"/>
                    </svg>
                    <span>{{ $link['label'] }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>

<nav id="bottomTabBar"
     class="lg:hidden fixed bottom-0 inset-x-0 z-50 px-3 pointer-events-none"
     style="padding-bottom: max(0.75rem, env(safe-area-inset-bottom, 0px));"
     aria-label="Mobile navigation">
    <div class="pointer-events-auto max-w-md mx-auto grid grid-cols-5 gap-1 p-1.5 bg-white/90 backdrop-blur-xl border border-slate-200/90 rounded-3xl shadow-2xl shadow-slate-900/10"
         style="height: var(--tab-h);">

        @foreach($bottomTabs as $key)
            @php
                $link = $navLinks[$key];
                $isCurrent = $isLinkActive($link['url']);
            @endphp
            <a href="{{ url($link['url']) }}"
               @if($isCurrent) aria-current="page" @endif
               class="flex flex-col items-center justify-center gap-0.5 rounded-2xl select-none transition active:scale-90
                      {{ $isCurrent ? 'bg-red-50 text-red-600 font-bold' : 'text-slate-500 font-medium hover:text-slate-800' }}">
                <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" stroke-width="{{ $isCurrent ? '1.9' : '1.5' }}" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons[$key] }}"/>
                </svg>
                <span class="text-[10px] leading-none">{{ $link['label'] }}</span>
            </a>
        @endforeach

        {{-- Tombol More --}}
        <button id="moreBtn"
                type="button"
                aria-label="More menu"
                aria-expanded="false"
                aria-controls="moreSheet"
                class="flex flex-col items-center justify-center gap-0.5 rounded-2xl select-none transition active:scale-90 cursor-pointer
                       {{ $isMoreActive ? 'bg-red-50 text-red-600 font-bold' : 'text-slate-500 font-medium hover:text-slate-800' }}">
            <svg class="w-[22px] h-[22px] pointer-events-none" fill="none" stroke="currentColor" stroke-width="{{ $isMoreActive ? '1.9' : '1.5' }}" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons['more'] }}"/>
            </svg>
            <span class="text-[10px] leading-none pointer-events-none">More</span>
        </button>
    </div>
</nav>

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

    function closeMoreSheet() {
        document.getElementById('moreSheet')?.classList.add('is-closed');
        document.getElementById('moreBtn')?.setAttribute('aria-expanded', 'false');
    }

    /* ── Sliding Pill (desktop) ───────────────────────────────── */
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

    /* ── Shrink on Scroll (Desktop Only) ──────────────────────── */
    function setupShrinkOnScroll() {
        const wrapper   = document.getElementById('navbarWrapper');
        const brandLink = document.getElementById('brandLink');
        if (!wrapper || !brandLink || wrapper.dataset.shrinkBound === '1') return;
        wrapper.dataset.shrinkBound = '1';

        const SHRINK_AT       = 120; 
        const RESHRINK_DELTA  = 80; 
        let isShrunk     = false;
        let userExpanded = false;
        let expandedAtY  = 0;

        const getY = () => window.scrollY || document.documentElement.scrollTop;

        function applyShrink(shrunk) {
            if (isShrunk === shrunk) return;
            isShrunk = shrunk;
            wrapper.classList.toggle('is-shrunk', shrunk);

            if (shrunk) {
                wrapper.setAttribute('role', 'button');
                wrapper.setAttribute('tabindex', '0');
                wrapper.setAttribute('aria-label', 'Expand navigation');
            } else {
                wrapper.removeAttribute('role');
                wrapper.removeAttribute('tabindex');
                wrapper.removeAttribute('aria-label');
                setTimeout(() => {
                    if (typeof window.__pictNavMoveTo === 'function' && activeTab) {
                        window.__pictNavMoveTo(activeTab, true);
                    }
                }, 420);
            }
        }

        function onScroll() {
            // Jangan jalankan shrink jika di tampilan mobile
            if (window.innerWidth < 1024) return;

            const y = getY();

            if (y <= SHRINK_AT) {
                userExpanded = false;
                applyShrink(false);
                return;
            }

            if (userExpanded) {
                if (Math.abs(y - expandedAtY) > RESHRINK_DELTA) {
                    userExpanded = false;
                    applyShrink(true);
                }
            } else {
                applyShrink(true);
            }
        }

        function expand() {
            if (!isShrunk) return;
            userExpanded = true;
            expandedAtY  = getY();
            applyShrink(false);
        }

        wrapper.addEventListener('click', function (e) {
            if (!isShrunk) return;
            e.preventDefault();
            expand();
        });

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

        onScroll();
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

    /* ── "More" sheet toggle (mobile) ─────────────────────────── */
    document.addEventListener('click', (e) => {
        const sheet = document.getElementById('moreSheet');
        if (!sheet) return;

        const btn = e.target.closest('#moreBtn');

        if (btn) {
            e.preventDefault();
            const isClosed = sheet.classList.contains('is-closed');
            sheet.classList.toggle('is-closed', !isClosed);
            btn.setAttribute('aria-expanded', isClosed ? 'true' : 'false');
            return;
        }

        if (e.target.closest('#moreSheet a') || !sheet.contains(e.target)) {
            closeMoreSheet();
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
                closeMoreSheet();
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