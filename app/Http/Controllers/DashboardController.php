<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Gallery;
use App\Models\News;
use App\Models\ShippingRoute;
use App\Models\Tariff;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /** Kunci cache statistik. Hapus lewat Cache::forget() setelah berita/tarif berubah. */
    public const STATS_CACHE_KEY = 'dashboard:stats';

    public function index()
    {
        $user = auth()->user();
        $isSuperAdmin = $user ? method_exists($user, 'isSuperAdmin') && $user->isSuperAdmin() : false;
        $stale = now()->subDays(30);

        /*
         * Statistik agregat di-cache 60 detik.
         * HANYA data primitif (angka & string tanggal) yang disimpan di cache,
         * BUKAN objek Eloquent model.
         */
        $stats = Cache::remember(self::STATS_CACHE_KEY, 60, function () use ($stale) {
            $aggregate = 'count(*) as total, max(updated_at) as last_update, '
                       . 'sum(case when updated_at < ? then 1 else 0 end) as stale';

            $news    = News::selectRaw($aggregate, [$stale])->first();
            $tariff  = Tariff::selectRaw($aggregate, [$stale])->first();
            $gallery = Gallery::selectRaw($aggregate, [$stale])->first();

            return [
                // News
                'totalNews'    => $news ? (int) $news->total : 0,
                'lastNewsAt'   => $news && $news->last_update ? (string) $news->last_update : null,
                'staleNews'    => $news ? (int) $news->stale : 0,

                // Tariffs
                'totalTariffs' => $tariff ? (int) $tariff->total : 0,
                'lastTariffAt' => $tariff && $tariff->last_update ? (string) $tariff->last_update : null,
                'staleTariffs' => $tariff ? (int) $tariff->stale : 0,

                // Gallery
                'totalGallery'    => $gallery ? (int) $gallery->total : 0,
                'lastGalleryAt'   => $gallery && $gallery->last_update ? (string) $gallery->last_update : null,

                // Shipping Routes (tanpa filter stale, karena route tidak "basi")
                'totalRoutes'  => ShippingRoute::count(),
                'activeRoutes' => ShippingRoute::where('is_active', true)->count(),
                'lastRouteAt'  => optional(ShippingRoute::latest('updated_at')->first())->updated_at?->toDateTimeString(),

                // Users
                'totalUsers'   => User::count(),
            ];
        });

        /*
         * Query model SELALU di luar cache, sehingga hasilnya dijamin
         * berupa collection of Eloquent model.
         */
        $attentionNews = News::where('updated_at', '<', $stale)
            ->orderBy('updated_at')
            ->limit(5)
            ->get(['id', 'title', 'category', 'updated_at']);

        $topCategories = News::select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $newsList = News::with(['updatedBy' => function ($q) {
            $q->select('id', 'name');
        }])->latest()->limit(10)->get();

        $tariffList = Tariff::with(['updatedBy' => function ($q) {
            $q->select('id', 'name');
        }])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->limit(10)
            ->get();

        $recentLogs = $isSuperAdmin
            ? ActivityLog::with(['user' => function ($q) {
                $q->select('id', 'name');
            }])->latest()->limit(5)->get()
            : collect();

        return view('dashboard', [
            'isSuperAdmin'  => $isSuperAdmin,

            // Statistik Utama
            'totalNews'     => $stats['totalNews'],
            'totalTariffs'  => $stats['totalTariffs'],
            'totalGallery'  => $stats['totalGallery'],
            'totalRoutes'   => $stats['totalRoutes'],
            'activeRoutes'  => $stats['activeRoutes'],
            'totalUsers'    => $stats['totalUsers'],

            // Stale (hanya untuk News & Tariff)
            'staleNews'     => $stats['staleNews'],
            'staleTariffs'  => $stats['staleTariffs'],

            // Waktu update terakhir
            'lastNewsAgo'    => $stats['lastNewsAt']
                ? Carbon::parse($stats['lastNewsAt'])->diffForHumans()
                : 'Belum ada',
            'lastTariffAgo'  => $stats['lastTariffAt']
                ? Carbon::parse($stats['lastTariffAt'])->diffForHumans()
                : 'Belum ada',
            'lastGalleryAgo' => $stats['lastGalleryAt']
                ? Carbon::parse($stats['lastGalleryAt'])->diffForHumans()
                : 'Belum ada',
            'lastRouteAgo'   => $stats['lastRouteAt']
                ? Carbon::parse($stats['lastRouteAt'])->diffForHumans()
                : 'Belum ada',

            // List Data
            'attentionNews' => $attentionNews,
            'topCategories' => $topCategories,
            'newsList'      => $newsList,
            'tariffList'    => $tariffList,
            'recentLogs'    => $recentLogs,

            // Warna badge log activity
            'actionColors'  => [
                'created' => 'bg-green-50 text-green-700 border-green-200',
                'updated' => 'bg-blue-50 text-blue-700 border-blue-200',
                'deleted' => 'bg-red-50 text-red-700 border-red-200',
                'login'   => 'bg-purple-50 text-purple-700 border-purple-200',
                'logout'  => 'bg-gray-50 text-gray-700 border-gray-200',
            ],
        ]);
    }
}