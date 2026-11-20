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

Route::fallback(function () {
    abort(404);
});