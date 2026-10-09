<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    private const DISK = 'supabase-news';

    /* ═══════════════════════════════════════════════
        PUBLIK
    ═══════════════════════════════════════════════ */

    public function index()
    {
        $newsList = News::query()
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('news.index', compact('newsList'));
    }

    public function show($slug)
    {
        $news = News::where('slug', $slug)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->firstOrFail();

        return view('news.show', compact('news'));
    }

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
        ADMIN — KELOLA BERITA
    ═══════════════════════════════════════════════ */

    /**
     * Halaman admin — daftar SEMUA berita (termasuk draft).
     */
    public function adminIndex()
    {
        $newsList = News::query()
            ->with(['updatedBy' => function ($q) {
                $q->select('id', 'name');
            }])
            ->latest('updated_at')
            ->paginate(15)
            ->withQueryString();

        return view('news.admin-index', compact('newsList'));
    }

    /**
     * Halaman detail berita versi admin (preview di dalam panel admin).
     */
    public function adminShow($id)
    {
        $news = News::with(['updatedBy' => function ($q) {
            $q->select('id', 'name');
        }])->findOrFail($id);

        return view('news.admin-show', compact('news'));
    }

    /**
     * Form tambah berita — sekaligus menampilkan tabel daftar berita.
     */
    public function create()
    {
        $newsList = News::query()
            ->with(['updatedBy' => function ($q) {
                $q->select('id', 'name');
            }])
            ->latest('updated_at')
            ->paginate(10)
            ->withQueryString();

        return view('news.create', compact('newsList'));
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

        Cache::forget(DashboardController::STATS_CACHE_KEY);

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil diunggah!');
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

        if ($file = $this->uploadedImage($request)) {
            $imagePath = $file->store('news', self::DISK);
        }

        $news->update([
            'title'      => $request->title,
            'slug'       => $this->uniqueSlug($request->title, $news->id),
            'category'   => $request->category,
            'image'      => $imagePath,
            'excerpt'    => $request->excerpt,
            'content'    => $request->content,
            'updated_by' => auth()->id(),
        ]);

        if ($oldPath && $oldPath !== $imagePath) {
            $this->deleteFileSafely($oldPath);
        }

        Cache::forget(DashboardController::STATS_CACHE_KEY);

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $path = $news->image;

        $news->delete();

        if ($path) {
            $this->deleteFileSafely($path);
        }

        Cache::forget(DashboardController::STATS_CACHE_KEY);

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil dihapus!');
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
            'image'         => $image,
            'image_gallery' => $image,
        ];
    }

    private function uploadedImage(Request $request): ?UploadedFile
    {
        return $request->file('image') ?? $request->file('image_gallery');
    }

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