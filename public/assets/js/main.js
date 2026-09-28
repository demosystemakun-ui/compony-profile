/* ═══ MAIN JAVASCRIPT — PT PATIMBAN INTERNATIONAL CAR TERMINAL ═══ */

document.addEventListener('DOMContentLoaded', function () {
    // Inisialisasi umum atau fungsi global tambahan di sini
    console.log('PICT Main JS Loaded Successfully.');

    // Contoh: Tangani klik tautan eksternal atau tombol interaktif global
    const interactiveElements = document.querySelectorAll('.interactive-element');
    interactiveElements.forEach(el => {
        el.addEventListener('click', function () {
            // Tambahkan logika interaktif jika diperlukan
        });
    });
});