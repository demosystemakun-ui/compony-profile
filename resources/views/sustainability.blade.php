@extends('layouts.app')

@section('title', 'Sustainability | PT Patimban International Car Terminal')
@section('meta_description', 'PICT approaches terminal operations through environmental management, occupational health and safety, and community engagement around Patimban Port.')

@section('content')

@include('partials.page-header', [
    'index' => '01',
    'eyebrow' => 'Responsibility',
    'title' => 'Responsible operations at the port.',
    'lede' => 'PICT manages terminal work with attention to the environment, the safety of people in the terminal zone, and the communities around Patimban Port.',
])

<section class="section section--paper">
    <div class="shell">
        <div class="section-head">
            <div>
                <p class="index"><b>02</b><span class="index-rule" aria-hidden="true"></span>Our focus</p>
                <h2 class="display-l section-head__title">Three areas of responsibility.</h2>
            </div>
            <p class="section-head__aside">
                These are the areas the terminal team plans around. They are part of daily operations, not a separate programme.
            </p>
        </div>

        <div class="numbered-grid">
            <div class="numbered-grid__item">
                <p class="numbered-grid__num">01</p>
                <h3 class="numbered-grid__title">Environment</h3>
                <p class="numbered-grid__text">
                    Terminal work is planned around waste handling, energy use, and monitoring of air and water quality in the area around the terminal.
                </p>
            </div>
            <div class="numbered-grid__item">
                <p class="numbered-grid__num">02</p>
                <h3 class="numbered-grid__title">Occupational health and safety</h3>
                <p class="numbered-grid__text">
                    Health, safety, and environment procedures apply to employees, logistics partners, and visitors working inside the terminal zone.
                </p>
            </div>
            <div class="numbered-grid__item">
                <p class="numbered-grid__num">03</p>
                <h3 class="numbered-grid__title">Society and community</h3>
                <p class="numbered-grid__text">
                    PICT works with communities around Patimban Port, including local skills development and initiatives connected to the regional economy.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="section section--dim">
    <div class="shell">
        <div class="narrative">
            <aside class="narrative__aside">
                <p class="index"><b>03</b><span class="index-rule" aria-hidden="true"></span>Our commitment</p>
                <h2 class="display-l mt-3">Supporting growth with care.</h2>
            </aside>

            <div class="stack-lg">
                <p class="body-copy">
                    Patimban Port is part of the national automotive logistics system, and the vehicle terminal has a role in how that system grows. PICT treats commercial growth and responsible operations as work that has to be managed together.
                </p>
                <p class="body-copy">
                    The company follows the development of Patimban Port as later phases are completed, and keeps its environmental, safety, and community responsibilities in view as terminal activity increases.
                </p>
                <p><a class="link" href="{{ url('/operations') }}">Read how the terminal operates</a></p>
            </div>
        </div>
    </div>
</section>

@include('partials.cta', [
    'index' => '04',
    'eyebrow' => 'Responsibility',
    'title' => 'Ask about PICT\'s operating standards.',
    'copy' => 'For more information about environmental management, safety procedures, or community work around Patimban Port, contact the terminal team.',
    'url' => '/contact',
    'label' => 'Contact PICT',
])

@endsection
