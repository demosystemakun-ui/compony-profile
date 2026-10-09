<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\News;
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
        $isSuperAdmin = auth()->user()->isSuperAdmin();
        $stale        = now()->subDays(30);

        /*
         * Statistik di-cache 60 detik supaya tidak menembak database
         * (yang jaraknya jauh) di setiap kali dashboard dibuka.
         */
        $stats = Cache::remember(self::STATS_CACHE_KEY, 60, function () use ($stale) {
            $aggregate = 'count(*) as total, max(updated_at) as last_update, '
                       . 'sum(case when updated_at < ? then 1 else 0 end) as stale';

            $news   = News::selectRaw($aggregate, [$stale])->first();
            $tariff = Tariff::selectRaw($aggregate, [$stale])->first();

            return [
                'totalNews'      => (int) $news->total,
                'lastNewsAt'     => $news->last_update,
                'staleNews'      => (int) $news->stale,

                'totalTariffs'   => (int) $tariff->total,
                'lastTariffAt'   => $tariff->last_update,
                'staleTariffs'   => (int) $tariff->stale,

                'totalUsers'     => User::count(),

                'attentionNews'  => News::where('updated_at', '<', $stale)
                                        ->orderBy('updated_at')
                                        ->limit(5)
                                        ->get(['id', 'title', 'category', 'updated_at']),

                'topCategories'  => News::select('category', DB::raw('count(*) as total'))
                                        ->groupBy('category')
                                        ->orderByDesc('total')
                                        ->limit(5)
                                        ->get(),
            ];
        });

        // Daftar tabel selalu segar (tanpa cache), hanya kolom yang dipakai.
        $newsList = News::with('updatedBy:id,name')->latest()->limit(10)->get();

        $tariffList = Tariff::with('updatedBy:id,name')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->limit(10)
            ->get();

        $recentLogs = $isSuperAdmin
            ? ActivityLog::with('user:id,name')->latest()->limit(5)->get()
            : collect();

        return view('dashboard', [
            'isSuperAdmin'  => $isSuperAdmin,

            'totalNews'     => $stats['totalNews'],
            'totalTariffs'  => $stats['totalTariffs'],
            'totalUsers'    => $stats['totalUsers'],
            'staleNews'     => $stats['staleNews'],
            'staleTariffs'  => $stats['staleTariffs'],
            'attentionNews' => $stats['attentionNews'],
            'topCategories' => $stats['topCategories'],

            'lastNewsAgo'   => $stats['lastNewsAt']
                ? Carbon::parse($stats['lastNewsAt'])->diffForHumans()
                : 'Belum ada',
            'lastTariffAgo' => $stats['lastTariffAt']
                ? Carbon::parse($stats['lastTariffAt'])->diffForHumans()
                : 'Belum ada',

            'newsList'      => $newsList,
            'tariffList'    => $tariffList,
            'recentLogs'    => $recentLogs,

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