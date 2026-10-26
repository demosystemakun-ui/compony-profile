<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingRoute;
use Illuminate\Http\Request;

class ShippingRouteController extends Controller
{
    public function index()
    {
        $routes = ShippingRoute::orderBy('sort_order')->get();
        return view('admin.shipping-routes.index', compact('routes'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        ShippingRoute::create($data);

        return redirect()->route('shipping-routes.index')
            ->with('success', 'Rute berhasil ditambahkan!');
    }

    public function update(Request $request, ShippingRoute $shippingRoute)
    {
        $data = $this->validateData($request);
        $shippingRoute->update($data);

        return redirect()->route('shipping-routes.index')
            ->with('success', 'Rute berhasil diperbarui!');
    }

    public function destroy(ShippingRoute $shippingRoute)
    {
        $shippingRoute->delete();
        return redirect()->route('shipping-routes.index')
            ->with('success', 'Rute berhasil dihapus!');
    }

    /**
     * Ubah longitude di luar rentang (mis. 261 atau -460 dari salinan peta Leaflet)
     * menjadi nilai setara dalam rentang -180..180 (261 => -99).
     */
    private function normalizeLongitude(Request $request): void
    {
        $lng = $request->input('longitude');

        if ($lng !== null && $lng !== '' && is_numeric($lng)) {
            $wrapped = fmod((float) $lng + 180, 360);
            if ($wrapped < 0) {
                $wrapped += 360;
            }
            $request->merge(['longitude' => round($wrapped - 180, 6)]);
        }
    }

    private function validateData(Request $request): array
    {
        // Normalisasi dulu sebelum validasi
        $this->normalizeLongitude($request);

        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'country'      => 'required|string|max:255',
            'region'       => 'nullable|string|max:255',
            'category'     => 'required|in:hub,domestic,international',
            'latitude'     => 'required|numeric|between:-90,90',
            'longitude'    => 'required|numeric|between:-180,180',
            'color'        => 'nullable|string|max:20',
            'flag'         => 'nullable|string|max:50',
            'description'  => 'nullable|string',
            'transit_days' => 'nullable|integer|min:0',
            'sort_order'   => 'nullable|integer',
            'is_active'    => 'nullable|boolean',
        ]);

        // Override eksplisit (JANGAN pakai operator +)
        $data['is_active']  = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['transit_days'] = $data['transit_days'] ?? 0;

        return $data;
    }
}