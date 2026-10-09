<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Article') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- ═══════════════════════════════════════════════ --}}
            {{-- FORM TAMBAH BERITA --}}
            {{-- ═══════════════════════════════════════════════ --}}
            <div class="max-w-3xl mx-auto">
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 p-6 sm:p-8 text-gray-900">

                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-800 rounded-lg text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Article Title</label>
                            <input type="text" name="title" value="{{ old('title') }}" placeholder="Enter article title..."
                                   class="w-full border border-gray-300 bg-white rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                            <input type="text" name="category" value="{{ old('category') }}" placeholder="e.g. Operations, Terminal Update, Safety"
                                   class="w-full border border-gray-300 bg-white rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                        </div>

                        {{-- Image Upload & Camera Section --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Image / Capture Photo</label>

                            {{-- Image Preview Area --}}
                            <div id="preview-container" class="mb-4 hidden">
                                <img id="image-preview" src="#" alt="Preview" class="w-full max-h-64 object-contain rounded-lg border border-gray-200 bg-gray-50 p-2">
                            </div>

                            <div class="flex flex-wrap gap-3">
                                <input type="file" name="image" id="cameraInput" accept="image/*" capture="environment" class="hidden" onchange="previewImage(event)">
                                <input type="file" name="image_gallery" id="galleryInput" accept="image/*" class="hidden" onchange="previewImage(event)">

                                <button type="button" onclick="document.getElementById('cameraInput').click()"
                                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Take Photo (Camera)
                                </button>

                                <button type="button" onclick="document.getElementById('galleryInput').click()"
                                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Choose from Gallery
                                </button>

                                <button type="button" id="removeBtn" onclick="clearImage()"
                                    class="hidden inline-flex items-center gap-2 px-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-700 text-sm font-medium rounded-lg transition-colors border border-red-200">
                                    Remove Image
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Use the camera button to take a direct photo or gallery to choose from storage.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Short Excerpt</label>
                            <textarea name="excerpt" rows="3" placeholder="Brief summary of the article..."
                                      class="w-full border border-gray-300 bg-white rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" required>{{ old('excerpt') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Full Content</label>
                            <textarea name="content" rows="6" placeholder="Write the complete article content here..."
                                      class="w-full border border-gray-300 bg-white rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" required>{{ old('content') }}</textarea>
                        </div>

                        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-800 text-sm font-medium">Cancel</a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2.5 rounded-lg transition-colors shadow-sm">
                                Save Article
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ═══════════════════════════════════════════════ --}}
            {{-- TABEL DATA BERITA --}}
            {{-- ═══════════════════════════════════════════════ --}}
            <div class="bg-white overflow-hidden shadow-md rounded-2xl border border-gray-100">

                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-red-50/50 to-transparent flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-red-600 flex items-center justify-center shadow-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-[#0A2540]">Daftar Berita Terpublikasi</h3>
                            <p class="text-xs text-gray-500">Kelola semua artikel dan berita yang tampil di website</p>
                        </div>
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
                                        $daysAgo = $item->updated_at
                                            ? $item->updated_at->diffInDays(now())
                                            : 0;
                                    @endphp
                                    <tr class="hover:bg-red-50/30 transition-colors">

                                        {{-- Gambar --}}
                                        <td class="py-3 px-4">
                                            @if($item->image_url)
                                                <div class="w-16 h-12 rounded-lg overflow-hidden bg-gray-100 border border-gray-200">
                                                    <img src="{{ $item->image_url }}"
                                                         alt="{{ $item->title }}"
                                                         class="w-full h-full object-cover"
                                                         loading="lazy">
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

                                        {{-- Judul --}}
                                        <td class="py-3 px-4">
                                            <p class="font-semibold text-[#0A2540] max-w-xs truncate">{{ $item->title }}</p>
                                            <p class="text-[11px] text-gray-400 mt-0.5 truncate max-w-xs">/{{ $item->slug }}</p>
                                        </td>

                                        {{-- Kategori --}}
                                        <td class="py-3 px-4">
                                            <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 border border-red-100 text-xs font-semibold px-2.5 py-1 rounded-md">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                                {{ $item->category }}
                                            </span>
                                        </td>

                                        {{-- Diperbarui --}}
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
                                                    <span class="text-gray-500">
                                                        {{ optional($item->updated_at)->diffForHumans() ?? '-' }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>

                                        {{-- Oleh --}}
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

                                        {{-- Aksi: Detail / Edit / Hapus --}}
                                        <td class="py-3 px-4">
                                            <div class="flex items-center justify-center gap-2">

                                                {{-- Detail --}}
                                                <a href="{{ route('news.show', $item->slug) }}"
                                                   target="_blank" rel="noopener"
                                                   title="Lihat detail berita"
                                                   class="inline-flex items-center gap-1 text-blue-700 hover:bg-blue-100 font-semibold text-xs bg-blue-50 px-3 py-1.5 rounded-md border border-blue-200 transition-colors">
                                                    Detail
                                                </a>

                                                {{-- Edit --}}
                                                <a href="{{ route('news.edit', $item->id) }}"
                                                   title="Edit berita"
                                                   class="inline-flex items-center gap-1 text-amber-700 hover:bg-amber-100 font-semibold text-xs bg-amber-50 px-3 py-1.5 rounded-md border border-amber-200 transition-colors">
                                                    Edit
                                                </a>

                                                {{-- Hapus --}}
                                                <form action="{{ route('news.destroy', $item->id) }}" method="POST"
                                                      onsubmit="return confirm('Yakin ingin menghapus berita ini? Tindakan tidak dapat dibatalkan.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            title="Hapus berita"
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

    {{-- Vanilla JavaScript for Preview & Reset --}}
    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('image-preview').src = e.target.result;
                    document.getElementById('preview-container').classList.remove('hidden');
                    document.getElementById('removeBtn').classList.remove('hidden');
                }
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
</x-admin-layout>