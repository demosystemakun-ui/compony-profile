<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Article') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
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

                <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Article Title</label>
                        <input type="text" name="title" value="{{ old('title') }}" placeholder="Enter article title..." class="w-full border border-gray-300 bg-white rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                        <input type="text" name="category" value="{{ old('category') }}" placeholder="e.g. Operations, Terminal Update, Safety" class="w-full border border-gray-300 bg-white rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                    </div>

                    {{-- Image Upload & Camera Section --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Image / Capture Photo</label>
                        
                        {{-- Image Preview Area --}}
                        <div id="preview-container" class="mb-4 hidden">
                            <img id="image-preview" src="#" alt="Preview" class="w-full max-h-64 object-contain rounded-lg border border-gray-200 bg-gray-50 p-2">
                        </div>

                        <div class="flex flex-wrap gap-3">
                            {{-- Camera Input --}}
                            <input type="file" name="image" id="cameraInput" accept="image/*" capture="environment" class="hidden" onchange="previewImage(event)">

                            {{-- Gallery Input --}}
                            <input type="file" name="image_gallery" id="galleryInput" accept="image/*" class="hidden" onchange="previewImage(event)">

                            {{-- Camera Button --}}
                            <button type="button" onclick="document.getElementById('cameraInput').click()" 
                                class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Take Photo (Camera)
                            </button>

                            {{-- Gallery Button --}}
                            <button type="button" onclick="document.getElementById('galleryInput').click()" 
                                class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Choose from Gallery
                            </button>

                            {{-- Remove Button --}}
                            <button type="button" id="removeBtn" onclick="clearImage()" 
                                class="hidden inline-flex items-center gap-2 px-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-700 text-sm font-medium rounded-lg transition-colors border border-red-200">
                                Remove Image
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Use the camera button to take a direct photo or gallery to choose from storage.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Short Excerpt</label>
                        <textarea name="excerpt" rows="3" placeholder="Brief summary of the article..." class="w-full border border-gray-300 bg-white rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" required>{{ old('excerpt') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Full Content</label>
                        <textarea name="content" rows="6" placeholder="Write the complete article content here..." class="w-full border border-gray-300 bg-white rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" required>{{ old('content') }}</textarea>
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