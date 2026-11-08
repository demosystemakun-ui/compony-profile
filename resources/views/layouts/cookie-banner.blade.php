{{-- Custom cookie consent bar. Choice is stored under pict_cookie_consent. --}}
<div id="cookieConsentBanner"
     class="cookie-bar on-dark"
     role="region"
     aria-label="Cookie notice">
    <div class="cookie-bar__inner">
        <p>
            <strong>Cookie notice.</strong>
            This site stores your preference on this device. Accept to allow optional cookies, or reject to keep only what the site needs to function.
        </p>

        <div class="cookie-bar__actions">
            <button id="acceptAllCookies" class="btn btn--primary" type="button">Accept</button>
            <button id="rejectCookies" class="btn btn--outline" type="button">Reject</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const banner = document.getElementById('cookieConsentBanner');
    const acceptBtn = document.getElementById('acceptAllCookies');
    const rejectBtn = document.getElementById('rejectCookies');

    if (!banner) return;

    let storedChoice = null;

    try {
        storedChoice = localStorage.getItem('pict_cookie_consent');
    } catch (error) {
        storedChoice = null;
    }

    if (!storedChoice) {
        window.setTimeout(() => banner.classList.add('is-open'), 900);
    }

    function saveChoice(value) {
        try {
            localStorage.setItem('pict_cookie_consent', value);
        } catch (error) {
            /* Storage may be unavailable in private mode. The banner still closes. */
        }
        banner.classList.remove('is-open');
    }

    acceptBtn?.addEventListener('click', () => saveChoice('accepted'));
    rejectBtn?.addEventListener('click', () => saveChoice('rejected'));
});
</script>
