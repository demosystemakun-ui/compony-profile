<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingRoute;
use App\Models\TerminalGallery;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Jika halaman home ini publik (bisa diakses tanpa login), 
        // hapus atau comment baris $this->middleware('auth');
        // $this->middleware('auth'); 
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // 1. Ambil data rute pelayaran
        // Jika Anda ingin memfilter yang aktif saja, gunakan where('is_active', true)
        $shippingRoutes = ShippingRoute::orderBy('sort_order')->get();

        // 2. Ambil data galeri (sesuai kode di view Anda)
        $terminalGallery = TerminalGallery::latest()->take(6)->get();

        // 3. Kirim datanya ke view 'home'
        return view('home', compact('shippingRoutes', 'terminalGallery'));
    }
}