@php
    $focus      = 'focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#0A2540]';
    $input      = "w-full rounded-xl border border-slate-200 bg-[#f6f9fc] px-3.5 py-2.5 text-sm text-[#0A2540] placeholder-slate-400 transition focus:border-[#0A2540] focus:bg-white focus:outline-none";
    $btn        = "inline-flex items-center justify-center rounded-full bg-[#eef5fb] px-4 py-2 text-xs sm:text-sm font-semibold text-[#0A2540] transition hover:bg-[#dce8f5] $focus";
    $btnPrimary = "inline-flex items-center justify-center gap-1.5 rounded-full bg-[#0A2540] px-5 py-2 text-xs sm:text-sm font-bold text-white transition hover:bg-[#13385e] $focus";
    $card       = 'bg-white rounded-2xl shadow-sm border border-slate-100';
@endphp

<x-admin-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-base sm:text-lg font-bold text-[#0A2540] leading-tight tracking-tight">
                {{ __('Edit Article') }}
            </h2>
            <p class="text-xs text-slate-500">Update article details for PICT</p>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-6">

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

        <section class="{{ $card }} overflow-hidden">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 px-5 pt-5 pb-4 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-[#0A2540]">Edit article</h3>
                    <p class="mt-0.5 text-xs text-slate-500">ID #{{ $news->id }} — /{{ $news->slug }}</p>
                </div>
                <a href="{{ route('admin.news.index') }}" class="{{ $btn }} !py-1.5 !px-3.5 !text-xs shrink-0">
                    Back to list
                </a>
            </div>

            <form action="{{ route('news.update', $news->id) }}" method="POST" enctype="multipart/form-data" class="p-5 sm:p-6 space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="editArticleTitle" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                        Article title
                    </label>
                    <input id="editArticleTitle"
                           type="text"
                           name="title"
                           value="{{ old('title', $news->title) }}"
                           class="{{ $input }}"
                           required>
                </div>

                <div>
                    <label for="editArticleCategory" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                        Category
                    </label>
                    <input id="editArticleCategory"
                           type="text"
                           name="category"
                           value="{{ old('category', $news->category) }}"
                           class="{{ $input }}"
                           required>
                </div>

                <div>
                    <label for="editArticleImage" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                        Update image (optional)
                    </label>

                    @if($news->image_url)
                        <div class="mb-3 flex items-center gap-3 rounded-xl bg-[#f6f9fc] p-3 border border-slate-100">
                            <img src="{{ $news->image_url }}"
                                 alt="Current Image"
                                 class="h-16 w-24 shrink-0 rounded-xl border border-slate-200 object-cover bg-white">
                            <p class="text-xs text-slate-500">
                                Current image. Choose a new file only if you want to replace it.
                            </p>
                        </div>
                    @endif

                    <input id="editArticleImage"
                           type="file"
                           name="image"
                           accept="image/jpeg,image/png,image/webp"
                           class="block w-full rounded-xl border border-slate-200 bg-[#f6f9fc] px-3.5 py-2 text-xs sm:text-sm text-slate-700 file:mr-3 file:rounded-full file:border-0 file:bg-[#eef5fb] file:px-3.5 file:py-1.5 file:text-xs file:font-semibold file:text-[#0A2540] hover:file:bg-[#dce8f5] transition focus:border-[#0A2540] focus:bg-white focus:outline-none">
                    <p class="mt-1.5 text-xs text-slate-400">JPG, PNG, or WebP. Max 10 MB.</p>
                </div>

                <div>
                    <label for="editArticleExcerpt" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                        Short excerpt
                    </label>
                    <textarea id="editArticleExcerpt"
                              name="excerpt"
                              rows="3"
                              class="{{ $input }}"
                              required>{{ old('excerpt', $news->excerpt) }}</textarea>
                </div>

                <div>
                    <label for="editArticleContent" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                        Full content
                    </label>
                    <textarea id="editArticleContent"
                              name="content"
                              rows="6"
                              class="{{ $input }}"
                              required>{{ old('content', $news->content) }}</textarea>
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-4 border-t border-slate-100">
                    <a href="{{ route('admin.news.index') }}" class="{{ $btn }}">
                        Cancel
                    </a>
                    <button type="submit" class="{{ $btnPrimary }}">
                        Update article
                    </button>
                </div>
            </form>
        </section>

    </div>
</x-admin-layout>