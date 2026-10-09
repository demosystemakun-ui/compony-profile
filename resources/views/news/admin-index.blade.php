<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-wrap gap-3 justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-[#0A2540] leading-tight tracking-tight">
                    {{ __('Kelola Berita') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">Kelola semua artikel berita yang tampil di website</p>
            </div>
            <a href="{{ route('news.create') }}"
               class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg shadow-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Berita
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-gray-50 via-white to-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="flex items-start gap-3 p-4 bg-green-50 border-l-4 border-green-500 text-green-800 rounded-lg text-sm shadow-sm">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-md rounded-2xl border border-gray-100">
                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-red-50/50 to-transparent flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-red-600 flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-[#0A2540]">Daftar Berita</h3>
                        <p class="text-xs text-gray-500">Total: {{ $newsList->total() }} berita</p>
                    </div>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b-2 border-gray-100 text-gray-500 text-xs uppercase tracking-wider bg-gray-50/50">
                                    <th class="py-3.5 px-4 font-bold">Gambar</th>
                                    <th class="py-3.5 px-4 font-bold">Judul</th>
                                    <th class="py-3.5 px-4 font-bold">Kategori</th>
                                    <th class="py-3.5 px-4 font-bold">Diperbarui</th>
                                    <th class="py-3.5 px-4 font-bold">Oleh</th>
                                    <th class="py-3.5 px-4 text-center font-bold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @forelse($newsList as $item)
                                    @php
                                        $daysAgo = $item->updated_at ? $item->updated_at->diffInDays(now()) : 0;
                                    @endphp
                                    <tr class="hover:bg-red-50/30 transition-colors">
                                        <td class="py-3 px-4">
                                            @if($item->image_url)
                                                <div class="w-16 h-12 rounded-lg overflow-hidden bg-gray-100 border border-gray-200">
                                                    <img src="{{ $item->image_url }}" alt="{{ $item->title }}"
                                                         class="w-full h-full object-cover" loading="lazy">
                                                </div>
                                            @else
                                                <div class="w-16 h-12 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-400">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </td>

                                        <td class="py-3 px-4">
                                            <p class="font-semibold text-[#0A2540] max-w-xs truncate">{{ $item->title }}</p>
                                            <p class="text-[11px] text-gray-400 mt-0.5 truncate max-w-xs">/{{ $item->slug }}</p>
                                        </td>

                                        <td class="py-3 px-4">
                                            <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 border border-red-100 text-xs font-semibold px-2.5 py-1 rounded-md">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                                {{ $item->category }}
                                            </span>
                                        </td>

                                        <td class="py-3 px-4 text-xs">
                                            <div class="flex items-center gap-1.5">
                                                @if($daysAgo > 30)
                                                    <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                                                    <span class="text-red-600 font-semibold">{{ $daysAgo }} hari lalu</span>
                                                @elseif($daysAgo > 7)
                                                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                                    <span class="text-amber-600 font-medium">{{ $daysAgo }} hari lalu</span>
                                                @else
                                                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                                    <span class="text-gray-500">{{ optional($item->updated_at)->diffForHumans() ?? '-' }}</span>
                                                @endif
                                            </div>
                                        </td>

                                        <td class="py-3 px-4">
                                            @if($item->updatedBy)
                                                <div class="flex items-center gap-2">
                                                    <div class="w-7 h-7 rounded-full bg-gradient-to-br from-red-500 to-red-700 text-white flex items-center justify-center text-[10px] font-bold shadow-sm">
                                                        {{ strtoupper(substr($item->updatedBy->name, 0, 1)) }}
                                                    </div>
                                                    <span class="text-xs font-semibold text-[#0A2540]">{{ $item->updatedBy->name }}</span>
                                                </div>
                                            @else
                                                <span class="text-[10px] text-gray-400 italic">Tidak tercatat</span>
                                            @endif
                                        </td>

                                        <td class="py-3 px-4">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('admin.news.show', $item->id) }}"
                                                   class="inline-flex items-center gap-1 text-blue-700 hover:bg-blue-100 font-semibold text-xs bg-blue-50 px-3 py-1.5 rounded-md border border-blue-200 transition-colors">
                                                    Detail
                                                </a>
                                                <a href="{{ route('news.edit', $item->id) }}"
                                                   class="inline-flex items-center gap-1 text-amber-700 hover:bg-amber-100 font-semibold text-xs bg-amber-50 px-3 py-1.5 rounded-md border border-amber-200 transition-colors">
                                                    Edit
                                                </a>
                                                <form action="{{ route('news.destroy', $item->id) }}" method="POST"
                                                      onsubmit="return confirm('Yakin ingin menghapus berita ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center gap-1 text-red-700 hover:bg-red-100 font-semibold text-xs bg-red-50 px-3 py-1.5 rounded-md border border-red-200 transition-colors">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-12 text-center text-gray-400 text-sm">
                                            Belum ada berita.
                                            <a href="{{ route('news.create') }}" class="text-red-600 font-semibold hover:underline">
                                                Tambah sekarang
                                            </a>.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($newsList->hasPages())
                        <div class="mt-6 flex justify-center">
                            {{ $newsList->links() }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>