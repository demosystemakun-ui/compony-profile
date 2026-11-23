<x-admin-layout>
    <x-slot name="header">
        {{-- Header disembunyikan karena kita menggunakan header kustom di dalam body --}}
    </x-slot>

    <div class="py-8 bg-gray-50/50 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Notifikasi Sukses --}}
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm flex items-center gap-2 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] rounded-2xl border border-gray-100">
                
                {{-- Top Bar: Title, Search, Filter, Add Button --}}
                <div class="p-6 md:p-8 flex flex-col xl:flex-row xl:items-center justify-between gap-4">
                    
                    {{-- Judul --}}
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Tariffs Document</h1>
                        <p class="text-sm text-gray-500 mt-1">Manage and organize your tariff files here.</p>
                    </div>

                    {{-- Form Search & Filter (Otomatis) --}}
                    <form action="{{ route('admin.tariffs.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3 w-full xl:w-auto m-0">
                        
                        {{-- Search Bar --}}
                        <div class="relative w-full sm:w-64">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 transition-colors" 
                                   placeholder="Cari judul... (Tekan Enter)">
                        </div>

                        {{-- Dropdown Filter Kategori (Otomatis submit saat diganti) --}}
                        <select name="tag" onchange="this.form.submit()" class="bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full sm:w-auto p-2.5 cursor-pointer">
                            <option value="">Semua Kategori</option>
                            @foreach(\App\Models\Tariff::TAGS as $tag)
                                <option value="{{ $tag }}" @selected(request('tag') == $tag)>{{ $tag }}</option>
                            @endforeach
                        </select>

                        {{-- Dropdown Filter Status (Otomatis submit saat diganti) --}}
                        <select name="status" onchange="this.form.submit()" class="bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full sm:w-auto p-2.5 cursor-pointer">
                            <option value="">Semua Status</option>
                            <option value="active" @selected(request('status') == 'active')>Tampil</option>
                            <option value="inactive" @selected(request('status') == 'inactive')>Disembunyikan</option>
                        </select>

                        {{-- Tombol Reset (Muncul hanya jika sedang memfilter) --}}
                        @if(request()->anyFilled(['search', 'tag', 'status']))
                            <a href="{{ route('admin.tariffs.index') }}" class="text-sm text-gray-500 hover:text-rose-600 underline whitespace-nowrap px-2">Reset</a>
                        @endif
                    </form>

                    {{-- Tombol Tambah --}}
                    <a href="{{ route('admin.tariffs.create') }}" class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg shadow-sm transition-colors w-full xl:w-auto mt-2 xl:mt-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span class="hidden sm:inline">Tambah Tarif</span>
                        <span class="sm:hidden">Tambah</span>
                    </a>
                </div>

                {{-- Tabel --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="text-gray-400 text-[11px] uppercase tracking-wider border-b border-gray-100">
                                <th class="py-4 px-6 font-semibold">Urutan</th>
                                <th class="py-4 px-6 font-semibold">Judul Tarif</th>
                                <th class="py-4 px-6 font-semibold">Kategori</th>
                                <th class="py-4 px-6 font-semibold">File PDF</th>
                                <th class="py-4 px-6 font-semibold">Status</th>
                                <th class="py-4 px-6 font-semibold">Diperbarui</th>
                                <th class="py-4 px-6 font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-50">
                            @forelse($tariffs as $item)
                                <tr class="hover:bg-gray-50/80 transition-colors group">
                                    {{-- Urutan --}}
                                    <td class="py-4 px-6">
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-md bg-gray-100 text-gray-600 text-xs font-bold">
                                            {{ $item->sort_order }}
                                        </span>
                                    </td>

                                    {{-- Judul --}}
                                    <td class="py-4 px-6">
                                        <div class="font-semibold text-gray-800">{{ $item->title }}</div>
                                        @if($item->description)
                                            <div class="text-xs text-gray-400 truncate max-w-[200px] mt-0.5" title="{{ $item->description }}">{{ $item->description }}</div>
                                        @endif
                                    </td>

                                    {{-- Kategori --}}
                                    <td class="py-4 px-6">
                                        <span class="bg-slate-100 text-slate-600 text-xs font-semibold px-3 py-1 rounded-md border border-slate-200/60">
                                            {{ $item->tag }}
                                        </span>
                                    </td>

                                    {{-- File PDF --}}
                                    <td class="py-4 px-6">
                                        @if($item->hasPdf())
                                            <a href="{{ route('admin.tariffs.preview', $item) }}?v={{ $item->updated_at?->timestamp }}"
                                               target="_blank" rel="noopener"
                                               class="inline-flex items-center gap-1.5 text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-md transition-colors text-xs font-medium">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                Lihat PDF
                                            </a>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-rose-500 bg-rose-50 px-3 py-1.5 rounded-md text-xs font-medium border border-rose-100">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                                Belum diunggah
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Status --}}
                                    <td class="py-4 px-6">
                                        @if($item->is_active)
                                            <span class="inline-flex items-center gap-1.5 text-emerald-700 bg-emerald-50 border border-emerald-200 text-xs font-semibold px-3 py-1 rounded-full">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Tampil
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-gray-600 bg-gray-100 border border-gray-200 text-xs font-semibold px-3 py-1 rounded-full">
                                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                                Disembunyikan
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Diperbarui --}}
                                    <td class="py-4 px-6 text-gray-500 text-xs">
                                        {{ $item->updated_at->format('d M Y, H:i') }}
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="py-4 px-6 text-right">
                                        <div class="flex items-center justify-end gap-2 opacity-100 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('admin.tariffs.edit', $item) }}" class="p-2 text-gray-400 hover:text-amber-500 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </a>
                                            <form action="{{ route('admin.tariffs.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus tarif ini beserta file PDF-nya?');" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-gray-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-16 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <svg class="w-12 h-12 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            @if(request()->anyFilled(['search', 'tag', 'status']))
                                                <p class="text-base font-medium text-gray-500">Tidak ada tarif yang cocok</p>
                                                <p class="text-sm mt-1">Coba ubah kata kunci atau filter Anda.</p>
                                            @else
                                                <p class="text-base font-medium text-gray-500">Belum ada dokumen tarif</p>
                                                <p class="text-sm mt-1">Mulai dengan menambahkan tarif baru.</p>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Footer Tabel (Pagination info dummy ala desain) --}}
                @if($tariffs->count() > 0)
                <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between text-sm text-gray-500 bg-white">
                    <div>
                        Menampilkan <span class="font-medium text-gray-800">{{ $tariffs->count() }}</span> tarif
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="px-3 py-1 text-gray-400 hover:text-gray-600 disabled:opacity-50" disabled>Previous</button>
                        <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-md font-medium">1</span>
                        <button class="px-3 py-1 text-gray-400 hover:text-gray-600 disabled:opacity-50" disabled>Next</button>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</x-admin-layout>