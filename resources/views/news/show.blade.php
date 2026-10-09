<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-wrap gap-3 justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-[#0A2540] leading-tight tracking-tight">
                    {{ __('Detail Berita') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">Pratinjau berita sebelum / sesudah dipublikasikan</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.news.index') }}"
                   class="inline-flex items-center gap-1.5 text-sm font-semibold text-gray-600 hover:text-[#0A2540] bg-white border border-gray-200 px-4 py-2 rounded-lg shadow-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
                <a href="{{ route('news.edit', $news->id) }}"
                   class="inline-flex items-center gap-1.5 text-sm font-semibold text-white bg-amber-600 hover:bg-amber-700 px-4 py-2 rounded-lg shadow-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-gray-50 via-white to-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="flex items-start gap-3 p-4 bg-green-50 border-l-4 border-green-500 text-green-800 rounded-lg text-sm shadow-sm">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-2xl border border-gray-100 shadow-md overflow-hidden">

                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-red-50/50 to-transparent flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-red-600 flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-[#0A2540]">Pratinjau Berita</h3>
                        <p class="text-[11px] text-gray-500">ID #{{ $news->id }} — {{ $news->slug }}</p>
                    </div>
                </div>

                <div class="p-6 sm:p-8">

                    <div class="flex flex-wrap items-center gap-3 mb-5">
                        @if($news->category)
                            <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 border border-red-100 text-xs font-semibold px-2.5 py-1 rounded-md">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                {{ $news->category }}
                            </span>
                        @endif

                        @if($news->published_at)
                            <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 border border-green-200 text-[11px] font-bold px-2 py-1 rounded-md uppercase tracking-wider">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                Publish: {{ $news->published_at->translatedFormat('d F Y') }}
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 border border-amber-200 text-[11px] font-bold px-2 py-1 rounded-md uppercase tracking-wider">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                Draft
                            </span>
                        @endif
                    </div>

                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-[#0A2540] leading-tight mb-6">
                        {{ $news->title }}
                    </h1>

                    <div class="flex flex-wrap items-center gap-4 mb-8 pb-6 border-b border-gray-100 text-xs text-gray-500">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span>
                                Oleh
                                <span class="font-semibold text-[#0A2540]">
                                    {{ $news->updatedBy->name ?? 'Tidak tercatat' }}
                                </span>
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>
                                Diperbarui
                                <span class="font-semibold text-[#0A2540]">
                                    {{ optional($news->updated_at)->diffForHumans() ?? '-' }}
                                </span>
                            </span>
                        </div>
                    </div>

                    @if($news->image_url)
                        <div class="aspect-[16/9] rounded-2xl overflow-hidden bg-gray-100 shadow-lg ring-1 ring-gray-200/60 mb-8">
                            <img src="{{ $news->image_url }}"
                                 alt="{{ $news->title }}"
                                 class="w-full h-full object-cover">
                        </div>
                    @endif

                    @if($news->excerpt)
                        <div class="p-5 bg-blue-50/60 border-l-4 border-blue-500 rounded-lg mb-8">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-blue-700 mb-1">
                                Excerpt
                            </p>
                            <p class="text-sm text-gray-700 leading-relaxed italic">
                                {{ $news->excerpt }}
                            </p>
                        </div>
                    @endif

                    <div class="prose prose-slate max-w-none
                                prose-headings:text-[#0A2540] prose-headings:font-bold
                                prose-a:text-red-700 prose-a:no-underline hover:prose-a:underline
                                prose-img:rounded-xl prose-img:shadow-md">
                        {!! $news->content !!}
                    </div>

                </div>

                <div class="px-6 sm:px-8 py-5 bg-gray-50 border-t border-gray-100 flex flex-wrap items-center justify-end gap-3">
                    <a href="{{ route('admin.news.index') }}"
                       class="inline-flex items-center gap-1.5 text-sm font-semibold text-gray-600 hover:text-[#0A2540] bg-white border border-gray-200 px-4 py-2 rounded-lg shadow-sm transition-colors">
                        Kembali ke Daftar
                    </a>
                    <a href="{{ route('news.show', $news->slug) }}"
                       target="_blank" rel="noopener"
                       class="inline-flex items-center gap-1.5 text-sm font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200 px-4 py-2 rounded-lg shadow-sm transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        Lihat di Halaman Publik
                    </a>
                    <a href="{{ route('news.edit', $news->id) }}"
                       class="inline-flex items-center gap-1.5 text-sm font-semibold text-white bg-amber-600 hover:bg-amber-700 px-4 py-2 rounded-lg shadow-sm transition-colors">
                        Edit Berita
                    </a>
                    <form action="{{ route('news.destroy', $news->id) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus berita ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 text-sm font-semibold text-red-700 bg-red-50 hover:bg-red-100 border border-red-200 px-4 py-2 rounded-lg shadow-sm transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>

            </div>

        </div>
    </div>
</x-admin-layout>