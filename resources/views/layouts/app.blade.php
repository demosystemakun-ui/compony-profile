<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">

    <title>@yield('title', 'PT Patimban International Car Terminal')</title>
    <meta name="description" content="@yield('meta_description', 'PT Patimban International Car Terminal operates the vehicle terminal at Patimban Port, Subang Regency, West Java.')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#f5f3ee">

    <link rel="icon" type="image/png" href="{{ asset('assets/images/pict.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/pict.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,300..600;1,6..72,300..500&family=Public+Sans:wght@300..700&display=swap" rel="stylesheet">

    {{-- Tailwind is compiled to a local file. The CDN build is not used. --}}
    <link rel="stylesheet" href="{{ asset('assets/css/tailwind.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    @stack('styles')
</head>

<body>
    <a class="skip-link" href="#main-content">Skip to content</a>

    @include('layouts.navbar')

    <main id="main-content">
        @yield('content')
    </main>

    <button id="backToTop" class="back-to-top" type="button" aria-label="Back to top">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 11l7-7 7 7M12 4v17"/>
        </svg>
    </button>

    @include('layouts.footer')

    @if (!request()->is('pict-internal-admin-portal*'))
        <div id="scamWarningModal" class="notice-backdrop" role="dialog" aria-modal="true" aria-labelledby="noticeTitle">
            <div class="notice">
                <p class="index"><b>Notice</b><span class="index-rule"></span>Public information</p>
                <h2 id="noticeTitle">Official notice</h2>
                <p>
                    Information about job vacancies, recruitment, or commercial activities that does not come from this official website is outside our responsibility and outside our system.
                </p>
                <p>
                    We urge users not to trust parties claiming to represent the company unofficially. For valid information, contact our official email:
                </p>
                <p class="mt-4"><a class="link" href="mailto:info@pict.co.id">info@pict.co.id</a></p>
                <div class="notice__actions">
                    <button type="button" id="closeModalBtn" class="btn btn--primary">I understand</button>
                </div>
            </div>
        </div>
    @endif

    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
    (function () {
        'use strict';

        /* Back to top */
        var backToTop = document.getElementById('backToTop');

        function updateBackToTop() {
            if (!backToTop) return;
            backToTop.classList.toggle('is-visible', window.scrollY > 320);
        }

        window.addEventListener('scroll', updateBackToTop, { passive: true });
        backToTop?.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
        updateBackToTop();

        /* Official notice: shown once every seven days, closed with Escape or the button. */
        var notice = document.getElementById('scamWarningModal');
        var closeNotice = document.getElementById('closeModalBtn');
        var lastFocused = null;

        function openNotice() {
            if (!notice) return;
            lastFocused = document.activeElement;
            notice.classList.add('is-open');
            document.body.style.overflow = 'hidden';
            closeNotice?.focus();
        }

        function dismissNotice() {
            if (!notice) return;
            notice.classList.remove('is-open');
            document.body.style.overflow = '';
            localStorage.setItem('pict_scam_warning_last_seen', String(Date.now()));
            lastFocused?.focus();
        }

        if (notice && closeNotice) {
            var lastSeen = localStorage.getItem('pict_scam_warning_last_seen');
            var sevenDays = 7 * 24 * 60 * 60 * 1000;

            if (!lastSeen || (Date.now() - parseInt(lastSeen, 10)) > sevenDays) {
                window.setTimeout(openNotice, 1200);
            }

            closeNotice.addEventListener('click', dismissNotice);
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && notice.classList.contains('is-open')) {
                    dismissNotice();
                }
            });
        }
    })();
    </script>

    @stack('scripts')

    @include('layouts.ai-chat')
    @include('layouts.cookie-banner')
</body>
</html>
