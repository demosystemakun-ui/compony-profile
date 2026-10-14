<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->get();
        return view('admin.gallery.index', compact('galleries'));
    }

  public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'tag' => 'required|string|max:255',
        'date_info' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'description' => 'required|string',
        'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        'page' => 'required|string|in:operations,home,services',  // NEW
        'section' => 'required|string|max:100',                    // NEW
        'sort_order' => 'nullable|integer',                        // NEW
    ]);

    $data = $request->all();
    $data['sort_order'] = $request->input('sort_order', 0);

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('gallery', 'public');
    }

    Gallery::create($data);

    return redirect()->route('gallery.index')->with('success', 'Gambar berhasil ditambahkan!');
}

public function update(Request $request, Gallery $gallery)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'tag' => 'required|string|max:255',
        'date_info' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'description' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        'page' => 'required|string|in:operations,home,services',
        'section' => 'required|string|max:100',
        'sort_order' => 'nullable|integer',
    ]);

    $data = $request->all();
    $data['sort_order'] = $request->input('sort_order', 0);

    if ($request->hasFile('image')) {
        if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
            Storage::disk('public')->delete($gallery->image);
        }
        $data['image'] = $request->file('image')->store('gallery', 'public');
    }

    $gallery->update($data);

    return redirect()->route('gallery.index')->with('success', 'Gambar berhasil diperbarui!');
}

    public function destroy(Gallery $gallery)
    {
        if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
            Storage::disk('public')->delete($gallery->image);
        }
        $gallery->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Gambar berhasil dihapus!');
    }
}