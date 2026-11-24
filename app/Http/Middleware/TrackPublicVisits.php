<?php

namespace App\Http\Middleware;

use App\Models\PageVisit;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class TrackPublicVisits
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->isMethod('GET')) {
            $ip   = (string) ($request->ip() ?? '0.0.0.0');
            $path = '/' . ltrim($request->path(), '/');

            // Hindari spam hit berulang dari IP & path yang sama dalam 15 menit
            $dedupKey = 'visit_dedup:' . md5($ip . '|' . $path);
            if (Cache::add($dedupKey, true, now()->addMinutes(15))) {
                PageVisit::create([
                    'ip_address' => $ip,
                    'path'       => $path,
                    'user_agent' => substr((string) $request->userAgent(), 0, 500),
                    'visited_at' => now(),
                ]);
            }
        }

        return $response;
    }
}