@extends('layouts.app')

@section('title', 'Operations | PT Patimban International Car Terminal')
@section('meta_description', 'How PICT moves vehicles through Patimban Port, from vessel arrival and discharge to yard staging, inspection, and gate release.')

@section('content')

@include('partials.page-header', [
    'index' => '01',
    'eyebrow' => 'Operations',
    'title' => 'A vehicle terminal built around one sequence.',
    'lede' => 'Every unit follows the same path through Patimban Port: arrive by vessel, discharge, move to the yard, pass inspection, and leave through the gate.',
    'image' => 'assets/images/vessel-1.jpeg',
    'alt' => 'Vehicle carrier at Patimban Port',
    'caption' => 'Vehicle carrier at the terminal berth. Photo: PICT.',
])

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

<section class="section section--tight weather on-dark">
    <div class="shell">
        <div class="weather__head">
            <div>
                <p class="index"><b>02</b><span class="index-rule" aria-hidden="true"></span>Marine conditions</p>
                <h2 class="display-m mt-3">Patimban Port weather.</h2>
            </div>
            <p class="weather__clock" id="live-clock">Loading local time</p>
        </div>

        <div class="weather__current">
            <div class="weather__stat">
                <span>Temperature</span>
                <strong id="weather-temp">--</strong>
            </div>
            <div class="weather__stat">
                <span>Wind speed</span>
                <strong id="weather-wind">--</strong>
            </div>
            <div class="weather__stat">
                <span>Humidity</span>
                <strong id="weather-humidity">--</strong>
            </div>
            <div class="weather__stat">
                <span>Ro-Ro berth</span>
                <strong>300 m</strong>
            </div>
        </div>

        <p class="weather__status" id="weather-status">Current conditions are read from Open-Meteo. The forecast below covers the next seven days.</p>

        <div class="weather__forecast" id="weather-forecast" aria-live="polite" aria-busy="true">
            <div class="weather__day">
                <strong>Forecast</strong>
                <span>Loading weather data.</span>
            </div>
        </div>
    </div>
</section>

<section class="section section--paper">
    <div class="shell">
        <div class="section-head">
            <div>
                <p class="index"><b>03</b><span class="index-rule" aria-hidden="true"></span>Why PICT</p>
                <h2 class="display-l section-head__title">A berth, a road, and a documented handover.</h2>
            </div>
            <p class="section-head__aside">
                The terminal is judged by what happens between the ship and the road. These are the three parts of that work.
            </p>
        </div>

        <div class="numbered-grid">
            <div class="numbered-grid__item">
                <p class="numbered-grid__num">01</p>
                <h3 class="numbered-grid__title">A berth built for vehicle carriers</h3>
                <p class="numbered-grid__text">A 300 metre Ro-Ro berth with a water depth of -14.0 metres, inside the Patimban Port area.</p>
            </div>
            <div class="numbered-grid__item">
                <p class="numbered-grid__num">02</p>
                <h3 class="numbered-grid__title">A short road to Jakarta</h3>
                <p class="numbered-grid__text">Patimban sits about 120 kilometres east of Jakarta, with road access toward the capital and the industrial corridors of West Java.</p>
            </div>
            <div class="numbered-grid__item">
                <p class="numbered-grid__num">03</p>
                <h3 class="numbered-grid__title">One sequence of custody</h3>
                <p class="numbered-grid__text">Vehicles are checked at discharge, routed to a yard position, inspected again, and released through the gate.</p>
            </div>
        </div>
    </div>
</section>

