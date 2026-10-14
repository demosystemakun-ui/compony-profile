<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\ShippingRoute;   // ⬅️ TAMBAHAN INI
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Halaman Home
     * Section: "terminal_gallery" — Operational Excellence in Action
     */
    public function home()
    {
        $terminalGallery = Gallery::where('page', 'home')
            ->where('section', 'terminal_gallery')
            ->orderBy('sort_order')
            ->get();

        $shippingRoutes = ShippingRoute::active()->get();

        return view('welcome', compact('terminalGallery', 'shippingRoutes'));
    }

    /**
     * Halaman Operations
     * Section: "gallery" — Inside the Terminal
     */
    public function operations()
    {
        $galleries = Gallery::where('page', 'operations')
            ->where('section', 'gallery')
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('operations', compact('galleries'));
    }

    /**
     * Halaman Services
     * Section: "portfolio" — Commercial Portfolio
     */
    
    public function services()
    {
        $portfolio = Gallery::where('page', 'services')
            ->where('section', 'portfolio')
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->get();

        $addOns = Gallery::where('page', 'services')
            ->where('section', 'value_added')
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('services', compact('portfolio', 'addOns'));
    }

    /**
     * Halaman About
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Halaman Sustainability
     */
    public function sustainability()
    {
        return view('sustainability');
    }

    /**
     * Halaman Contact
     */
    public function contact()
    {
        return view('contact');
    }
}