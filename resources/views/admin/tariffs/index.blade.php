<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard - Kelola Tarif') }}
            </h2>
            <a href="{{ route('admin.tariffs.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors shadow">
                + Tambah Tarif
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Daftar Dokumen Tarif</h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-200 text-gray-500 text-xs uppercase tracking-wider bg-gray-50/50">
                                    <th class="py-3 px-4 font-semibold">Urutan</th>
                                    <th class="py-3 px-4 font-semibold">Judul</th>
                                    <th class="py-3 px-4 font-semibold">Kategori</th>
                                    <th class="py-3 px-4 font-semibold">File PDF</th>
                                    <th class="py-3 px-4 font-semibold">Status</th>
                                    <th class="py-3 px-4 font-semibold">Diperbarui</th>
                                    <th class="py-3 px-4 text-center font-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @forelse($tariffs as $item)
                                    <tr class="hover:bg-gray-50/80 transition-colors">
                                        <td class="py-3.5 px-4 text-gray-500">{{ $item->sort_order }}</td>
                                        <td class="py-3.5 px-4 font-medium text-gray-900">{{ $item->title }}</td>
                                        <td class="py-3.5 px-4">
                                            <span class="bg-blue-50 text-blue-700 border border-blue-100 text-xs font-semibold px-2.5 py-1 rounded-md">
                                                {{ $item->tag }}
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            @if($item->hasPdf())
                                                <a href="{{ route('admin.tariffs.preview', $item) }}?v={{ $item->updated_at?->timestamp }}"
                                                   target="_blank" rel="noopener"
                                                   class="text-blue-600 hover:underline text-xs font-medium">Lihat PDF</a>
                                            @else
                                                <span class="text-xs text-red-500 font-medium">Belum diunggah</span>
                                            @endif
                                        </td>
                                        <td class="py-3.5 px-4">
                                            @if($item->is_active)
                                                <span class="text-xs font-semibold text-green-700 bg-green-50 border border-green-100 px-2.5 py-1 rounded-md">Tampil</span>
                                            @else
                                                <span class="text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 px-2.5 py-1 rounded-md">Disembunyikan</span>
                                            @endif
                                        </td>
                                        <td class="py-3.5 px-4 text-gray-500 text-xs">{{ $item->updated_at->format('d M Y H:i') }}</td>
                                        <td class="py-3.5 px-4 text-center">
                                            <div class="flex items-center justify-center space-x-3">
                                                <a href="{{ route('admin.tariffs.edit', $item) }}" class="text-amber-600 hover:text-amber-700 hover:underline font-medium text-xs bg-amber-50 px-2.5 py-1 rounded border border-amber-100">Edit</a>

                                                <form action="{{ route('admin.tariffs.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus tarif ini beserta file PDF-nya?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-700 hover:underline font-medium text-xs bg-red-50 px-2.5 py-1 rounded border border-red-100">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-8 text-center text-gray-400 text-sm">
                                            Belum ada tarif. Klik <span class="text-blue-600 font-semibold">"+ Tambah Tarif"</span> di atas.
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
