@extends('layouts.app')

@section('title', 'PT Patimban International Car Terminal')
@section('meta_description', 'PT Patimban International Car Terminal operates the vehicle terminal at Patimban Port, Subang Regency, West Java, about 120 km east of Jakarta.')

@section('content')

<section class="hero">
    <div class="shell">
        <div class="hero__grid">
            <div>
                <p class="index"><b>01</b><span class="index-rule" aria-hidden="true"></span>Patimban Port</p>

                <h1 class="display-xl hero__title">The vehicle terminal at Patimban Port.</h1>

                <p class="lede hero__lede">
                    PT Patimban International Car Terminal handles vehicle imports and exports at Patimban Port in Subang Regency, West Java. The company was established in November 2021 and has operated the terminal since December 2021.
                </p>

                <div class="btn-row hero__actions">
                    <a class="btn btn--primary" href="{{ url('/about') }}">About PICT</a>
                    <a class="btn btn--outline" href="{{ url('/our-tariffs') }}">Terminal tariffs</a>
                </div>

                <ul class="hero__meta">
                    <li>Pusakanagara, Subang</li>
                    <li>Operating since December 2021</li>
                    <li>&plusmn;120 km from Jakarta</li>
                </ul>
            </div>

            <figure class="hero__figure">
                <img src="{{ asset('assets/images/patimban-yard-1.jpeg') }}"
                     alt="Vehicle staging yard at Patimban Port"
                     width="1280"
                     height="720"
                     fetchpriority="high"
                     decoding="async">
                <figcaption class="caption">Vehicle staging area inside the terminal. Photo: PICT.</figcaption>
            </figure>
        </div>
    </div>
</section>

<section class="facts" aria-label="Terminal facts">
    <div class="shell">
        <dl class="facts__grid">
            <div class="facts__item">
                <dt>Ro-Ro berth</dt>
                <dd>300 <span>m</span></dd>
            </div>
            <div class="facts__item">
                <dt>Water depth</dt>
                <dd>-14.0 <span>m</span></dd>
            </div>
            <div class="facts__item">
                <dt>Distance from Jakarta</dt>
                <dd>&plusmn;120 <span>km</span></dd>
            </div>
            <div class="facts__item">
                <dt>Terminal operations</dt>
                <dd>Dec <span>2021</span></dd>
            </div>
        </dl>
    </div>
</section>

<section class="section section--paper">
    <div class="shell">
        <div class="section-head">
            <div>
                <p class="index"><b>02</b><span class="index-rule" aria-hidden="true"></span>Company</p>
                <h2 class="display-l section-head__title">One job, done without damage.</h2>
            </div>
            <p class="section-head__aside">
                A vehicle terminal is judged by what happens between the ship and the road. PICT works on that stretch of the journey.
            </p>
        </div>

        <div class="narrative">
            <aside class="narrative__aside">
                <blockquote class="pullquote">
                    <p>&ldquo;Becoming the best vehicle port in Asia.&rdquo;</p>
                    <footer>PICT vision</footer>
                </blockquote>
            </aside>

            <div class="stack-lg">
                <p class="body-copy">
                    PICT is a vehicle terminal operator at Patimban Port, about 120 kilometres east of central Jakarta. Patimban is a National Strategic Project of the Government of Indonesia, built in phases since 2018 with support from an Official Development Assistance loan.
                </p>
                <p class="body-copy">
                    PT Pelabuhan Indonesia managed the vehicle terminal temporarily until responsibility was transferred to PICT, a company capitalised by a consortium of Japanese enterprises in automotive logistics and shipping.
                </p>
                <p class="body-copy">
                    The terminal handles roll-on/roll-off cargo: passenger vehicles, commercial vehicles, and heavy equipment. Every unit is inspected, moved, and staged under a documented handling procedure.
                </p>
                <p><a class="link" href="{{ url('/about') }}">Read the company profile</a></p>
            </div>
        </div>
    </div>
</section>

