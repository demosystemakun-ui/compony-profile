<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Article') }}
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

                <form action="{{ route('news.update', $news->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Article Title</label>
                        <input type="text" name="title" value="{{ old('title', $news->title) }}" class="w-full border border-gray-300 bg-white rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                        <input type="text" name="category" value="{{ old('category', $news->category) }}" class="w-full border border-gray-300 bg-white rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Update Image (Optional)</label>
                        @if($news->image_url)
                            <div class="mb-3">
                                <img src="{{ $news->image_url }}" alt="Current Image" class="w-32 h-20 object-cover rounded border">
                                <p class="text-xs text-gray-400 mt-1">Gambar saat ini. Pilih file baru hanya jika ingin menggantinya.</p>
                            </div>
                        @endif
                        <input type="file" name="image" accept="image/jpeg,image/png,image/webp" class="w-full border border-gray-300 bg-white rounded-lg p-2.5 text-sm">
                        <p class="text-xs text-gray-500 mt-1">Format JPG, PNG, atau WebP. Maksimal 10 MB.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Short Excerpt</label>
                        <textarea name="excerpt" rows="3" class="w-full border border-gray-300 bg-white rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" required>{{ old('excerpt', $news->excerpt) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Full Content</label>
                        <textarea name="content" rows="6" class="w-full border border-gray-300 bg-white rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" required>{{ old('content', $news->content) }}</textarea>
                    </div>

                    <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-100">
                        <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-800 text-sm font-medium">Cancel</a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2.5 rounded-lg transition-colors shadow-sm">
                            Update Article
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-admin-layout>