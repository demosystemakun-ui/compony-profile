@php
    $navLinks = [
        'about'          => ['label' => 'About',           'url' => '/about'],
        'operations'     => ['label' => 'Operations',       'url' => '/operations'],
        'services'       => ['label' => 'Services',        'url' => '/services'],
        'our-tariffs'    => ['label' => 'Tariffs',         'url' => '/our-tariffs'],
        'sustainability' => ['label' => 'Sustainability',  'url' => '/sustainability'],
        'news'           => ['label' => 'News',            'url' => '/news'],
        'contact'        => ['label' => 'Contact',         'url' => '/contact'],
    ];

    $isLinkActive = function (string $url): bool {
        $target = trim($url, '/');
        return $target === ''
            ? request()->path() === '/'
            : request()->is($target . '*');
    };
@endphp

<header class="site-header">
    <div class="shell site-header__inner">
        <a href="{{ url('/') }}" class="brand" aria-label="PICT home">
            <img src="{{ asset('assets/images/pict.png') }}" alt="" width="96" height="28" decoding="async">
            <span class="brand__name">
                Patimban International Car Terminal
                <span>Vehicle terminal, Subang</span>
            </span>
        </a>

        <nav class="site-nav" aria-label="Primary">
            @foreach ($navLinks as $link)
                <a href="{{ url($link['url']) }}"
                   @if ($isLinkActive($link['url'])) aria-current="page" @endif>
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="site-header__actions">
            <a class="header-link" href="https://patimbancarterminal.com/login" target="_blank" rel="noopener noreferrer">
                PICTOS
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M8 7h9v9"/>
                </svg>
            </a>

            <button id="mobileMenuBtn"
                    class="menu-toggle"
                    type="button"
                    aria-label="Open navigation menu"
                    aria-expanded="false"
                    aria-controls="mobileMenu">
                <span class="menu-toggle__bars" aria-hidden="true"></span>
            </button>
        </div>
    </div>

    <div id="mobileMenu" class="mobile-menu">
        <ul class="mobile-menu__list">
            <li>
                <a href="{{ url('/') }}" @if (request()->path() === '/') aria-current="page" @endif>
                    <span class="mobile-menu__num">01</span> Home
                </a>
            </li>
            @foreach ($navLinks as $key => $link)
                <li>
                    <a href="{{ url($link['url']) }}"
                       @if ($isLinkActive($link['url'])) aria-current="page" @endif>
                        <span class="mobile-menu__num">{{ str_pad($loop->iteration + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        {{ $link['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="mobile-menu__foot">
            <a class="header-link header-link--mobile" href="https://patimbancarterminal.com/login" target="_blank" rel="noopener noreferrer">
                PICTOS login
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M8 7h9v9"/>
                </svg>
            </a>
            <a class="small link link--quiet" href="mailto:info@pict.co.id">info@pict.co.id</a>
        </div>
    </div>
</header>

@push('scripts')
<script>
(function () {
    'use strict';

    var toggle = document.getElementById('mobileMenuBtn');
    var menu = document.getElementById('mobileMenu');

    if (!toggle || !menu) return;

    function setOpen(open) {
        menu.classList.toggle('is-open', open);
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        toggle.setAttribute('aria-label', open ? 'Close navigation menu' : 'Open navigation menu');
        document.body.style.overflow = open ? 'hidden' : '';
        if (open) {
            menu.querySelector('a')?.focus();
        }
    }

    toggle.addEventListener('click', function () {
        setOpen(!menu.classList.contains('is-open'));
    });

    menu.addEventListener('click', function (event) {
        if (event.target.closest('a')) setOpen(false);
    });

    document.addEventListener('click', function (event) {
        if (!menu.classList.contains('is-open')) return;
        if (event.target.closest('#mobileMenu') || event.target.closest('#mobileMenuBtn')) return;
        setOpen(false);
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && menu.classList.contains('is-open')) {
            setOpen(false);
            toggle.focus();
        }
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth >= 1024 && menu.classList.contains('is-open')) {
            setOpen(false);
        }
    });
})();
</script>
@endpush