<section class="section section--dim">
    <div class="shell">
        <div class="section-head">
            <div>
                <p class="index"><b>03</b><span class="index-rule" aria-hidden="true"></span>Terminal gallery</p>
                <h2 class="display-l section-head__title">Inside the terminal.</h2>
            </div>
            <p class="section-head__aside">
                Photographs from the yard and the berth. The gallery is maintained by the terminal team.
            </p>
        </div>

        @if ($terminalGallery->isNotEmpty())
            <div class="gallery">
                @foreach ($terminalGallery as $item)
                    <figure class="gallery-item{{ $loop->first ? ' gallery-item--wide' : '' }}">
                        <img src="{{ $item->image_url }}"
                             alt="{{ $item->title }}"
                             loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                             decoding="async">
                        <figcaption>
                            <div class="gallery-item__meta">
                                <h3 class="gallery-item__title">{{ $item->title }}</h3>
                                @if ($item->tag)
                                    <span class="gallery-item__tag">{{ $item->tag }}</span>
                                @endif
                            </div>
                            @if ($item->description)
                                <p class="gallery-item__desc">{{ $item->description }}</p>
                            @endif
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <h3>Gallery in preparation</h3>
                <p>Terminal photographs will be published here. In the meantime, the operations page describes how the terminal works.</p>
                <p class="mt-4"><a class="link" href="{{ url('/operations') }}">Go to operations</a></p>
            </div>
        @endif
    </div>
</section>

<section class="section section--paper">
    <div class="shell">
        <div class="section-head">
            <div>
                <p class="index"><b>04</b><span class="index-rule" aria-hidden="true"></span>Connectivity</p>
                <h2 class="display-l section-head__title">Shipping routes.</h2>
            </div>
            <p class="section-head__aside">
                Domestic feeder channels and international deep-sea lanes served through Patimban Port.
            </p>
        </div>

        <div class="map-block">
            <div class="map-block__toolbar">
                <div class="route-tabs" role="group" aria-label="Filter shipping routes">
                    <button class="route-tab" type="button" data-route="all" aria-pressed="true">All routes</button>
                    <button class="route-tab" type="button" data-route="international" aria-pressed="false">International</button>
                    <button class="route-tab" type="button" data-route="domestic" aria-pressed="false">Domestic</button>
                </div>
                <p class="small" id="routeCount">{{ $shippingRoutes->count() }} ports in the network</p>
            </div>

            <div id="routeMap" role="img" aria-label="Map of shipping routes between Patimban Port and international and domestic destinations"></div>

            <div class="map-caption" aria-live="polite">
                <strong id="routeInfoTitle">Patimban Port network</strong>
                <span id="routeInfoDesc">All international and domestic routes shown together.</span>
            </div>

            @if ($shippingRoutes->where('category', '!=', 'hub')->isNotEmpty())
                <details class="map-routes">
                    <summary>View the route list</summary>
                    <ul class="tag-list">
                        @foreach ($shippingRoutes->where('category', '!=', 'hub')->sortBy('name') as $route)
                            <li>{{ $route->name }}{{ $route->country ? ', ' . $route->country : '' }}</li>
                        @endforeach
                    </ul>
                </details>
            @endif
        </div>
    </div>
</section>

