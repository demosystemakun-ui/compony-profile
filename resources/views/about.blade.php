@extends('layouts.app')

@section('title', 'About PICT | PT Patimban International Car Terminal')
@section('meta_description', 'PT Patimban International Car Terminal is the vehicle terminal operator at Patimban Port, Subang Regency, West Java. Established in November 2021 and operating since December 2021.')

@section('content')

@include('partials.page-header', [
    'index' => '01',
    'eyebrow' => 'Company',
    'title' => 'The vehicle terminal at Patimban Port.',
    'lede' => 'PT Patimban International Car Terminal has operated the port\'s vehicle terminal since December 2021, handling imports and exports for Indonesia\'s automotive industry.',
    'image' => 'assets/images/patimban-yard-2.jpeg',
    'alt' => 'Vehicle staging area at Patimban Port',
    'caption' => 'Staging yard inside the terminal. Photo: PICT.',
])

<section class="section section--paper">
    <div class="shell">
        <div class="section-head">
            <div>
                <p class="index"><b>02</b><span class="index-rule" aria-hidden="true"></span>Profile</p>
                <h2 class="display-l section-head__title">Who we are.</h2>
            </div>
            <p class="section-head__aside">
                A terminal company formed for one part of the automotive supply chain: the port.
            </p>
        </div>

        <div class="grid-2">
            <div>
                <dl class="rule-list rule-list--split">
                    <li>
                        <dt>Established</dt>
                        <dd>November 2021</dd>
                    </li>
                    <li>
                        <dt>Terminal operations</dt>
                        <dd>Since December 2021</dd>
                    </li>
                    <li>
                        <dt>Ro-Ro berth</dt>
                        <dd>300 m</dd>
                    </li>
                    <li>
                        <dt>Water depth</dt>
                        <dd>-14.0 m</dd>
                    </li>
                    <li>
                        <dt>Distance from Jakarta</dt>
                        <dd>&plusmn;120 km</dd>
                    </li>
                </dl>
            </div>

            <div class="stack-lg">
                <p class="body-copy">
                    PT Patimban International Car Terminal (PICT) is a vehicle terminal operator at Patimban Port, Pusakanagara, Subang Regency, West Java, about 120 kilometres east of central Jakarta. The company was established in November 2021 by the Toyota Tsusho Group and began operating the terminal in December 2021.
                </p>
                <p class="body-copy">
                    Patimban Port is a National Strategic Project of the Government of Indonesia, built in phases since 2018 with support from an Official Development Assistance loan. PT Pelabuhan Indonesia managed the vehicle terminal temporarily until responsibility was transferred to PICT, a company capitalised by a consortium of Japanese enterprises.
                </p>
                <p class="body-copy">
                    The terminal handles roll-on/roll-off cargo for domestic and international markets. Its work covers vessel handling, vehicle discharge, yard staging, inspection, and release through the gate.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="section section--dim">
    <div class="shell">
        <div class="section-head">
            <div>
                <p class="index"><b>03</b><span class="index-rule" aria-hidden="true"></span>History</p>
                <h2 class="display-l section-head__title">How the terminal came to be.</h2>
            </div>
            <p class="section-head__aside">
                Patimban Port is a National Strategic Project, built in phases since 2018. PICT has run the vehicle terminal since operations began in December 2021.
            </p>
        </div>

        @php
            $timeline = [
                [
                    'date' => '2018',
                    'title' => 'Construction of Patimban Port begins',
                    'desc' => 'Construction started in phases as a National Strategic Project of the Government of Indonesia, financed through an Official Development Assistance loan.',
                ],
                [
                    'date' => 'November 2021',
                    'title' => 'PICT established',
                    'desc' => 'PT Patimban International Car Terminal was established by the Toyota Tsusho Group to operate the port\'s vehicle terminal.',
                ],
                [
                    'date' => 'December 2021',
                    'title' => 'Terminal operations begin',
                    'desc' => 'PICT took over terminal operations from PT Pelabuhan Indonesia (Pelindo), which had managed the facility temporarily.',
                ],
                [
                    'date' => '30 June 2023',
                    'title' => 'Shareholding expanded',
                    'desc' => 'Toyota Tsusho transferred part of its stake to Toyofuji Shipping, NYK Line, and Kamigumi, bringing three specialised shipping and terminal operators into the ownership structure.',
                ],
                [
                    'date' => 'Ongoing',
                    'title' => 'Capacity expansion',
                    'desc' => 'PICT is expanding terminal facilities as later phases of Patimban Port are completed.',
                ],
            ];
        @endphp

        <ol class="timeline">
            @foreach ($timeline as $entry)
                <li>
                    <span class="timeline__date">{{ $entry['date'] }}</span>
                    <div>
                        <h3>{{ $entry['title'] }}</h3>
                        <p>{{ $entry['desc'] }}</p>
                    </div>
                </li>
            @endforeach
        </ol>
    </div>
