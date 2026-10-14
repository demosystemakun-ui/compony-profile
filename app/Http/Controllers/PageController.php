<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function operations()
    {
        // Ambil semua data galeri, diurutkan dari yang terbaru
        $galleries = Gallery::latest()->get();

        // Kirim variabel $galleries ke view operations.blade.php
        return view('operations', compact('galleries'));
    }
}