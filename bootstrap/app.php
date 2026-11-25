<?php

use App\Http\Middleware\SecurityHeaders;
use App\Http\Middleware\TrackPublicVisits;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Percaya pada semua proxy (penting untuk Render / Heroku agar HTTPS & IP asli terbaca)
        $middleware->trustProxies(at: '*');

        // Alias middleware kustom
        $middleware->alias([
            'super_admin' => \App\Http\Middleware\SuperAdminMiddleware::class,
        ]);

        // Middleware global untuk grup web
        $middleware->web(append: [
            SecurityHeaders::class,
            TrackPublicVisits::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();