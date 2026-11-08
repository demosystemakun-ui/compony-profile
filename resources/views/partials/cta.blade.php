@php
    $index = $index ?? null;
    $eyebrow = $eyebrow ?? 'Get in touch';
    $secondaryLabel = $secondaryLabel ?? null;
    $secondaryUrl = $secondaryUrl ?? null;
@endphp

<section class="cta-band on-dark">
    <div class="shell cta-band__grid">
        <div>
            <p class="index">
                @if ($index)<b>{{ $index }}</b>@endif
                <span class="index-rule" aria-hidden="true"></span>
                <span>{{ $eyebrow }}</span>
            </p>
            <h2 class="display-m cta-band__title">{{ $title }}</h2>
            <p class="cta-band__copy">{{ $copy }}</p>
        </div>

        <div class="btn-row cta-band__actions">
            <a class="btn btn--primary" href="{{ url($url) }}">{{ $label }}</a>
            @if ($secondaryLabel && $secondaryUrl)
                <a class="btn btn--outline" href="{{ url($secondaryUrl) }}">{{ $secondaryLabel }}</a>
            @endif
        </div>
    </div>
</section>
