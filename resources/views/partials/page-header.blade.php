@php
    $image = $image ?? null;
    $caption = $caption ?? null;
    $alt = $alt ?? '';
    $index = $index ?? null;
    $eyebrow = $eyebrow ?? null;
@endphp

<header class="page-head">
    <div class="shell">
        <div class="page-head__grid{{ $image ? '' : ' page-head__grid--solo' }}">
            <div>
                @if ($index || $eyebrow)
                    <p class="index">
                        @if ($index)<b>{{ $index }}</b>@endif
                        <span class="index-rule" aria-hidden="true"></span>
                        <span>{{ $eyebrow }}</span>
                    </p>
                @endif

                <h1 class="display-l page-head__title">{{ $title }}</h1>

                @if (!empty($lede))
                    <p class="lede page-head__lede">{{ $lede }}</p>
                @endif
            </div>

            @if ($image)
                <figure class="page-head__figure">
                    <img src="{{ asset($image) }}"
                         alt="{{ $alt }}"
                         width="1280"
                         height="800"
                         fetchpriority="high"
                         decoding="async">
                    @if ($caption)
                        <figcaption class="caption">{{ $caption }}</figcaption>
                    @endif
                </figure>
            @endif
        </div>
    </div>
</header>
