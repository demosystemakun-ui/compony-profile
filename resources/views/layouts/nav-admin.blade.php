{{-- ═══ SIDEBAR ADMIN (VERTIKAL) ═══ --}}
<aside class="fixed inset-y-0 left-0 z-40 w-64 bg-[#0F172A] text-white flex flex-col -translate-x-full lg:translate-x-0 transition-transform duration-300"
       id="adminSidebar">

    {{-- Logo --}}
    <div class="h-16 flex items-center px-6 border-b border-white/10">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
            <span class="text-[#EC2029] font-extrabold text-2xl italic tracking-tighter">PICT</span>
            <span class="text-white font-bold text-lg tracking-wide">Admin</span>
        </a>
    </div>

    {{-- Menu Navigasi --}}
    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-colors
                  {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Dashboard
        </a>

        {{-- Tariffs --}}
        <a href="{{ url('/pict-internal-admin-portal/tariffs') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-colors
                  {{ request()->is('pict-internal-admin-portal/tariffs*') ? 'bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Tariffs
        </a>

        {{-- News --}}
        <a href="{{ url('/pict-internal-admin-portal/news/create') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-colors
                  {{ request()->is('pict-internal-admin-portal/news*') ? 'bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
            </svg>
            News
        </a>

        {{-- Gallery (MENU BARU) --}}
        <a href="{{ url('/pict-internal-admin-portal/gallery') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-colors
                  {{ request()->is('pict-internal-admin-portal/gallery*') ? 'bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Gallery
        </a>
    </nav>

    {{-- User Info di Bawah --}}
    <div class="p-4 border-t border-white/10">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-[#EC2029] flex items-center justify-center font-bold text-sm shrink-0">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                <p class="text-[11px] text-slate-400 truncate">Administrator</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" title="Logout" class="text-slate-400 hover:text-red-400 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>

{{-- ═══ OVERLAY UNTUK MOBILE ═══ --}}
<div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden"></div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('sidebarOverlay');

        // Tombol hamburger (kalau ada di topbar)
        const toggleBtn = document.getElementById('mobileNavToggle');
        if (toggleBtn && sidebar && overlay) {
            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            });
            overlay.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            });
        }
    });
</script>