<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\SecurityHeaders;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Percaya pada semua proxy (penting untuk platform seperti Render / Heroku agar HTTPS terdeteksi)
        $middleware->trustProxies(at: '*');
        
        // Daftarkan alias middleware kustom Anda
        $middleware->alias([
            'super_admin' => \App\Http\Middleware\SuperAdminMiddleware::class,
        ]);

        // Menambahkan Security Headers secara global ke dalam grup web
        $middleware->web(append: [
            SecurityHeaders::class,
        ]);
        
        // Atau jika ingin diterapkan secara global ke seluruh request (web & api):
        // $middleware->append(SecurityHeaders::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();