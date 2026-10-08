<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    private const DISK = 'supabase';

    /* ═══════════════════════════════════════════════
        PUBLIK
    ═══════════════════════════════════════════════ */

    public function index()
    {
        $newsList = News::latest('published_at')->get();

        return view('news.index', compact('newsList'));
    }

    public function show($slug)
    {
        $news = News::where('slug', $slug)->firstOrFail();

        return view('news.show', compact('news'));
    }

    /** Gambar berita dari Supabase, dilayani lewat domain sendiri. */
    public function image(News $news)
    {
        abort_unless($news->image, 404);
        abort_unless(Storage::disk(self::DISK)->exists($news->image), 404);

        return Storage::disk(self::DISK)->response(
            $news->image,
            null,
            ['Cache-Control' => 'public, max-age=604800'],
            'inline'
        );
    }

    /* ═══════════════════════════════════════════════
        ADMIN
    ═══════════════════════════════════════════════ */

    public function create()
    {
        return view('news.create');
    }

    public function store(Request $request)
    {
        $request->validate($this->rules());

        $imagePath = null;
        if ($file = $this->uploadedImage($request)) {
            $imagePath = $file->store('news', self::DISK);
        }

        News::create([
            'title'        => $request->title,
            'slug'         => $this->uniqueSlug($request->title),
            'category'     => $request->category,
            'image'        => $imagePath,
            'excerpt'      => $request->excerpt,
            'content'      => $request->content,
            'published_at' => now(),
            'updated_by'   => auth()->id(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Berita berhasil diunggah!');
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);

        return view('news.edit', compact('news'));
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->rules());

        $news      = News::findOrFail($id);
        $oldPath   = $news->image;
        $imagePath = $oldPath;

        // 1) Upload gambar baru lebih dulu; jika gagal, gambar lama tetap aman.
        if ($file = $this->uploadedImage($request)) {
            $imagePath = $file->store('news', self::DISK);
        }

        // 2) Perbarui database.
        $news->update([
            'title'      => $request->title,
            'slug'       => $this->uniqueSlug($request->title, $news->id),
            'category'   => $request->category,
            'image'      => $imagePath,
            'excerpt'    => $request->excerpt,
            'content'    => $request->content,
            'updated_by' => auth()->id(),
        ]);

        // 3) Baru hapus gambar lama setelah DB berhasil diperbarui.
        if ($oldPath && $oldPath !== $imagePath) {
            $this->deleteFileSafely($oldPath);
        }

        return redirect()->route('dashboard')->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $path = $news->image;

        $news->delete();

        if ($path) {
            $this->deleteFileSafely($path);
        }

        return redirect()->route('dashboard')->with('success', 'Berita berhasil dihapus!');
    }

    /* ═══════════════════════════════════════════════
        HELPER
    ═══════════════════════════════════════════════ */

    private function rules(): array
    {
        $image = ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:10240'];

        return [
            'title'         => ['required', 'string', 'max:255'],
            'category'      => ['required', 'string', 'max:100'],
            'excerpt'       => ['required', 'string'],
            'content'       => ['required', 'string'],
            'image'         => $image, // input kamera / file biasa
            'image_gallery' => $image, // input galeri (sebelumnya tidak divalidasi)
        ];
    }

    /** Ambil file gambar dari input kamera atau galeri. */
    private function uploadedImage(Request $request): ?UploadedFile
    {
        return $request->file('image') ?? $request->file('image_gallery');
    }

    /** Slug unik: judul sama akan menjadi judul-2, judul-3, dst. */
    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'berita';
        $slug = $base;
        $i    = 2;

        while (
            News::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    /** Hapus file di Supabase tanpa menggagalkan request jika storage tidak terjangkau. */
    private function deleteFileSafely(string $path): void
    {
        try {
            Storage::disk(self::DISK)->delete($path);
        } catch (\Throwable $e) {
            Log::warning('Gagal menghapus gambar berita dari Supabase.', [
                'path'  => $path,
                'error' => $e->getMessage(),
            ]);
        }
    }
}