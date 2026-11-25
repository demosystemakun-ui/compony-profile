<?php

namespace App\Http\Middleware;

use App\Models\PageVisit;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackPublicVisits
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $request->isMethod('GET') || $response->getStatusCode() >= 400) {
            return $response;
        }

        if ($request->is('pict-internal-admin-portal*', 'admin*', 'storage/*', '_*')) {
            return $response;
        }

        $ua = (string) $request->userAgent();
        if ($ua === '' || preg_match('/Go-http-client|bot|crawl|spider|slurp|lighthouse|uptimerobot/i', $ua)) {
            return $response;
        }

        $ip  = (string) ($request->ip() ?? '0.0.0.0');
        $day = now()->toDateString();

        $alreadyVisitedToday = PageVisit::query()
            ->where('ip_address', $ip)
            ->whereDate('visited_at', $day)
            ->exists();

        if (! $alreadyVisitedToday) {
            PageVisit::create([
                'ip_address' => $ip,
                'path'       => '/' . ltrim($request->path(), '/'),
                'user_agent' => substr($ua, 0, 500),
                'visited_at' => now(),
            ]);
        }

        return $response;
    }
}