<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-wrap gap-3 justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-[#0A2540] leading-tight tracking-tight">
                    {{ __('Manage Terminal Gallery') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">Manage images that appear on the Home, Operations, and Services pages.</p>
            </div>
            <button onclick="openModal('add')" class="bg-[#EC2029] hover:bg-[#961c22] text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                + Add Image
            </button>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-6 flex items-start gap-3 p-4 bg-green-50 border-l-4 border-green-500 text-green-800 rounded-lg text-sm shadow-sm">
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-[#0A2540]">Image Gallery List</h3>
                <p class="text-xs text-gray-500">All images managed here will automatically display on the public pages</p>
            </div>
        </div>

        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b-2 border-gray-100 text-gray-500 text-xs uppercase tracking-wider bg-gray-50/50">
                            <th class="py-3.5 px-4 font-bold">Image</th>
                            <th class="py-3.5 px-4 font-bold">Title & Description</th>
                            <th class="py-3.5 px-4 font-bold">Page / Section</th>
                            <th class="py-3.5 px-4 font-bold">Tag</th>
                            <th class="py-3.5 px-4 text-center font-bold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($galleries as $item)
                        <tr class="hover:bg-red-50/30 transition-colors">
                            <td class="py-4 px-4">
                                {{-- ✅ PERBAIKAN: pakai image_url --}}
                                <img src="{{ $item->image_url }}"
                                     alt="{{ $item->title }}"
                                     class="w-32 h-20 object-cover rounded-lg border border-gray-200">
                            </td>
                            <td class="py-4 px-4 max-w-xs">
                                <p class="font-bold text-[#0A2540] truncate">{{ $item->title }}</p>
                                <p class="text-gray-500 text-xs line-clamp-2 mt-1">{{ $item->description }}</p>
                            </td>
                            <td class="py-4 px-4">
                                <span class="inline-block bg-blue-50 text-blue-700 border border-blue-100 text-[10px] font-bold px-2 py-1 rounded uppercase mb-1">
                                    {{ $item->page }}
                                </span>
                                <p class="text-slate-500 text-[11px] font-medium">{{ $item->section }}</p>
                            </td>
                            <td class="py-4 px-4">
                                <span class="bg-red-50 text-red-700 border border-red-100 text-[10px] font-bold px-2 py-1 rounded uppercase">{{ $item->tag }}</span>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick="openModal('edit', {{ $item }})" class="inline-flex items-center gap-1 text-amber-700 hover:bg-amber-100 font-semibold text-xs bg-amber-50 px-3 py-1.5 rounded-md border border-amber-200 transition-colors">
                                        Edit
                                    </button>
                                    <form action="{{ route('gallery.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus gambar ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 text-red-700 hover:bg-red-100 font-semibold text-xs bg-red-50 px-3 py-1.5 rounded-md border border-red-200 transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-400 text-sm">No gallery data available. Please click "+ Add Image".</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Form --}}
    <div id="galleryModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <form id="galleryForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                
                <div class="p-6 border-b border-slate-100 flex justify-between items-center sticky top-0 bg-white z-10">
                    <h3 id="modalTitle" class="text-lg font-bold text-[#0A2540]">Add New Image</h3>
                    <button type="button" onclick="closeModal()" class="text-slate-400 hover:text-slate-600 text-2xl leading-none">&times;</button>
                </div>

                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Image Title</label>
                        <input type="text" name="title" id="inputTitle" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#EC2029] focus:border-[#EC2029] outline-none">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Target Page</label>
                            <select name="page" id="inputPage" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#EC2029] outline-none">
                                <option value="home">Home</option>
                                <option value="operations">Operations</option>
                                <option value="services">Services</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Section</label>
                            <select name="section" id="inputSection" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#EC2029] outline-none">
                                <option value="terminal_gallery">terminal_gallery (Home)</option>
                                <option value="gallery">gallery (Operations)</option>
                                <option value="portfolio">portfolio (Services)</option>
                                <option value="value_added">value_added (Services)</option>
                            </select>
                            <p class="text-[10px] text-slate-400 mt-1">Select the target page.</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Sort Order</label>
                        <input type="number" name="sort_order" id="inputSort" value="0" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#EC2029] outline-none">
                        <p class="text-[10px] text-slate-400 mt-1">Smaller numbers appear first.</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tag (Badge)</label>
                            <input type="text" name="tag" id="inputTag" required placeholder="Example: CBU Units" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#EC2029] outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Info Tanggal</label>
                            <input type="text" name="date_info" id="inputDate" required placeholder="Example: Quality Control" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#EC2029] outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Lokasi / Fitur</label>
                        <input type="text" name="location" id="inputLocation" required placeholder="Example: Inspection Area" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#EC2029] outline-none">
                        <p class="text-[10px] text-slate-400 mt-1">For bullet points in Services, separate with the <code>|</code> symbol. Example: <code>300m Pier|Mooring Teams|Fresh Water</code></p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Deskripsi</label>
                        <textarea name="description" id="inputDescription" rows="3" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#EC2029] outline-none"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Upload Image</label>
                        <input type="file" name="image" id="inputImage" accept="image/*" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#0A2540] file:text-white hover:file:bg-slate-800">
                        <p id="imageHelp" class="text-xs text-slate-400 mt-1 hidden">Leave blank if you don't want to change the image.</p>
                    </div>
                </div>

                <div class="p-6 border-t border-slate-100 flex justify-end gap-3 sticky bottom-0 bg-white">
                    <button type="button" onclick="closeModal()" class="px-5 py-2.5 rounded-lg text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-lg text-sm font-semibold text-white bg-[#EC2029] hover:bg-[#961c22] transition-colors">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(mode, data = null) {
            const modal = document.getElementById('galleryModal');
            const form = document.getElementById('galleryForm');
            const title = document.getElementById('modalTitle');
            const method = document.getElementById('formMethod');
            const imageHelp = document.getElementById('imageHelp');

            if (mode === 'add') {
                title.innerText = 'Tambah Gambar Baru';
                form.action = "{{ route('gallery.store') }}";
                method.value = 'POST';
                form.reset();
                imageHelp.classList.add('hidden');
                document.getElementById('inputImage').required = true;
            } else {
                title.innerText = 'Edit Gambar';
                form.action = "{{ url('/pict-internal-admin-portal/gallery') }}/" + data.id;
                method.value = 'PUT';
                
                document.getElementById('inputTitle').value = data.title;
                document.getElementById('inputPage').value = data.page || 'operations';
                document.getElementById('inputSection').value = data.section || 'gallery';
                document.getElementById('inputSort').value = data.sort_order || 0;
                document.getElementById('inputTag').value = data.tag;
                document.getElementById('inputDate').value = data.date_info;
                document.getElementById('inputLocation').value = data.location;
                document.getElementById('inputDescription').value = data.description;
                
                imageHelp.classList.remove('hidden');
                document.getElementById('inputImage').required = false;
            }

            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('galleryModal').classList.add('hidden');
        }
    </script>
</x-admin-layout>