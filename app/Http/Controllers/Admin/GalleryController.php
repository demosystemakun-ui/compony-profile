<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    private function disk(): string
    {
        return (string) config('filesystems.default', 'public');
    }

    /**
     * Daftar gallery di admin panel.
     */
    public function index()
    {
        $galleries = Gallery::latest()->get();

        return view('admin.gallery.index', compact('galleries'));
    }

    /**
     * Stream gambar dari disk aktif (Cloudflare R2 / storage terkonfigurasi).
     */
    public function image(Gallery $gallery)
    {
        $disk = Storage::disk($this->disk());

        if (!$gallery->image || !$disk->exists($gallery->image)) {
            abort(404, 'Gambar tidak ditemukan.');
        }

        $mimeType = $disk->mimeType($gallery->image) ?: 'image/jpeg';

        return response()->stream(function () use ($disk, $gallery) {
            $stream = $disk->readStream($gallery->image);
            fpassthru($stream);
            if (is_resource($stream)) {
                fclose($stream);
            }
        }, 200, [
            'Content-Type'  => $mimeType,
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }

    /**
     * Simpan gallery baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'tag'         => 'required|string|max:255',
            'date_info'   => 'required|string|max:255',
            'location'    => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'page'        => 'required|string|in:home,operations,services',
            'section'     => 'required|string|max:100',
            'sort_order'  => 'nullable|integer',
        ]);

        $data = $request->all();
        $data['sort_order'] = $request->input('sort_order', 0);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'gallery/' . Str::uuid() . '.' . $file->getClientOriginalExtension();

            Storage::disk($this->disk())->put($filename, file_get_contents($file));

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
            'title'       => 'required|string|max:255',
            'tag'         => 'required|string|max:255',
            'date_info'   => 'required|string|max:255',
            'location'    => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'page'        => 'required|string|in:home,operations,services',
            'section'     => 'required|string|max:100',
            'sort_order'  => 'nullable|integer',
        ]);

        $data = $request->all();
        $data['sort_order'] = $request->input('sort_order', 0);

        if ($request->hasFile('image')) {
            $oldPath = $gallery->image;
            $file = $request->file('image');
            $filename = 'gallery/' . Str::uuid() . '.' . $file->getClientOriginalExtension();

            // Upload gambar baru lebih dulu agar gambar lama aman jika upload gagal
            Storage::disk($this->disk())->put($filename, file_get_contents($file));
            $data['image'] = $filename;

            if ($oldPath && $oldPath !== $filename) {
                $this->deleteFileSafely($oldPath);
            }
        }

        $gallery->update($data);

        return redirect()->route('gallery.index')->with('success', 'Gambar berhasil diperbarui!');
    }

    /**
     * Hapus gallery.
     */
    public function destroy(Gallery $gallery)
    {
        $path = $gallery->image;

        $gallery->delete();

        if ($path) {
            $this->deleteFileSafely($path);
        }

        return redirect()->route('gallery.index')->with('success', 'Gambar berhasil dihapus!');
    }

    private function deleteFileSafely(string $path): void
    {
        $diskName = $this->disk();

        try {
            $disk = Storage::disk($diskName);
            if ($disk->exists($path)) {
                $disk->delete($path);
            }
        } catch (\Throwable $e) {
            Log::warning("Gagal menghapus gambar galeri dari disk {$diskName}.", [
                'disk'  => $diskName,
                'path'  => $path,
                'error' => $e->getMessage(),
            ]);
        }
    }
}