<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    // Menampilkan daftar berita untuk publik
    public function index()
    {
        $newsList = News::latest('published_at')->get();
        return view('news.index', compact('newsList'));
    }

    // Menampilkan detail berita untuk publik
    public function show($slug)
    {
        $news = News::where('slug', $slug)->firstOrFail();
        return view('news.show', compact('news'));
    }

    // Menampilkan form tambah berita
    public function create()
    {
        return view('news.create');
    }

    // Menyimpan berita baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'excerpt'  => 'required|string',
            'content'  => 'required|string',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news', 'public');
        } elseif ($request->hasFile('image_gallery')) {
            $imagePath = $request->file('image_gallery')->store('news', 'public');
        }

        News::create([
            'title'        => $request->title,
            'slug'         => Str::slug($request->title),
            'category'     => $request->category,
            'image'        => $imagePath,
            'excerpt'      => $request->excerpt,
            'content'      => $request->content,
            'published_at' => now(),
            'updated_by'   => auth()->id(), // ⭐ histori: siapa yang membuat
        ]);

        return redirect()->route('dashboard')->with('success', 'Berita berhasil diunggah!');
    }

    // Menampilkan form edit berita
    public function edit($id)
    {
        $news = News::findOrFail($id);
        return view('news.edit', compact('news'));
    }

    // Memproses pembaruan berita
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'excerpt'  => 'required|string',
            'content'  => 'required|string',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        $news = News::findOrFail($id);
        $imagePath = $news->image;

        if ($request->hasFile('image')) {
            // Hapus gambar lama kalau ada
            if ($news->image && Storage::disk('public')->exists($news->image)) {
                Storage::disk('public')->delete($news->image);
            }
            $imagePath = $request->file('image')->store('news', 'public');
        } elseif ($request->hasFile('image_gallery')) {
            if ($news->image && Storage::disk('public')->exists($news->image)) {
                Storage::disk('public')->delete($news->image);
            }
            $imagePath = $request->file('image_gallery')->store('news', 'public');
        }

        $news->update([
            'title'      => $request->title,
            'slug'       => Str::slug($request->title),
            'category'   => $request->category,
            'image'      => $imagePath,
            'excerpt'    => $request->excerpt,
            'content'    => $request->content,
            'updated_by' => auth()->id(), // ⭐ histori: siapa yang memperbarui
        ]);

        return redirect()->route('dashboard')->with('success', 'Berita berhasil diperbarui!');
    }

    // Menghapus berita dari database dan file gambar terkait
    public function destroy($id)
    {
        $news = News::findOrFail($id);

        // Hapus file gambar fisik dari storage jika ada
        if ($news->image && Storage::disk('public')->exists($news->image)) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return redirect()->route('dashboard')->with('success', 'Berita berhasil dihapus!');
    }
}