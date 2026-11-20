{{--
    Semua data dikirim dari App\Http\Controllers\DashboardController:
    $isSuperAdmin, $totalNews, $totalTariffs, $totalUsers, $staleNews, $staleTariffs,
    $totalGallery, $totalRoutes, $activeRoutes,
    $lastNewsAgo, $lastTariffAgo, $lastGalleryAgo, $lastRouteAgo,
    $attentionNews, $topCategories, $recentLogs,
    $newsList, $tariffList, $actionColors
--}}
@php
    /* Umur konten: >30 hari merah, >7 hari kuning, selebihnya hijau */
    $age = function ($date) {
        $d = $date ? (int) $date->diffInDays(now()) : 0;
        if ($d > 30) return ['dot' => 'bg-red-500',     'text' => 'text-red-600 font-medium',   'label' => $d . ' days ago'];
        if ($d > 7)  return ['dot' => 'bg-amber-500',   'text' => 'text-amber-700',             'label' => $d . ' days ago'];
        return              ['dot' => 'bg-emerald-500', 'text' => 'text-slate-500',             'label' => optional($date)->diffForHumans() ?? '-'];
    };

    $btn      = 'inline-flex items-center justify-center rounded-md border border-slate-300 bg-white px-3 py-1.5 text-sm font-medium text-slate-700 hover:bg-slate-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#0A2540]';
    $btnDanger = 'inline-flex items-center justify-center rounded-md border border-slate-300 bg-white px-3 py-1.5 text-sm font-medium text-red-700 hover:bg-red-50 hover:border-red-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600';
    $card     = 'bg-white rounded-xl border border-slate-200';
    $cardHead = 'flex items-start justify-between gap-4 px-4 sm:px-5 py-4 border-b border-slate-200';
    $pill     = 'inline-block rounded bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-700';

    $stats = [
        ['label' => 'News',            'value' => $totalNews,           'sub' => 'Updated ' . $lastNewsAgo,                 'href' => route('admin.news.index')],
        ['label' => 'Tariffs',         'value' => $totalTariffs,        'sub' => 'Updated ' . $lastTariffAgo,               'href' => route('admin.tariffs.index')],
        ['label' => 'Gallery',         'value' => $totalGallery ?? 0,   'sub' => 'Updated ' . ($lastGalleryAgo ?? '-'),     'href' => url('/pict-internal-admin-portal/gallery')],
        ['label' => 'Shipping routes', 'value' => $totalRoutes ?? 0,    'sub' => ($activeRoutes ?? 0) . ' active',          'href' => url('/pict-internal-admin-portal/shipping-routes')],
    ];
    if ($isSuperAdmin) {
        $stats[] = ['label' => 'Users', 'value' => $totalUsers, 'sub' => 'Registered in the system', 'href' => route('users.index')];
    }
    $maxCategory = max(1, (int) ($topCategories->max('total') ?? 1));
@endphp

