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
        $user = auth()->user();
        $isSuperAdmin = $user ? method_exists($user, 'isSuperAdmin') && $user->isSuperAdmin() : false;
        $stale = now()->subDays(30);

        /*
         * Statistik agregat di-cache 60 detik.
         * HANYA data primitif (angka & string tanggal) yang disimpan di cache,
         * BUKAN objek Eloquent model — agar tidak ada risiko
         * "Attempt to read property on string" akibat serialisasi cache.
         */
        $stats = Cache::remember(self::STATS_CACHE_KEY, 60, function () use ($stale) {
            $aggregate = 'count(*) as total, max(updated_at) as last_update, '
                       . 'sum(case when updated_at < ? then 1 else 0 end) as stale';

            $news   = News::selectRaw($aggregate, [$stale])->first();
            $tariff = Tariff::selectRaw($aggregate, [$stale])->first();

            return [
                'totalNews'    => $news ? (int) $news->total : 0,
                'lastNewsAt'   => $news && $news->last_update
                                    ? (string) $news->last_update
                                    : null,
                'staleNews'    => $news ? (int) $news->stale : 0,

                'totalTariffs' => $tariff ? (int) $tariff->total : 0,
                'lastTariffAt' => $tariff && $tariff->last_update
                                    ? (string) $tariff->last_update
                                    : null,
                'staleTariffs' => $tariff ? (int) $tariff->stale : 0,

                'totalUsers'   => User::count(),
            ];
        });

        /*
         * Query model SELALU di luar cache, sehingga hasilnya dijamin
         * berupa collection of Eloquent model (bukan string / array).
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

            'totalNews'     => $stats['totalNews'],
            'totalTariffs'  => $stats['totalTariffs'],
            'totalUsers'    => $stats['totalUsers'],
            'staleNews'     => $stats['staleNews'],
            'staleTariffs'  => $stats['staleTariffs'],

            'attentionNews' => $attentionNews,
            'topCategories' => $topCategories,

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