<section class="section section--bright">
    <div class="shell">
        <div class="section-head">
            <div>
                <p class="index"><b>05</b><span class="index-rule" aria-hidden="true"></span>Location</p>
                <h2 class="display-l section-head__title">Where the terminal sits.</h2>
            </div>
            <p class="section-head__aside">
                Patimban Port is on the north coast of West Java, in Pusakanagara, Subang Regency.
            </p>
        </div>

        <div class="grid-2">
            <div class="stack-lg">
                <p class="body-copy">
                    The terminal sits inside the Patimban National Strategic Project zone, with road access toward Jakarta and the industrial corridors of West Java.
                </p>
                <dl class="rule-list rule-list--split">
                    <li>
                        <dt>Address</dt>
                        <dd>Patimban Port, Pusakanagara, Subang Regency, West Java, Indonesia</dd>
                    </li>
                    <li>
                        <dt>Terminal type</dt>
                        <dd>Roll-on/roll-off vehicle terminal</dd>
                    </li>
                    <li>
                        <dt>Berth</dt>
                        <dd>300 m Ro-Ro berth, water depth -14.0 m</dd>
                    </li>
                </dl>
                <p><a class="link" href="{{ url('/contact') }}">Contact the terminal team</a></p>
            </div>

            <figure class="figure">
                <iframe
                    src="https://www.google.com/maps?q=Pelabuhan+Patimban,+Subang,+Jawa+Barat&z=13&output=embed"
                    title="Map of Patimban Port in Subang Regency, West Java"
                    width="640"
                    height="420"
                    style="border:0; width:100%; height:420px;"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    allowfullscreen></iframe>
                <figcaption class="caption">Patimban Port, Subang Regency. Map: Google.</figcaption>
            </figure>
        </div>
    </div>
</section>

@include('partials.cta', [
    'index' => '06',
    'eyebrow' => 'Partnership',
    'title' => 'Planning a shipment through Patimban?',
    'copy' => 'Talk to the commercial and operations team about berth schedules, handling requirements, and terminal tariffs.',
    'url' => '/contact',
    'label' => 'Contact PICT',
    'secondaryUrl' => '/our-tariffs',
    'secondaryLabel' => 'View tariffs',
])

