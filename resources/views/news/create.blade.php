@php
    $focus      = 'focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#0A2540]';
    $input      = "w-full rounded-xl border border-slate-200 bg-[#f6f9fc] px-3.5 py-2.5 text-sm text-[#0A2540] placeholder-slate-400 transition focus:border-[#0A2540] focus:bg-white focus:outline-none";
    $btn        = "inline-flex items-center justify-center rounded-full bg-[#eef5fb] px-4 py-2 text-xs sm:text-sm font-semibold text-[#0A2540] transition hover:bg-[#dce8f5] $focus";
    $btnPrimary = "inline-flex items-center justify-center gap-1.5 rounded-full bg-[#0A2540] px-5 py-2 text-xs sm:text-sm font-bold text-white transition hover:bg-[#13385e] $focus";
    $btnDanger  = "inline-flex items-center justify-center rounded-full bg-red-50 px-3.5 py-1.5 text-xs font-semibold text-red-700 transition hover:bg-red-100 $focus";
    $card       = 'bg-white rounded-2xl shadow-sm border border-slate-100';
    $pillGray   = 'inline-block rounded-full bg-[#eef5fb] px-2.5 py-0.5 text-xs font-semibold text-[#0A2540]';

    $resolveNewsImg = function ($item) {
        if (empty($item->image)) {
            return $item->image_url ?? null;
        }
        if (\Illuminate\Support\Str::startsWith($item->image, ['http://', 'https://'])) {
            return $item->image;
        }
        return \Illuminate\Support\Facades\Storage::disk('public')->url($item->image);
    };
@endphp

<x-admin-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-base sm:text-lg font-bold text-[#0A2540] leading-tight tracking-tight">
                {{ __('Create Article') }}
            </h2>
            <p class="text-xs text-slate-500">Publish a new news article for PICT</p>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto space-y-6">

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

        {{-- ═══ FORM TAMBAH ARTIKEL ═══ --}}
        <section class="{{ $card }} overflow-hidden">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 px-5 pt-5 pb-4 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-[#0A2540]">Add new article</h3>
                    <p class="mt-0.5 text-xs text-slate-500">Fill in the title, category, publish date, photo, and article content</p>
                </div>
                <a href="{{ route('admin.news.index') }}" class="{{ $btn }} !py-1.5 !px-3.5 !text-xs shrink-0">
                    Back to list
                </a>
            </div>

            <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data" class="p-5 sm:p-6 space-y-4">
                @csrf

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
                    <p class="mt-2 text-xs text-slate-400">JPG, PNG, or WebP. Max 10 MB. Stored on local public disk.</p>
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

                <div class="flex items-center justify-end gap-2.5 pt-4 border-t border-slate-100">
                    <a href="{{ route('admin.news.index') }}" class="{{ $btn }}">
                        Cancel
                    </a>
                    <button type="submit" class="{{ $btnPrimary }}">
                        Save article
                    </button>
                </div>
            </form>
        </section>

        {{-- ═══ DAFTAR ARTIKEL TERBARU ═══ --}}
        @isset($newsList)
            <section class="{{ $card }} overflow-hidden">
                <div class="px-5 pt-5 pb-4 border-b border-slate-100">
                    <h3 class="text-base font-bold text-[#0A2540]">Recent articles</h3>
                    <p class="mt-0.5 text-xs text-slate-500">Latest articles currently saved in the system</p>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($newsList as $item)
                        @php $imgSrc = $resolveNewsImg($item); @endphp
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-5 py-3.5 hover:bg-[#f6f9fc] transition-colors">
                            <div class="flex items-center gap-3 min-w-0">
                                @if($imgSrc)
                                    <div class="h-11 w-16 shrink-0 overflow-hidden rounded-xl border border-slate-200 bg-[#f6f9fc]">
                                        <img src="{{ $imgSrc }}"
                                             alt="{{ $item->title }}"
                                             class="h-full w-full object-cover"
                                             loading="lazy">
                                    </div>
                                @else
                                    <div class="flex h-11 w-16 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-[#f6f9fc] text-slate-400">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif

                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-[#0A2540]">{{ $item->title }}</p>
                                    <div class="mt-0.5 flex flex-wrap items-center gap-2 text-xs text-slate-500">
                                        <span class="{{ $pillGray }}">{{ $item->category }}</span>
                                        <span>{{ optional($item->published_at)->format('d M Y') ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 shrink-0">
                                <a href="{{ route('news.edit', $item->id) }}" class="{{ $btn }} !py-1 !px-3 !text-xs">Edit</a>
                                <form action="{{ route('news.destroy', $item->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus berita ini? Tindakan tidak dapat dibatalkan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="{{ $btnDanger }} !py-1 !px-3 !text-xs">Delete</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="px-5 py-8 text-center text-sm text-slate-500">
                            No articles available yet.
                        </div>
                    @endforelse
                </div>

                @if(method_exists($newsList, 'links'))
                    <div class="px-5 py-3 border-t border-slate-100">
                        {{ $newsList->links() }}
                    </div>
                @endif
            </section>
        @endisset

    </div>

    @push('scripts')
    <script>
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
    </script>
    @endpush
</x-admin-layout>