<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AiChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TariffController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\SuperAdmin\UserController;
use App\Http\Controllers\SuperAdmin\ActivityLogController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| Utility Routes
|--------------------------------------------------------------------------
*/

Route::get('/set-cookie', function () {
    return response('Cookie set')->withCookie(
        cookie('secure_cookie', 'true', 60, '/', null, true, true)
    );
});

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// ───── PAGES ─────
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/operations', [PageController::class, 'operations'])->name('operations');
Route::get('/services', [PageController::class, 'services'])->name('services');

Route::view('/sustainability', 'sustainability')->name('sustainability');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');

// Public Tariffs
Route::get('/our-tariffs', [TariffController::class, 'publicIndex'])->name('tarif.index');
Route::get('/tarif/{tariff}/stream',   [TariffController::class, 'stream'])->name('tarif.stream');
Route::get('/tarif/{tariff}/download', [TariffController::class, 'download'])->name('tarif.download');

// ───── PUBLIC NEWS ─────
Route::get('/news', [NewsController::class, 'index'])->name('news');
Route::get('/media/news/{news}', [NewsController::class, 'image'])->name('news.image');
Route::get('/news/{slug}', [NewsController::class, 'show'])
    ->name('news.show')
    ->where('slug', '[a-z0-9-]+');

// ───── PUBLIC GALLERY IMAGE STREAM ─────
Route::get('/media/gallery/{gallery}', [GalleryController::class, 'image'])->name('gallery.image');

// AI Chat
Route::post('/api/chat', [AiChatController::class, 'send'])->name('ai.chat');

// ───── PUBLIC CONTACT FORM SUBMIT ─────
Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.store')
    ->middleware('throttle:5,1');

/*
|--------------------------------------------------------------------------
| Guest Routes (Login Portal Admin)
|--------------------------------------------------------------------------
*/

Route::prefix('pict-internal-admin-portal')->middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

/*
|--------------------------------------------------------------------------
| Authenticated Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('pict-internal-admin-portal')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // ───── News Management ─────
    Route::get('/news', [NewsController::class, 'adminIndex'])->name('admin.news.index');
    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/news/store', [NewsController::class, 'store'])->name('news.store');

    Route::resource('shipping-routes', \App\Http\Controllers\Admin\ShippingRouteController::class)
        ->except(['show', 'create', 'edit']);

    Route::get('/news/{id}/detail', [NewsController::class, 'adminShow'])
        ->name('admin.news.show')
        ->where('id', '[0-9]+');

    Route::get('/news/{id}/edit', [NewsController::class, 'edit'])->name('news.edit')->where('id', '[0-9]+');
    Route::put('/news/{id}', [NewsController::class, 'update'])->name('news.update')->where('id', '[0-9]+');
    Route::delete('/news/{id}', [NewsController::class, 'destroy'])->name('news.destroy')->where('id', '[0-9]+');

    // ───── Tariff Management ─────
    Route::name('admin.')->group(function () {
        Route::get('tariffs/{tariff}/preview', [TariffController::class, 'preview'])->name('tariffs.preview');
        Route::resource('tariffs', TariffController::class)->except(['show']);
    });

    // ───── Gallery Management ─────
    Route::resource('gallery', GalleryController::class)->except(['show', 'create', 'edit']);

    // ───── Contact Messages ─────
    Route::get('/contact-messages', [ContactController::class, 'adminIndex'])->name('admin.contact-messages.index');
    Route::get('/contact-messages/{contactMessage}', [ContactController::class, 'adminShow'])->name('admin.contact-messages.show');
    Route::patch('/contact-messages/{contactMessage}/read', [ContactController::class, 'markRead'])->name('admin.contact-messages.read');
    Route::delete('/contact-messages/{contactMessage}', [ContactController::class, 'destroy'])->name('admin.contact-messages.destroy');

    // ───── Profile & Password ─────
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Super Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'super_admin'])->prefix('pict-internal-admin-portal')->group(function () {
    Route::resource('users', UserController::class);
    Route::patch('users/{user}/role', [UserController::class, 'updateRole'])->name('users.update-role');

    Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::delete('activity-logs/clear', [ActivityLogController::class, 'clear'])->name('activity-logs.clear');
});

/*
|--------------------------------------------------------------------------
| Logout Route
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Fallback Route (404)
|--------------------------------------------------------------------------
*/

Route::get('/api/patimban-weather', function () {
    return Cache::remember('bmkg_patimban_weather', 3600, function () {
        try {
            // Kode adm4 resmi Desa Patimban, Kec. Pusakanagara, Kab. Subang
            $res = Http::timeout(8)->get('https://api.bmkg.go.id/publik/prakiraan-cuaca', [
                'adm4' => '32.13.10.2008',
            ]);

            if ($res->successful()) {
                $json = $res->json();
                $days = $json['data'][0]['cuaca'] ?? [];

                if (!empty($days)) {
                    // Ambil slot waktu terdekat pada hari pertama
                    $currentSlot = $days[0][0] ?? null;

                    $daily = [];
                    foreach ($days as $daySlots) {
                        if (empty($daySlots)) continue;

                        $temps = array_column($daySlots, 't');
                        $winds = array_column($daySlots, 'ws');
                        // Ambil sampel tengah hari untuk deskripsi utama
                        $midSlot = $daySlots[intdiv(count($daySlots), 2)];

                        $daily[] = [
                            'date'      => substr($daySlots[0]['local_datetime'], 0, 10),
                            'temp_max'  => max($temps),
                            'temp_min'  => min($temps),
                            'wind_max'  => max($winds),
                            'desc_en'   => $midSlot['weather_desc_en'] ?? ($midSlot['weather_desc'] ?? 'Fair'),
                            'desc_id'   => $midSlot['weather_desc'] ?? '',
                            'image'     => $midSlot['image'] ?? null,
                        ];
                    }

                    return [
                        'source'  => 'BMKG (32.13.10.2008)',
                        'current' => [
                            'temp'      => $currentSlot['t'] ?? null,
                            'humidity'  => $currentSlot['hu'] ?? null,
                            'wind'      => $currentSlot['ws'] ?? null,
                            'wind_dir'  => $currentSlot['wd'] ?? '',
                            'desc_en'   => $currentSlot['weather_desc_en'] ?? 'Fair',
                            'desc_id'   => $currentSlot['weather_desc'] ?? '',
                        ],
                        'daily' => $daily,
                    ];
                }
            }
        } catch (\Throwable $e) {
            // Lanjut ke fallback di bawah jika BMKG gagal
        }

        return ['source' => 'FALLBACK'];
    });
})->name('api.patimban.weather');

Route::fallback(function () {
    abort(404);
});