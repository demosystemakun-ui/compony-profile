@extends('layouts.app')

@section('title', 'Contact Us — PT Patimban International Car Terminal')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
{{-- Google reCAPTCHA --}}
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<style>
    /* ═══ DESIGN SYSTEM — PICT CONTACT ═══ */
    :root {
        --color-navy:   #0A2540;
        --color-signal: #EC2029;
        --color-paper:  #F5F3EE;
        --color-ink:    #16232E;
        --color-muted:  #5B6672;
        --color-line:   #D8D4C8;
    }

    body, * {
        font-family: 'Century Gothic', 'CenturyGothic', 'Poppins', sans-serif !important;
    }

    /* ═══ HERO BACKGROUND ═══ */
    .hero-bg-contact {
        background-image:
            linear-gradient(rgba(15, 23, 42, 0.78), rgba(15, 23, 42, 0.72)),
            url('{{ asset("assets/images/patimban-yard-2.jpeg") }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }

    /* ═══ EYEBROW LABEL ═══ */
    .eyebrow {
        display: inline-block;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: var(--color-signal);
    }

    /* ═══ FORM INPUT FOCUS ═══ */
    .form-input {
        transition: border-color .2s ease, box-shadow .2s ease, background-color .2s ease;
    }
    .form-input:focus {
        border-color: var(--color-signal);
        box-shadow: 0 0 0 3px rgba(236, 32, 41, 0.12);
        background-color: #FFFFFF;
    }

    /* ═══ INFO CARD HOVER ═══ */
    .info-card {
        transition: transform .3s cubic-bezier(0.4, 0, 0.2, 1),
                    border-color .3s ease,
                    box-shadow .3s ease;
    }
    .info-card:hover {
        transform: translateY(-2px);
        border-color: var(--color-signal);
        box-shadow: 0 12px 28px -6px rgba(15, 23, 42, 0.12);
    }
    .info-card .info-icon {
        transition: transform .3s ease;
    }
    .info-card:hover .info-icon {
        transform: scale(1.08);
    }
</style>
@endpush

@section('content')

{{-- ═══════════════════════════════════════════════════════════════
     1. HERO SECTION (Tanpa AOS agar langsung tampil tanpa refresh)
═══════════════════════════════════════════════════════════════ --}}
<section class="hero-bg-contact relative flex items-center min-h-[480px] px-6 sm:px-12 md:px-16 pt-32 pb-16 overflow-hidden">
    {{-- Decorative grid --}}
    <div class="pointer-events-none absolute inset-0 opacity-[0.04]">
        <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
            <defs>
                <pattern id="grid-contact" width="8" height="8" patternUnits="userSpaceOnUse">
                    <path d="M 8 0 L 0 0 0 8" fill="none" stroke="white" stroke-width="0.4"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid-contact)"/>
        </svg>
    </div>
    {{-- Accent glow --}}
    <div class="pointer-events-none absolute -top-32 -right-32 h-96 w-96 rounded-full bg-[#EC2029]/15 blur-3xl"></div>

    <div class="relative max-w-4xl">
        <span class="inline-flex items-center gap-2 rounded-full bg-white/10 backdrop-blur-sm px-4 py-1.5 text-xs font-semibold uppercase tracking-widest text-white ring-1 ring-inset ring-white/20 mb-6">
            <span class="h-1.5 w-1.5 rounded-full bg-[#EC2029] animate-pulse"></span>
            Contact Center
        </span>

        <h1 class="text-white text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight leading-[1.1] max-w-3xl">
            Get in Touch with PICT
        </h1>

        <p class="text-slate-200 max-w-2xl mt-6 leading-relaxed text-sm sm:text-base lg:text-lg">
            Reach out to our commercial and operational teams for inquiries regarding terminal services, berthing schedules, or logistics coordination.
        </p>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     2. CONTACT INFO + FORM
═══════════════════════════════════════════════════════════════ --}}
<section class="max-w-7xl mx-auto px-6 py-20 bg-white text-slate-800">
    <div class="grid lg:grid-cols-12 gap-14 items-start">

        {{-- Contact Info --}}
        <div class="lg:col-span-5 space-y-8" data-aos="fade-right">
            <div>
                <span class="eyebrow block mb-2">Get in Touch</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    Contact Information
                </h2>
                <div class="mt-4 h-1 w-16 bg-[#EC2029] rounded-full"></div>
                <p class="mt-5 text-slate-600 text-sm leading-relaxed">
                    Our team is ready to assist you with any inquiries regarding PICT terminal operations and commercial partnerships.
                </p>
            </div>

            <div class="space-y-4">
                @php
                    $infoItems = [
                        [
                            'title' => 'Address',
                            'value' => 'Patimban Port, Pusakanagara, Subang Regency, West Java 41255, Indonesia',
                            'color' => 'red',
                            'icon'  => 'M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z',
                        ],
                        [
                            'title' => 'Email',
                            'value' => 'info@pict.co.id',
                            'color' => 'emerald',
                            'icon'  => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                        ],
                        [
                            'title' => 'Phone / WhatsApp',
                            'value' => '1234567890',
                            'color' => 'blue',
                            'icon'  => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z',
                        ],
                    ];

                    $colorMap = [
                        'red'     => ['bg' => 'bg-red-600/10',    'text' => 'text-red-600'],
                        'emerald' => ['bg' => 'bg-emerald-600/10', 'text' => 'text-emerald-600'],
                        'blue'    => ['bg' => 'bg-blue-600/10',    'text' => 'text-blue-600'],
                    ];
                @endphp

                @foreach($infoItems as $item)
                    @php $c = $colorMap[$item['color']]; @endphp
                    <div class="info-card flex items-start gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-200 shadow-sm">
                        <div class="info-icon w-11 h-11 rounded-xl {{ $c['bg'] }} {{ $c['text'] }} flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                @foreach(explode(' M', $item['icon']) as $i => $path)
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="{{ $i === 0 ? $path : 'M' . $path }}"/>
                                @endforeach
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h3 class="font-bold text-slate-900 mb-1 text-sm">{{ $item['title'] }}</h3>
                            <p class="text-slate-600 text-xs leading-relaxed">{{ $item['value'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Contact Form --}}
        <div class="lg:col-span-7 bg-slate-50 border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm" data-aos="fade-left">
            <div class="flex items-center gap-3 mb-6">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-600/10 text-red-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-900 tracking-tight">Send Us a Message</h2>
                    <p class="text-xs text-slate-500">Fill in the form and we will get back to you shortly.</p>
                </div>
            </div>

            <form id="contactForm" class="space-y-5" novalidate>
                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" required
                               placeholder="Your full name"
                               class="form-input w-full px-4 py-3 rounded-xl border border-slate-300 bg-white text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none">
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="email" name="email" required
                               placeholder="you@company.com"
                               class="form-input w-full px-4 py-3 rounded-xl border border-slate-300 bg-white text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none">
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label for="subject" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Subject
                        </label>
                        <input type="text" id="subject" name="subject"
                               placeholder="Inquiry subject"
                               class="form-input w-full px-4 py-3 rounded-xl border border-slate-300 bg-white text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none">
                    </div>

                    <div>
                        <label for="whatsapp" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            No. WhatsApp / Office <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" id="whatsapp" name="whatsapp" required
                               oninput="this.value = this.value.replace(/[^0-9+\-()\s]/g, '')"
                               placeholder="(021) 8382910"
                               class="form-input w-full px-4 py-3 rounded-xl border border-slate-300 bg-white text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label for="message" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Message <span class="text-red-500">*</span>
                    </label>
                    <textarea id="message" name="message" rows="5" required
                              placeholder="Tell us about your inquiry..."
                              class="form-input w-full px-4 py-3 rounded-xl border border-slate-300 bg-white text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none resize-none"></textarea>
                </div>

                {{-- reCAPTCHA --}}
                <div class="pt-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Security Verification <span class="text-red-500">*</span>
                    </label>
                    <div class="g-recaptcha"
                         data-sitekey="{{ env('RECAPTCHA_SITE_KEY', '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI') }}"
                         data-callback="enableSubmitButton"></div>
                </div>

                {{-- Submit Button --}}
                <button type="submit" id="submitBtn" disabled
                        class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-slate-300 text-slate-500 font-bold py-3.5 px-6 text-xs uppercase tracking-wider transition cursor-not-allowed">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Complete Verification to Send
                </button>

                <p class="text-[11px] text-slate-400 text-center leading-relaxed">
                    By submitting this form, you agree to be contacted by PICT's commercial team regarding your inquiry.
                </p>
            </form>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
function initAOS() {
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 900,
            easing: 'ease-out-cubic',
            once: true,
            offset: 120
        });
    }
}

