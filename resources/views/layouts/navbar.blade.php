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

    $adminLinks = [
        'dashboard' => ['label' => 'Dashboard', 'url' => '/pict-internal-admin-portal'],
        'tariffs'   => ['label' => 'Tariffs',   'url' => '/pict-internal-admin-portal/tariffs'],
        'news'      => ['label' => 'News',      'url' => '/pict-internal-admin-portal/news/create'],
        'profile'   => ['label' => 'Profile',   'url' => '/pict-internal-admin-portal/profile'],
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

    @media (prefers-reduced-motion: reduce) {
        #mobileMenu,
        #navSlider,
        .nav-tab {
            transition: none !important;
        }
    }
</style>
@endpush

{{-- ═══════════════════════════════════════════════════════════════
     FLOATING COMPACT NAVBAR (LIGHT THEME)
══════════════════════════════════════════════════════════════ --}}
<header class="fixed top-0 inset-x-0 z-50 px-4 pointer-events-none"
        style="padding-top: max(0.75rem, env(safe-area-inset-top));">

    <div class="max-w-6xl mx-auto flex items-center justify-between pointer-events-auto bg-white/90 backdrop-blur-xl border border-slate-200/90 rounded-full px-4 sm:px-5 py-2 shadow-xl shadow-slate-900/5 gap-4 relative z-50">

        {{-- ═══ BRAND ═══ --}}
        <a href="{{ url('/') }}" class="flex items-center gap-2.5 shrink-0 group" aria-label="PICT Home">
            <img src="{{ asset('assets/images/pict.png') }}"
                 alt="PICT Logo"
                 class="relative z-10 h-7 sm:h-8 w-auto object-contain transition-transform duration-300 group-hover:scale-105 shrink-0">
            <span class="leading-tight hidden sm:block">
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
                       @if($isCurrent) aria-current="page" @endif
                       class="nav-tab relative inline-flex items-center justify-center px-3.5 py-1.5 rounded-full text-xs font-medium transition-colors duration-200 select-none whitespace-nowrap
                              {{ $isCurrent ? 'active-tab text-white font-bold' : 'text-slate-600 hover:text-slate-900' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>
        </nav>

        {{-- ═══ RIGHT ACTIONS ═══ --}}
        <div class="flex items-center gap-2 shrink-0">

            {{-- ADMIN MENU (HANYA MUNCUL JIKA LOGIN) --}}
            @auth
                <div class="hidden lg:flex items-center gap-1 mr-2">
                    @foreach($adminLinks as $key => $link)
                        @php $isCurrent = $isLinkActive($link['url']); @endphp
                        <a href="{{ url($link['url']) }}"
                           class="px-3 py-1.5 rounded-full text-xs font-medium transition-colors duration-200
                                  {{ $isCurrent
                                     ? 'bg-red-600 text-white font-bold shadow-sm'
                                     : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                            {{ $link['label'] }}
                        </a>
                    @endforeach

                    {{-- Logout --}}
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                                class="px-3 py-1.5 rounded-full text-xs font-medium text-red-600 hover:bg-red-50 transition-colors duration-200">
                            Logout
                        </button>
                    </form>
                </div>
            @endauth

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

            {{-- ADMIN MENU (MOBILE) --}}
            @auth
                <div class="border-b border-slate-100 pb-2 mb-2 space-y-1">
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider px-4 mb-2">Admin Panel</div>
                    @foreach($adminLinks as $key => $link)
                        @php $isCurrent = $isLinkActive($link['url']); @endphp
                        <a href="{{ url($link['url']) }}"
                           class="flex items-center justify-between px-4 py-2.5 rounded-2xl text-xs font-medium transition active:scale-95
                                  {{ $isCurrent
                                     ? 'bg-gradient-to-r from-red-600 to-rose-600 text-white font-bold shadow-md shadow-red-600/20'
                                     : 'text-slate-700 bg-slate-50 hover:bg-slate-100' }}">
                            <span>{{ $link['label'] }}</span>
                        </a>
                    @endforeach

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full text-left flex items-center justify-between px-4 py-2.5 rounded-2xl text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 transition active:scale-95">
                            Logout
                        </button>
                    </form>
                </div>
            @endauth

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
                @foreach($navLinks as $link)
                    @php $isCurrent = $isLinkActive($link['url']); @endphp
                    <a href="{{ url($link['url']) }}"
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

    /* ═══════════════════════════════════════════════════════════════
       GUARD: kalau script ini dieksekusi ulang (mis. oleh Swup),
       jangan pasang listener lagi. Cukup init ulang pill-nya.
    ═══════════════════════════════════════════════════════════════ */
    if (window.__pictNavLoaded) {
        if (typeof window.__pictNavInit === 'function') window.__pictNavInit();
        return;
    }
    window.__pictNavLoaded = true;

    let activeTab = null;

    /* ═══════════════════════════════════════════════════════════════
       HELPER
    ═══════════════════════════════════════════════════════════════ */
    function closeMobileMenu() {
        document.getElementById('mobileMenu')?.classList.add('is-closed');
        document.getElementById('mobileMenuBtn')?.setAttribute('aria-expanded', 'false');
    }

    /* ═══════════════════════════════════════════════════════════════
       SLIDING PILL (DESKTOP NAV)
    ═══════════════════════════════════════════════════════════════ */
    function setupSlidingPill() {
        const container = document.getElementById('navContainer');
        const slider    = document.getElementById('navSlider');
        if (!container || !slider) return;

        const tabs = Array.from(container.querySelectorAll('.nav-tab'));
        if (tabs.length === 0) return;

        const currentPath = window.location.pathname.replace(/\/$/, '') || '/';
        activeTab = null;

        /* Cari tab yang cocok dengan current path */
        tabs.forEach(tab => {
            const tabPath = new URL(tab.href, window.location.origin).pathname.replace(/\/$/, '') || '/';
            if (tabPath === currentPath) {
                activeTab = tab;
            } else if (!activeTab && tabPath !== '/' && currentPath.startsWith(tabPath)) {
                activeTab = tab;
            }
        });

        if (!activeTab) activeTab = tabs[0];

        /* Update style semua tab */
        function applyTabStyles(target) {
            tabs.forEach(tab => {
                const isActive = tab === target;
                tab.classList.toggle('text-white',     isActive);
                tab.classList.toggle('font-bold',      isActive);
                tab.classList.toggle('text-slate-600', !isActive);
            });
        }

        /* Pindahkan slider ke tab target */
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

        /* Simpan supaya bisa dipanggil dari resize handler */
        window.__pictNavMoveTo = moveTo;

        /* Inisialisasi posisi */
        moveTo(activeTab, true);

        /* Pasang listener hanya sekali per elemen */
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

    /* ═══════════════════════════════════════════════════════════════
       RESIZE (dipasang sekali)
    ═══════════════════════════════════════════════════════════════ */
    let resizeTimer = null;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            if (typeof window.__pictNavMoveTo === 'function' && activeTab) {
                window.__pictNavMoveTo(activeTab, true);
            }
        }, 100);
    });

    /* ═══════════════════════════════════════════════════════════════
       MOBILE MENU — Event Delegation (dipasang sekali)
    ═══════════════════════════════════════════════════════════════ */
    document.addEventListener('click', (e) => {
        const menu = document.getElementById('mobileMenu');
        if (!menu) return;

        const btn = e.target.closest('#mobileMenuBtn');

        /* Tombol hamburger */
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

        /* Klik link di dalam menu, atau klik di luar menu → tutup */
        if (e.target.closest('#mobileMenu a') || !menu.contains(e.target)) {
            closeMobileMenu();
        }
    });

    /* ═══════════════════════════════════════════════════════════════
       INITIALIZE
    ═══════════════════════════════════════════════════════════════ */
    function initNavbar() {
        setupSlidingPill();
    }
    window.__pictNavInit = initNavbar;

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initNavbar);
    } else {
        initNavbar();
    }

    /* ═══════════════════════════════════════════════════════════════
       SWUP INTEGRATION (hook didaftarkan sekali)
    ═══════════════════════════════════════════════════════════════ */
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
        /* Kalau Swup di-inisialisasi setelah file ini, cek berkala sebentar */
        let attempts = 0;
        const swupCheck = setInterval(() => {
            attempts++;
            if (bindSwup() || attempts > 20) clearInterval(swupCheck);
        }, 250);
    }
})();
</script>
@endpush