</section>

<section class="section section--bright">
    <div class="shell">
        <div class="section-head">
            <div>
                <p class="index"><b>04</b><span class="index-rule" aria-hidden="true"></span>Ownership</p>
                <h2 class="display-l section-head__title">Four companies, one terminal.</h2>
            </div>
            <p class="section-head__aside">
                PICT is owned by four Japanese companies with backgrounds in trading, shipping, and port operations.
            </p>
        </div>

        @php
            $shareholders = [
                [
                    'name' => 'Toyota Tsusho Corporation',
                    'sector' => 'General trading',
                    'share' => '34%',
                    'logo' => 'assets/images/logo-toyota.png',
                    'url' => 'https://www.toyota-tsusho.com/',
                ],
                [
                    'name' => 'Toyofuji Shipping Co., Ltd.',
                    'sector' => 'Marine transport',
                    'share' => '26%',
                    'logo' => 'assets/images/toyofuji-logo.jpg',
                    'url' => 'https://www.toyofuji.co.jp/en/english/company/company.html',
                ],
                [
                    'name' => 'Nippon Yusen Kabushiki Kaisha (NYK Line)',
                    'sector' => 'Global shipping',
                    'share' => '25%',
                    'logo' => 'assets/images/nyk-logo.jpg',
                    'url' => 'https://www.nyk.com/english/',
                ],
                [
                    'name' => 'Kamigumi Co., Ltd.',
                    'sector' => 'Port and warehousing',
                    'share' => '15%',
                    'logo' => 'assets/images/logo-kamigumi.png',
                    'url' => 'https://www.kamigumi.co.jp/english/',
                ],
            ];
        @endphp

        <table class="ownership">
            <caption>Shareholding after the June 2023 transfer. Select a company name to open its website in a new tab.</caption>
            <thead>
                <tr>
                    <th scope="col">Company</th>
                    <th scope="col">Share</th>
                    <th scope="col">Share of PICT</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($shareholders as $company)
                    <tr>
                        <td>
                            <a class="ownership__name" href="{{ $company['url'] }}" target="_blank" rel="noopener noreferrer">
                                <img src="{{ asset($company['logo']) }}" alt="" width="56" height="28" loading="lazy" decoding="async">
                                <span>
                                    <strong>{{ $company['name'] }}</strong>
                                    <span>{{ $company['sector'] }}</span>
                                </span>
                            </a>
                        </td>
                        <td>
                            <span class="ownership__bar" aria-hidden="true">
                                <span style="width: {{ $company['share'] }};"></span>
                            </span>
                        </td>
                        <td><span class="ownership__share">{{ $company['share'] }}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

@include('partials.cta', [
    'index' => '05',
    'eyebrow' => 'Contact',
    'title' => 'Visit the terminal or ask a question.',
    'copy' => 'For terminal services, shipping schedules, or a site visit, contact the PICT team at Patimban Port.',
    'url' => '/contact',
    'label' => 'Contact PICT',
])

@endsection
