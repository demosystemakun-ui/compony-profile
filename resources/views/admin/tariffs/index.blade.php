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
    $pillGray  = 'inline-block rounded-full bg-[#eef5fb] px-2.5 py-0.5 text-xs font-semibold text-[#0A2540]';
@endphp

<x-admin-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-base sm:text-lg font-bold text-[#0A2540] leading-tight tracking-tight">
                {{ __('Tariffs Document') }}
            </h2>
            <p class="text-xs text-slate-500">Manage and organize PICT service tariff files</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Notifikasi Sukses --}}
        @if(session('success'))
            <div role="status" class="flex items-start gap-3 rounded-xl bg-emerald-50 px-4 py-3 text-sm text-emerald-900 ring-1 ring-emerald-200">
                <svg class="mt-0.5 h-4 w-4 shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <section class="{{ $card }} overflow-hidden">

            {{-- Top Bar: Title, Search, Filter, Add Button --}}
            <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4 px-5 pt-5 pb-4">
                <div>
                    <h3 class="text-base font-bold text-[#0A2540]">Tariff documents</h3>
                    <p class="mt-0.5 text-xs text-slate-500">Service tariffs in PDF format</p>
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 w-full xl:w-auto">
                    <form action="{{ route('admin.tariffs.index') }}" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 w-full sm:w-auto m-0">
                        {{-- Search Bar --}}
                        <div class="relative w-full sm:w-56">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   class="block w-full rounded-full border border-slate-200 bg-[#f6f9fc] py-1.5 pl-9 pr-3.5 text-xs font-medium text-[#0A2540] placeholder-slate-400 transition focus:border-[#0A2540] focus:bg-white focus:outline-none"
                                   placeholder="Search title... (Enter)">
                        </div>

                        {{-- Filter Kategori --}}
                        <select name="tag"
                                onchange="this.form.submit()"
                                class="cursor-pointer rounded-full border border-slate-200 bg-[#f6f9fc] px-3.5 py-1.5 text-xs font-semibold text-[#0A2540] transition hover:bg-[#eef5fb] focus:border-[#0A2540] focus:outline-none">
                            <option value="">All categories</option>
                            @foreach(\App\Models\Tariff::TAGS as $tag)
                                <option value="{{ $tag }}" @selected(request('tag') == $tag)>{{ $tag }}</option>
                            @endforeach
                        </select>

                        {{-- Filter Status --}}
                        <select name="status"
                                onchange="this.form.submit()"
                                class="cursor-pointer rounded-full border border-slate-200 bg-[#f6f9fc] px-3.5 py-1.5 text-xs font-semibold text-[#0A2540] transition hover:bg-[#eef5fb] focus:border-[#0A2540] focus:outline-none">
                            <option value="">All statuses</option>
                            <option value="active" @selected(request('status') == 'active')>Active</option>
                            <option value="inactive" @selected(request('status') == 'inactive')>Hidden</option>
                        </select>

                        @if(request()->anyFilled(['search', 'tag', 'status']))
                            <a href="{{ route('admin.tariffs.index') }}"
                               class="inline-flex items-center justify-center rounded-full px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-50 transition {{ $focus }}">
                                Reset
                            </a>
                        @endif
                    </form>

                    <a href="{{ route('admin.tariffs.create') }}"
                       class="inline-flex items-center justify-center gap-1.5 rounded-full bg-[#0A2540] px-4 py-1.5 text-xs font-bold text-white transition hover:bg-[#13385e] shrink-0 {{ $focus }}">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 5v14M5 12h14"/>
                        </svg>
                        Add tariff
                    </a>
                </div>
            </div>

            {{-- Tabel (Desktop) --}}
            <div class="hidden md:block overflow-x-auto px-3 pb-3">
                <table class="w-full text-left text-sm">
                    <thead class="text-xs text-slate-500">
                        <tr class="bg-[#f6f9fc]">
                            <th scope="col" class="rounded-l-xl px-4 py-2.5 font-semibold">Order</th>
                            <th scope="col" class="px-3 py-2.5 font-semibold">Title</th>
                            <th scope="col" class="px-3 py-2.5 font-semibold">Category</th>
                            <th scope="col" class="px-3 py-2.5 font-semibold">PDF file</th>
                            <th scope="col" class="px-3 py-2.5 font-semibold">Status</th>
                            <th scope="col" class="px-3 py-2.5 font-semibold">Updated</th>
                            <th scope="col" class="rounded-r-xl px-4 py-2.5 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($tariffs as $item)
                            @php $a = $age($item->updated_at); @endphp
                            <tr class="hover:bg-[#f6f9fc] transition-colors">
                                <td class="px-4 py-3">
                                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-[#eef5fb] text-xs font-bold tabular-nums text-[#0A2540]">
                                        {{ $item->sort_order }}
                                    </span>
                                </td>
                                <td class="max-w-xs px-3 py-3">
                                    <p class="truncate font-semibold text-[#0A2540]">{{ $item->title }}</p>
                                    @if($item->description)
                                        <p class="mt-0.5 truncate text-xs text-slate-400" title="{{ $item->description }}">{{ $item->description }}</p>
                                    @endif
                                </td>
                                <td class="px-3 py-3">
                                    <span class="{{ $pillGray }}">{{ $item->tag }}</span>
                                </td>
                                <td class="px-3 py-3 whitespace-nowrap">
                                    @if($item->hasPdf())
                                        <a href="{{ route('admin.tariffs.preview', $item) }}?v={{ $item->updated_at?->timestamp }}"
                                           target="_blank" rel="noopener"
                                           class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#0A2540] hover:text-[#EC2029]">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            View PDF
                                        </a>
                                    @else
                                        <span class="rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700">Not uploaded</span>
                                    @endif
                                </td>
                                <td class="px-3 py-3 whitespace-nowrap">
                                    @if($item->is_active)
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-800">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500" aria-hidden="true"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">
                                            <span class="h-1.5 w-1.5 rounded-full bg-slate-400" aria-hidden="true"></span>
                                            Hidden
                                        </span>
                                    @endif
                                </td>
                                <td class="px-3 py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold {{ $a['pill'] }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $a['dot'] }}" aria-hidden="true"></span>
                                        {{ $a['label'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.tariffs.edit', $item) }}" class="{{ $btn }}">Edit</a>
                                        <form action="{{ route('admin.tariffs.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this tariff and its PDF file?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="{{ $btnDanger }}">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-12 text-center">
                                    @if(request()->anyFilled(['search', 'tag', 'status']))
                                        <p class="text-sm font-semibold text-slate-700">No matching tariffs found</p>
                                        <p class="mt-1 text-xs text-slate-500">Try adjusting your search keyword or filters.</p>
                                    @else
                                        <p class="text-sm font-semibold text-slate-700">No tariffs yet</p>
                                        <p class="mt-1 text-xs text-slate-500">
                                            <a href="{{ route('admin.tariffs.create') }}" class="font-semibold text-[#0A2540] underline">Add the first tariff</a>
                                        </p>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- List (Mobile) --}}
            <ul class="md:hidden space-y-3 px-3 pb-3">
                @forelse($tariffs as $item)
                    @php $a = $age($item->updated_at); @endphp
                    <li class="rounded-xl bg-[#f6f9fc] p-3.5">
                        <div class="flex items-start justify-between gap-3">
                            <p class="text-sm font-semibold text-[#0A2540] line-clamp-2">{{ $item->title }}</p>
                            <span class="shrink-0 rounded-full bg-white px-2 py-0.5 text-xs font-bold tabular-nums text-[#0A2540]">#{{ $item->sort_order }}</span>
                        </div>
                        @if($item->description)
                            <p class="mt-1 text-xs text-slate-500 line-clamp-2">{{ $item->description }}</p>
                        @endif
                        <div class="mt-2 flex flex-wrap items-center gap-2 text-xs">
                            <span class="{{ $pillGray }} !bg-white">{{ $item->tag }}</span>
                            @if($item->is_active)
                                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 font-semibold text-emerald-800">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500" aria-hidden="true"></span>Active
                                </span>
                            @else
                                <span class="rounded-full bg-white px-2 py-0.5 font-semibold text-slate-500">Hidden</span>
                            @endif
                            <span class="inline-flex items-center gap-1.5 rounded-full px-2 py-0.5 font-semibold {{ $a['pill'] }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ $a['dot'] }}" aria-hidden="true"></span>{{ $a['label'] }}
                            </span>
                            @if($item->hasPdf())
                                <a href="{{ route('admin.tariffs.preview', $item) }}?v={{ $item->updated_at?->timestamp }}"
                                   target="_blank" rel="noopener"
                                   class="font-semibold text-[#0A2540] underline underline-offset-2">View PDF</a>
                            @else
                                <span class="rounded-full bg-red-50 px-2 py-0.5 font-semibold text-red-700">Not uploaded</span>
                            @endif
                        </div>
                        <div class="mt-3 flex gap-2">
                            <a href="{{ route('admin.tariffs.edit', $item) }}" class="{{ $btn }} !bg-white flex-1">Edit</a>
                            <form action="{{ route('admin.tariffs.destroy', $item) }}" method="POST" class="flex-1" onsubmit="return confirm('Delete this tariff and its PDF file?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="{{ $btnDanger }} w-full">Delete</button>
                            </form>
                        </div>
                    </li>
                @empty
                    <li class="px-4 py-10 text-center text-sm text-slate-500">
                        @if(request()->anyFilled(['search', 'tag', 'status']))
                            No matching tariffs found.
                        @else
                            No tariffs yet. <a href="{{ route('admin.tariffs.create') }}" class="font-semibold text-[#0A2540] underline">Add the first tariff</a>
                        @endif
                    </li>
                @endforelse
            </ul>

            {{-- Pagination / Summary Footer --}}
            @if($tariffs instanceof \Illuminate\Contracts\Pagination\Paginator)
                <div class="border-t border-slate-100 px-5 py-3.5">
                    {{ $tariffs->withQueryString()->links() }}
                </div>
            @elseif($tariffs->count() > 0)
                <div class="flex items-center justify-between border-t border-slate-100 px-5 py-3.5 text-xs text-slate-500">
                    <span>Showing <strong class="font-semibold text-[#0A2540]">{{ $tariffs->count() }}</strong> tariffs</span>
                </div>
            @endif

        </section>

    </div>
</x-admin-layout>