<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-[#0A2540] leading-tight tracking-tight">
                    {{ __('Dashboard - Manage Content') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Summary of activities and published content for PICT</p>
            </div>
            <p class="flex items-center gap-2 text-xs sm:text-sm text-slate-500">
                <span class="h-2 w-2 shrink-0 rounded-full bg-emerald-500" aria-hidden="true"></span>
                <span id="live-clock" class="tabular-nums text-slate-700">Loading...</span>
            </p>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5 sm:space-y-6">

            @if(session('success'))
                <div role="status" class="flex items-start gap-3 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">
                    <svg class="mt-0.5 h-4 w-4 shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            {{-- Konten perlu update --}}
            @if($staleNews + $staleTariffs > 0)
                <div role="alert" class="flex items-start gap-3 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm">
                    <svg class="mt-0.5 h-4 w-4 shrink-0 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                    <p class="text-amber-900">
                        <span class="font-semibold">{{ $staleNews + $staleTariffs }} items need an update.</span>
                        {{ $staleNews }} news articles and {{ $staleTariffs }} tariffs have not been updated for more than 30 days.
                    </p>
                </div>
            @endif

            {{-- ═══ STATISTIK: satu strip, bukan lima kartu ═══ --}}
            <div class="{{ $card }} overflow-hidden">
                <div class="grid grid-cols-2 {{ $isSuperAdmin ? 'lg:grid-cols-5' : 'lg:grid-cols-4' }} gap-px bg-slate-200">
                    @foreach($stats as $s)
                        <a href="{{ $s['href'] }}"
                           class="bg-white px-4 py-4 sm:px-5 sm:py-5 hover:bg-slate-50 focus-visible:outline focus-visible:outline-2 focus-visible:-outline-offset-2 focus-visible:outline-[#0A2540]
                                  {{ $isSuperAdmin && $loop->last ? 'col-span-2 lg:col-span-1' : '' }}">
                            <p class="text-sm text-slate-500">{{ $s['label'] }}</p>
                            <p class="mt-1 text-2xl sm:text-3xl font-semibold tabular-nums text-[#0A2540]">{{ $s['value'] }}</p>
                            <p class="mt-1 text-xs text-slate-400 truncate">{{ $s['sub'] }}</p>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- ═══ AKSI CEPAT ═══ --}}
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('news.create') }}"
                   class="inline-flex items-center gap-1.5 rounded-md bg-[#0A2540] px-3.5 py-2 text-sm font-medium text-white hover:bg-[#0d3159] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#0A2540]">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14M5 12h14"/></svg>
                    Add news
                </a>
                <a href="{{ route('admin.tariffs.create') }}" class="{{ $btn }} !py-2 !px-3.5">Add tariff</a>
                <a href="{{ url('/pict-internal-admin-portal/gallery') }}" class="{{ $btn }} !py-2 !px-3.5">Add gallery</a>
                <a href="{{ url('/pict-internal-admin-portal/shipping-routes') }}" class="{{ $btn }} !py-2 !px-3.5">Add shipping route</a>
                <a href="{{ url('/') }}" target="_blank" rel="noopener"
                   class="ml-auto inline-flex items-center gap-1 px-1 py-2 text-sm font-medium text-slate-600 hover:text-[#0A2540] hover:underline">
                    View website
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6v6M20 4L10 14"/></svg>
                </a>
            </div>

            {{-- ═══ PERLU PERHATIAN + AKTIVITAS ═══ --}}
            <div class="grid grid-cols-1 {{ $isSuperAdmin ? 'lg:grid-cols-5' : '' }} gap-5 sm:gap-6">

                <section class="{{ $card }} {{ $isSuperAdmin ? 'lg:col-span-3' : '' }}">
                    <div class="{{ $cardHead }}">
                        <div>
                            <h3 class="text-base font-semibold text-[#0A2540]">Content requiring attention</h3>
                            <p class="mt-0.5 text-sm text-slate-500">News not updated for more than 30 days</p>
                        </div>
                    </div>

                    <ul class="divide-y divide-slate-100">
                        @forelse($attentionNews as $item)
                            @php
                                $daysAgo  = $item->updated_at ? (int) $item->updated_at->diffInDays(now()) : 0;
                                $progress = min(100, ($daysAgo / 60) * 100);
                            @endphp
                            <li class="px-4 sm:px-5 py-3.5">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-[#0A2540] line-clamp-2 sm:truncate">{{ $item->title }}</p>
                                        <p class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-0.5 text-xs text-slate-500">
                                            <span>{{ $item->category }}</span>
                                            <span>{{ $daysAgo }} days ago</span>
                                        </p>
                                    </div>
                                    <a href="{{ route('news.edit', $item->id) }}" class="{{ $btn }} shrink-0">Update</a>
                                </div>
                                <div class="mt-3 h-1 w-full overflow-hidden rounded-full bg-slate-100" aria-hidden="true">
                                    <div class="h-full rounded-full {{ $progress > 75 ? 'bg-red-500' : ($progress > 40 ? 'bg-amber-500' : 'bg-emerald-500') }}"
                                         style="width: {{ $progress }}%"></div>
                                </div>
                            </li>
                        @empty
                            <li class="px-5 py-10 text-center">
                                <p class="text-sm font-medium text-slate-700">All content is up to date</p>
                                <p class="mt-1 text-sm text-slate-500">No news articles need attention right now.</p>
                            </li>
                        @endforelse
                    </ul>
                </section>

                @if($isSuperAdmin)
                    <section class="{{ $card }} lg:col-span-2">
                        <div class="{{ $cardHead }}">
                            <div>
                                <h3 class="text-base font-semibold text-[#0A2540]">Recent activities</h3>
                                <p class="mt-0.5 text-sm text-slate-500">5 latest logs from all users</p>
                            </div>
                            <a href="{{ route('activity-logs.index') }}" class="shrink-0 text-sm font-medium text-[#0A2540] hover:underline">View all</a>
                        </div>

                        <ul class="divide-y divide-slate-100">
                            @forelse($recentLogs as $log)
                                @php $color = $actionColors[$log->action] ?? 'bg-slate-50 text-slate-700 border-slate-200'; @endphp
                                <li class="flex items-start gap-3 px-4 sm:px-5 py-3.5">
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#0A2540] text-xs font-semibold text-white" aria-hidden="true">
                                        {{ strtoupper(substr($log->user->name ?? 'S', 0, 1)) }}
                                    </span>
                                    <div class="min-w-0 flex-1">
                                        <div class="flex flex-wrap items-center gap-x-2 gap-y-1">
                                            <p class="text-sm font-medium text-[#0A2540]">{{ $log->user->name ?? 'System' }}</p>
                                            <span class="rounded border px-1.5 py-0.5 text-xs font-medium capitalize {{ $color }}">{{ $log->action }}</span>
                                        </div>
                                        <p class="mt-0.5 text-sm text-slate-600 line-clamp-2">{{ $log->description }}</p>
                                        <p class="mt-0.5 text-xs text-slate-400">{{ optional($log->created_at)->diffForHumans() ?? '-' }}</p>
                                    </div>
                                </li>
                            @empty
                                <li class="px-5 py-10 text-center text-sm text-slate-500">No recent activities.</li>
                            @endforelse
                        </ul>
                    </section>
                @endif
            </div>

            {{-- ═══ KATEGORI TERATAS: bar proporsional, bukan lima kotak ═══ --}}
            @if($topCategories->count() > 0)
                <section class="{{ $card }}">
                    <div class="{{ $cardHead }}">
                        <div>
                            <h3 class="text-base font-semibold text-[#0A2540]">Top news categories</h3>
                            <p class="mt-0.5 text-sm text-slate-500">The 5 categories with the most news</p>
                        </div>
                    </div>
                    <ul class="grid gap-x-10 gap-y-4 px-4 py-5 sm:px-5 sm:grid-cols-2">
                        @foreach($topCategories as $cat)
                            <li>
                                <div class="flex items-baseline justify-between gap-3 text-sm">
                                    <span class="truncate text-slate-700">{{ $cat->category }}</span>
                                    <span class="font-semibold tabular-nums text-[#0A2540]">{{ $cat->total }}</span>
                                </div>
                                <div class="mt-1.5 h-1.5 overflow-hidden rounded-full bg-slate-100" aria-hidden="true">
                                    <div class="h-full rounded-full bg-[#0A2540]" style="width: {{ ($cat->total / $maxCategory) * 100 }}%"></div>
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
                        <h3 class="text-base font-semibold text-[#0A2540]">Published news</h3>
                        <p class="mt-0.5 text-sm text-slate-500">Articles shown on the website</p>
                    </div>
                    <a href="{{ route('admin.news.index') }}" class="shrink-0 text-sm font-medium text-[#0A2540] hover:underline">View all</a>
                </div>

                {{-- Desktop: tabel --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="border-b border-slate-200 bg-slate-50 text-xs font-medium text-slate-500">
                            <tr>
                                <th scope="col" class="px-5 py-3 font-medium">Title</th>
                                <th scope="col" class="px-3 py-3 font-medium">Category</th>
                                <th scope="col" class="px-3 py-3 font-medium">Updated</th>
                                <th scope="col" class="px-3 py-3 font-medium">Author</th>
                                <th scope="col" class="px-5 py-3 text-right font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($newsList as $item)
                                @php $a = $age($item->updated_at); @endphp
                                <tr class="hover:bg-slate-50">
                                    <td class="max-w-xs truncate px-5 py-3.5 font-medium text-[#0A2540]">{{ $item->title }}</td>
                                    <td class="px-3 py-3.5"><span class="{{ $pill }}">{{ $item->category }}</span></td>
                                    <td class="px-3 py-3.5 text-xs whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1.5 {{ $a['text'] }}">
                                            <span class="h-2 w-2 rounded-full {{ $a['dot'] }}" aria-hidden="true"></span>{{ $a['label'] }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-3.5">
                                        @if($item->updatedBy)
                                            <span class="inline-flex items-center gap-2 text-slate-700">
                                                <span class="flex h-6 w-6 items-center justify-center rounded-full bg-slate-200 text-[11px] font-semibold text-slate-700" aria-hidden="true">{{ strtoupper(substr($item->updatedBy->name, 0, 1)) }}</span>
                                                {{ $item->updatedBy->name }}
                                            </span>
                                        @else
                                            <span class="text-xs italic text-slate-400">Not recorded</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5">
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
                                    <td colspan="5" class="px-5 py-12 text-center text-slate-500">
                                        No news yet. <a href="{{ route('news.create') }}" class="font-medium text-[#0A2540] underline">Add the first article</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Mobile: daftar bertumpuk --}}
                <ul class="md:hidden divide-y divide-slate-100">
                    @forelse($newsList as $item)
                        @php $a = $age($item->updated_at); @endphp
                        <li class="px-4 py-4">
                            <p class="text-sm font-medium text-[#0A2540] line-clamp-2">{{ $item->title }}</p>
                            <div class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-1.5 text-xs">
                                <span class="{{ $pill }}">{{ $item->category }}</span>
                                <span class="inline-flex items-center gap-1.5 {{ $a['text'] }}">
                                    <span class="h-2 w-2 rounded-full {{ $a['dot'] }}" aria-hidden="true"></span>{{ $a['label'] }}
                                </span>
                                @if($item->updatedBy)
                                    <span class="text-slate-500">by {{ $item->updatedBy->name }}</span>
                                @endif
                            </div>
                            <div class="mt-3 flex gap-2">
                                <a href="{{ route('news.edit', $item->id) }}" class="{{ $btn }} flex-1">Edit</a>
                                <form action="{{ route('news.destroy', $item->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Hapus berita ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="{{ $btnDanger }} w-full">Delete</button>
                                </form>
                            </div>
                        </li>
                    @empty
                        <li class="px-4 py-10 text-center text-sm text-slate-500">
                            No news yet. <a href="{{ route('news.create') }}" class="font-medium text-[#0A2540] underline">Add the first article</a>
                        </li>
                    @endforelse
                </ul>
            </section>

            {{-- ═══ DAFTAR TARIF ═══ --}}
            <section class="{{ $card }} overflow-hidden">
                <div class="{{ $cardHead }}">
                    <div>
                        <h3 class="text-base font-semibold text-[#0A2540]">Tariff documents</h3>
                        <p class="mt-0.5 text-sm text-slate-500">Service tariffs in PDF format</p>
                    </div>
                    <a href="{{ route('admin.tariffs.index') }}" class="shrink-0 text-sm font-medium text-[#0A2540] hover:underline">View all</a>
                </div>

                {{-- Desktop: tabel --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="border-b border-slate-200 bg-slate-50 text-xs font-medium text-slate-500">
                            <tr>
                                <th scope="col" class="px-5 py-3 font-medium">Title</th>
                                <th scope="col" class="px-3 py-3 font-medium">Category</th>
                                <th scope="col" class="px-3 py-3 font-medium">PDF file</th>
                                <th scope="col" class="px-3 py-3 font-medium">Updated</th>
                                <th scope="col" class="px-5 py-3 text-right font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($tariffList as $tariff)
                                @php $a = $age($tariff->updated_at); @endphp
                                <tr class="hover:bg-slate-50">
                                    <td class="max-w-xs truncate px-5 py-3.5 font-medium text-[#0A2540]">
                                        {{ $tariff->title }}
                                        @unless($tariff->is_active)
                                            <span class="ml-2 rounded border border-slate-200 bg-slate-100 px-1.5 py-0.5 text-xs font-medium text-slate-500">Hidden</span>
                                        @endunless
                                    </td>
                                    <td class="px-3 py-3.5"><span class="{{ $pill }}">{{ $tariff->tag }}</span></td>
                                    <td class="px-3 py-3.5">
                                        @if($tariff->hasPdf())
                                            <a href="{{ route('admin.tariffs.preview', $tariff) }}?v={{ $tariff->updated_at?->timestamp }}"
                                               target="_blank" rel="noopener"
                                               class="text-sm font-medium text-[#0A2540] underline decoration-slate-300 underline-offset-2 hover:decoration-[#0A2540]">View PDF</a>
                                        @else
                                            <span class="text-xs font-medium text-red-600">Not uploaded</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-3.5 text-xs whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1.5 {{ $a['text'] }}">
                                            <span class="h-2 w-2 rounded-full {{ $a['dot'] }}" aria-hidden="true"></span>{{ $a['label'] }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5">
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
                                    <td colspan="5" class="px-5 py-12 text-center text-slate-500">
                                        No tariffs yet. <a href="{{ route('admin.tariffs.create') }}" class="font-medium text-[#0A2540] underline">Add the first tariff</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Mobile: daftar bertumpuk --}}
                <ul class="md:hidden divide-y divide-slate-100">
                    @forelse($tariffList as $tariff)
                        @php $a = $age($tariff->updated_at); @endphp
                        <li class="px-4 py-4">
                            <div class="flex items-start justify-between gap-3">
                                <p class="text-sm font-medium text-[#0A2540] line-clamp-2">{{ $tariff->title }}</p>
                                @unless($tariff->is_active)
                                    <span class="shrink-0 rounded border border-slate-200 bg-slate-100 px-1.5 py-0.5 text-xs font-medium text-slate-500">Hidden</span>
                                @endunless
                            </div>
                            <div class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-1.5 text-xs">
                                <span class="{{ $pill }}">{{ $tariff->tag }}</span>
                                <span class="inline-flex items-center gap-1.5 {{ $a['text'] }}">
                                    <span class="h-2 w-2 rounded-full {{ $a['dot'] }}" aria-hidden="true"></span>{{ $a['label'] }}
                                </span>
                                @if($tariff->hasPdf())
                                    <a href="{{ route('admin.tariffs.preview', $tariff) }}?v={{ $tariff->updated_at?->timestamp }}"
                                       target="_blank" rel="noopener"
                                       class="font-medium text-[#0A2540] underline underline-offset-2">View PDF</a>
                                @else
                                    <span class="font-medium text-red-600">Not uploaded</span>
                                @endif
                            </div>
                            <div class="mt-3 flex gap-2">
                                <a href="{{ route('admin.tariffs.edit', $tariff) }}" class="{{ $btn }} flex-1">Edit</a>
                                <form action="{{ route('admin.tariffs.destroy', $tariff) }}" method="POST" class="flex-1" onsubmit="return confirm('Delete this tariff?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="{{ $btnDanger }} w-full">Delete</button>
                                </form>
                            </div>
                        </li>
                    @empty
                        <li class="px-4 py-10 text-center text-sm text-slate-500">
                            No tariffs yet. <a href="{{ route('admin.tariffs.create') }}" class="font-medium text-[#0A2540] underline">Add the first tariff</a>
                        </li>
                    @endforelse
                </ul>
            </section>

        </div>
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