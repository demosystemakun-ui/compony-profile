<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Admin Panel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS via CDN -->
        <script src="https://cdn.tailwindcss.com"></script>

        <style>
            :root { --admin-tab-h: 64px; }

            #adminMoreSheet {
                transition: opacity 0.25s ease, transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
                transform-origin: bottom center;
            }
            #adminMoreSheet.is-closed {
                opacity: 0;
                transform: scale(0.96) translateY(12px);
                pointer-events: none;
            }

            #backToTop {
                transition: opacity 0.25s ease, transform 0.25s ease;
            }
            #backToTop.is-hidden {
                opacity: 0;
                transform: translateY(10px) scale(0.92);
                pointer-events: none;
            }

            @media (prefers-reduced-motion: reduce) {
                #adminMoreSheet,
                #backToTop {
                    transition: none !important;
                }
            }

            @media (max-width: 1023px) {
                body {
                    padding-top: calc(4.75rem + env(safe-area-inset-top, 0px));
                    padding-bottom: calc(var(--admin-tab-h) + 2rem + env(safe-area-inset-bottom, 0px));
                }

                #backToTop {
                    bottom: calc(var(--admin-tab-h) + 1.85rem + env(safe-area-inset-bottom, 0px)) !important;
                    right: 1rem !important;
                }
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-100 text-gray-900 overflow-x-hidden">

        @php
            try {
                $__unreadContact = \Illuminate\Support\Facades\Schema::hasTable('contact_messages')
                    ? \App\Models\ContactMessage::where('is_read', false)->count()
                    : 0;
            } catch (\Throwable $e) {
                $__unreadContact = 0;
            }

            $__isSuperAdmin = auth()->check() && auth()->user()->isSuperAdmin();

            $__mobileBottomItems = [
                [
                    'key'    => 'dashboard',
                    'label'  => 'Dashboard',
                    'url'    => route('dashboard'),
                    'active' => request()->routeIs('dashboard'),
                    'badge'  => 0,
                    'icon'   => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
                ],
                [
                    'key'    => 'tariffs',
                    'label'  => 'Tariffs',
                    'url'    => url('/pict-internal-admin-portal/tariffs'),
                    'active' => request()->is('pict-internal-admin-portal/tariffs*'),
                    'badge'  => 0,
                    'icon'   => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                ],
                [
                    'key'    => 'news',
                    'label'  => 'News',
                    'url'    => url('/pict-internal-admin-portal/news/create'),
                    'active' => request()->is('pict-internal-admin-portal/news*'),
                    'badge'  => 0,
                    'icon'   => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z',
                ],
                [
                    'key'    => 'messages',
                    'label'  => 'Messages',
                    'url'    => route('admin.contact-messages.index'),
                    'active' => request()->routeIs('admin.contact-messages.*'),
                    'badge'  => $__unreadContact,
                    'icon'   => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                ],
            ];

            $__mobileMoreItems = [
                [
                    'label'  => 'Gallery',
                    'url'    => url('/pict-internal-admin-portal/gallery'),
                    'active' => request()->is('pict-internal-admin-portal/gallery*'),
                    'icon'   => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z',
                ],
                [
                    'label'  => 'Shipping Routes',
                    'url'    => url('/pict-internal-admin-portal/shipping-routes'),
                    'active' => request()->is('pict-internal-admin-portal/shipping-routes*'),
                    'icon'   => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7',
                ],
            ];

            if ($__isSuperAdmin) {
                $__mobileMoreItems[] = [
                    'label'  => 'Manajemen User',
                    'url'    => route('users.index'),
                    'active' => request()->routeIs('users.*'),
                    'icon'   => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
                ];
                $__mobileMoreItems[] = [
                    'label'  => 'Log Aktivitas',
                    'url'    => route('activity-logs.index'),
                    'active' => request()->routeIs('activity-logs.*'),
                    'icon'   => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                ];
            }

            $__isAdminMoreActive = collect($__mobileMoreItems)->contains(fn ($item) => $item['active']);
        @endphp

        <div class="flex min-h-dvh lg:h-screen lg:overflow-hidden">

            {{-- ═══════════════════════════════════════════════════ --}}
            {{-- SIDEBAR (DESKTOP + DRAWER OPSIONAL)                 --}}
            {{-- ═══════════════════════════════════════════════════ --}}
            <aside id="sidebar"
                   aria-label="Sidebar Navigation"
                   class="fixed inset-y-0 left-0 z-50 w-64 bg-[#0A2540] text-white transform -translate-x-full lg:translate-x-0 lg:static lg:inset-0 transition-transform duration-300 ease-in-out flex flex-col">

                {{-- Logo --}}
                <div class="flex items-center justify-between lg:justify-center h-16 px-4 bg-[#081c30] border-b border-white/10 shrink-0">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <img src="{{ asset('assets/images/pict.png') }}" alt="PICT Logo" class="h-8 w-auto object-contain" />
                        <span class="font-bold text-lg tracking-wider">PICT Admin</span>
                    </a>

                    <button type="button"
                            id="sidebarClose"
                            aria-label="Tutup sidebar"
                            class="lg:hidden p-1.5 rounded-lg text-gray-300 hover:text-white hover:bg-white/10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Navigation Links --}}
                <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">

                    <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="dashboard">
                        {{ __('Dashboard') }}
                    </x-sidebar-link>

                    <x-sidebar-link :href="url('/pict-internal-admin-portal/tariffs')" :active="request()->is('pict-internal-admin-portal/tariffs*')" icon="document">
                        {{ __('Tariffs') }}
                    </x-sidebar-link>

                    <x-sidebar-link :href="url('/pict-internal-admin-portal/news/create')" :active="request()->is('pict-internal-admin-portal/news*')" icon="news">
                        {{ __('News') }}
                    </x-sidebar-link>

                    <x-sidebar-link :href="url('/pict-internal-admin-portal/gallery')" :active="request()->is('pict-internal-admin-portal/gallery*')" icon="gallery">
                        {{ __('Gallery') }}
                    </x-sidebar-link>

                    <x-sidebar-link :href="url('/pict-internal-admin-portal/shipping-routes')" :active="request()->is('pict-internal-admin-portal/shipping-routes*')" icon="route">
                        {{ __('Shipping Routes') }}
                    </x-sidebar-link>

                    <a href="{{ route('admin.contact-messages.index') }}"
                       class="flex items-center justify-between gap-2 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                              {{ request()->routeIs('admin.contact-messages.*') ? 'bg-white/10 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                        <span class="flex items-center gap-3">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>{{ __('Contact Messages') }}</span>
                        </span>
                        @if($__unreadContact > 0)
                            <span class="inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full bg-red-600 text-white text-[10px] font-extrabold">
                                {{ $__unreadContact > 99 ? '99+' : $__unreadContact }}
                            </span>
                        @endif
                    </a>

                    @if($__isSuperAdmin)
                        <div class="pt-5 mt-5 border-t border-white/10">
                            <div class="px-4 mb-3 text-[10px] font-bold text-red-400 uppercase tracking-widest flex items-center gap-2">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                Super Admin
                            </div>

                            <x-sidebar-link :href="route('users.index')" :active="request()->routeIs('users.*')" icon="user">
                                {{ __('Manajemen User') }}
                            </x-sidebar-link>

                            <x-sidebar-link :href="route('activity-logs.index')" :active="request()->routeIs('activity-logs.*')" icon="dashboard">
                                {{ __('Log Aktivitas') }}
                            </x-sidebar-link>
                        </div>
                    @endif
                </nav>

                <div class="p-4 border-t border-white/10 shrink-0 text-xs text-gray-400 text-center">
                    © {{ date('Y') }} PICT System
                </div>
            </aside>

            {{-- ═══════════════════════════════════════════════════ --}}
            {{-- MAIN CONTENT AREA                                   --}}
            {{-- ═══════════════════════════════════════════════════ --}}
            <div class="flex-1 flex flex-col min-w-0 lg:h-screen lg:overflow-hidden relative">

                {{-- FLOATING PILL HEADER (MOBILE ONLY) --}}
                <div class="lg:hidden fixed top-0 inset-x-0 z-40 px-4 pointer-events-none"
                     style="padding-top: max(0.75rem, env(safe-area-inset-top));">
                    <div class="max-w-md mx-auto bg-white/90 backdrop-blur-xl border border-slate-200/90 rounded-full px-3.5 py-2 shadow-xl shadow-slate-900/5 flex items-center justify-between gap-2 pointer-events-auto relative">

                        <button type="button"
                                id="sidebarToggle"
                                aria-label="Buka drawer sidebar"
                                class="w-9 h-9 rounded-full flex items-center justify-center text-slate-600 hover:bg-slate-100 active:scale-95 transition shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>

                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 min-w-0">
                            <img src="{{ asset('assets/images/pict.png') }}" alt="PICT Logo" class="h-6 w-auto object-contain shrink-0">
                            <span class="text-slate-900 font-extrabold text-xs tracking-tight truncate">
                                PICT Admin
                            </span>
                        </a>

                        <div class="relative shrink-0" id="mobileProfileDropdownContainer">
                            <button type="button"
                                    id="mobileProfileDropdownBtn"
                                    aria-label="Menu profil admin"
                                    aria-expanded="false"
                                    class="w-9 h-9 rounded-full bg-gradient-to-br from-red-600 to-rose-600 flex items-center justify-center text-xs font-bold text-white shadow-sm active:scale-95 transition">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </button>

                            <div id="mobileProfileDropdownMenu"
                                 class="hidden absolute right-0 mt-2.5 w-56 max-w-[calc(100vw-2rem)] rounded-2xl shadow-2xl py-1.5 bg-white/95 backdrop-blur-xl ring-1 ring-black/5 border border-slate-200/90 z-50 overflow-hidden">
                                <div class="px-4 py-2.5 border-b border-slate-100 bg-slate-50/70">
                                    <div class="text-xs font-bold text-slate-900 truncate">{{ Auth::user()->name }}</div>
                                    <div class="text-[11px] text-slate-500 truncate">{{ Auth::user()->email }}</div>
                                </div>
                                <a href="{{ route('profile.edit') }}"
                                   class="flex items-center gap-2 px-4 py-2.5 text-xs font-medium text-slate-700 hover:bg-slate-50">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span>{{ __('Profile') }}</span>
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="w-full flex items-center gap-2 px-4 py-2.5 text-xs font-semibold text-red-600 hover:bg-red-50 text-left">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        <span>{{ __('Log Out') }}</span>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- TOP HEADER (DESKTOP ONLY) --}}
                <header class="hidden lg:flex bg-white border-b border-gray-200 h-16 shrink-0 z-30 items-center justify-between px-4 sm:px-6 lg:px-8 shadow-sm">
                    <div class="flex items-center gap-3">
                        <h1 class="text-sm font-semibold text-[#0A2540]">Admin Panel</h1>
                    </div>

                    <div class="relative" id="profileDropdownContainer">
                        <button type="button"
                                id="profileDropdownBtn"
                                class="flex items-center gap-2.5 px-2 py-1.5 rounded-full hover:bg-gray-100 transition-colors focus:outline-none">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-red-500 to-red-700 flex items-center justify-center text-xs font-bold text-white shadow-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="text-left leading-tight">
                                <div class="text-sm font-semibold text-[#0A2540]">{{ Auth::user()->name }}</div>
                                <div class="text-[10px] text-gray-500">
                                    {{ $__isSuperAdmin ? 'Super Administrator' : 'Administrator' }}
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div id="profileDropdownMenu"
                             class="hidden absolute right-0 mt-2 w-56 rounded-xl shadow-lg py-1 bg-white ring-1 ring-black/5 border border-gray-100 z-50 overflow-hidden">
                            <div class="px-4 py-3 border-b border-gray-100 bg-gray-50/50">
                                <div class="text-sm font-semibold text-[#0A2540]">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</div>
                            </div>
                            <a href="{{ route('profile.edit') }}"
                               class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                {{ __('Profile') }}
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors text-left">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </header>

                {{-- Overlay (Mobile Sidebar) --}}
                <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

                {{-- Page Header (Slot) --}}
                @isset($header)
                    <header class="bg-white border-b border-gray-200 shadow-sm shrink-0">
                        <div class="max-w-7xl mx-auto py-4 sm:py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                {{-- Page Content --}}
                <main id="adminMainScroll" class="flex-1 overflow-x-hidden lg:overflow-y-auto bg-gray-100 p-4 sm:p-6 lg:p-8">
                    {{ $slot }}
                </main>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════ --}}
        {{-- MOBILE: "MORE" SHEET + FLOATING BOTTOM TAB BAR      --}}
        {{-- ═══════════════════════════════════════════════════ --}}
        <div id="adminMoreSheet"
             class="lg:hidden fixed inset-x-0 z-50 px-4 is-closed pointer-events-none"
             style="bottom: calc(max(0.75rem, env(safe-area-inset-bottom, 0px)) + var(--admin-tab-h) + 0.5rem);">
            <div class="max-w-md mx-auto bg-white/95 backdrop-blur-2xl border border-slate-200 rounded-3xl p-3 shadow-2xl shadow-slate-900/15 pointer-events-auto">
                <div class="grid grid-cols-2 gap-2">
                    @foreach($__mobileMoreItems as $item)
                        <a href="{{ $item['url'] }}"
                           @if($item['active']) aria-current="page" @endif
                           class="flex items-center gap-2.5 px-3 py-3 rounded-2xl text-xs font-semibold transition active:scale-95
                                  {{ $item['active']
                                     ? 'bg-gradient-to-r from-red-600 to-rose-600 text-white shadow-md shadow-red-600/20'
                                     : 'text-slate-700 bg-slate-50 hover:bg-slate-100' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/>
                            </svg>
                            <span class="truncate">{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <nav id="adminBottomTabBar"
             class="lg:hidden fixed bottom-0 inset-x-0 z-50 px-3 pointer-events-none"
             style="padding-bottom: max(0.75rem, env(safe-area-inset-bottom, 0px));"
             aria-label="Mobile admin navigation">
            <div class="pointer-events-auto max-w-md mx-auto grid grid-cols-5 gap-1 p-1.5 bg-white/90 backdrop-blur-xl border border-slate-200/90 rounded-3xl shadow-2xl shadow-slate-900/10"
                 style="height: var(--admin-tab-h);">

                @foreach($__mobileBottomItems as $tab)
                    <a href="{{ $tab['url'] }}"
                       @if($tab['active']) aria-current="page" @endif
                       class="relative flex flex-col items-center justify-center gap-0.5 rounded-2xl select-none transition active:scale-90
                              {{ $tab['active'] ? 'bg-red-50 text-red-600 font-bold' : 'text-slate-500 font-medium hover:text-slate-800' }}">
                        <div class="relative">
                            <svg class="w-[21px] h-[21px]" fill="none" stroke="currentColor" stroke-width="{{ $tab['active'] ? '1.9' : '1.5' }}" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $tab['icon'] }}"/>
                            </svg>
                            @if($tab['badge'] > 0)
                                <span class="absolute -top-1.5 -right-2.5 inline-flex items-center justify-center min-w-[16px] h-4 px-1 rounded-full bg-red-600 text-white text-[9px] font-extrabold leading-none">
                                    {{ $tab['badge'] > 99 ? '99+' : $tab['badge'] }}
                                </span>
                            @endif
                        </div>
                        <span class="text-[10px] leading-none truncate max-w-full px-0.5">{{ $tab['label'] }}</span>
                    </a>
                @endforeach

                <button id="adminMoreBtn"
                        type="button"
                        aria-label="More menu"
                        aria-expanded="false"
                        aria-controls="adminMoreSheet"
                        class="flex flex-col items-center justify-center gap-0.5 rounded-2xl select-none transition active:scale-90 cursor-pointer
                               {{ $__isAdminMoreActive ? 'bg-red-50 text-red-600 font-bold' : 'text-slate-500 font-medium hover:text-slate-800' }}">
                    <svg class="w-[21px] h-[21px] pointer-events-none" fill="none" stroke="currentColor" stroke-width="{{ $__isAdminMoreActive ? '1.9' : '1.5' }}" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/>
                    </svg>
                    <span class="text-[10px] leading-none pointer-events-none">More</span>
                </button>

            </div>
        </nav>

        {{-- BACK TO TOP BUTTON (MOBILE) --}}
        <button id="backToTop"
                type="button"
                aria-label="Kembali ke atas"
                class="lg:hidden fixed right-4 z-40 w-11 h-11 rounded-full bg-red-900 text-white shadow-lg shadow-red-950/25 flex items-center justify-center active:scale-90 is-hidden">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/>
            </svg>
        </button>

        {{-- ═══════════════════════════════════════════════════════ --}}
        {{-- SCRIPT: SIDEBAR, MORE SHEET, DROPDOWN & BACK TO TOP     --}}
        {{-- ═══════════════════════════════════════════════════════ --}}
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const sidebar = document.getElementById('sidebar');
                const toggleBtn = document.getElementById('sidebarToggle');
                const closeBtn = document.getElementById('sidebarClose');
                const overlay = document.getElementById('sidebarOverlay');

                function toggleSidebar(forceClose = false) {
                    if (!sidebar || !overlay) return;
                    if (forceClose) {
                        sidebar.classList.add('-translate-x-full');
                        overlay.classList.add('hidden');
                        return;
                    }
                    sidebar.classList.toggle('-translate-x-full');
                    overlay.classList.toggle('hidden');
                }

                if (toggleBtn) toggleBtn.addEventListener('click', () => toggleSidebar(false));
                if (closeBtn) closeBtn.addEventListener('click', () => toggleSidebar(true));
                if (overlay) overlay.addEventListener('click', () => toggleSidebar(true));

                // Desktop Profile Dropdown
                const profileBtn = document.getElementById('profileDropdownBtn');
                const profileMenu = document.getElementById('profileDropdownMenu');
                if (profileBtn && profileMenu) {
                    profileBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        profileMenu.classList.toggle('hidden');
                    });
                }

                // Mobile Profile Dropdown
                const mobileProfileBtn = document.getElementById('mobileProfileDropdownBtn');
                const mobileProfileMenu = document.getElementById('mobileProfileDropdownMenu');
                if (mobileProfileBtn && mobileProfileMenu) {
                    mobileProfileBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const isHidden = mobileProfileMenu.classList.contains('hidden');
                        mobileProfileMenu.classList.toggle('hidden');
                        mobileProfileBtn.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
                    });
                }

                // Mobile "More" Sheet
                const moreSheet = document.getElementById('adminMoreSheet');
                const moreBtn = document.getElementById('adminMoreBtn');

                function closeMoreSheet() {
                    if (!moreSheet || !moreBtn) return;
                    moreSheet.classList.add('is-closed');
                    moreBtn.setAttribute('aria-expanded', 'false');
                }

                document.addEventListener('click', (e) => {
                    if (profileBtn && profileMenu && !profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
                        profileMenu.classList.add('hidden');
                    }
                    if (mobileProfileBtn && mobileProfileMenu && !mobileProfileBtn.contains(e.target) && !mobileProfileMenu.contains(e.target)) {
                        mobileProfileMenu.classList.add('hidden');
                        mobileProfileBtn.setAttribute('aria-expanded', 'false');
                    }
                    if (moreSheet && moreBtn) {
                        const clickedMoreBtn = e.target.closest('#adminMoreBtn');
                        if (clickedMoreBtn) {
                            e.preventDefault();
                            const isClosed = moreSheet.classList.contains('is-closed');
                            moreSheet.classList.toggle('is-closed', !isClosed);
                            moreBtn.setAttribute('aria-expanded', isClosed ? 'true' : 'false');
                            return;
                        }
                        if (e.target.closest('#adminMoreSheet a') || !moreSheet.contains(e.target)) {
                            closeMoreSheet();
                        }
                    }
                });

                // Back to Top
                const backToTopBtn = document.getElementById('backToTop');
                const mainScroll = document.getElementById('adminMainScroll');

                function getScrollPosition() {
                    const winY = window.scrollY || document.documentElement.scrollTop || 0;
                    const mainY = mainScroll ? mainScroll.scrollTop : 0;
                    return Math.max(winY, mainY);
                }

                function updateBackToTop() {
                    if (!backToTopBtn) return;
                    backToTopBtn.classList.toggle('is-hidden', getScrollPosition() < 180);
                }

                window.addEventListener('scroll', updateBackToTop, { passive: true });
                if (mainScroll) mainScroll.addEventListener('scroll', updateBackToTop, { passive: true });
                updateBackToTop();

                if (backToTopBtn) {
                    backToTopBtn.addEventListener('click', () => {
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                        if (mainScroll) mainScroll.scrollTo({ top: 0, behavior: 'smooth' });
                    });
                }
            });
        </script>
    </body>
</html>