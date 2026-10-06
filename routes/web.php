<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AiChatController;
use App\Http\Controllers\TariffController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\SuperAdmin\UserController;
use App\Http\Controllers\SuperAdmin\ActivityLogController;

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

Route::view('/', 'welcome')->name('home');
Route::view('/operations', 'operations')->name('operations');
Route::view('/services', 'services')->name('services');
Route::view('/sustainability', 'sustainability')->name('sustainability');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');

// Public Tariffs
Route::get('/our-tariffs', [TariffController::class, 'publicIndex'])->name('our-tariffs');
Route::get('/tarif/{tariff}/download', [TariffController::class, 'download'])->name('tarif.download');

// Public News
Route::get('/news', [NewsController::class, 'index'])->name('news');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

// AI Chat
Route::post('/api/chat', [AiChatController::class, 'send'])->name('ai.chat');

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
| Authenticated Admin Routes (Semua Role: super_admin, admin, editor)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('pict-internal-admin-portal')->group(function () {
    
    // Dashboard
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    // News Management
    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/news/store', [NewsController::class, 'store'])->name('news.store');
    Route::get('/news/{id}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::put('/news/{id}', [NewsController::class, 'update'])->name('news.update');
    Route::delete('/news/{id}', [NewsController::class, 'destroy'])->name('news.destroy');

    // Tariff Management
    Route::name('admin.')->group(function () {
        Route::resource('tariffs', TariffController::class)->except('show');
    });

    // Profile & Password
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Super Admin Routes (Hanya super_admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'super_admin'])->prefix('pict-internal-admin-portal')->group(function () {
    
    // Manajemen User
    Route::resource('users', UserController::class);
    Route::patch('users/{user}/role', [UserController::class, 'updateRole'])->name('users.update-role');

    // Log Activity
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