<section class="section section--dim" id="operations-flow">
    <div class="shell">
        <div class="section-head">
            <div>
                <p class="index"><b>04</b><span class="index-rule" aria-hidden="true"></span>Operation flow</p>
                <h2 class="display-l section-head__title">Seven stages, from ship to gate.</h2>
            </div>
            <p class="section-head__aside">
                Select a stage to see the equipment, safety control, and division responsible for it.
            </p>
        </div>

        @php
            $steps = [
                [
                    'title' => 'Ship arrival',
                    'equip' => 'Vessel traffic coordination',
                    'safety' => 'Port clearance',
                    'div' => 'Marine operations',
                    'desc' => 'The vessel is guided into port limits and prepared for the berthing sequence.',
                ],
                [
                    'title' => 'Berthing',
                    'equip' => 'Tugboats and mooring lines',
                    'safety' => 'Mooring safety',
                    'div' => 'Harbour master team',
                    'desc' => 'The carrier is secured alongside the terminal berth before discharge begins.',
                ],
                [
                    'title' => 'Vehicle inspection',
                    'equip' => 'Handheld scanners',
                    'safety' => 'Zero-scratch protocol',
                    'div' => 'Quality assurance',
                    'desc' => 'Units are checked before discharge so their condition is recorded at the start of the handover.',
                ],
                [
                    'title' => 'Ro-Ro discharge',
                    'equip' => 'Ramps and lashing',
                    'safety' => 'PPE and traffic control',
                    'div' => 'Stevedoring',
                    'desc' => 'Vehicles are driven from the vessel decks, down the ramp, and into the staging area.',
                ],
                [
                    'title' => 'Yard staging',
                    'equip' => 'Terminal management system',
                    'safety' => 'Yard speed control',
                    'div' => 'Yard control',
                    'desc' => 'Each unit is routed to a yard position and recorded against its vessel and customer.',
                ],
                [
                    'title' => 'Final inspection',
                    'equip' => 'Cameras and check sheets',
                    'safety' => 'Pre-delivery inspection',
                    'div' => 'Inspection team',
                    'desc' => 'The vehicle is checked again before release, including its identity, accessories, and condition.',
                ],
                [
                    'title' => 'Gate release',
                    'equip' => 'Car carriers and transporters',
                    'safety' => 'Gate security check',
                    'div' => 'Logistics and delivery',
                    'desc' => 'The unit is loaded for onward transport and its documents are closed out at the gate.',
                ],
            ];

            $firstStep = $steps[0];
        @endphp

        <div class="flow">
            <div class="flow__nav" role="tablist" aria-label="Terminal operation stages">
                @foreach ($steps as $index => $step)
                    <button class="flow__tab"
                            type="button"
                            role="tab"
                            id="flow-tab-{{ $index }}"
                            aria-controls="flow-panel"
                            aria-selected="{{ $index === 0 ? 'true' : 'false' }}"
                            tabindex="{{ $index === 0 ? '0' : '-1' }}"
                            data-index="{{ $index }}">
                        <span class="flow__num">0{{ $index + 1 }}</span>
                        <span>{{ $step['title'] }}</span>
                    </button>
                @endforeach
            </div>

            <div class="flow__panel" id="flow-panel" role="tabpanel" tabindex="0" aria-labelledby="flow-tab-0">
                <p class="index"><b id="detail-number">01</b><span class="index-rule" aria-hidden="true"></span>Stage</p>
                <h3 class="mt-3" id="detail-title">{{ $firstStep['title'] }}</h3>
                <p id="detail-desc">{{ $firstStep['desc'] }}</p>

                <dl class="flow__specs">
                    <div>
                        <dt>Equipment</dt>
                        <dd id="detail-equip">{{ $firstStep['equip'] }}</dd>
                    </div>
                    <div>
                        <dt>Safety</dt>
                        <dd id="detail-safety">{{ $firstStep['safety'] }}</dd>
                    </div>
                    <div>
                        <dt>Division</dt>
                        <dd id="detail-div">{{ $firstStep['div'] }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</section>

<section class="section section--bright">
    <div class="shell">
        <div class="section-head">
            <div>
                <p class="index"><b>05</b><span class="index-rule" aria-hidden="true"></span>Terminal capability</p>
                <h2 class="display-l section-head__title">Two sides of the same operation.</h2>
            </div>
            <p class="section-head__aside">
                Vessel handling and yard work are run as one sequence, not as separate service counters.
            </p>
        </div>

        <article class="split-row">
            <figure class="split-row__media">
                <img src="{{ asset('assets/images/vessel-5.jpeg') }}"
                     alt="Vehicle carrier moored at Patimban Port"
                     width="1600"
                     height="1067"
                     loading="lazy"
                     decoding="async">
            </figure>
            <div class="split-row__body">
                <p class="card__kicker">Marine</p>
                <h3 class="split-row__title">Ro-Ro vessel handling</h3>
                <p class="split-row__text">
                    Vessel arrival, berthing, ramp operations, and discharge are coordinated by the terminal team with the carrier and the port authority.
                </p>
            </div>
        </article>

        <article class="split-row">
            <figure class="split-row__media">
                <img src="{{ asset('assets/images/patimban-yard-1.jpeg') }}"
                     alt="Vehicle staging yard at Patimban Port"
                     width="1280"
                     height="720"
                     loading="lazy"
                     decoding="async">
            </figure>
            <div class="split-row__body">
                <p class="card__kicker">Yard</p>
                <h3 class="split-row__title">Staging and inspection</h3>
                <p class="split-row__text">
                    Discharged vehicles are positioned in the staging yard, checked against the vessel manifest, and held for inspection or release.
                </p>
            </div>
        </article>
    </div>
</section>

<section class="section section--paper">
    <div class="shell">
        <div class="section-head">
            <div>
                <p class="index"><b>06</b><span class="index-rule" aria-hidden="true"></span>Cargo</p>
                <h2 class="display-l section-head__title">What the terminal handles.</h2>
            </div>
            <p class="section-head__aside">
                The terminal is set up for vehicles and vehicle-related cargo moving through Patimban Port.
            </p>
        </div>

        <div class="grid-2">
            <div>
                <h3 class="display-s">Vehicles</h3>
                <dl class="rule-list mt-4">
                    <li>
                        <dt>Passenger vehicles</dt>
                        <dd>Sedans, SUVs, MPVs, and electric vehicles handled under the terminal's inspection procedure.</dd>
                    </li>
                    <li>
                        <dt>Commercial vehicles</dt>
                        <dd>Trucks, buses, and chassis moved through the terminal on reinforced ramp routes.</dd>
                    </li>
                </dl>
            </div>

            <div>
                <h3 class="display-s">Other cargo</h3>
                <dl class="rule-list mt-4">
                    <li>
                        <dt>Heavy equipment</dt>
                        <dd>Excavators, wheel loaders, and bulldozers for mining, construction, and agricultural projects.</dd>
                    </li>
                    <li>
                        <dt>General cargo</dt>
                        <dd>Non-vehicle shipments handled under the terminal's standard cargo procedure.</dd>
                    </li>
                </dl>
            </div>
        </div>
    </div>
</section>

<section class="section section--dim" id="gallery">
    <div class="shell">
        <div class="section-head">
            <div>
                <p class="index"><b>07</b><span class="index-rule" aria-hidden="true"></span>Visual record</p>
                <h2 class="display-l section-head__title">Inside the terminal.</h2>
            </div>
            <p class="section-head__aside">
                Photographs from the berth, the yard, and the gate. The gallery is maintained by the terminal team.
            </p>
        </div>

        @if ($galleries->isNotEmpty())
            <div class="gallery">
                @foreach ($galleries as $item)
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
                            @if ($item->location || $item->date_info)
                                <p class="small mt-2">{{ collect([$item->location, $item->date_info])->filter()->join(' / ') }}</p>
                            @endif
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <h3>Gallery in preparation</h3>
                <p>Terminal photographs will be published here. In the meantime, the service pages describe what PICT handles.</p>
                <p class="mt-4"><a class="link" href="{{ url('/services') }}">Read about terminal services</a></p>
            </div>
        @endif
    </div>
</section>

@include('partials.cta', [
    'index' => '08',
    'eyebrow' => 'Operations',
    'title' => 'Plan a vehicle movement through Patimban.',
    'copy' => 'Talk to the terminal team about vessel schedules, discharge requirements, yard capacity for your shipment, and gate release.',
    'url' => '/contact',
    'label' => 'Contact operations',
    'secondaryUrl' => '/our-tariffs',
    'secondaryLabel' => 'View tariffs',
])

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    /* Local time */
    var clock = document.getElementById('live-clock');

    function updateClock() {
        if (!clock) return;
        clock.textContent = new Intl.DateTimeFormat('en-GB', {
            weekday: 'short',
            day: 'numeric',
            month: 'short',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            hour12: false,
            timeZone: 'Asia/Jakarta'
        }).format(new Date()) + ' WIB';
    }

    updateClock();
    window.setInterval(updateClock, 30000);

    /* Weather */
    var status = document.getElementById('weather-status');
    var forecast = document.getElementById('weather-forecast');

    function conditionText(code) {
        if (code === 0) return 'Clear';
        if ([1, 2, 3].includes(code)) return 'Partly cloudy';
        if ([45, 48].includes(code)) return 'Fog';
        if ([51, 53, 55, 56, 57].includes(code)) return 'Drizzle';
        if ([61, 63, 65, 66, 67].includes(code)) return 'Rain';
        if ([71, 73, 75, 77].includes(code)) return 'Snow';
        if ([95, 96, 99].includes(code)) return 'Thunderstorm';
        return 'Fair';
    }

    function setValue(id, value) {
        var element = document.getElementById(id);
        if (element) element.textContent = value;
    }

    function renderForecast(days) {
        if (!forecast) return;
        forecast.textContent = '';

        days.forEach(function (day, index) {
            var item = document.createElement('div');
            item.className = 'weather__day';

            var label = document.createElement('strong');
            label.textContent = index === 0 ? 'Today' : new Intl.DateTimeFormat('en-GB', { weekday: 'short' }).format(new Date(day.date + 'T12:00:00'));

            var detail = document.createElement('span');
            detail.textContent = new Intl.DateTimeFormat('en-GB', { day: 'numeric', month: 'short' }).format(new Date(day.date + 'T12:00:00'))
                + '. ' + day.condition
                + '. High ' + day.max + ' C, low ' + day.min + ' C. Wind ' + day.wind + ' km/h.';

            item.appendChild(label);
            item.appendChild(detail);
            forecast.appendChild(item);
        });

        forecast.setAttribute('aria-busy', 'false');
    }

    fetch('https://api.open-meteo.com/v1/forecast?latitude=-6.23&longitude=107.85&current=temperature_2m,relative_humidity_2m,wind_speed_10m&daily=weathercode,temperature_2m_max,temperature_2m_min,wind_speed_10m_max&timezone=auto', { cache: 'no-store' })
        .then(function (response) {
            if (!response.ok) throw new Error('Weather request failed');
            return response.json();
        })
        .then(function (data) {
            if (data.current) {
                setValue('weather-temp', Math.round(data.current.temperature_2m) + ' C');
                setValue('weather-wind', Math.round(data.current.wind_speed_10m) + ' km/h');
                setValue('weather-humidity', Math.round(data.current.relative_humidity_2m) + '%');
            }

            if (data.daily && Array.isArray(data.daily.time)) {
                renderForecast(data.daily.time.map(function (date, index) {
                    return {
                        date: date,
                        condition: conditionText(data.daily.weathercode[index]),
                        max: Math.round(data.daily.temperature_2m_max[index]),
                        min: Math.round(data.daily.temperature_2m_min[index]),
                        wind: Math.round(data.daily.wind_speed_10m_max[index])
                    };
                }));

                if (status) {
                    status.textContent = 'Current conditions and the seven-day forecast are supplied by Open-Meteo.';
                }
            }
        })
        .catch(function () {
            if (forecast) {
                forecast.textContent = '';
                var item = document.createElement('div');
                item.className = 'weather__day';
                var label = document.createElement('strong');
                label.textContent = 'Forecast';
                var detail = document.createElement('span');
                detail.textContent = 'Weather data is unavailable right now. Please check again later.';
                item.appendChild(label);
                item.appendChild(detail);
                forecast.appendChild(item);
                forecast.setAttribute('aria-busy', 'false');
            }

            if (status) {
                status.textContent = 'Weather data could not be loaded. The terminal fact sheet above does not depend on this feed.';
            }
        });

    /* Operation flow tabs */
    var steps = @json($steps);
    var tabs = Array.prototype.slice.call(document.querySelectorAll('.flow__tab'));
    var panel = document.getElementById('flow-panel');
    var detailNumber = document.getElementById('detail-number');
    var detailTitle = document.getElementById('detail-title');
    var detailDesc = document.getElementById('detail-desc');
    var detailEquip = document.getElementById('detail-equip');
    var detailSafety = document.getElementById('detail-safety');
    var detailDiv = document.getElementById('detail-div');

    function activateStep(index, focusTab) {
        var step = steps[index];
        if (!step) return;

        tabs.forEach(function (tab, tabIndex) {
            var isActive = tabIndex === index;
            tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
            tab.setAttribute('tabindex', isActive ? '0' : '-1');
        });

        if (detailNumber) detailNumber.textContent = '0' + (index + 1);
        if (detailTitle) detailTitle.textContent = step.title;
        if (detailDesc) detailDesc.textContent = step.desc;
        if (detailEquip) detailEquip.textContent = step.equip;
        if (detailSafety) detailSafety.textContent = step.safety;
        if (detailDiv) detailDiv.textContent = step.div;
        if (panel) panel.setAttribute('aria-labelledby', 'flow-tab-' + index);

        if (focusTab && tabs[index]) tabs[index].focus();
    }

    tabs.forEach(function (tab, index) {
        tab.addEventListener('click', function () {
            activateStep(index, false);
        });

        tab.addEventListener('keydown', function (event) {
            var nextIndex = null;

            if (event.key === 'ArrowDown' || event.key === 'ArrowRight') {
                nextIndex = (index + 1) % tabs.length;
            } else if (event.key === 'ArrowUp' || event.key === 'ArrowLeft') {
                nextIndex = (index - 1 + tabs.length) % tabs.length;
            } else if (event.key === 'Home') {
                nextIndex = 0;
            } else if (event.key === 'End') {
                nextIndex = tabs.length - 1;
            }

            if (nextIndex !== null) {
                event.preventDefault();
                activateStep(nextIndex, true);
            }
        });
    });
});
</script>
@endpush
