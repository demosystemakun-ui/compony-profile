<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    /**
     * Daftar gallery di admin panel.
     */
    public function index()
    {
        $galleries = Gallery::latest()->get();
        return view('admin.gallery.index', compact('galleries'));
    }

    /**
     * Stream gambar dari Supabase Storage.
     * Method ini meniru pola TariffController@stream.
     */
    public function image(Gallery $gallery)
    {
        $disk = Storage::disk('supabase-gallery');

        if (!$gallery->image || !$disk->exists($gallery->image)) {
            abort(404, 'Gambar tidak ditemukan.');
        }

        // Deteksi MIME type
        $mimeType = $disk->mimeType($gallery->image) ?: 'image/jpeg';

        return response()->stream(function () use ($disk, $gallery) {
            $stream = $disk->readStream($gallery->image);
            fpassthru($stream);
            if (is_resource($stream)) {
                fclose($stream);
            }
        }, 200, [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }

    /**
     * Simpan gallery baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'tag' => 'required|string|max:255',
            'date_info' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'page' => 'required|string|in:home,operations,services',
            'section' => 'required|string|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        $data = $request->all();
        $data['sort_order'] = $request->input('sort_order', 0);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'gallery/' . Str::uuid() . '.' . $file->getClientOriginalExtension();
            
            // Upload ke Supabase
            Storage::disk('supabase-gallery')->put($filename, file_get_contents($file), 'public');
            
            $data['image'] = $filename;
        }

        Gallery::create($data);

        return redirect()->route('gallery.index')->with('success', 'Gambar berhasil ditambahkan!');
    }

    /**
     * Update gallery.
     */
    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'tag' => 'required|string|max:255',
            'date_info' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'page' => 'required|string|in:home,operations,services',
            'section' => 'required|string|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        $data = $request->all();
        $data['sort_order'] = $request->input('sort_order', 0);

        if ($request->hasFile('image')) {
            // Hapus gambar lama dari Supabase
            if ($gallery->image) {
                Storage::disk('supabase-gallery')->delete($gallery->image);
            }

            $file = $request->file('image');
            $filename = 'gallery/' . Str::uuid() . '.' . $file->getClientOriginalExtension();
            
            Storage::disk('supabase-gallery')->put($filename, file_get_contents($file), 'public');
            
            $data['image'] = $filename;
        }

        $gallery->update($data);

        return redirect()->route('gallery.index')->with('success', 'Gambar berhasil diperbarui!');
    }

    /**
     * Hapus gallery.
     */
    public function destroy(Gallery $gallery)
    {
        // Hapus gambar dari Supabase
        $gallery->deleteImageFile();
        $gallery->delete();

        return redirect()->route('gallery.index')->with('success', 'Gambar berhasil dihapus!');
    }
}