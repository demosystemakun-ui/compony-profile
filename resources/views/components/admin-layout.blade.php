<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Admin Panel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS via CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="font-sans antialiased bg-gray-100 text-gray-900">
        
        <div class="flex h-screen overflow-hidden">

            {{-- ═══════════════════════════════════════════════════ --}}
            {{-- SIDEBAR --}}
            {{-- ═══════════════════════════════════════════════════ --}}
            <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-[#0A2540] text-white transform -translate-x-full lg:translate-x-0 lg:static lg:inset-0 transition-transform duration-300 ease-in-out flex flex-col">
                
                {{-- Logo --}}
                <div class="flex items-center justify-center h-16 bg-[#081c30] border-b border-white/10 shrink-0">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <x-application-logo class="h-8 w-auto fill-current text-white" />
                        <span class="font-bold text-lg tracking-wider">PICT Admin</span>
                    </a>
                </div>

                {{-- Navigation Links --}}
                <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                    
                    {{-- MENU UTAMA --}}
                    <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="dashboard">
                        {{ __('Dashboard') }}
                    </x-sidebar-link>

                    <x-sidebar-link :href="url('/pict-internal-admin-portal/tariffs')" :active="request()->is('pict-internal-admin-portal/tariffs*')" icon="document">
                        {{ __('Tariffs') }}
                    </x-sidebar-link>

                    <x-sidebar-link :href="url('/pict-internal-admin-portal/news/create')" :active="request()->is('pict-internal-admin-portal/news*')" icon="news">
                        {{ __('News') }}
                    </x-sidebar-link>

        

                    {{-- ═══════════════════════════════════════════════════ --}}
                    {{-- MENU KHUSUS SUPER ADMIN --}}
                    {{-- ═══════════════════════════════════════════════════ --}}
                    @if(auth()->user()->isSuperAdmin())
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

                {{-- Footer Sidebar --}}
                <div class="p-4 border-t border-white/10 shrink-0 text-xs text-gray-400 text-center">
                    © {{ date('Y') }} PICT System
                </div>
            </aside>

            {{-- ═══════════════════════════════════════════════════ --}}
            {{-- MAIN CONTENT AREA --}}
            {{-- ═══════════════════════════════════════════════════ --}}
            <div class="flex-1 flex flex-col h-screen overflow-hidden relative">

                {{-- TOP HEADER --}}
                <header class="bg-white border-b border-gray-200 h-16 shrink-0 z-30 flex items-center justify-between px-4 sm:px-6 lg:px-8 shadow-sm">
                    
                    {{-- LEFT: Hamburger (Mobile) + Page Title --}}
                    <div class="flex items-center gap-3">
                        <button id="sidebarToggle" class="lg:hidden p-2 rounded-md text-gray-500 hover:bg-gray-100 focus:outline-none">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <h1 class="text-sm font-semibold text-[#0A2540] hidden sm:block">Admin Panel</h1>
                    </div>

                    {{-- RIGHT: User Profile Dropdown --}}
                    <div class="relative" id="profileDropdownContainer">
                        <button type="button" id="profileDropdownBtn" 
                                class="flex items-center gap-2.5 px-2 py-1.5 rounded-full hover:bg-gray-100 transition-colors focus:outline-none">
                            
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-red-500 to-red-700 flex items-center justify-center text-xs font-bold text-white shadow-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>

                            <div class="hidden sm:block text-left leading-tight">
                                <div class="text-sm font-semibold text-[#0A2540]">{{ Auth::user()->name }}</div>
                                <div class="text-[10px] text-gray-500">
                                    {{ auth()->user()->isSuperAdmin() ? 'Super Administrator' : 'Administrator' }}
                                </div>
                            </div>

                            <svg class="w-4 h-4 text-gray-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                {{-- Page Content --}}
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-4 sm:p-6 lg:p-8">
                    {{ $slot }}
                </main>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════ --}}
        {{-- SCRIPT: SIDEBAR TOGGLE & DROPDOWN --}}
        {{-- ═══════════════════════════════════════════════════════ --}}
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Sidebar Toggle (Mobile)
                const sidebar = document.getElementById('sidebar');
                const toggleBtn = document.getElementById('sidebarToggle');
                const overlay = document.getElementById('sidebarOverlay');

                function toggleSidebar() {
                    sidebar.classList.toggle('-translate-x-full');
                    overlay.classList.toggle('hidden');
                }

                if (toggleBtn) toggleBtn.addEventListener('click', toggleSidebar);
                if (overlay) overlay.addEventListener('click', toggleSidebar);

                // Profile Dropdown
                const profileBtn = document.getElementById('profileDropdownBtn');
                const profileMenu = document.getElementById('profileDropdownMenu');

                if (profileBtn && profileMenu) {
                    profileBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        profileMenu.classList.toggle('hidden');
                    });

                    document.addEventListener('click', (e) => {
                        if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
                            profileMenu.classList.add('hidden');
                        }
                    });
                }
            });
        </script>
    </body>
</html>