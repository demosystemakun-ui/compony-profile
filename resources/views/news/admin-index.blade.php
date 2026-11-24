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
                {{ __('Kelola Berita') }}
            </h2>
            <p class="text-xs text-slate-500">Manage all news articles published on the website</p>
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

        <section class="{{ $card }} overflow-hidden">

            {{-- Top Bar --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-5 pt-5 pb-4">
                <div>
                    <h3 class="text-base font-bold text-[#0A2540]">Published news</h3>
                    <p class="mt-0.5 text-xs text-slate-500">
                        Total: <strong class="font-semibold text-[#0A2540]">{{ $newsList->total() }}</strong> news articles
                    </p>
                </div>

                <a href="{{ route('news.create') }}"
                   class="inline-flex items-center justify-center gap-1.5 rounded-full bg-[#0A2540] px-4 py-1.5 text-xs font-bold text-white transition hover:bg-[#13385e] shrink-0 {{ $focus }}">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 5v14M5 12h14"/>
                    </svg>
                    Add news
                </a>
            </div>

            {{-- Filter Tanggal Kalender --}}
            <form method="GET" action="{{ url()->current() }}" class="flex flex-wrap items-center gap-2.5 px-5 pb-4">
                <label for="filter_date" class="text-xs font-semibold text-slate-600">
                    Publish Date:
                </label>
                <input type="date"
                       id="filter_date"
                       name="date"
                       value="{{ request('date') }}"
                       class="rounded-full border border-slate-200 bg-[#f6f9fc] px-3.5 py-1.5 text-xs font-medium text-[#0A2540] {{ $focus }}">

                <button type="submit"
                        class="inline-flex items-center justify-center rounded-full bg-[#0A2540] px-4 py-1.5 text-xs font-semibold text-white transition hover:bg-[#13385e] {{ $focus }}">
                    Filter
                </button>

                @if(request('date'))
                    <a href="{{ url()->current() }}" class="{{ $btn }}">
                        Reset
                    </a>
                @endif
            </form>

            {{-- Tabel (Desktop) --}}
            <div class="hidden md:block overflow-x-auto px-3 pb-3">
                <table class="w-full text-left text-sm">
                    <thead class="text-xs text-slate-500">
                        <tr class="bg-[#f6f9fc]">
                            <th scope="col" class="rounded-l-xl px-4 py-2.5 font-semibold">Image</th>
                            <th scope="col" class="px-3 py-2.5 font-semibold">Title</th>
                            <th scope="col" class="px-3 py-2.5 font-semibold">Category</th>
                            <th scope="col" class="px-3 py-2.5 font-semibold">Published</th>
                            <th scope="col" class="px-3 py-2.5 font-semibold">Updated</th>
                            <th scope="col" class="px-3 py-2.5 font-semibold">Author</th>
                            <th scope="col" class="rounded-r-xl px-4 py-2.5 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($newsList as $item)
                            @php $a = $age($item->updated_at); @endphp
                            <tr class="hover:bg-[#f6f9fc] transition-colors">
                                <td class="px-4 py-3">
                                    @if($item->image_url)
                                        <div class="h-11 w-16 overflow-hidden rounded-xl border border-slate-200 bg-[#f6f9fc]">
                                            <img src="{{ $item->image_url }}"
                                                 alt="{{ $item->title }}"
                                                 class="h-full w-full object-cover"
                                                 loading="lazy">
                                        </div>
                                    @else
                                        <div class="flex h-11 w-16 items-center justify-center rounded-xl border border-slate-200 bg-[#f6f9fc] text-slate-400">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </td>

                                <td class="max-w-xs px-3 py-3">
                                    <p class="truncate font-semibold text-[#0A2540]">{{ $item->title }}</p>
                                    <p class="mt-0.5 truncate text-xs text-slate-400">/{{ $item->slug }}</p>
                                </td>

                                <td class="px-3 py-3">
                                    <span class="{{ $pillGray }}">{{ $item->category }}</span>
                                </td>

                                <td class="px-3 py-3 whitespace-nowrap text-xs font-medium text-slate-600">
                                    {{ optional($item->published_at)->format('d M Y') ?? '-' }}
                                </td>

                                <td class="px-3 py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold {{ $a['pill'] }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $a['dot'] }}" aria-hidden="true"></span>
                                        {{ $a['label'] }}
                                    </span>
                                </td>

                                <td class="px-3 py-3 whitespace-nowrap">
                                    @if($item->updatedBy)
                                        <span class="inline-flex items-center gap-2 font-medium text-slate-700">
                                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-[#0A2540] text-[10px] font-bold text-white" aria-hidden="true">
                                                {{ strtoupper(substr($item->updatedBy->name, 0, 1)) }}
                                            </span>
                                            {{ $item->updatedBy->name }}
                                        </span>
                                    @else
                                        <span class="text-xs italic text-slate-400">Not recorded</span>
                                    @endif
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.news.show', $item->id) }}" class="{{ $btn }}">Detail</a>
                                        <a href="{{ route('news.edit', $item->id) }}" class="{{ $btn }}">Edit</a>
                                        <form action="{{ route('news.destroy', $item->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus berita ini?');">
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
                                    <p class="text-sm font-semibold text-slate-700">No news articles available</p>
                                    <p class="mt-1 text-xs text-slate-500">
                                        <a href="{{ route('news.create') }}" class="font-semibold text-[#0A2540] underline">Add the first news article</a>
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- List (Mobile) --}}
            <ul class="md:hidden space-y-3 px-3 pb-3">
                @forelse($newsList as $item)
                    @php $a = $age($item->updated_at); @endphp
                    <li class="rounded-xl bg-[#f6f9fc] p-3.5">
                        <div class="flex items-start gap-3">
                            @if($item->image_url)
                                <div class="h-14 w-20 shrink-0 overflow-hidden rounded-xl border border-slate-200 bg-white">
                                    <img src="{{ $item->image_url }}"
                                         alt="{{ $item->title }}"
                                         class="h-full w-full object-cover"
                                         loading="lazy">
                                </div>
                            @endif
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-[#0A2540] line-clamp-2">{{ $item->title }}</p>
                                <p class="mt-0.5 truncate text-xs text-slate-400">/{{ $item->slug }}</p>
                            </div>
                        </div>

                        <div class="mt-2.5 flex flex-wrap items-center gap-2 text-xs">
                            <span class="{{ $pillGray }} !bg-white">{{ $item->category }}</span>
                            @if($item->published_at)
                                <span class="text-slate-600 font-medium">{{ $item->published_at->format('d M Y') }}</span>
                            @endif
                            <span class="inline-flex items-center gap-1.5 rounded-full px-2 py-0.5 font-semibold {{ $a['pill'] }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ $a['dot'] }}" aria-hidden="true"></span>{{ $a['label'] }}
                            </span>
                            @if($item->updatedBy)
                                <span class="text-slate-500">by {{ $item->updatedBy->name }}</span>
                            @endif
                        </div>

                        <div class="mt-3 flex gap-2">
                            <a href="{{ route('admin.news.show', $item->id) }}" class="{{ $btn }} !bg-white flex-1">Detail</a>
                            <a href="{{ route('news.edit', $item->id) }}" class="{{ $btn }} !bg-white flex-1">Edit</a>
                            <form action="{{ route('news.destroy', $item->id) }}"
                                  method="POST"
                                  class="flex-1"
                                  onsubmit="return confirm('Yakin ingin menghapus berita ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="{{ $btnDanger }} w-full">Delete</button>
                            </form>
                        </div>
                    </li>
                @empty
                    <li class="px-4 py-10 text-center text-sm text-slate-500">
                        No news articles available. <a href="{{ route('news.create') }}" class="font-semibold text-[#0A2540] underline">Add the first news article</a>
                    </li>
                @endforelse
            </ul>

            @if($newsList->hasPages())
                <div class="border-t border-slate-100 px-5 py-3.5">
                    {{ $newsList->links() }}
                </div>
            @endif

        </section>

    </div>
</x-admin-layout>