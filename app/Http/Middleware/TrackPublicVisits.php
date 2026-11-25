<?php

namespace App\Http\Middleware;

use App\Models\PageVisit;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
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
        $uaShort = substr($ua, 0, 500);
        $today = now()->toDateString();

        $cookieId = (string) $request->cookie('visitor_id');
        $hasCookie = Str::isUuid($cookieId);
        $visitorId = $hasCookie ? $cookieId : (string) Str::uuid();

        // Dedup: pakai cookie kalau ada, kalau tidak pakai IP + user agent
        $query = PageVisit::query()->whereDate('visited_at', $today);

        if ($hasCookie) {
            $query->where('visitor_id', $visitorId);
        } else {
            $query->where('ip_address', $ip)->where('user_agent', $uaShort);
        }

        if (! $query->exists()) {
            PageVisit::create([
                'visitor_id' => $visitorId,
                'ip_address' => $ip,
                'path'       => '/' . ltrim($request->path(), '/'),
                'user_agent' => $uaShort,
                'visited_at' => now(),
            ]);
        }

        if (! $hasCookie) {
            Cookie::queue(Cookie::make('visitor_id', $visitorId, 60 * 24 * 365));
        }

        return $response;
    }
}