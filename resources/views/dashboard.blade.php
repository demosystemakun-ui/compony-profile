<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-wrap gap-3 justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-[#0A2540] leading-tight tracking-tight">
                    {{ __('Dashboard - Kelola Konten') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">Kelola berita, tarif, dan konten publikasi PICT</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.tariffs.create') }}"
                   class="inline-flex items-center gap-1.5 bg-[#0A2540] hover:bg-[#132f4c] text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition-all shadow-md hover:shadow-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Tarif
                </a>
                <a href="{{ route('news.create') }}"
                   class="inline-flex items-center gap-1.5 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition-all shadow-md hover:shadow-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Berita Baru
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-gray-50 via-white to-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="flex items-start gap-3 p-4 bg-green-50 border-l-4 border-green-500 text-green-800 rounded-lg text-sm shadow-sm">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            {{-- ═════════════ KELOLA BERITA ═════════════ --}}
            <div class="bg-white overflow-hidden shadow-md rounded-2xl border border-gray-100">
                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-red-50/50 to-transparent flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-red-600 flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-[#0A2540]">Daftar Berita Terpublikasi</h3>
                        <p class="text-xs text-gray-500">Kelola semua artikel dan berita yang tampil di website</p>
                    </div>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b-2 border-gray-100 text-gray-500 text-xs uppercase tracking-wider bg-gray-50/50">
                                    <th class="py-3.5 px-4 font-bold">Judul</th>
                                    <th class="py-3.5 px-4 font-bold">Kategori</th>
                                    <th class="py-3.5 px-4 font-bold">Tanggal</th>
                                    <th class="py-3.5 px-4 font-bold">Diperbarui Oleh</th>
                                    <th class="py-3.5 px-4 text-center font-bold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @php
                                    $allNews = \App\Models\News::with('updatedBy')->latest()->get();
                                @endphp

                                @forelse($allNews as $item)
                                    <tr class="hover:bg-red-50/30 transition-colors">
                                        <td class="py-4 px-4 font-semibold text-[#0A2540] max-w-xs truncate">{{ $item->title }}</td>
                                        <td class="py-4 px-4">
                                            <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 border border-red-100 text-xs font-semibold px-2.5 py-1 rounded-md">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                                {{ $item->category }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4 text-gray-500 text-xs font-medium">
                                            {{ $item->created_at->format('d M Y') }}
                                        </td>
                                        <td class="py-4 px-4">
                                            @if($item->updatedBy)
                                                <div class="flex items-center gap-2">
                                                    <div class="w-7 h-7 rounded-full bg-gradient-to-br from-red-500 to-red-700 text-white flex items-center justify-center text-[10px] font-bold shadow-sm">
                                                        {{ strtoupper(substr($item->updatedBy->name, 0, 1)) }}
                                                    </div>
                                                    <div class="leading-tight">
                                                        <div class="text-xs font-semibold text-[#0A2540]">{{ $item->updatedBy->name }}</div>
                                                        <div class="text-[10px] text-gray-400">
                                                            {{ $item->updated_at->format('d M Y, H:i') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="inline-flex items-center gap-1 text-[10px] text-gray-400 italic">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                                    </svg>
                                                    Tidak tercatat
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('news.edit', $item->id) }}"
                                                   class="inline-flex items-center gap-1 text-amber-700 hover:bg-amber-100 font-semibold text-xs bg-amber-50 px-3 py-1.5 rounded-md border border-amber-200 transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    Edit
                                                </a>

                                                <form action="{{ route('news.destroy', $item->id) }}" method="POST"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center gap-1 text-red-700 hover:bg-red-100 font-semibold text-xs bg-red-50 px-3 py-1.5 rounded-md border border-red-200 transition-colors">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-12 text-center text-gray-400 text-sm">
                                            <div class="flex flex-col items-center gap-2">
                                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2"/>
                                                </svg>
                                                <span>Belum ada berita yang diunggah.</span>
                                                <span class="text-xs">Klik tombol <span class="text-red-600 font-semibold">"+ Tambah Berita Baru"</span> di atas.</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ═════════════ KELOLA TARIF ═════════════ --}}
            <div class="bg-white overflow-hidden shadow-md rounded-2xl border border-gray-100">
                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-blue-50/50 to-transparent flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-[#0A2540] flex items-center justify-center shadow-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-[#0A2540]">Dokumen Tarif</h3>
                            <p class="text-xs text-gray-500">Kelola dokumen tarif layanan dalam format PDF</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.tariffs.index') }}"
                       class="inline-flex items-center gap-1 text-sm font-semibold text-[#0A2540] hover:text-red-600 transition-colors">
                        Lihat semua
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b-2 border-gray-100 text-gray-500 text-xs uppercase tracking-wider bg-gray-50/50">
                                    <th class="py-3.5 px-4 font-bold">Judul</th>
                                    <th class="py-3.5 px-4 font-bold">Kategori</th>
                                    <th class="py-3.5 px-4 font-bold">File PDF</th>
                                    <th class="py-3.5 px-4 font-bold">Diperbarui Oleh</th>
                                    <th class="py-3.5 px-4 text-center font-bold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @php
                                    $allTariffs = \App\Models\Tariff::with('updatedBy')->orderBy('sort_order')->orderBy('id')->get();
                                @endphp

                                @forelse($allTariffs as $tariff)
                                    <tr class="hover:bg-blue-50/30 transition-colors">
                                        <td class="py-4 px-4 font-semibold text-[#0A2540] max-w-xs truncate">
                                            {{ $tariff->title }}
                                            @unless($tariff->is_active)
                                                <span class="ml-2 text-[10px] font-semibold text-gray-500 bg-gray-100 border border-gray-200 px-1.5 py-0.5 rounded">
                                                    Disembunyikan
                                                </span>
                                            @endunless
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="inline-flex items-center gap-1 bg-[#0A2540]/5 text-[#0A2540] border border-[#0A2540]/10 text-xs font-semibold px-2.5 py-1 rounded-md">
                                                <span class="w-1.5 h-1.5 rounded-full bg-[#0A2540]"></span>
                                                {{ $tariff->tag }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4">
                                            @if($tariff->hasPdf())
                                                <a href="{{ $tariff->pdfUrl() }}" target="_blank"
                                                   class="inline-flex items-center gap-1 text-blue-700 hover:text-blue-900 text-xs font-semibold hover:underline">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                    Lihat PDF
                                                </a>
                                            @else
                                                <span class="inline-flex items-center gap-1 text-xs text-red-600 font-semibold bg-red-50 border border-red-100 px-2 py-1 rounded">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                    </svg>
                                                    Belum diunggah
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-4">
                                            @if($tariff->updatedBy)
                                                <div class="flex items-center gap-2">
                                                    <div class="w-7 h-7 rounded-full bg-gradient-to-br from-[#0A2540] to-[#1a3a5f] text-white flex items-center justify-center text-[10px] font-bold shadow-sm">
                                                        {{ strtoupper(substr($tariff->updatedBy->name, 0, 1)) }}
                                                    </div>
                                                    <div class="leading-tight">
                                                        <div class="text-xs font-semibold text-[#0A2540]">{{ $tariff->updatedBy->name }}</div>
                                                        <div class="text-[10px] text-gray-400">
                                                            {{ $tariff->updated_at->format('d M Y, H:i') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="inline-flex items-center gap-1 text-[10px] text-gray-400 italic">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                                    </svg>
                                                    Tidak tercatat
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('admin.tariffs.edit', $tariff) }}"
                                                   class="inline-flex items-center gap-1 text-amber-700 hover:bg-amber-100 font-semibold text-xs bg-amber-50 px-3 py-1.5 rounded-md border border-amber-200 transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    Edit
                                                </a>

                                                <form action="{{ route('admin.tariffs.destroy', $tariff) }}" method="POST"
                                                      onsubmit="return confirm('Hapus tarif ini beserta file PDF-nya?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center gap-1 text-red-700 hover:bg-red-100 font-semibold text-xs bg-red-50 px-3 py-1.5 rounded-md border border-red-200 transition-colors">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-12 text-center text-gray-400 text-sm">
                                            <div class="flex flex-col items-center gap-2">
                                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                <span>Belum ada tarif.</span>
                                                <span class="text-xs">Klik tombol <span class="text-[#0A2540] font-semibold">"+ Tambah Tarif"</span> di atas.</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>