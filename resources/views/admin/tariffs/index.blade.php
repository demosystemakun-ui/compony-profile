@php
    $editingTariff = $tariff ?? new \App\Models\Tariff();
    $isEdit        = (bool) $editingTariff->exists;

    $age = function ($date) {
        $d = $date ? (int) $date->diffInDays(now()) : 0;
        if ($d > 30) return ['dot' => 'bg-red-500',     'pill' => 'bg-red-50 text-red-700',         'label' => $d . ' days ago'];
        if ($d > 7)  return ['dot' => 'bg-amber-500',   'pill' => 'bg-amber-50 text-amber-800',     'label' => $d . ' days ago'];
        return              ['dot' => 'bg-emerald-500', 'pill' => 'bg-emerald-50 text-emerald-800', 'label' => optional($date)->diffForHumans() ?? '-'];
    };

    $focus      = 'focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#0A2540]';
    $input      = "w-full rounded-xl border border-slate-200 bg-[#f6f9fc] px-3.5 py-2 text-sm text-[#0A2540] placeholder-slate-400 transition focus:border-[#0A2540] focus:bg-white focus:outline-none";
    $btn        = "inline-flex items-center justify-center rounded-full bg-[#eef5fb] px-3.5 py-1.5 text-xs font-semibold text-[#0A2540] transition hover:bg-[#dce8f5] $focus";
    $btnPrimary = "inline-flex items-center justify-center gap-1.5 rounded-full bg-[#0A2540] px-4 py-1.5 text-xs font-bold text-white transition hover:bg-[#13385e] $focus";
    $btnDanger  = "inline-flex items-center justify-center rounded-full bg-red-50 px-3.5 py-1.5 text-xs font-semibold text-red-700 transition hover:bg-red-100 $focus";
    $card       = 'bg-white rounded-2xl shadow-sm border border-slate-100';
    $pillGray   = 'inline-block rounded-full bg-[#eef5fb] px-2.5 py-0.5 text-xs font-semibold text-[#0A2540]';
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

        {{-- ═══ TABEL DATA TARIF (TAMPIL PERTAMA) ═══ --}}
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

                    <button type="button"
                            onclick="openTariffModal()"
                            class="{{ $btnPrimary }} shrink-0">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 5v14M5 12h14"/>
                        </svg>
                        Add tariff
                    </button>
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
                                            <button type="button" onclick="openTariffModal()" class="font-semibold text-[#0A2540] underline">Add the first tariff</button>
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
                            No tariffs yet. <button type="button" onclick="openTariffModal()" class="font-semibold text-[#0A2540] underline">Add the first tariff</button>
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

    {{-- ═══ MODAL FORM TARIF MELAYANG + BLUR BACKDROP ═══ --}}
    <div id="tariffModal"
         role="dialog"
         aria-modal="true"
         aria-labelledby="tariffModalTitle"
         class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
        <div class="w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-2xl border border-slate-100 bg-white shadow-xl">
            <form method="POST"
                  action="{{ $isEdit ? route('admin.tariffs.update', $editingTariff) : route('admin.tariffs.store') }}"
                  enctype="multipart/form-data">
                @csrf
                @if($isEdit) @method('PUT') @endif

                <div class="sticky top-0 z-10 flex items-center justify-between border-b border-slate-100 bg-white px-5 py-4">
                    <div>
                        <h3 id="tariffModalTitle" class="text-base font-bold text-[#0A2540]">
                            {{ $isEdit ? 'Edit tariff' : 'Add new tariff' }}
                        </h3>
                        <p class="text-xs text-slate-500">
                            {{ $isEdit ? 'Update tariff document information' : 'Complete the tariff document details below' }}
                        </p>
                    </div>
                    <button type="button"
                            onclick="closeTariffModal()"
                            aria-label="Close modal"
                            class="flex h-8 w-8 items-center justify-center rounded-full bg-[#eef5fb] text-sm font-bold text-[#0A2540] transition hover:bg-[#dce8f5] {{ $focus }}">
                        &times;
                    </button>
                </div>

                <div class="p-5 space-y-4">
                    @if ($errors->any())
                        <div role="alert" class="rounded-xl bg-red-50 px-4 py-3 text-xs sm:text-sm text-red-800 ring-1 ring-red-200">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Kategori & Judul --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label for="tariffTag" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <select id="tariffTag" name="tag" required class="{{ $input }} cursor-pointer">
                                <option value="" disabled @selected(!old('tag', $editingTariff->tag))>Select category</option>
                                @foreach(\App\Models\Tariff::TAGS as $tag)
                                    <option value="{{ $tag }}" @selected(old('tag', $editingTariff->tag) === $tag)>{{ $tag }}</option>
                                @endforeach
                            </select>
                            @error('tag') <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="tariffTitle" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                Title <span class="text-red-500">*</span>
                            </label>
                            <input id="tariffTitle"
                                   type="text"
                                   name="title"
                                   value="{{ old('title', $editingTariff->title) }}"
                                   placeholder="Domestic Tariffs"
                                   class="{{ $input }}"
                                   required>
                            @error('title') <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label for="tariffDescription" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                            Short description
                        </label>
                        <textarea id="tariffDescription"
                                  name="description"
                                  rows="3"
                                  placeholder="Explain the content of this tariff document..."
                                  class="{{ $input }} resize-none">{{ old('description', $editingTariff->description) }}</textarea>
                        @error('description') <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Ikon & Urutan --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="tariffIcon" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                Icon
                            </label>
                            <select id="tariffIcon" name="icon" class="{{ $input }} cursor-pointer">
                                @foreach(['building' => 'Building', 'globe' => 'Globe', 'document' => 'Document'] as $key => $label)
                                    <option value="{{ $key }}" @selected(old('icon', $editingTariff->icon) === $key)>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('icon') <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="tariffSortOrder" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                Sort order
                            </label>
                            <select id="tariffSortOrder" name="sort_order" class="{{ $input }} cursor-pointer">
                                @foreach([1, 2, 3] as $order)
                                    <option value="{{ $order }}" @selected(old('sort_order', $editingTariff->sort_order ?? 1) == $order)>{{ $order }}</option>
                                @endforeach
                            </select>
                            @error('sort_order') <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- PDF --}}
                    <div class="rounded-xl border border-slate-200 bg-[#f6f9fc] p-4">
                        <label for="tariffPdf" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">
                            {{ $isEdit && $editingTariff->hasPdf() ? 'Change PDF file' : 'PDF file' }}
                            <span class="text-red-500">*</span>
                        </label>

                        @if($isEdit && $editingTariff->hasPdf())
                            <div class="mb-3 rounded-xl border border-slate-200 bg-white p-2.5 text-xs text-slate-600">
                                Current file:
                                <a href="{{ $editingTariff->pdfUrl() }}"
                                   target="_blank"
                                   rel="noopener"
                                   class="font-semibold text-[#0A2540] hover:text-[#EC2029] underline">
                                    {{ basename($editingTariff->pdf_path) }}
                                </a>
                                <span class="text-slate-400">&mdash; Leave blank if you don't want to change it.</span>
                            </div>
                        @endif

                        <input id="tariffPdf"
                               type="file"
                               name="pdf"
                               accept="application/pdf"
                               @if(!$isEdit || !$editingTariff->hasPdf()) required @endif
                               class="block w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs sm:text-sm text-slate-700 file:mr-3 file:rounded-full file:border-0 file:bg-[#eef5fb] file:px-3.5 file:py-1.5 file:text-xs file:font-semibold file:text-[#0A2540] hover:file:bg-[#dce8f5] transition focus:border-[#0A2540] focus:outline-none">
                        <p class="mt-1.5 text-xs text-slate-400">PDF file, max 10 MB.</p>
                        @error('pdf') <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p> @enderror

                        @if($isEdit && $editingTariff->hasPdf())
                            <label class="mt-3 flex cursor-pointer items-center gap-2 rounded-xl bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 hover:bg-red-100 transition">
                                <input type="checkbox" name="remove_pdf" value="1" class="rounded border-slate-300 text-red-600 focus:ring-red-500">
                                <span>Delete existing PDF</span>
                            </label>
                        @endif
                    </div>

                    {{-- Aktif --}}
                    <label class="flex cursor-pointer items-center gap-3 rounded-xl bg-[#f6f9fc] p-3 border border-slate-100 hover:bg-[#eef5fb]/60 transition">
                        <input type="checkbox"
                               name="is_active"
                               value="1"
                               @checked(old('is_active', $editingTariff->is_active ?? true))
                               class="h-4 w-4 shrink-0 rounded border-slate-300 text-[#0A2540] focus:ring-[#0A2540]">
                        <div>
                            <div class="text-xs sm:text-sm font-semibold text-[#0A2540]">Show in public</div>
                            <div class="text-xs text-slate-500">If disabled, this tariff will not appear on the public website</div>
                        </div>
                    </label>
                </div>

                <div class="sticky bottom-0 flex items-center justify-end gap-2.5 border-t border-slate-100 bg-[#f6f9fc] px-5 py-4">
                    <button type="button"
                            onclick="closeTariffModal()"
                            class="inline-flex items-center justify-center rounded-full bg-white px-4 py-2 text-xs sm:text-sm font-semibold text-[#0A2540] ring-1 ring-slate-200 transition hover:bg-[#eef5fb] {{ $focus }}">
                        Cancel
                    </button>
                    <button type="submit" class="{{ $btnPrimary }} !px-5 !py-2 !text-xs sm:!text-sm">
                        {{ $isEdit ? 'Save changes' : 'Save tariff' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function openTariffModal() {
            const modal = document.getElementById('tariffModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeTariffModal() {
            const modal = document.getElementById('tariffModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('tariffModal');
            modal.addEventListener('click', function (e) {
                if (e.target === this) {
                    closeTariffModal();
                }
            });

            @if ($errors->any() || $isEdit)
                openTariffModal();
            @endif
        });
    </script>
    @endpush
</x-admin-layout>