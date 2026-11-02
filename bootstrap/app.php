<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->trustProxies(at: '*');
        
        $middleware->alias([
            'super_admin' => \App\Http\Middleware\SuperAdminMiddleware::class,
        ]);

        // Menambahkan Security Headers secara global untuk mengatasi isu Hardening Improvements
        $middleware->append(function (Request $request, $next) {
            $response = $next($request);

            // Mencegah ClickJacking
            $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
            
            // Mencegah Content Type Sniffing
            $response->headers->set('X-Content-Type-Options', 'nosniff');
            
            // Memaksa HSTS (Strict Transport Security)
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
            
            // Proteksi XSS tambahan
            $response->headers->set('X-XSS-Protection', '1; mode=block');

            return $response;
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();