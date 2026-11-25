<?php

namespace App\Http\Middleware;

use App\Models\PageVisit;
use Closure;
use Illuminate\Http\Request;
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

        // Ambil visitor_id dari cookie, buat baru jika belum ada / tidak valid
        $visitorId = (string) $request->cookie('visitor_id');
        $isNewVisitor = ! Str::isUuid($visitorId);

        if ($isNewVisitor) {
            $visitorId = (string) Str::uuid();
        }

        $alreadyVisitedToday = ! $isNewVisitor && PageVisit::query()
            ->where('visitor_id', $visitorId)
            ->whereDate('visited_at', now()->toDateString())
            ->exists();

        if (! $alreadyVisitedToday) {
            PageVisit::create([
                'visitor_id' => $visitorId,
                'ip_address' => (string) ($request->ip() ?? '0.0.0.0'),
                'path'       => '/' . ltrim($request->path(), '/'),
                'user_agent' => substr($ua, 0, 500),
                'visited_at' => now(),
            ]);
        }

        // Pasang cookie hanya jika visitor baru (berlaku 1 tahun)
        if ($isNewVisitor) {
            $response->headers->setCookie(
                cookie('visitor_id', $visitorId, 60 * 24 * 365)
            );
        }

        return $response;
    }
}