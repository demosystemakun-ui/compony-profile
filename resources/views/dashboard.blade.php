{{--
    Semua data dikirim dari App\Http\Controllers\DashboardController:
    $isSuperAdmin, $totalNews, $totalTariffs, $totalUsers, $staleNews, $staleTariffs,
    $totalGallery, $totalRoutes, $activeRoutes,
    $lastNewsAgo, $lastTariffAgo, $lastGalleryAgo, $lastRouteAgo,
    $attentionNews, $topCategories, $recentLogs,
    $newsList, $tariffList, $actionColors
--}}
@php
    $age = function ($date) {
        $d = $date ? (int) $date->diffInDays(now()) : 0;
        if ($d > 30) return ['dot' => 'bg-red-500',     'pill' => 'bg-red-50 text-red-700',         'label' => $d . ' days ago'];
        if ($d > 7)  return ['dot' => 'bg-amber-500',   'pill' => 'bg-amber-50 text-amber-800',     'label' => $d . ' days ago'];
        return              ['dot' => 'bg-emerald-500', 'pill' => 'bg-emerald-50 text-emerald-800', 'label' => optional($date)->diffForHumans() ?? '-'];
    };

    $focus     = 'focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#0A2540]';
    $btn       = "inline-flex items-center justify-center rounded-full bg-[#eef5fb] px-3.5 py-1.5 text-xs font-semibold text-[#0A2540] transition hover:bg-[#dce8f5] $focus";
    $btnDanger = "inline-flex items-center justify-center rounded-full bg-red-50 px-3.5 py-1.5 text-xs font-semibold text-red-700 transition hover:bg-red-100 $focus";
    $card      = 'bg-white rounded-2xl shadow-sm border border-slate-100';
    $cardHead  = 'flex items-center justify-between gap-4 px-5 pt-5 pb-3';
    $pillGray  = 'inline-block rounded-full bg-[#eef5fb] px-2.5 py-0.5 text-xs font-semibold text-[#0A2540]';

    $firstName = \Illuminate\Support\Str::before(auth()->user()->name ?? 'there', ' ');

    $stats = [
        ['label' => 'News',            'value' => $totalNews,         'sub' => 'Updated ' . $lastNewsAgo,             'href' => route('admin.news.index'),
         'tint' => 'bg-red-50',  'ic' => 'text-[#EC2029]', 'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2'],
        ['label' => 'Tariffs',         'value' => $totalTariffs,      'sub' => 'Updated ' . $lastTariffAgo,           'href' => route('admin.tariffs.index'),
         'tint' => 'bg-[#e3eefb]', 'ic' => 'text-[#0A2540]', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
        ['label' => 'Gallery',         'value' => $totalGallery ?? 0, 'sub' => 'Updated ' . ($lastGalleryAgo ?? '-'), 'href' => url('/pict-internal-admin-portal/gallery'),
         'tint' => 'bg-red-50',  'ic' => 'text-[#EC2029]', 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
        ['label' => 'Shipping routes', 'value' => $totalRoutes ?? 0,  'sub' => ($activeRoutes ?? 0) . ' active',      'href' => url('/pict-internal-admin-portal/shipping-routes'),
         'tint' => 'bg-[#e3eefb]', 'ic' => 'text-[#0A2540]', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
    ];
    if ($isSuperAdmin) {
        $stats[] = ['label' => 'Users', 'value' => $totalUsers, 'sub' => 'Registered in the system', 'href' => route('users.index'),
                    'tint' => 'bg-red-50', 'ic' => 'text-[#EC2029]', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'];
    }
    $maxCategory = max(1, (int) ($topCategories->max('total') ?? 1));
    $staleTotal  = $staleNews + $staleTariffs;
@endphp

<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-0.5 sm:flex-row sm:items-center sm:gap-6">
            <div>
                <h2 class="text-base sm:text-lg font-bold text-[#0A2540] leading-tight tracking-tight">
                    {{ __('Dashboard - Manage Content') }}
                </h2>
                <p class="text-xs text-slate-500">Summary of activities and published content for PICT</p>
            </div>
            <p class="flex items-center gap-2 text-xs text-slate-500 sm:ml-2">
                <span class="h-2 w-2 shrink-0 rounded-full bg-emerald-500" aria-hidden="true"></span>
                <span id="live-clock" class="tabular-nums text-slate-700">Loading...</span>
            </p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">

        @if(session('success'))
            <div role="status" class="flex items-start gap-3 rounded-xl bg-emerald-50 px-4 py-3 text-sm text-emerald-900 ring-1 ring-emerald-200">
                <svg class="mt-0.5 h-4 w-4 shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        {{-- ═══ BANNER ═══ --}}
        <section class="relative overflow-hidden rounded-2xl bg-[#0A2540] px-5 py-6 sm:px-8 sm:py-7 text-white">
            <div class="flex flex-col gap-3">
                <div>
                    <h3 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Hello, {{ $firstName }}</h3>
                    <p class="mt-1 text-sm text-slate-300">Here is where your content stands today.</p>
                </div>

                @if($staleTotal > 0)
                    <p class="inline-flex w-fit max-w-full items-start gap-2 rounded-lg bg-amber-400/15 px-3 py-2 text-sm text-amber-100 ring-1 ring-amber-300/30">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                        </svg>
                        <span><strong class="font-bold">{{ $staleTotal }} items need an update.</strong> {{ $staleNews }} news and {{ $staleTariffs }} tariffs untouched for over 30 days.</span>
                    </p>
                @else
                    <p class="inline-flex w-fit items-center gap-2 rounded-full bg-emerald-400/15 px-3 py-1.5 text-sm text-emerald-100 ring-1 ring-emerald-300/30">
                        <span class="h-2 w-2 rounded-full bg-emerald-400" aria-hidden="true"></span>
                        All content is up to date
                    </p>
                @endif

                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('news.create') }}"
                       class="inline-flex items-center gap-1.5 rounded-full bg-white px-4 py-1.5 text-sm font-bold text-[#0A2540] transition hover:bg-red-50 {{ $focus }}">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 5v14M5 12h14"/></svg>
                        Add news
                    </a>
                    @foreach([
                        ['Add tariff', route('admin.tariffs.create')],
                        ['Add gallery', url('/pict-internal-admin-portal/gallery')],
                        ['Add shipping route', url('/pict-internal-admin-portal/shipping-routes')],
                    ] as [$text, $href])
                        <a href="{{ $href }}"
                           class="inline-flex items-center rounded-full bg-white/10 px-4 py-1.5 text-sm font-semibold text-white ring-1 ring-white/25 transition hover:bg-white/20 {{ $focus }}">
                            {{ $text }}
                        </a>
                    @endforeach
                    <a href="{{ url('/') }}" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-sm font-semibold text-slate-200 transition hover:text-white {{ $focus }}">
                        View website
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6v6M20 4L10 14"/></svg>
                    </a>
                </div>
            </div>
        </section>

        {{-- ═══ STATISTIK ═══ --}}
        <div class="grid grid-cols-2 md:grid-cols-3 {{ $isSuperAdmin ? 'xl:grid-cols-5' : 'xl:grid-cols-4' }} gap-3 sm:gap-4">
            @foreach($stats as $s)
                <a href="{{ $s['href'] }}"
                   class="group rounded-2xl bg-white p-4 sm:p-5 shadow-sm border border-slate-100 transition hover:-translate-y-0.5 hover:shadow-md {{ $focus }}">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl {{ $s['tint'] }} {{ $s['ic'] }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $s['icon'] }}"/>
                        </svg>
                    </span>
                    <p class="mt-3 text-xs sm:text-sm font-medium text-slate-500">{{ $s['label'] }}</p>
                    <p class="mt-0.5 text-2xl sm:text-3xl font-extrabold tabular-nums tracking-tight text-[#0A2540]">{{ $s['value'] }}</p>
                    <p class="mt-1 text-xs text-slate-400 truncate">{{ $s['sub'] }}</p>
                </a>
            @endforeach
        </div>

        {{-- ═══ KONTEN UTAMA ═══ --}}
        <div class="grid grid-cols-1 {{ $isSuperAdmin ? 'lg:grid-cols-3' : '' }} gap-5">

            {{-- Perlu Perhatian --}}
            <section class="{{ $card }} {{ $isSuperAdmin ? 'lg:col-span-2' : '' }}">
                <div class="{{ $cardHead }}">
                    <div>
                        <h3 class="text-base font-bold text-[#0A2540]">Content requiring attention</h3>
                        <p class="mt-0.5 text-xs text-slate-500">News not updated for more than 30 days</p>
                    </div>
                </div>

                <ul class="space-y-2 px-3 pb-3">
                    @forelse($attentionNews as $item)
                        @php
                            $daysAgo  = $item->updated_at ? (int) $item->updated_at->diffInDays(now()) : 0;
                            $progress = min(100, ($daysAgo / 60) * 100);
                        @endphp
                        <li class="rounded-xl bg-[#f6f9fc] px-4 py-3 hover:bg-[#eef5fb] transition-colors">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-[#0A2540] line-clamp-2 sm:truncate">{{ $item->title }}</p>
                                    <p class="mt-1.5 flex flex-wrap items-center gap-2 text-xs">
                                        <span class="{{ $pillGray }} !bg-white">{{ $item->category }}</span>
                                        <span class="rounded-full px-2 py-0.5 font-semibold {{ $progress > 75 ? 'bg-red-50 text-red-700' : 'bg-amber-50 text-amber-800' }}">{{ $daysAgo }} days ago</span>
                                    </p>
                                </div>
                                <a href="{{ route('news.edit', $item->id) }}" class="{{ $btn }} !bg-white shrink-0 hover:!bg-[#dce8f5]">Update</a>
                            </div>
                            <div class="mt-2.5 h-1 w-full overflow-hidden rounded-full bg-white" aria-hidden="true">
                                <div class="h-full rounded-full {{ $progress > 75 ? 'bg-red-500' : ($progress > 40 ? 'bg-amber-500' : 'bg-emerald-500') }}"
                                     style="width: {{ $progress }}%"></div>
                            </div>
                        </li>
                    @empty
                        <li class="px-5 py-10 text-center">
                            <p class="text-sm font-semibold text-slate-700">All content is up to date</p>
                            <p class="mt-1 text-xs text-slate-500">No news articles need attention right now.</p>
                        </li>
                    @endforelse
                </ul>
            </section>

            {{-- Aktivitas --}}
            @if($isSuperAdmin)
                <section class="{{ $card }}">
                    <div class="{{ $cardHead }}">
                        <div>
                            <h3 class="text-base font-bold text-[#0A2540]">Recent activities</h3>
                            <p class="mt-0.5 text-xs text-slate-500">5 latest logs</p>
                        </div>
                        <a href="{{ route('activity-logs.index') }}" class="shrink-0 rounded-full bg-[#eef5fb] px-3 py-1 text-xs font-semibold text-[#0A2540] transition hover:bg-[#dce8f5] {{ $focus }}">View all</a>
                    </div>

                    <ul class="px-5 pb-3">
                        @forelse($recentLogs as $log)
                            @php $color = $actionColors[$log->action] ?? 'bg-slate-50 text-slate-700 border-slate-200'; @endphp
                            <li class="flex items-start gap-3 py-2.5 {{ $loop->last ? '' : 'border-b border-slate-100' }}">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#0A2540] text-[11px] font-bold text-white" aria-hidden="true">
                                    {{ strtoupper(substr($log->user->name ?? 'S', 0, 1)) }}
                                </span>
                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-wrap items-center gap-x-2 gap-y-1">
                                        <p class="text-sm font-semibold text-[#0A2540]">{{ $log->user->name ?? 'System' }}</p>
                                        <span class="rounded-full border px-2 py-0.5 text-xs font-semibold capitalize {{ $color }}">{{ $log->action }}</span>
                                    </div>
                                    <p class="mt-0.5 text-xs text-slate-600 line-clamp-2">{{ $log->description }}</p>
                                    <p class="mt-0.5 text-xs text-slate-400">{{ optional($log->created_at)->diffForHumans() ?? '-' }}</p>
                                </div>
                            </li>
                        @empty
                            <li class="py-10 text-center text-sm text-slate-500">No recent activities.</li>
                        @endforelse
                    </ul>
                </section>
            @endif
        </div>

        {{-- ═══ KATEGORI TERATAS ═══ --}}
        @if($topCategories->count() > 0)
            <section class="{{ $card }} pb-4">
                <div class="{{ $cardHead }}">
                    <div>
                        <h3 class="text-base font-bold text-[#0A2540]">Top news categories</h3>
                        <p class="mt-0.5 text-xs text-slate-500">5 categories with the most news</p>
                    </div>
                </div>
                <ul class="grid gap-x-10 gap-y-4 px-5 pb-2 sm:grid-cols-2">
                    @foreach($topCategories as $cat)
                        <li>
                            <div class="flex items-baseline justify-between gap-3 text-sm">
                                <span class="truncate font-medium text-slate-700">{{ $cat->category }}</span>
                                <span class="font-bold tabular-nums text-[#0A2540]">{{ $cat->total }}</span>
                            </div>
                            <div class="mt-1.5 h-2 overflow-hidden rounded-full bg-[#eef5fb]" aria-hidden="true">
                                <div class="h-full rounded-full {{ $loop->first ? 'bg-[#EC2029]' : 'bg-[#0A2540]' }}" style="width: {{ ($cat->total / $maxCategory) * 100 }}%"></div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif

        {{-- ═══ DAFTAR BERITA ═══ --}}
        <section class="{{ $card }} overflow-hidden">
            <div class="{{ $cardHead }}">
                <div>
                    <h3 class="text-base font-bold text-[#0A2540]">Published news</h3>
                    <p class="mt-0.5 text-xs text-slate-500">Articles shown on the website</p>
                </div>
                <a href="{{ route('admin.news.index') }}" class="shrink-0 rounded-full bg-[#eef5fb] px-3 py-1 text-xs font-semibold text-[#0A2540] transition hover:bg-[#dce8f5] {{ $focus }}">View all</a>
            </div>

            <div class="hidden md:block overflow-x-auto px-3 pb-3">
                <table class="w-full text-left text-sm">
                    <thead class="text-xs text-slate-500">
                        <tr class="bg-[#f6f9fc]">
                            <th scope="col" class="rounded-l-xl px-4 py-2.5 font-semibold">Title</th>
                            <th scope="col" class="px-3 py-2.5 font-semibold">Category</th>
                            <th scope="col" class="px-3 py-2.5 font-semibold">Updated</th>
                            <th scope="col" class="px-3 py-2.5 font-semibold">Author</th>
                            <th scope="col" class="rounded-r-xl px-4 py-2.5 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($newsList as $item)
                            @php $a = $age($item->updated_at); @endphp
                            <tr class="hover:bg-[#f6f9fc] transition-colors">
                                <td class="max-w-xs truncate px-4 py-3 font-semibold text-[#0A2540]">{{ $item->title }}</td>
                                <td class="px-3 py-3"><span class="{{ $pillGray }}">{{ $item->category }}</span></td>
                                <td class="px-3 py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold {{ $a['pill'] }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $a['dot'] }}" aria-hidden="true"></span>{{ $a['label'] }}
                                    </span>
                                </td>
                                <td class="px-3 py-3">
                                    @if($item->updatedBy)
                                        <span class="inline-flex items-center gap-2 font-medium text-slate-700">
                                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-[#0A2540] text-[10px] font-bold text-white" aria-hidden="true">{{ strtoupper(substr($item->updatedBy->name, 0, 1)) }}</span>
                                            {{ $item->updatedBy->name }}
                                        </span>
                                    @else
                                        <span class="text-xs italic text-slate-400">Not recorded</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('news.edit', $item->id) }}" class="{{ $btn }}">Edit</a>
                                        <form action="{{ route('news.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus berita ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="{{ $btnDanger }}">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center text-slate-500">
                                    No news yet. <a href="{{ route('news.create') }}" class="font-semibold text-[#0A2540] underline">Add the first article</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <ul class="md:hidden space-y-3 px-3 pb-3">
                @forelse($newsList as $item)
                    @php $a = $age($item->updated_at); @endphp
                    <li class="rounded-xl bg-[#f6f9fc] p-3.5">
                        <p class="text-sm font-semibold text-[#0A2540] line-clamp-2">{{ $item->title }}</p>
                        <div class="mt-2 flex flex-wrap items-center gap-2 text-xs">
                            <span class="{{ $pillGray }} !bg-white">{{ $item->category }}</span>
                            <span class="inline-flex items-center gap-1.5 rounded-full px-2 py-0.5 font-semibold {{ $a['pill'] }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ $a['dot'] }}" aria-hidden="true"></span>{{ $a['label'] }}
                            </span>
                        </div>
                        @if($item->updatedBy)
                            <p class="mt-2 text-xs text-slate-500">Updated by {{ $item->updatedBy->name }}</p>
                        @endif
                        <div class="mt-3 flex gap-2">
                            <a href="{{ route('news.edit', $item->id) }}" class="{{ $btn }} !bg-white flex-1">Edit</a>
                            <form action="{{ route('news.destroy', $item->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Hapus berita ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="{{ $btnDanger }} w-full">Delete</button>
                            </form>
                        </div>
                    </li>
                @empty
                    <li class="px-4 py-10 text-center text-sm text-slate-500">
                        No news yet. <a href="{{ route('news.create') }}" class="font-semibold text-[#0A2540] underline">Add the first article</a>
                    </li>
                @endforelse
            </ul>
        </section>

        {{-- ═══ DAFTAR TARIF ═══ --}}
        <section class="{{ $card }} overflow-hidden">
            <div class="{{ $cardHead }}">
                <div>
                    <h3 class="text-base font-bold text-[#0A2540]">Tariff documents</h3>
                    <p class="mt-0.5 text-xs text-slate-500">Service tariffs in PDF format</p>
                </div>
                <a href="{{ route('admin.tariffs.index') }}" class="shrink-0 rounded-full bg-[#eef5fb] px-3 py-1 text-xs font-semibold text-[#0A2540] transition hover:bg-[#dce8f5] {{ $focus }}">View all</a>
            </div>

            <div class="hidden md:block overflow-x-auto px-3 pb-3">
                <table class="w-full text-left text-sm">
                    <thead class="text-xs text-slate-500">
                        <tr class="bg-[#f6f9fc]">
                            <th scope="col" class="rounded-l-xl px-4 py-2.5 font-semibold">Title</th>
                            <th scope="col" class="px-3 py-2.5 font-semibold">Category</th>
                            <th scope="col" class="px-3 py-2.5 font-semibold">PDF file</th>
                            <th scope="col" class="px-3 py-2.5 font-semibold">Updated</th>
                            <th scope="col" class="rounded-r-xl px-4 py-2.5 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($tariffList as $tariff)
                            @php $a = $age($tariff->updated_at); @endphp
                            <tr class="hover:bg-[#f6f9fc] transition-colors">
                                <td class="max-w-xs truncate px-4 py-3 font-semibold text-[#0A2540]">
                                    {{ $tariff->title }}
                                    @unless($tariff->is_active)
                                        <span class="ml-2 rounded-full bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-500">Hidden</span>
                                    @endunless
                                </td>
                                <td class="px-3 py-3"><span class="{{ $pillGray }}">{{ $tariff->tag }}</span></td>
                                <td class="px-3 py-3">
                                    @if($tariff->hasPdf())
                                        <a href="{{ route('admin.tariffs.preview', $tariff) }}?v={{ $tariff->updated_at?->timestamp }}"
                                           target="_blank" rel="noopener"
                                           class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#0A2540] hover:text-[#EC2029]">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            View PDF
                                        </a>
                                    @else
                                        <span class="rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700">Not uploaded</span>
                                    @endif
                                </td>
                                <td class="px-3 py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold {{ $a['pill'] }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $a['dot'] }}" aria-hidden="true"></span>{{ $a['label'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.tariffs.edit', $tariff) }}" class="{{ $btn }}">Edit</a>
                                        <form action="{{ route('admin.tariffs.destroy', $tariff) }}" method="POST" onsubmit="return confirm('Delete this tariff?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="{{ $btnDanger }}">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center text-slate-500">
                                    No tariffs yet. <a href="{{ route('admin.tariffs.create') }}" class="font-semibold text-[#0A2540] underline">Add the first tariff</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <ul class="md:hidden space-y-3 px-3 pb-3">
                @forelse($tariffList as $tariff)
                    @php $a = $age($tariff->updated_at); @endphp
                    <li class="rounded-xl bg-[#f6f9fc] p-3.5">
                        <div class="flex items-start justify-between gap-3">
                            <p class="text-sm font-semibold text-[#0A2540] line-clamp-2">{{ $tariff->title }}</p>
                            @unless($tariff->is_active)
                                <span class="shrink-0 rounded-full bg-white px-2 py-0.5 text-xs font-semibold text-slate-500">Hidden</span>
                            @endunless
                        </div>
                        <div class="mt-2 flex flex-wrap items-center gap-2 text-xs">
                            <span class="{{ $pillGray }} !bg-white">{{ $tariff->tag }}</span>
                            <span class="inline-flex items-center gap-1.5 rounded-full px-2 py-0.5 font-semibold {{ $a['pill'] }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ $a['dot'] }}" aria-hidden="true"></span>{{ $a['label'] }}
                            </span>
                            @if($tariff->hasPdf())
                                <a href="{{ route('admin.tariffs.preview', $tariff) }}?v={{ $tariff->updated_at?->timestamp }}"
                                   target="_blank" rel="noopener"
                                   class="font-semibold text-[#0A2540] underline underline-offset-2">View PDF</a>
                            @else
                                <span class="rounded-full bg-red-50 px-2.5 py-1 font-semibold text-red-700">Not uploaded</span>
                            @endif
                        </div>
                        <div class="mt-3 flex gap-2">
                            <a href="{{ route('admin.tariffs.edit', $tariff) }}" class="{{ $btn }} !bg-white flex-1">Edit</a>
                            <form action="{{ route('admin.tariffs.destroy', $tariff) }}" method="POST" class="flex-1" onsubmit="return confirm('Delete this tariff?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="{{ $btnDanger }} w-full">Delete</button>
                            </form>
                        </div>
                    </li>
                @empty
                    <li class="px-4 py-10 text-center text-sm text-slate-500">
                        No tariffs yet. <a href="{{ route('admin.tariffs.create') }}" class="font-semibold text-[#0A2540] underline">Add the first tariff</a>
                    </li>
                @endforelse
            </ul>
        </section>

    </div>

    @push('scripts')
    <script>
        function updateRealTimeClock() {
            const el = document.getElementById('live-clock');
            if (!el) return;
            const now = new Date();
            el.innerText = now.toLocaleDateString('id-ID', {
                weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
                hour: '2-digit', minute: '2-digit', second: '2-digit'
            });
        }
        setInterval(updateRealTimeClock, 1000);
        updateRealTimeClock();
    </script>
    @endpush
</x-admin-layout>