@extends('layouts.app')

@section('title', 'Contact | PT Patimban International Car Terminal')
@section('meta_description', 'Contact PT Patimban International Car Terminal at Patimban Port, Pusakanagara, Subang Regency, West Java. Email info@pict.co.id.')

@section('content')

@include('partials.page-header', [
    'index' => '01',
    'eyebrow' => 'Contact',
    'title' => 'Talk to the terminal team.',
    'lede' => 'For terminal services, vessel schedules, tariffs, or a site visit, reach the PICT team at Patimban Port in Subang Regency, West Java.',
    'image' => 'assets/images/patimban-yard-2.jpeg',
    'alt' => 'Vehicle staging area at Patimban Port',
    'caption' => 'Staging yard at Patimban Port. Photo: PICT.',
])

<section class="section section--paper">
    <div class="shell">
        <div class="narrative">
            <aside class="narrative__aside">
                <p class="index"><b>02</b><span class="index-rule" aria-hidden="true"></span>Contact details</p>
                <h2 class="display-l mt-3">Where to find us.</h2>
                <p class="body-copy mt-4">
                    The terminal sits inside the Patimban Port area. Email is the most direct way to reach the commercial team.
                </p>

                <dl class="rule-list mt-8">
                    <li>
                        <dt>Address</dt>
                        <dd>
                            Patimban Port, Pusakanagara,<br>
                            Subang Regency, West Java,<br>
                            Indonesia
                        </dd>
                    </li>
                    <li>
                        <dt>Email</dt>
                        <dd><a class="link" href="mailto:info@pict.co.id">info@pict.co.id</a></dd>
                    </li>
                    <li>
                        <dt>LinkedIn</dt>
                        <dd>
                            <a class="link" href="https://www.linkedin.com/company/patimban-international-car-terminal/posts/?feedView=all" target="_blank" rel="noopener noreferrer">Patimban International Car Terminal</a>
                        </dd>
                    </li>
                    <li>
                        <dt>Location</dt>
                        <dd>
                            <a class="link" href="https://www.google.com/maps/search/?api=1&amp;query=Pelabuhan+Patimban%2C+Subang%2C+Jawa+Barat" target="_blank" rel="noopener noreferrer">Open Patimban Port in Google Maps</a>
                        </dd>
                    </li>
                </dl>
            </aside>

            <div>
                <p class="index"><b>03</b><span class="index-rule" aria-hidden="true"></span>Message</p>
                <h2 class="display-l mt-3">Send a message.</h2>
                <p class="body-copy mt-4">
                    This form opens your email application with the message filled in. It does not store your details on this website.
                </p>

                <form id="contactForm" class="form-grid form-grid--two mt-8" novalidate>
                    <label class="field" for="contact-name">
                        <span class="field__label">Name <abbr title="required">*</abbr></span>
                        <input type="text" id="contact-name" name="name" autocomplete="name" required>
                    </label>

                    <label class="field" for="contact-email">
                        <span class="field__label">Email <abbr title="required">*</abbr></span>
                        <input type="email" id="contact-email" name="email" autocomplete="email" required>
                    </label>

                    <label class="field" for="contact-subject">
                        <span class="field__label">Subject</span>
                        <input type="text" id="contact-subject" name="subject" autocomplete="off">
                    </label>

                    <label class="field" for="contact-message">
                        <span class="field__label">Message <abbr title="required">*</abbr></span>
                        <textarea id="contact-message" name="message" required></textarea>
                    </label>

                    <div class="field-hint">
                        <p class="form-status" id="contactStatus" role="status" aria-live="polite"></p>
                    </div>

                    <div>
                        <button class="btn btn--primary" type="submit">Open email draft</button>
                        <noscript>
                            <p class="field-hint">JavaScript is turned off. Please write directly to <a class="link" href="mailto:info@pict.co.id">info@pict.co.id</a>.</p>
                        </noscript>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@include('partials.cta', [
    'index' => '04',
    'eyebrow' => 'Tariffs',
    'title' => 'Need the current tariff schedule?',
    'copy' => 'The tariff page lists the published document for each terminal service. For rates that are not listed, contact the commercial team.',
    'url' => '/our-tariffs',
    'label' => 'View terminal tariffs',
    'secondaryUrl' => '/contact',
    'secondaryLabel' => 'Email PICT',
])

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    var form = document.getElementById('contactForm');
    if (!form) return;

    var status = document.getElementById('contactStatus');
    var name = document.getElementById('contact-name');
    var email = document.getElementById('contact-email');
    var subject = document.getElementById('contact-subject');
    var message = document.getElementById('contact-message');

    function setStatus(text, state) {
        if (!status) return;
        status.textContent = text;
        status.dataset.state = state || '';
    }

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        var errors = [];

        [name, email, message].forEach(function (field) {
            if (field) field.removeAttribute('aria-invalid');
        });

        if (!name.value.trim()) {
            errors.push('Please enter your name.');
            name.setAttribute('aria-invalid', 'true');
        }

        if (!email.value.trim()) {
            errors.push('Please enter your email address.');
            email.setAttribute('aria-invalid', 'true');
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) {
            errors.push('Please enter a valid email address.');
            email.setAttribute('aria-invalid', 'true');
        }

        if (!message.value.trim()) {
            errors.push('Please write a message.');
            message.setAttribute('aria-invalid', 'true');
        }

        if (errors.length > 0) {
            setStatus(errors.join(' '), 'error');
            var firstInvalid = form.querySelector('[aria-invalid="true"]');
            if (firstInvalid) firstInvalid.focus();
            return;
        }

        var mailSubject = subject.value.trim() || 'Inquiry from the PICT website';
        var body = [
            'Name: ' + name.value.trim(),
            'Email: ' + email.value.trim(),
            '',
            'Message:',
            message.value.trim()
        ].join('\r\n');

        setStatus('Opening your email application.', 'ok');
        window.location.href = 'mailto:info@pict.co.id?subject=' + encodeURIComponent(mailSubject) + '&body=' + encodeURIComponent(body);

        window.setTimeout(function () {
            setStatus('If your email application did not open, write to info@pict.co.id.', 'ok');
        }, 1200);
    });

    [name, email, message].forEach(function (field) {
        field?.addEventListener('input', function () {
            field.removeAttribute('aria-invalid');
            if (status && status.dataset.state === 'error') setStatus('', '');
        });
    });
});
</script>
@endpush
