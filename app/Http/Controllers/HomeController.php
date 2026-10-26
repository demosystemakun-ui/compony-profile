<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingRoute;
use App\Models\TerminalGallery;

class HomeController extends Controller
{
    public function index()
    {
        // HAPUS atau COMMENT baris middleware ini jika halaman Home bisa diakses tanpa login
        // $this->middleware('auth'); 

        // Ambil semua rute yang aktif
        $shippingRoutes = ShippingRoute::where('is_active', true)->orderBy('sort_order')->get();

        // Ambil data galeri (jika model TerminalGallery belum siap, baris ini bisa dihapus sementara)
        $terminalGallery = TerminalGallery::latest()->take(6)->get();

        return view('home', compact('shippingRoutes', 'terminalGallery'));
    }
}