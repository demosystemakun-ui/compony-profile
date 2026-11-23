@php
    $focus     = 'focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#0A2540]';
    $btn       = "inline-flex items-center justify-center gap-1.5 rounded-full bg-[#eef5fb] px-3.5 py-1.5 text-xs font-semibold text-[#0A2540] transition hover:bg-[#dce8f5] $focus";
    $btnPrimary = "inline-flex items-center justify-center gap-1.5 rounded-full bg-[#0A2540] px-4 py-1.5 text-xs font-bold text-white transition hover:bg-[#13385e] $focus";
    $btnDanger = "inline-flex items-center justify-center gap-1.5 rounded-full bg-red-50 px-3.5 py-1.5 text-xs font-semibold text-red-700 transition hover:bg-red-100 $focus";
    $card      = 'bg-white rounded-2xl shadow-sm border border-slate-100';
    $pillGray  = 'inline-flex items-center rounded-full bg-[#eef5fb] px-2.5 py-0.5 text-xs font-semibold text-[#0A2540]';
@endphp

<x-admin-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-base sm:text-lg font-bold text-[#0A2540] leading-tight tracking-tight">
                {{ __('Detail News') }}
            </h2>
            <p class="text-xs text-slate-500">Preview news article before or after publishing</p>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">

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
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-5 pt-5 pb-4 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-[#0A2540]">Preview news</h3>
                    <p class="mt-0.5 text-xs text-slate-500">ID #{{ $news->id }} — /{{ $news->slug }}</p>
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    <a href="{{ route('admin.news.index') }}" class="{{ $btn }}">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back
                    </a>
                    <a href="{{ route('news.edit', $news->id) }}" class="{{ $btnPrimary }}">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </a>
                </div>
            </div>

            {{-- Article Body --}}
            <div class="p-5 sm:p-7">

                <div class="flex flex-wrap items-center gap-2 mb-4">
                    @if($news->category)
                        <span class="{{ $pillGray }}">{{ $news->category }}</span>
                    @endif

                    @if($news->published_at)
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-800">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500" aria-hidden="true"></span>
                            Published: {{ $news->published_at->translatedFormat('d F Y') }}
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-semibold text-amber-800">
                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500" aria-hidden="true"></span>
                            Draft
                        </span>
                    @endif
                </div>

                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0A2540] leading-tight tracking-tight mb-4">
                    {{ $news->title }}
                </h1>

                <div class="flex flex-wrap items-center gap-4 mb-6 pb-5 border-b border-slate-100 text-xs text-slate-500">
                    <div class="flex items-center gap-2">
                        @if($news->updatedBy)
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-[#0A2540] text-[10px] font-bold text-white" aria-hidden="true">
                                {{ strtoupper(substr($news->updatedBy->name, 0, 1)) }}
                            </span>
                            <span>By <strong class="font-semibold text-[#0A2540]">{{ $news->updatedBy->name }}</strong></span>
                        @else
                            <span>By <span class="italic text-slate-400">Not recorded</span></span>
                        @endif
                    </div>

                    <div class="flex items-center gap-1.5">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Updated <strong class="font-semibold text-[#0A2540]">{{ optional($news->updated_at)->diffForHumans() ?? '-' }}</strong></span>
                    </div>
                </div>

                @if($news->image_url)
                    <div class="aspect-[16/9] rounded-2xl overflow-hidden bg-[#f6f9fc] border border-slate-100 mb-6">
                        <img src="{{ $news->image_url }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
                    </div>
                @endif

                @if($news->excerpt)
                    <div class="rounded-xl bg-[#f6f9fc] border border-slate-100 p-4 mb-6">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Excerpt</p>
                        <p class="text-sm text-slate-700 leading-relaxed">{{ $news->excerpt }}</p>
                    </div>
                @endif

                <div class="prose prose-slate max-w-none
                            prose-headings:text-[#0A2540] prose-headings:font-bold
                            prose-a:text-[#EC2029] prose-a:no-underline hover:prose-a:underline
                            prose-img:rounded-xl">
                    {!! $news->content !!}
                </div>

            </div>

            {{-- Footer Actions --}}
            <div class="px-5 sm:px-7 py-4 bg-[#f6f9fc] border-t border-slate-100 flex flex-wrap items-center justify-end gap-2">
                <a href="{{ route('admin.news.index') }}" class="{{ $btn }} !bg-white">
                    Back to list
                </a>

                <a href="{{ route('news.show', $news->slug) }}" target="_blank" rel="noopener" class="{{ $btn }} !bg-white">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    View on public page
                </a>

                <a href="{{ route('news.edit', $news->id) }}" class="{{ $btnPrimary }}">
                    Edit news
                </a>

                <form action="{{ route('news.destroy', $news->id) }}"
                      method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus berita ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="{{ $btnDanger }}">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete
                    </button>
                </form>
            </div>

        </section>

    </div>
</x-admin-layout>