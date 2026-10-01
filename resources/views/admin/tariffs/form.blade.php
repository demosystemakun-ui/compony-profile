@php $isEdit = $tariff->exists; @endphp

<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $isEdit ? 'Edit Tarif' : 'Tambah Tarif' }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <form method="POST"
                  action="{{ $isEdit ? route('admin.tariffs.update', $tariff) : route('admin.tariffs.store') }}"
                  enctype="multipart/form-data"
                  class="bg-white shadow-sm rounded-xl border border-gray-100 p-6 space-y-5">
                @csrf
                @if($isEdit) @method('PUT') @endif

                {{-- Kategori & Judul --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="tag"
                                class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="" disabled @selected(!old('tag', $tariff->tag))>Pilih kategori</option>
                            @foreach(\App\Models\Tariff::TAGS as $tag)
                                <option value="{{ $tag }}" @selected(old('tag', $tariff->tag) === $tag)>{{ $tag }}</option>
                            @endforeach
                        </select>
                        @error('tag') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                        <input type="text" name="title" value="{{ old('title', $tariff->title) }}" placeholder="Domestic Tariffs"
                               class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500" required>
                        @error('title') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi singkat</label>
                    <textarea name="description" rows="3"
                              class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $tariff->description) }}</textarea>
                    @error('description') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Ikon & Urutan --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ikon</label>
                        <select name="icon" class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                            @foreach(['building' => 'Gedung', 'globe' => 'Globe', 'document' => 'Dokumen'] as $key => $label)
                                <option value="{{ $key }}" @selected(old('icon', $tariff->icon) === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('icon') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Urutan tampil</label>
                        <input type="number" name="sort_order" min="0" value="{{ old('sort_order', $tariff->sort_order ?? 0) }}"
                               class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('sort_order') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- PDF --}}
                <div class="rounded-lg border border-dashed border-gray-300 p-4 bg-gray-50/60">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        {{ $isEdit && $tariff->hasPdf() ? 'Ganti file PDF' : 'File PDF' }}
                    </label>

                    @if($isEdit && $tariff->hasPdf())
                        <p class="text-xs text-gray-500 mb-3">
                            File saat ini:
                            <a href="{{ $tariff->pdfUrl() }}" target="_blank" class="text-blue-600 hover:underline">{{ basename($tariff->pdf_path) }}</a>
                            — kosongkan jika tidak ingin mengganti.
                        </p>
                    @endif

                    <input type="file" name="pdf" accept="application/pdf"
                           class="block w-full text-sm text-gray-600 file:mr-3 file:rounded-lg file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-xs text-gray-400 mt-2">Format PDF, maksimal 20 MB.</p>
                    @error('pdf') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror

                    @if($isEdit && $tariff->hasPdf())
                        <label class="mt-3 flex items-center gap-2 text-xs text-red-600">
                            <input type="checkbox" name="remove_pdf" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                            Hapus file PDF saja (kartu tampil sebagai "Unavailable")
                        </label>
                    @endif
                </div>

                {{-- Aktif --}}
                <label class="flex items-center gap-2 text-sm text-gray-700">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $tariff->is_active ?? true))
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    Tampilkan di halaman publik
                </label>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ route('admin.tariffs.index') }}" class="text-sm text-gray-600 hover:text-gray-900 px-4 py-2">Batal</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2 rounded-lg shadow transition-colors">
                        {{ $isEdit ? 'Simpan perubahan' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>