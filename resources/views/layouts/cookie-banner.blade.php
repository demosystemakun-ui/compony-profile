<!-- ═══ CUSTOM COOKIE CONSENT BANNER ═══ -->
<div id="cookieConsentBanner" class="fixed bottom-0 left-0 right-0 z-50 p-4 md:p-6 bg-slate-900/95 backdrop-blur-md border-t border-slate-800 shadow-2xl transition-all duration-500 translate-y-full opacity-0 hidden">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="text-slate-300 text-xs md:text-sm leading-relaxed text-center md:text-left">
            <span class="font-bold text-white block mb-1">🍪 Privacy & Cookie Notice</span>
            We use cookies to ensure you have the best experience on the PT Patimban International Car Terminal website. By continuing to use this site, you agree to the use of all our cookies.
        </div>
        <div class="flex items-center gap-3 shrink-0">
            <button id="acceptAllCookies" class="px-6 py-2.5 rounded-xl bg-red-600 hover:bg-red-500 text-white text-xs font-bold transition shadow-lg shadow-red-600/30 cursor-pointer">
                Accept All
            </button>
            <button id="rejectCookies" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold transition border border-slate-700 cursor-pointer">
                Reject
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const banner = document.getElementById('cookieConsentBanner');
    const acceptBtn = document.getElementById('acceptAllCookies');
    const rejectBtn = document.getElementById('rejectCookies');

    // Cek apakah user sudah pernah memilih sebelumnya
    if (!localStorage.getItem('pict_cookie_consent')) {
        // Tampilkan banner dengan animasi
        setTimeout(() => {
            banner.classList.remove('hidden');
            setTimeout(() => {
                banner.classList.remove('translate-y-full', 'opacity-0');
            }, 50);
        }, 1000); // Muncul 1 detik setelah halaman dimuat
    }

    // Jika tombol "Terima Semua" diklik
    acceptBtn.addEventListener('click', function () {
        localStorage.setItem('pict_cookie_consent', 'accepted');
        hideBanner();
    });

    // Jika tombol "Tolak" diklik
    rejectBtn.addEventListener('click', function () {
        localStorage.setItem('pict_cookie_consent', 'rejected');
        hideBanner();
    });

    function hideBanner() {
        banner.classList.add('translate-y-full', 'opacity-0');
        setTimeout(() => {
            banner.classList.add('hidden');
        }, 500);
    }
});
</script>