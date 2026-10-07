<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="color-scheme" content="light">

    <title>{{ config('app.name', 'PICT') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            color-scheme: light;
            --pa-navy-900: #111a3c;
            --pa-navy-800: #1e2a5a;
            --pa-navy-700: #2a3a80;
            --pa-red: #e31e24;
            --pa-slate-900: #0f172a;
            --pa-slate-700: #334155;
            --pa-slate-600: #475569;
            --pa-slate-500: #64748b;
            --pa-slate-400: #94a3b8;
            --pa-slate-300: #cbd5e1;
            --pa-slate-200: #e2e8f0;
        }
        [x-cloak] { display: none !important; }

        .pa-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: minmax(0, 1.05fr) minmax(0, 1fr);
            background: #f4f6fb;
            font-family: 'Figtree', ui-sans-serif, system-ui, sans-serif;
            color: var(--pa-slate-900);
            -webkit-font-smoothing: antialiased;
        }

        /* ---------- Panel brand (kiri) ---------- */
        .pa-brand {
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px 56px;
            color: #fff;
            background: linear-gradient(150deg, var(--pa-navy-900) 0%, var(--pa-navy-800) 55%, var(--pa-navy-700) 100%);
        }
        .pa-brand::before {
            content: "";
            position: absolute;
            width: 520px; height: 520px;
            right: -180px; top: -160px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(227,30,36,.35) 0%, rgba(227,30,36,0) 68%);
        }
        .pa-brand::after {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.045) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.045) 1px, transparent 1px);
            background-size: 44px 44px;
            -webkit-mask-image: linear-gradient(to bottom, rgba(0,0,0,.9), rgba(0,0,0,.15));
                    mask-image: linear-gradient(to bottom, rgba(0,0,0,.9), rgba(0,0,0,.15));
            pointer-events: none;
        }
        .pa-brand > * { position: relative; z-index: 1; }

        .pa-logo-chip {
            display: inline-flex;
            align-items: center;
            background: #fff;
            border-radius: 14px;
            padding: 12px 20px;
            box-shadow: 0 10px 30px -10px rgba(0,0,0,.45);
        }
        .pa-logo-chip img { height: 52px; width: auto; display: block; }

        .pa-brand-title {
            margin: 0;
            font-size: 34px;
            line-height: 1.2;
            font-weight: 700;
            letter-spacing: -0.02em;
        }
        .pa-brand-title span { color: #ff6b70; }
        .pa-brand-text {
            margin: 14px 0 0;
            max-width: 420px;
            font-size: 15px;
            line-height: 1.6;
            color: rgba(255,255,255,.72);
        }
        .pa-points { list-style: none; margin: 28px 0 0; padding: 0; display: grid; gap: 14px; }
        .pa-points li { display: flex; align-items: center; gap: 12px; font-size: 14px; color: rgba(255,255,255,.88); }
        .pa-points .pa-dot {
            display: inline-flex; align-items: center; justify-content: center;
            width: 28px; height: 28px; border-radius: 8px;
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.14);
        }
        .pa-points svg { width: 16px; height: 16px; }
        .pa-brand-foot { font-size: 12px; color: rgba(255,255,255,.55); }

        /* ---------- Area form (kanan) ---------- */
        .pa-main {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }
        .pa-mobile-logo { display: none; margin-bottom: 28px; }
        .pa-mobile-logo img { height: 64px; width: auto; display: block; }

        .pa-card {
            width: 100%;
            max-width: 430px;
            background: #fff;
            border: 1px solid #e6eaf3;
            border-radius: 18px;
            padding: 40px 36px 36px;
            box-shadow: 0 1px 2px rgba(15,23,42,.04), 0 18px 40px -18px rgba(15,23,42,.22);
        }
        .pa-copy { margin-top: 28px; font-size: 12px; color: var(--pa-slate-500); text-align: center; }

        /* ---------- Komponen form ---------- */
        .pa-head { text-align: center; margin-bottom: 28px; }
        .pa-title { margin: 0; font-size: 26px; font-weight: 700; letter-spacing: -0.02em; color: var(--pa-slate-900); }
        .pa-sub { margin: 6px 0 0; font-size: 14px; color: var(--pa-slate-500); }

        .pa-form { display: grid; gap: 20px; }

        .pa-label-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px; }
        .pa-label { display: block; font-size: 13px; font-weight: 600; color: var(--pa-slate-700); }

        .pa-field { position: relative; }
        .pa-input {
            display: block;
            width: 100%;
            height: 46px;
            box-sizing: border-box;
            padding: 0 44px 0 44px;
            font: inherit;
            font-size: 14px;
            color: var(--pa-slate-900);
            background: #fff;
            border: 1px solid var(--pa-slate-300);
            border-radius: 10px;
            outline: none;
            transition: border-color .15s, box-shadow .15s;
        }
        .pa-input::placeholder { color: var(--pa-slate-400); }
        .pa-input:hover { border-color: var(--pa-slate-400); }
        .pa-input:focus {
            border-color: var(--pa-navy-700);
            box-shadow: 0 0 0 4px rgba(42,58,128,.14);
        }
        .pa-input.pa-invalid { border-color: #f87171; }
        .pa-input.pa-invalid:focus { box-shadow: 0 0 0 4px rgba(239,68,68,.15); }
        .pa-input:-webkit-autofill,
        .pa-input:-webkit-autofill:hover,
        .pa-input:-webkit-autofill:focus {
            -webkit-text-fill-color: var(--pa-slate-900);
            -webkit-box-shadow: 0 0 0 1000px #fff inset;
            transition: background-color 9999s ease-in-out 0s;
        }

        .pa-ico-l {
            position: absolute; left: 14px; top: 50%;
            transform: translateY(-50%);
            width: 18px; height: 18px;
            color: var(--pa-slate-400);
            pointer-events: none;
            transition: color .15s;
        }
        .pa-field:focus-within .pa-ico-l { color: var(--pa-navy-700); }

        .pa-ico-r {
            position: absolute; right: 6px; top: 50%;
            transform: translateY(-50%);
            display: inline-flex; align-items: center; justify-content: center;
            width: 34px; height: 34px;
            padding: 0; border: 0; border-radius: 8px;
            background: transparent;
            color: var(--pa-slate-400);
            cursor: pointer;
            transition: color .15s, background-color .15s;
        }
        .pa-ico-r:hover { color: var(--pa-slate-700); background: #f1f5f9; }
        .pa-ico-r:focus-visible { outline: 2px solid var(--pa-navy-700); outline-offset: 1px; }
        .pa-ico-r svg { width: 18px; height: 18px; }

        .pa-link {
            font-size: 13px; font-weight: 600;
            color: var(--pa-navy-700);
            text-decoration: none;
            transition: color .15s;
        }
        .pa-link:hover { color: var(--pa-red); text-decoration: underline; }

        .pa-check { display: inline-flex; align-items: center; gap: 10px; cursor: pointer; user-select: none; font-size: 14px; color: var(--pa-slate-600); }
        .pa-check input { width: 16px; height: 16px; margin: 0; accent-color: var(--pa-navy-800); cursor: pointer; }

        .pa-btn {
            position: relative;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            width: 100%; height: 48px;
            border: 0; border-radius: 10px;
            font: inherit; font-size: 14px; font-weight: 600; letter-spacing: .02em;
            color: #fff;
            background: linear-gradient(135deg, var(--pa-navy-800), var(--pa-navy-700));
            box-shadow: 0 8px 20px -8px rgba(30,42,90,.6);
            cursor: pointer;
            transition: transform .15s, box-shadow .15s, filter .15s;
        }
        .pa-btn:hover { transform: translateY(-1px); filter: brightness(1.08); box-shadow: 0 12px 24px -10px rgba(30,42,90,.7); }
        .pa-btn:active { transform: translateY(0); }
        .pa-btn:focus-visible { outline: 3px solid rgba(42,58,128,.35); outline-offset: 2px; }
        .pa-btn:disabled { opacity: .75; cursor: not-allowed; transform: none; }
        .pa-spin { width: 18px; height: 18px; animation: pa-spin .8s linear infinite; }
        @keyframes pa-spin { to { transform: rotate(360deg); } }

        .pa-divider { height: 1px; background: var(--pa-slate-200); border: 0; margin: 4px 0 0; }
        .pa-foot { text-align: center; font-size: 14px; color: var(--pa-slate-600); }

        /* ---------- Responsif ---------- */
        @media (max-width: 960px) {
            .pa-shell { grid-template-columns: 1fr; }
            .pa-brand { display: none; }
            .pa-mobile-logo { display: block; }
        }
        @media (max-width: 480px) {
            .pa-card { padding: 32px 22px 28px; border-radius: 16px; }
        }
        @media (prefers-reduced-motion: reduce) {
            .pa-btn, .pa-input, .pa-ico-r { transition: none; }
            .pa-spin { animation-duration: 2s; }
        }
    </style>
</head>
<body>
    <div class="pa-shell">

        {{-- Panel brand --}}
        <aside class="pa-brand" aria-hidden="true">
            <div>
                <span class="pa-logo-chip">
                    <img src="{{ asset('assets/images/pict.png') }}" alt="">
                </span>
            </div>

            <div>
                <h1 class="pa-brand-title">PICT <span>Compro Portal</span></h1>
                <p class="pa-brand-text">
                    Patimban International Car Terminal.
                    Sign in to access your account and manage your work securely.
                </p>

                <ul class="pa-points">
                    <li>
                        <span class="pa-dot">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m6 2.25a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </span>
                        Authorized personnel only
                    </li>
                    <li>
                        <span class="pa-dot">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                        </span>
                        Secure, encrypted sign-in
                    </li>
                    <li>
                        <span class="pa-dot">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M12 2.25l8.25 3v6c0 5.1-3.4 8.9-8.25 10.5C7.15 20.15 3.75 16.35 3.75 11.25v-6L12 2.25z"/></svg>
                        </span>
                        Access activity is monitored
                    </li>
                </ul>
            </div>

            <div class="pa-brand-foot">&copy; {{ date('Y') }} - PICT Operational System</div>
        </aside>

        {{-- Area form --}}
        <main class="pa-main">
            <a href="/" class="pa-mobile-logo" aria-label="PICT">
                <img src="{{ asset('assets/images/pict.png') }}" alt="PICT - Patimban International Car Terminal">
            </a>

            <div class="pa-card">
                {{ $slot }}
            </div>

        </main>
    </div>
</body>
</html>