// Inisialisasi saat DOM siap
document.addEventListener('DOMContentLoaded', function () {
    initAOS();
});

// Hook untuk Swup (jika halaman dimuat secara asinkronus/SPA)
if (window.swup) {
    window.swup.hooks.on('page:view', () => {
        if (typeof AOS !== 'undefined') {
            AOS.refreshHard();
        }
        initAOS();
    });
}

/* ═══════════════════════════════════════════════════════════════
   reCAPTCHA CALLBACK — enable submit button
═══════════════════════════════════════════════════════════════ */
function enableSubmitButton() {
    const btn = document.getElementById('submitBtn');
    if (!btn) return;

    btn.removeAttribute('disabled');
    btn.classList.remove('bg-slate-300', 'text-slate-500', 'cursor-not-allowed');
    btn.classList.add('bg-[#EC2029]', 'hover:bg-[#c41a22]', 'text-white', 'shadow-lg', 'shadow-red-600/20', 'cursor-pointer');
    btn.innerHTML = `
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
        </svg>
        Send via Email App
    `;
}

/* ═══════════════════════════════════════════════════════════════
   FORM SUBMIT HANDLER
═══════════════════════════════════════════════════════════════ */
document.getElementById('contactForm')?.addEventListener('submit', function (e) {
    e.preventDefault();

    if (typeof grecaptcha === 'undefined' || grecaptcha.getResponse().length === 0) {
        alert('Please complete the security verification (reCAPTCHA) first.');
        return;
    }

    const name     = document.getElementById('name').value.trim();
    const email    = document.getElementById('email').value.trim();
    const whatsapp = document.getElementById('whatsapp').value.trim();
    const subject  = document.getElementById('subject').value.trim() || 'Inquiry from Website';
    const message  = document.getElementById('message').value.trim();

    if (!name || !email || !whatsapp || !message) {
        alert('Mohon lengkapi semua field yang wajib diisi.');
        return;
    }

    const targetEmail = "info@pict.co.id";
    const bodyText = [
        `Name: ${name}`,
        `Email: ${email}`,
        `Phone / WhatsApp: ${whatsapp}`,
        ``,
        `Message:`,
        message
    ].join('\r\n');

    window.location.href = `mailto:${targetEmail}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(bodyText)}`;
});
</script>
@endpush