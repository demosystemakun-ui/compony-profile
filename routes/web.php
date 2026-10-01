<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AiChatController;
use App\Http\Controllers\TariffController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/set-cookie', function () {
    return response('Cookie set')->withCookie(
        cookie('secure_cookie', 'true', 60, '/', null, true, true)
    );
});

// Halaman Utama & Publik
Route::view('/', 'welcome')->name('home');
Route::get('/our-tariffs', [TariffController::class, 'publicIndex'])->name('our-tariffs');
Route::view('/operations', 'operations')->name('operations');
Route::view('/services', 'services')->name('services');
Route::view('/sustainability', 'sustainability')->name('sustainability');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');

// Rute Publik Berita
Route::get('/news', [NewsController::class, 'index'])->name('news');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

// AI Chat Endpoint
Route::post('/api/chat', [AiChatController::class, 'send'])->name('ai.chat');

// Download Tariff PDF (satu route untuk semua tarif, berdasarkan ID dari database)
Route::get('/tarif/{tariff}/download', [TariffController::class, 'download'])->name('tarif.download');

// Rute Tamu (Login Portal Admin dengan Prefix Khusus)
Route::prefix('pict-internal-admin-portal')->middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// Rute Khusus Admin, Profile, & Password yang sudah terautentikasi
Route::middleware(['auth'])->prefix('pict-internal-admin-portal')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    // News Admin Management
    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/news/store', [NewsController::class, 'store'])->name('news.store');
    Route::get('/news/{id}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::put('/news/{id}', [NewsController::class, 'update'])->name('news.update');
    Route::delete('/news/{id}', [NewsController::class, 'destroy'])->name('news.destroy');

    // Tariff Admin Management
    // URL : /pict-internal-admin-portal/tariffs, /tariffs/create, /tariffs/{tariff}/edit
    // Name: admin.tariffs.index | create | store | edit | update | destroy
    Route::name('admin.')->group(function () {
        Route::resource('tariffs', TariffController::class)->except('show');
    });

    // Profile & Password Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Logout Route
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// Fallback rute untuk menangkap halaman yang belum dibuat (404)
Route::fallback(function () {
    abort(404);
});