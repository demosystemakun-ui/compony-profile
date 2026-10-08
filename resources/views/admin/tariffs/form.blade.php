@php $isEdit = $tariff->exists; @endphp

<x-admin-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-[#0A2540] leading-tight tracking-tight">
                {{ $isEdit ? 'Edit Tarif' : 'Tambah Tarif' }}
            </h2>
            <p class="text-xs text-gray-500 mt-1">
                {{ $isEdit ? 'Perbarui informasi dokumen tarif layanan' : 'Tambahkan dokumen tarif layanan baru' }}
            </p>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="POST"
                  action="{{ $isEdit ? route('admin.tariffs.update', $tariff) : route('admin.tariffs.store') }}"
                  enctype="multipart/form-data"
                  class="bg-white shadow-md rounded-2xl border border-gray-100 overflow-hidden">

                {{-- Header Card --}}
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50/50 to-transparent flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-[#0A2540] flex items-center justify-center shadow-sm flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-[#0A2540]">
                            {{ $isEdit ? 'Formulir Edit Tarif' : 'Formulir Tarif Baru' }}
                        </h3>
                        <p class="text-xs text-gray-500">Lengkapi informasi di bawah ini dengan benar</p>
                    </div>
                </div>

                {{-- Body --}}
                <div class="p-6 space-y-4">
                    @csrf
                    @if($isEdit) @method('PUT') @endif

                    {{-- Kategori & Judul --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-[#0A2540] mb-1.5">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select name="tag"
                                    class="w-full rounded-lg border-gray-300 text-sm focus:border-[#0A2540] focus:ring-[#0A2540] transition-colors" required>
                                <option value="" disabled @selected(!old('tag', $tariff->tag))>Pilih kategori</option>
                                @foreach(\App\Models\Tariff::TAGS as $tag)
                                    <option value="{{ $tag }}" @selected(old('tag', $tariff->tag) === $tag)>{{ $tag }}</option>
                                @endforeach
                            </select>
                            @error('tag') <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p> @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-semibold text-[#0A2540] mb-1.5">
                                Judul <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" value="{{ old('title', $tariff->title) }}" placeholder="Domestic Tariffs"
                                   class="w-full rounded-lg border-gray-300 text-sm focus:border-[#0A2540] focus:ring-[#0A2540] transition-colors" required>
                            @error('title') <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#0A2540] mb-1.5">Deskripsi Singkat</label>
                        <textarea name="description" rows="3"
                                  placeholder="Jelaskan secara singkat isi dokumen tarif ini..."
                                  class="w-full rounded-lg border-gray-300 text-sm focus:border-[#0A2540] focus:ring-[#0A2540] transition-colors resize-none">{{ old('description', $tariff->description) }}</textarea>
                        @error('description') <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p> @enderror
                    </div>

                    {{-- Ikon & Urutan --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-[#0A2540] mb-1.5">Ikon</label>
                            <select name="icon" class="w-full rounded-lg border-gray-300 text-sm focus:border-[#0A2540] focus:ring-[#0A2540] transition-colors">
                                @foreach(['building' => 'Gedung', 'globe' => 'Globe', 'document' => 'Dokumen'] as $key => $label)
                                    <option value="{{ $key }}" @selected(old('icon', $tariff->icon) === $key)>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('icon') <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#0A2540] mb-1.5">Urutan Tampil</label>
                            <input type="number" name="sort_order" min="0" value="{{ old('sort_order', $tariff->sort_order ?? 0) }}"
                                   class="w-full rounded-lg border-gray-300 text-sm focus:border-[#0A2540] focus:ring-[#0A2540] transition-colors">
                            @error('sort_order') <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- PDF --}}
                    <div class="rounded-xl border-2 border-dashed border-[#0A2540]/20 p-4 bg-gradient-to-br from-blue-50/30 to-transparent">
                        <label class="flex items-center gap-2 text-sm font-semibold text-[#0A2540] mb-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            {{ $isEdit && $tariff->hasPdf() ? 'Ganti File PDF' : 'File PDF' }}
                        </label>

                        @if($isEdit && $tariff->hasPdf())
                            <div class="flex items-start gap-2 p-2.5 mb-3 bg-white border border-blue-100 rounded-lg">
                                <svg class="w-4 h-4 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-xs text-gray-600">
                                    File saat ini:
                                    <a href="{{ $tariff->pdfUrl() }}" target="_blank" class="text-[#0A2540] font-semibold hover:text-red-600 hover:underline transition-colors">
                                        {{ basename($tariff->pdf_path) }}
                                    </a>
                                    <span class="text-gray-400">— kosongkan jika tidak ingin mengganti.</span>
                                </p>
                            </div>
                        @endif

                        <input type="file" name="pdf" accept="application/pdf"
                               class="block w-full text-sm text-gray-600 file:mr-3 file:rounded-lg file:border-0 file:bg-[#0A2540] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-[#132f4c] file:cursor-pointer file:transition-colors file:shadow-sm">
                        <p class="text-xs text-gray-400 mt-2 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Format PDF, maksimal 20 MB.
                        </p>
                        @error('pdf') <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p> @enderror

                        @if($isEdit && $tariff->hasPdf())
                            <label class="mt-3 flex items-center gap-2 text-xs text-red-600 cursor-pointer select-none bg-red-50 border border-red-100 px-3 py-2 rounded-lg hover:bg-red-100 transition-colors">
                                <input type="checkbox" name="remove_pdf" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                <span class="font-semibold">Hapus file PDF saja</span>
                                <span class="text-red-500">(kartu tampil sebagai "Unavailable")</span>
                            </label>
                        @endif
                    </div>

                    {{-- Aktif --}}
                    <label class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100 cursor-pointer hover:bg-gray-100/70 transition-colors">
                        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $tariff->is_active ?? true))
                               class="rounded border-gray-300 text-[#0A2540] focus:ring-[#0A2540] w-4 h-4 flex-shrink-0">
                        <div>
                            <div class="text-sm font-semibold text-[#0A2540]">Tampilkan di halaman publik</div>
                            <div class="text-xs text-gray-500">Jika dinonaktifkan, tarif ini tidak akan muncul di website</div>
                        </div>
                    </label>
                </div>

                {{-- Footer --}}
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between gap-3">
                    <a href="{{ route('admin.tariffs.index') }}"
                       class="inline-flex items-center gap-1.5 text-sm text-gray-600 hover:text-[#0A2540] font-semibold px-4 py-2 rounded-lg hover:bg-gray-200/60 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex items-center gap-1.5 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg shadow-md hover:shadow-lg transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Tarif' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
