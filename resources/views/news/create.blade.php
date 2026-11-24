@php
    $age = function ($date) {
        $d = $date ? (int) $date->diffInDays(now()) : 0;
        if ($d > 30) return ['dot' => 'bg-red-500',     'pill' => 'bg-red-50 text-red-700',         'label' => $d . ' days ago'];
        if ($d > 7)  return ['dot' => 'bg-amber-500',   'pill' => 'bg-amber-50 text-amber-800',     'label' => $d . ' days ago'];
        return              ['dot' => 'bg-emerald-500', 'pill' => 'bg-emerald-50 text-emerald-800', 'label' => optional($date)->diffForHumans() ?? '-'];
    };

    $focus      = 'focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#0A2540]';
    $input      = "w-full rounded-xl border border-slate-200 bg-[#f6f9fc] px-3.5 py-2.5 text-sm text-[#0A2540] placeholder-slate-400 transition focus:border-[#0A2540] focus:bg-white focus:outline-none";
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
                {{ __('News Management') }}
            </h2>
            <p class="text-xs text-slate-500">Create and manage news articles for PICT</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">

        @if ($errors->any())
            <div role="alert" class="rounded-xl bg-red-50 px-4 py-3 text-sm text-red-800 ring-1 ring-red-200">
                <p class="font-semibold mb-1">Please fix the following errors:</p>
                <ul class="list-disc pl-5 space-y-1 text-xs sm:text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div role="status" class="flex items-start gap-3 rounded-xl bg-emerald-50 px-4 py-3 text-sm text-emerald-900 ring-1 ring-emerald-200">
                <svg class="mt-0.5 h-4 w-4 shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        {{-- ═══ TABEL DATA BERITA (TAMPIL PERTAMA) ═══ --}}
        <section class="{{ $card }} overflow-hidden">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-5 pt-5 pb-4">
                <div>
                    <h3 class="text-base font-bold text-[#0A2540]">Published news</h3>
                    <p class="mt-0.5 text-xs text-slate-500">Articles shown on the website</p>
                </div>

                <button type="button"
                        onclick="openArticleModal()"
                        class="{{ $btnPrimary }} shrink-0">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 5v14M5 12h14"/>
                    </svg>
                    Add article
                </button>
            </div>

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
                                              onsubmit="return confirm('Yakin ingin menghapus berita ini? Tindakan tidak dapat dibatalkan.');">
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
                                    <p class="text-sm font-semibold text-slate-700">No news yet</p>
                                    <p class="mt-1 text-xs text-slate-500">Click &ldquo;Add article&rdquo; above to create the first news article.</p>
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
                                  onsubmit="return confirm('Yakin ingin menghapus berita ini? Tindakan tidak dapat dibatalkan.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="{{ $btnDanger }} w-full">Delete</button>
                            </form>
                        </div>
                    </li>
                @empty
                    <li class="px-4 py-10 text-center text-sm text-slate-500">
                        No news yet. Click &ldquo;Add article&rdquo; above.
                    </li>
                @endforelse
            </ul>
        </section>

    </div>

    {{-- ═══ MODAL FORM TAMBAH BERITA MELAYANG + BLUR BACKDROP ═══ --}}
    <div id="addArticleModal"
         role="dialog"
         aria-modal="true"
         aria-labelledby="addArticleModalTitle"
         class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
        <div class="w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-2xl border border-slate-100 bg-white shadow-xl">
            <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="sticky top-0 z-10 flex items-center justify-between border-b border-slate-100 bg-white px-5 py-4">
                    <div>
                        <h3 id="addArticleModalTitle" class="text-base font-bold text-[#0A2540]">Add new article</h3>
                        <p class="text-xs text-slate-500">Fill in the title, category, publish date, photo, and article content</p>
                    </div>
                    <button type="button"
                            onclick="closeArticleModal()"
                            aria-label="Close modal"
                            class="flex h-8 w-8 items-center justify-center rounded-full bg-[#eef5fb] text-sm font-bold text-[#0A2540] transition hover:bg-[#dce8f5] {{ $focus }}">
                        &times;
                    </button>
                </div>

                <div class="p-5 space-y-4">
                    <div>
                        <label for="articleTitle" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                            Article title
                        </label>
                        <input id="articleTitle"
                               type="text"
                               name="title"
                               value="{{ old('title') }}"
                               placeholder="Enter article title..."
                               class="{{ $input }}"
                               required>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="articleCategory" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                Category
                            </label>
                            <input id="articleCategory"
                                   type="text"
                                   name="category"
                                   value="{{ old('category') }}"
                                   placeholder="e.g. Operations, Terminal Update, Safety"
                                   class="{{ $input }}"
                                   required>
                        </div>

                        <div>
                            <label for="articlePublishedAt" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                Publish date &amp; time
                            </label>
                            <input id="articlePublishedAt"
                                   type="datetime-local"
                                   name="published_at"
                                   value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}"
                                   class="{{ $input }}">
                        </div>
                    </div>

                    {{-- Image Upload & Camera Section --}}
                    <div>
                        <span class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">
                            Upload image or capture photo
                        </span>

                        <div id="preview-container" class="mb-3 hidden">
                            <img id="image-preview"
                                 src="#"
                                 alt="Preview"
                                 class="w-full max-h-60 rounded-2xl border border-slate-200 bg-[#f6f9fc] object-contain p-2">
                        </div>

                        <div class="flex flex-wrap gap-2">
                            <input type="file" name="image" id="cameraInput" accept="image/*" capture="environment" class="hidden" onchange="previewImage(event)">
                            <input type="file" name="image_gallery" id="galleryInput" accept="image/*" class="hidden" onchange="previewImage(event)">

                            <button type="button"
                                    onclick="document.getElementById('cameraInput').click()"
                                    class="inline-flex items-center gap-1.5 rounded-full bg-[#eef5fb] px-4 py-2 text-xs font-semibold text-[#0A2540] transition hover:bg-[#dce8f5] {{ $focus }}">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Take photo
                            </button>

                            <button type="button"
                                    onclick="document.getElementById('galleryInput').click()"
                                    class="inline-flex items-center gap-1.5 rounded-full bg-[#eef5fb] px-4 py-2 text-xs font-semibold text-[#0A2540] transition hover:bg-[#dce8f5] {{ $focus }}">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Choose from gallery
                            </button>

                            <button type="button"
                                    id="removeBtn"
                                    onclick="clearImage()"
                                    class="hidden inline-flex items-center gap-1.5 rounded-full bg-red-50 px-4 py-2 text-xs font-semibold text-red-700 transition hover:bg-red-100 {{ $focus }}">
                                Remove image
                            </button>
                        </div>
                        <p class="mt-2 text-xs text-slate-400">Capture directly with camera or pick an image from storage.</p>
                    </div>

                    <div>
                        <label for="articleExcerpt" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                            Short excerpt
                        </label>
                        <textarea id="articleExcerpt"
                                  name="excerpt"
                                  rows="3"
                                  placeholder="Brief summary of the article..."
                                  class="{{ $input }}"
                                  required>{{ old('excerpt') }}</textarea>
                    </div>

                    <div>
                        <label for="articleContent" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                            Full content
                        </label>
                        <textarea id="articleContent"
                                  name="content"
                                  rows="5"
                                  placeholder="Write the complete article content here..."
                                  class="{{ $input }}"
                                  required>{{ old('content') }}</textarea>
                    </div>
                </div>

                <div class="sticky bottom-0 flex items-center justify-end gap-2.5 border-t border-slate-100 bg-[#f6f9fc] px-5 py-4">
                    <button type="button"
                            onclick="closeArticleModal()"
                            class="inline-flex items-center justify-center rounded-full bg-white px-4 py-2 text-xs sm:text-sm font-semibold text-[#0A2540] ring-1 ring-slate-200 transition hover:bg-[#eef5fb] {{ $focus }}">
                        Cancel
                    </button>
                    <button type="submit" class="{{ $btnPrimary }} !px-5 !py-2 !text-xs sm:!text-sm">
                        Save article
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function openArticleModal() {
            const modal = document.getElementById('addArticleModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeArticleModal() {
            const modal = document.getElementById('addArticleModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('image-preview').src = e.target.result;
                    document.getElementById('preview-container').classList.remove('hidden');
                    document.getElementById('removeBtn').classList.remove('hidden');
                };
                reader.readAsDataURL(file);

                if (event.target.id === 'cameraInput') {
                    document.getElementById('galleryInput').value = '';
                } else {
                    document.getElementById('cameraInput').value = '';
                }
            }
        }

        function clearImage() {
            document.getElementById('cameraInput').value = '';
            document.getElementById('galleryInput').value = '';
            document.getElementById('preview-container').classList.add('hidden');
            document.getElementById('removeBtn').classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('addArticleModal');
            modal.addEventListener('click', function (e) {
                if (e.target === this) {
                    closeArticleModal();
                }
            });

            @if ($errors->any())
                openArticleModal();
            @endif
        });
    </script>
    @endpush
</x-admin-layout>