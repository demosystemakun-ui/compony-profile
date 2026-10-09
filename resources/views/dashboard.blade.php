{{--
    Semua data dikirim dari App\Http\Controllers\DashboardController:
    $isSuperAdmin, $totalNews, $totalTariffs, $totalUsers, $staleNews, $staleTariffs,
    $lastNewsAgo, $lastTariffAgo, $attentionNews, $topCategories, $recentLogs,
    $newsList, $tariffList, $actionColors
--}}
<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-wrap gap-3 justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-[#0A2540] leading-tight tracking-tight">
                    {{ __('Dashboard - Kelola Konten') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">Kelola berita, tarif, dan konten publikasi PICT</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-gray-50 via-white to-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="flex items-start gap-3 p-4 bg-green-50 border-l-4 border-green-500 text-green-800 rounded-lg text-sm shadow-sm">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            {{-- ═══════════════════════════════════════════════════════ --}}
            {{-- STATISTIK CARDS --}}
            {{-- ═══════════════════════════════════════════════════════ --}}
            <div class="grid grid-cols-2 {{ $isSuperAdmin ? 'lg:grid-cols-4' : 'lg:grid-cols-3' }} gap-4">

                {{-- Total Berita --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Berita</p>
                            <p class="text-3xl font-bold text-[#0A2540] mt-2">{{ $totalNews }}</p>
                            <p class="text-[11px] text-gray-400 mt-1">Update: {{ $lastNewsAgo }}</p>
                        </div>
                        <div class="w-11 h-11 rounded-xl bg-red-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Total Tarif --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Tarif</p>
                            <p class="text-3xl font-bold text-[#0A2540] mt-2">{{ $totalTariffs }}</p>
                            <p class="text-[11px] text-gray-400 mt-1">Update: {{ $lastTariffAgo }}</p>
                        </div>
                        <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Total User (HANYA SUPER ADMIN) --}}
                @if($isSuperAdmin)
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total User</p>
                                <p class="text-3xl font-bold text-[#0A2540] mt-2">{{ $totalUsers }}</p>
                                <p class="text-[11px] text-gray-400 mt-1">Terdaftar di sistem</p>
                            </div>
                            <div class="w-11 h-11 rounded-xl bg-purple-50 flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Konten Stale --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition {{ $staleNews + $staleTariffs > 0 ? 'ring-2 ring-amber-200' : '' }}">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Perlu Update</p>
                            <p class="text-3xl font-bold {{ $staleNews + $staleTariffs > 0 ? 'text-amber-600' : 'text-[#0A2540]' }} mt-2">
                                {{ $staleNews + $staleTariffs }}
                            </p>
                            <p class="text-[11px] text-gray-400 mt-1">Tidak diupdate &gt; 30 hari</p>
                        </div>
                        <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══════════════════════════════════════════════════════ --}}
            {{-- ROW: KONTEN PERLU PERHATIAN + AKTIVITAS TERBARU --}}
            {{-- ═══════════════════════════════════════════════════════ --}}
            <div class="grid grid-cols-1 {{ $isSuperAdmin ? 'lg:grid-cols-2' : '' }} gap-6">

                {{-- ───── KONTEN PERLU PERHATIAN ───── --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-amber-50/50 to-transparent flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center shadow-sm">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-[#0A2540]">Konten Perlu Perhatian</h3>
                            <p class="text-[11px] text-gray-500">Berita yang belum diupdate lebih dari 30 hari</p>
                        </div>
                    </div>

                    <div class="p-4">
                        @forelse($attentionNews as $item)
                            @php
                                $daysAgo = $item->updated_at->diffInDays(now());
                                $progress = min(100, ($daysAgo / 60) * 100);
                            @endphp
                            <div class="py-3 border-b border-gray-100 last:border-0">
                                <div class="flex items-start justify-between gap-3 mb-2">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-[#0A2540] truncate">{{ $item->title }}</p>
                                        <p class="text-[11px] text-gray-500 mt-0.5">
                                            {{ $item->category }} • {{ $daysAgo }} hari lalu
                                        </p>
                                    </div>
                                    <a href="{{ route('news.edit', $item->id) }}"
                                       class="shrink-0 text-[11px] font-semibold text-amber-700 bg-amber-50 hover:bg-amber-100 px-2.5 py-1 rounded-md border border-amber-200 transition">
                                        Update
                                    </a>
                                </div>
                                <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full transition-all
                                        {{ $progress > 75 ? 'bg-red-500' : ($progress > 40 ? 'bg-amber-500' : 'bg-green-500') }}"
                                         style="width: {{ $progress }}%"></div>
                                </div>
                            </div>
                        @empty
                            <div class="py-8 text-center">
                                <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-500">Semua konten terupdate!</p>
                                <p class="text-[11px] text-gray-400 mt-1">Tidak ada berita yang perlu perhatian.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- ───── AKTIVITAS TERBARU (HANYA SUPER ADMIN) ───── --}}
                @if($isSuperAdmin)
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-purple-50/50 to-transparent flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-purple-600 flex items-center justify-center shadow-sm">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-[#0A2540]">Aktivitas Terbaru</h3>
                                    <p class="text-[11px] text-gray-500">5 log terakhir dari semua user</p>
                                </div>
                            </div>
                            <a href="{{ route('activity-logs.index') }}"
                               class="text-[11px] font-semibold text-[#0A2540] hover:text-red-600 transition">
                                Lihat semua →
                            </a>
                        </div>

                        <div class="p-4">
                            @forelse($recentLogs as $log)
                                <div class="flex items-start gap-3 py-3 border-b border-gray-100 last:border-0">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#0A2540] to-[#1a3a5f] text-white flex items-center justify-center text-[10px] font-bold shrink-0">
                                        {{ strtoupper(substr($log->user->name ?? 'S', 0, 1)) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-0.5">
                                            <p class="text-xs font-semibold text-[#0A2540]">{{ $log->user->name ?? 'System' }}</p>
                                            @php $color = $actionColors[$log->action] ?? 'bg-gray-50 text-gray-700 border-gray-200'; @endphp
                                            <span class="text-[9px] font-bold uppercase px-1.5 py-0.5 rounded border {{ $color }}">
                                                {{ $log->action }}
                                            </span>
                                        </div>
                                        <p class="text-[11px] text-gray-600 truncate">{{ $log->description }}</p>
                                        <p class="text-[10px] text-gray-400 mt-0.5">{{ $log->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="py-8 text-center text-sm text-gray-400">Belum ada aktivitas.</div>
                            @endforelse
                        </div>
                    </div>
                @endif
            </div>

            {{-- ═══════════════════════════════════════════════════════ --}}
            {{-- TOP KATEGORI BERITA --}}
            {{-- ═══════════════════════════════════════════════════════ --}}
            @if($topCategories->count() > 0)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50/50 to-transparent">
                        <h3 class="text-base font-bold text-[#0A2540]">Top Kategori Berita</h3>
                        <p class="text-[11px] text-gray-500">5 kategori dengan berita terbanyak</p>
                    </div>
                    <div class="p-6 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                        @foreach($topCategories as $cat)
                            <div class="text-center p-4 rounded-xl bg-gray-50 border border-gray-100 hover:border-red-200 hover:bg-red-50/30 transition">
                                <div class="text-2xl font-bold text-[#0A2540]">{{ $cat->total }}</div>
                                <div class="text-[11px] font-semibold text-red-600 uppercase tracking-wider mt-1 truncate">{{ $cat->category }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- ═══════════════════════════════════════════════════════ --}}
            {{-- DAFTAR BERITA --}}
            {{-- ═══════════════════════════════════════════════════════ --}}
            <div class="bg-white overflow-hidden shadow-md rounded-2xl border border-gray-100">
                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-red-50/50 to-transparent flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-red-600 flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-[#0A2540]">Daftar Berita Terpublikasi</h3>
                        <p class="text-xs text-gray-500">Kelola semua artikel dan berita yang tampil di website</p>
                    </div>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b-2 border-gray-100 text-gray-500 text-xs uppercase tracking-wider bg-gray-50/50">
                                    <th class="py-3.5 px-4 font-bold">Judul</th>
                                    <th class="py-3.5 px-4 font-bold">Kategori</th>
                                    <th class="py-3.5 px-4 font-bold">Diperbarui</th>
                                    <th class="py-3.5 px-4 font-bold">Oleh</th>
                                    <th class="py-3.5 px-4 text-center font-bold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @forelse($newsList as $item)
                                    @php $daysAgo = $item->updated_at->diffInDays(now()); @endphp
                                    <tr class="hover:bg-red-50/30 transition-colors">
                                        <td class="py-4 px-4 font-semibold text-[#0A2540] max-w-xs truncate">{{ $item->title }}</td>
                                        <td class="py-4 px-4">
                                            <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 border border-red-100 text-xs font-semibold px-2.5 py-1 rounded-md">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                                {{ $item->category }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4 text-xs">
                                            <div class="flex items-center gap-1.5">
                                                @if($daysAgo > 30)
                                                    <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                                                    <span class="text-red-600 font-semibold">{{ $daysAgo }} hari lalu</span>
                                                @elseif($daysAgo > 7)
                                                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                                    <span class="text-amber-600 font-medium">{{ $daysAgo }} hari lalu</span>
                                                @else
                                                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                                    <span class="text-gray-500">{{ $item->updated_at->diffForHumans() }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-4 px-4">
                                            @if($item->updatedBy)
                                                <div class="flex items-center gap-2">
                                                    <div class="w-7 h-7 rounded-full bg-gradient-to-br from-red-500 to-red-700 text-white flex items-center justify-center text-[10px] font-bold shadow-sm">
                                                        {{ strtoupper(substr($item->updatedBy->name, 0, 1)) }}
                                                    </div>
                                                    <span class="text-xs font-semibold text-[#0A2540]">{{ $item->updatedBy->name }}</span>
                                                </div>
                                            @else
                                                <span class="text-[10px] text-gray-400 italic">Tidak tercatat</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('news.edit', $item->id) }}"
                                                   class="inline-flex items-center gap-1 text-amber-700 hover:bg-amber-100 font-semibold text-xs bg-amber-50 px-3 py-1.5 rounded-md border border-amber-200 transition-colors">
                                                    Edit
                                                </a>
                                                <form action="{{ route('news.destroy', $item->id) }}" method="POST"
                                                      onsubmit="return confirm('Hapus berita ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center gap-1 text-red-700 hover:bg-red-100 font-semibold text-xs bg-red-50 px-3 py-1.5 rounded-md border border-red-200 transition-colors">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-12 text-center text-gray-400 text-sm">Belum ada berita.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ═══════════════════════════════════════════════════════ --}}
            {{-- DAFTAR TARIF --}}
            {{-- ═══════════════════════════════════════════════════════ --}}
            <div class="bg-white overflow-hidden shadow-md rounded-2xl border border-gray-100">
                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-blue-50/50 to-transparent flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-[#0A2540] flex items-center justify-center shadow-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-[#0A2540]">Dokumen Tarif</h3>
                            <p class="text-xs text-gray-500">Kelola dokumen tarif layanan dalam format PDF</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.tariffs.index') }}"
                       class="inline-flex items-center gap-1 text-sm font-semibold text-[#0A2540] hover:text-red-600 transition-colors">
                        Lihat semua →
                    </a>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b-2 border-gray-100 text-gray-500 text-xs uppercase tracking-wider bg-gray-50/50">
                                    <th class="py-3.5 px-4 font-bold">Judul</th>
                                    <th class="py-3.5 px-4 font-bold">Kategori</th>
                                    <th class="py-3.5 px-4 font-bold">File PDF</th>
                                    <th class="py-3.5 px-4 font-bold">Diperbarui</th>
                                    <th class="py-3.5 px-4 text-center font-bold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @forelse($tariffList as $tariff)
                                    @php $daysAgo = $tariff->updated_at->diffInDays(now()); @endphp
                                    <tr class="hover:bg-blue-50/30 transition-colors">
                                        <td class="py-4 px-4 font-semibold text-[#0A2540] max-w-xs truncate">
                                            {{ $tariff->title }}
                                            @unless($tariff->is_active)
                                                <span class="ml-2 text-[10px] font-semibold text-gray-500 bg-gray-100 border border-gray-200 px-1.5 py-0.5 rounded">
                                                    Disembunyikan
                                                </span>
                                            @endunless
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="inline-flex items-center gap-1 bg-[#0A2540]/5 text-[#0A2540] border border-[#0A2540]/10 text-xs font-semibold px-2.5 py-1 rounded-md">
                                                {{ $tariff->tag }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4">
                                            @if($tariff->hasPdf())
                                                <a href="{{ route('admin.tariffs.preview', $tariff) }}?v={{ $tariff->updated_at?->timestamp }}"
                                                   target="_blank" rel="noopener"
                                                   class="inline-flex items-center gap-1 text-blue-700 hover:text-blue-900 text-xs font-semibold hover:underline">
                                                    Lihat PDF
                                                </a>
                                            @else
                                                <span class="text-[10px] text-red-600 font-semibold bg-red-50 border border-red-100 px-2 py-1 rounded">
                                                    Belum diunggah
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-4 text-xs">
                                            <div class="flex items-center gap-1.5">
                                                @if($daysAgo > 30)
                                                    <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                                                    <span class="text-red-600 font-semibold">{{ $daysAgo }} hari lalu</span>
                                                @elseif($daysAgo > 7)
                                                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                                    <span class="text-amber-600 font-medium">{{ $daysAgo }} hari lalu</span>
                                                @else
                                                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                                    <span class="text-gray-500">{{ $tariff->updated_at->diffForHumans() }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('admin.tariffs.edit', $tariff) }}"
                                                   class="inline-flex items-center gap-1 text-amber-700 hover:bg-amber-100 font-semibold text-xs bg-amber-50 px-3 py-1.5 rounded-md border border-amber-200 transition-colors">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.tariffs.destroy', $tariff) }}" method="POST"
                                                      onsubmit="return confirm('Hapus tarif ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center gap-1 text-red-700 hover:bg-red-100 font-semibold text-xs bg-red-50 px-3 py-1.5 rounded-md border border-red-200 transition-colors">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-12 text-center text-gray-400 text-sm">Belum ada tarif.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>