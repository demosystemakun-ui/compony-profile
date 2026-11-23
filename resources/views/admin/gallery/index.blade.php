@php
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
                {{ __('Manage Terminal Gallery') }}
            </h2>
            <p class="text-xs text-slate-500">Manage images displayed on Home, Operations, and Services pages</p>
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
                    <h3 class="text-base font-bold text-[#0A2540]">Image gallery list</h3>
                    <p class="mt-0.5 text-xs text-slate-500">Images managed here appear on public pages</p>
                </div>

                <button type="button"
                        onclick="openModal('add')"
                        class="{{ $btnPrimary }} shrink-0">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 5v14M5 12h14"/>
                    </svg>
                    Add image
                </button>
            </div>

            {{-- Tabel (Desktop) --}}
            <div class="hidden md:block overflow-x-auto px-3 pb-3">
                <table class="w-full text-left text-sm">
                    <thead class="text-xs text-slate-500">
                        <tr class="bg-[#f6f9fc]">
                            <th scope="col" class="rounded-l-xl px-4 py-2.5 font-semibold">Image</th>
                            <th scope="col" class="px-3 py-2.5 font-semibold">Title &amp; description</th>
                            <th scope="col" class="px-3 py-2.5 font-semibold">Page / section</th>
                            <th scope="col" class="px-3 py-2.5 font-semibold">Tag</th>
                            <th scope="col" class="rounded-r-xl px-4 py-2.5 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($galleries as $item)
                            <tr class="hover:bg-[#f6f9fc] transition-colors">
                                <td class="px-4 py-3">
                                    <div class="h-14 w-24 overflow-hidden rounded-xl border border-slate-200 bg-[#f6f9fc]">
                                        <img src="{{ $item->image_url }}"
                                             alt="{{ $item->title }}"
                                             class="h-full w-full object-cover"
                                             loading="lazy">
                                    </div>
                                </td>

                                <td class="max-w-xs px-3 py-3">
                                    <p class="truncate font-semibold text-[#0A2540]">{{ $item->title }}</p>
                                    <p class="mt-0.5 line-clamp-2 text-xs text-slate-500">{{ $item->description }}</p>
                                </td>

                                <td class="px-3 py-3">
                                    <span class="{{ $pillGray }} uppercase">{{ $item->page }}</span>
                                    <p class="mt-1 text-xs font-medium text-slate-500">{{ $item->section }}</p>
                                </td>

                                <td class="px-3 py-3 whitespace-nowrap">
                                    <span class="inline-block rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-semibold text-red-700">
                                        {{ $item->tag }}
                                    </span>
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button"
                                                onclick='openModal("edit", @json($item))'
                                                class="{{ $btn }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('gallery.destroy', $item->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus gambar ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="{{ $btnDanger }}">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-12 text-center">
                                    <p class="text-sm font-semibold text-slate-700">No gallery data available</p>
                                    <p class="mt-1 text-xs text-slate-500">Click &ldquo;Add image&rdquo; above to upload a gallery item.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- List (Mobile) --}}
            <ul class="md:hidden space-y-3 px-3 pb-3">
                @forelse($galleries as $item)
                    <li class="rounded-xl bg-[#f6f9fc] p-3.5">
                        <div class="flex items-start gap-3">
                            <div class="h-16 w-24 shrink-0 overflow-hidden rounded-xl border border-slate-200 bg-white">
                                <img src="{{ $item->image_url }}"
                                     alt="{{ $item->title }}"
                                     class="h-full w-full object-cover"
                                     loading="lazy">
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-[#0A2540] line-clamp-2">{{ $item->title }}</p>
                                <p class="mt-0.5 text-xs text-slate-500 line-clamp-2">{{ $item->description }}</p>
                            </div>
                        </div>

                        <div class="mt-2.5 flex flex-wrap items-center gap-2 text-xs">
                            <span class="{{ $pillGray }} !bg-white uppercase">{{ $item->page }}</span>
                            <span class="font-medium text-slate-500">{{ $item->section }}</span>
                            <span class="rounded-full bg-red-50 px-2.5 py-0.5 font-semibold text-red-700">{{ $item->tag }}</span>
                        </div>

                        <div class="mt-3 flex gap-2">
                            <button type="button"
                                    onclick='openModal("edit", @json($item))'
                                    class="{{ $btn }} !bg-white flex-1">
                                Edit
                            </button>
                            <form action="{{ route('gallery.destroy', $item->id) }}"
                                  method="POST"
                                  class="flex-1"
                                  onsubmit="return confirm('Yakin ingin menghapus gambar ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="{{ $btnDanger }} w-full">Delete</button>
                            </form>
                        </div>
                    </li>
                @empty
                    <li class="px-4 py-10 text-center text-sm text-slate-500">
                        No gallery data available. Click &ldquo;Add image&rdquo; above.
                    </li>
                @endforelse
            </ul>

        </section>

    </div>

    {{-- Modal Form --}}
    <div id="galleryModal"
         role="dialog"
         aria-modal="true"
         aria-labelledby="modalTitle"
         class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
        <div class="w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-2xl border border-slate-100 bg-white shadow-xl">
            <form id="galleryForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="sticky top-0 z-10 flex items-center justify-between border-b border-slate-100 bg-white px-5 py-4">
                    <h3 id="modalTitle" class="text-base font-bold text-[#0A2540]">Add new image</h3>
                    <button type="button"
                            onclick="closeModal()"
                            aria-label="Close modal"
                            class="flex h-8 w-8 items-center justify-center rounded-full bg-[#eef5fb] text-sm font-bold text-[#0A2540] transition hover:bg-[#dce8f5] {{ $focus }}">
                        &times;
                    </button>
                </div>

                <div class="p-5 space-y-4">
                    <div>
                        <label for="inputTitle" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                            Image title
                        </label>
                        <input type="text" name="title" id="inputTitle" required class="{{ $input }}">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="inputPage" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                Target page
                            </label>
                            <select name="page" id="inputPage" required class="{{ $input }} cursor-pointer">
                                <option value="home">Home</option>
                                <option value="operations">Operations</option>
                                <option value="services">Services</option>
                            </select>
                        </div>

                        <div>
                            <label for="inputSection" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                Section
                            </label>
                            <select name="section" id="inputSection" required class="{{ $input }} cursor-pointer">
                                <option value="terminal_gallery">terminal_gallery (Home)</option>
                                <option value="gallery">gallery (Operations)</option>
                                <option value="portfolio">portfolio (Services)</option>
                                <option value="value_added">value_added (Services)</option>
                            </select>
                            <p class="mt-1 text-xs text-slate-400">Select the target section.</p>
                        </div>
                    </div>

                    <div>
                        <label for="inputSort" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                            Sort order
                        </label>
                        <input type="number" name="sort_order" id="inputSort" value="0" class="{{ $input }}">
                        <p class="mt-1 text-xs text-slate-400">Smaller numbers appear first.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="inputTag" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                Tag (badge)
                            </label>
                            <input type="text" name="tag" id="inputTag" required placeholder="e.g. CBU Units" class="{{ $input }}">
                        </div>

                        <div>
                            <label for="inputDate" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                Date info
                            </label>
                            <input type="text" name="date_info" id="inputDate" required placeholder="e.g. Quality Control" class="{{ $input }}">
                        </div>
                    </div>

                    <div>
                        <label for="inputLocation" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                            Location / features
                        </label>
                        <input type="text" name="location" id="inputLocation" required placeholder="e.g. Inspection Area" class="{{ $input }}">
                        <p class="mt-1 text-xs text-slate-400">
                            For bullet points in Services, separate with <code class="rounded bg-[#eef5fb] px-1.5 py-0.5 font-semibold text-[#0A2540]">|</code>. Example: <code class="rounded bg-[#eef5fb] px-1.5 py-0.5 font-semibold text-[#0A2540]">300m Pier|Mooring Teams|Fresh Water</code>
                        </p>
                    </div>

                    <div>
                        <label for="inputDescription" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                            Description
                        </label>
                        <textarea name="description" id="inputDescription" rows="3" required class="{{ $input }}"></textarea>
                    </div>

                    <div>
                        <label for="inputImage" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                            Upload image
                        </label>
                        <input type="file"
                               name="image"
                               id="inputImage"
                               accept="image/*"
                               class="block w-full rounded-xl border border-slate-200 bg-[#f6f9fc] px-3.5 py-2 text-xs sm:text-sm text-slate-700 file:mr-3 file:rounded-full file:border-0 file:bg-[#eef5fb] file:px-3.5 file:py-1.5 file:text-xs file:font-semibold file:text-[#0A2540] hover:file:bg-[#dce8f5] transition focus:border-[#0A2540] focus:bg-white focus:outline-none">
                        <p id="imageHelp" class="mt-1 text-xs text-slate-400 hidden">Leave blank if you don't want to change the image.</p>
                    </div>
                </div>

                <div class="sticky bottom-0 flex items-center justify-end gap-2.5 border-t border-slate-100 bg-[#f6f9fc] px-5 py-4">
                    <button type="button"
                            onclick="closeModal()"
                            class="inline-flex items-center justify-center rounded-full bg-white px-4 py-2 text-xs sm:text-sm font-semibold text-[#0A2540] ring-1 ring-slate-200 transition hover:bg-[#eef5fb] {{ $focus }}">
                        Cancel
                    </button>
                    <button type="submit" class="{{ $btnPrimary }} !px-5 !py-2 !text-xs sm:!text-sm">
                        Save data
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function openModal(mode, data = null) {
            const modal = document.getElementById('galleryModal');
            const form = document.getElementById('galleryForm');
            const title = document.getElementById('modalTitle');
            const method = document.getElementById('formMethod');
            const imageHelp = document.getElementById('imageHelp');

            if (mode === 'add') {
                title.innerText = 'Add new image';
                form.action = "{{ route('gallery.store') }}";
                method.value = 'POST';
                form.reset();
                imageHelp.classList.add('hidden');
                document.getElementById('inputImage').required = true;
            } else {
                title.innerText = 'Edit image';
                form.action = "{{ url('/pict-internal-admin-portal/gallery') }}/" + data.id;
                method.value = 'PUT';

                document.getElementById('inputTitle').value = data.title ?? '';
                document.getElementById('inputPage').value = data.page || 'operations';
                document.getElementById('inputSection').value = data.section || 'gallery';
                document.getElementById('inputSort').value = data.sort_order ?? 0;
                document.getElementById('inputTag').value = data.tag ?? '';
                document.getElementById('inputDate').value = data.date_info ?? '';
                document.getElementById('inputLocation').value = data.location ?? '';
                document.getElementById('inputDescription').value = data.description ?? '';

                imageHelp.classList.remove('hidden');
                document.getElementById('inputImage').required = false;
            }

            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('galleryModal').classList.add('hidden');
        }
    </script>
    @endpush
</x-admin-layout> 