@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    var mapElement = document.getElementById('routeMap');
    if (!mapElement || typeof L === 'undefined') return;

    var routes = @json($shippingRoutes ?? []);
    if (!Array.isArray(routes) || routes.length === 0) return;

    function nearestLng(lng, reference) {
        while (lng - reference > 180) lng -= 360;
        while (lng - reference < -180) lng += 360;
        return lng;
    }

    function escapeHtml(value) {
        return String(value ?? '').replace(/[&<>"']/g, function (character) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[character];
        });
    }

    var validRoutes = routes
        .filter(function (route) {
            return route && route.latitude !== null && route.latitude !== '' && route.longitude !== null && route.longitude !== '';
        })
        .map(function (route) {
            route.latitude = parseFloat(route.latitude);
            route.longitude = parseFloat(route.longitude);
            return route;
        })
        .filter(function (route) {
            return !isNaN(route.latitude) && !isNaN(route.longitude);
        });

    if (validRoutes.length === 0) return;

    var hub = validRoutes.find(function (route) { return route.category === 'hub'; });
    var reference = hub ? hub.longitude : 108;

    validRoutes.forEach(function (route) {
        route.mapLng = nearestLng(route.longitude, reference);
    });

    var map = L.map('routeMap', {
        scrollWheelZoom: false,
        worldCopyJump: true,
        minZoom: 2
    }).setView([12, 118], 3);

    L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri',
        maxZoom: 19
    }).addTo(map);

    var linesLayer = L.layerGroup().addTo(map);
    var markersLayer = L.layerGroup().addTo(map);
    var markerRefs = [];
    var lineRefs = [];

    function markerColour(category) {
        if (category === 'hub') return '#ec2029';
        if (category === 'domestic') return '#163a5a';
        return '#c8102e';
    }

    if (hub) {
        validRoutes.forEach(function (route) {
            if (route.category === 'hub') return;

            var line = L.polyline(
                [[hub.latitude, hub.mapLng], [route.latitude, route.mapLng]],
                {
                    color: markerColour(route.category),
                    weight: route.category === 'domestic' ? 1.3 : 1.6,
                    dashArray: route.category === 'domestic' ? '3 5' : '6 5',
                    opacity: route.category === 'domestic' ? 0.55 : 0.75
                }
            ).addTo(linesLayer);

            lineRefs.push({ line: line, category: route.category });
        });
    }

    validRoutes.forEach(function (route) {
        var colour = markerColour(route.category);
        var isHub = route.category === 'hub';

        var icon = L.divIcon({
            className: 'route-marker',
            html: '<span style="display:block;width:' + (isHub ? 18 : 10) + 'px;height:' + (isHub ? 18 : 10) + 'px;border:2px solid #f5f3ee;border-radius:50%;background:' + colour + ';"></span>',
            iconSize: isHub ? [18, 18] : [10, 10],
            iconAnchor: isHub ? [9, 9] : [5, 5]
        });

        var popup = '<div style="font-family:Public Sans, Arial, sans-serif;">'
            + '<strong style="display:block;color:#0a2540;font-size:13px;">' + escapeHtml(route.name) + '</strong>'
            + (route.country ? '<span style="display:block;color:#5b6672;font-size:11px;margin-top:2px;">' + escapeHtml(route.country) + '</span>' : '')
            + (route.description ? '<p style="color:#5b6672;font-size:11px;line-height:1.5;margin:6px 0 0;">' + escapeHtml(route.description) + '</p>' : '')
            + (route.transit_days ? '<p style="color:#c8102e;font-size:11px;font-weight:600;margin:6px 0 0;">Transit: ' + escapeHtml(route.transit_days) + ' days</p>' : '')
            + '</div>';

        var marker = L.marker([route.latitude, route.mapLng], { icon: icon })
            .bindTooltip(escapeHtml(route.name), {
                permanent: true,
                direction: isHub ? 'top' : 'right',
                offset: isHub ? [0, -12] : [8, 0],
                opacity: 1,
                className: 'custom-tooltip'
            })
            .bindPopup(popup, { maxWidth: 260, autoPan: true })
            .addTo(markersLayer);

        markerRefs.push({ marker: marker, category: route.category });
    });

    if (validRoutes.length > 1) {
        map.fitBounds(
            L.latLngBounds(validRoutes.map(function (route) { return [route.latitude, route.mapLng]; })),
            { padding: [46, 46], maxZoom: 5 }
        );
    }

    var buttons = document.querySelectorAll('.route-tab');
    var infoTitle = document.getElementById('routeInfoTitle');
    var infoDesc = document.getElementById('routeInfoDesc');
    var routeCount = document.getElementById('routeCount');

    var info = {
        all: {
            title: 'Patimban Port network',
            desc: 'All international and domestic routes shown together.'
        },
        international: {
            title: 'International routes',
            desc: 'Deep-sea lanes connecting Patimban with ports across Asia and beyond.'
        },
        domestic: {
            title: 'Domestic routes',
            desc: 'Feeder connections to ports in Sumatra, Kalimantan, Sulawesi, and the Riau Islands.'
        }
    };

    function setActiveRoute(category) {
        buttons.forEach(function (button) {
            button.setAttribute('aria-pressed', button.dataset.route === category ? 'true' : 'false');
        });

        markerRefs.forEach(function (entry) {
            var show = category === 'all' || entry.category === category || entry.category === 'hub';
            if (show && !markersLayer.hasLayer(entry.marker)) markersLayer.addLayer(entry.marker);
            if (!show && markersLayer.hasLayer(entry.marker)) markersLayer.removeLayer(entry.marker);
        });

        lineRefs.forEach(function (entry) {
            var show = category === 'all' || entry.category === category;
            if (show && !linesLayer.hasLayer(entry.line)) linesLayer.addLayer(entry.line);
            if (!show && linesLayer.hasLayer(entry.line)) linesLayer.removeLayer(entry.line);
        });

        var selected = info[category] || info.all;
        if (infoTitle) infoTitle.textContent = selected.title;
        if (infoDesc) infoDesc.textContent = selected.desc;

        if (routeCount) {
            var count = category === 'all'
                ? validRoutes.length
                : validRoutes.filter(function (route) { return route.category === category; }).length;
            routeCount.textContent = count + ' ports in the network';
        }
    }

    buttons.forEach(function (button) {
        button.addEventListener('click', function () {
            setActiveRoute(button.dataset.route);
        });
    });

    setActiveRoute('all');
});
</script>
@endpush
