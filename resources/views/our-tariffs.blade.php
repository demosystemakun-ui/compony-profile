@extends('layouts.app')

@section('title', 'Tariffs | PT Patimban International Car Terminal')
@section('meta_description', 'Official terminal service tariffs for domestic, international, and other vehicle handling at Patimban Port, published as PDF documents.')

@php
    /* Tariff documents come from TariffController@publicIndex. The stream route
       is served from our own domain so the in-page PDF viewer can read it. */
    $documents = $tariffs->map(fn ($tariff) => [
        'tag' => $tariff->tag,
        'title' => $tariff->title,
        'desc' => $tariff->description,
        'exists' => $tariff->hasPdf(),
        'view' => route('tarif.stream', $tariff),
        'download' => route('tarif.download', $tariff),
    ])->all();
@endphp

@section('content')

@include('partials.page-header', [
    'index' => '01',
    'eyebrow' => 'Tariffs',
    'title' => 'Terminal service tariffs.',
    'lede' => 'Official fee structure for vehicle handling at Patimban Port, published as PDF documents for each service group.',
])

<section class="section section--paper">
    <div class="shell">
        <div class="section-head">
            <div>
                <p class="index"><b>02</b><span class="index-rule" aria-hidden="true"></span>Documents</p>
                <h2 class="display-l section-head__title">Published rate sheets.</h2>
            </div>
            <p class="section-head__aside">
                Each document is issued by the terminal team. Rates are subject to change, so confirm the current figure before booking.
            </p>
        </div>

        @if (count($documents) > 0)
            <noscript>
                <p class="body-copy mb-6">
                    JavaScript is turned off, so in-page preview is unavailable. Use the download links below to open each PDF.
                </p>
            </noscript>

            <div class="tariff-list">
                @foreach ($documents as $document)
                    <article class="tariff-row">
                        <div>
                            <div class="tariff-row__head">
                                <span class="tariff-row__tag">{{ $document['tag'] }}</span>
                                <h3 class="tariff-row__title">{{ $document['title'] }}</h3>
                            </div>

                            @if ($document['desc'])
                                <p class="tariff-row__desc">{{ $document['desc'] }}</p>
                            @endif
                        </div>

                        <div class="tariff-row__actions">
                            @if ($document['exists'])
                                <button type="button"
                                        class="btn btn--outline"
                                        onclick="openPdfViewer(@js($document['view']), @js($document['title']), @js($document['download']))">
                                    View document
                                </button>
                                <a class="btn btn--primary" href="{{ $document['download'] }}">
                                    Download PDF
                                </a>
                            @else
                                <p class="tariff-row__unavailable">
                                    PDF not yet available. Write to
                                    <a class="link" href="mailto:info@pict.co.id">info@pict.co.id</a>
                                    for the current rate.
                                </p>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <h3>No tariff documents yet</h3>
                <p>Rate sheets will be published here once the terminal team releases them. In the meantime, ask the commercial desk for the current tariff.</p>
                <p class="mt-4"><a class="link" href="{{ url('/contact') }}">Contact the terminal team</a></p>
            </div>
        @endif

        <p class="body-copy mt-10">
            Tariffs are subject to change in line with company policy. For confirmation of the latest rates, write to
            <a class="link" href="mailto:info@pict.co.id">info@pict.co.id</a>.
        </p>
    </div>
</section>

@include('partials.cta', [
    'index' => '03',
    'eyebrow' => 'Commercial',
    'title' => 'Need a rate confirmed before booking?',
    'copy' => 'The commercial team can confirm the current tariff for your vessel, cargo, and handling requirements.',
    'url' => '/contact',
    'label' => 'Contact PICT',
])

{{-- Notification toast. Moved to <body> by the script below. --}}
<div id="pdfNotification" class="toast" role="status" aria-live="polite">
    <div class="toast__body">
        <p class="toast__label">Notice</p>
        <p id="notificationText">Document not available.</p>
    </div>
    <button type="button" onclick="hideNotification()" aria-label="Close notice">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>

{{-- In-page PDF viewer. Moved to <body> by the script below. --}}
<div id="pdf-viewer-modal" class="pdf-modal" role="dialog" aria-modal="true" aria-labelledby="pdf-modal-title" hidden>
    <div class="pdf-toolbar">
        <div class="pdf-toolbar__doc">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 3H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V8l-6-5z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 3v5h5"/>
            </svg>
            <div>
                <span id="pdf-modal-title" class="pdf-toolbar__title">Document</span>
                <span id="pdf-page-info" class="pdf-toolbar__page">Page 1 / 1</span>
            </div>
        </div>

        <div class="pdf-toolbar__tools">
            <button id="pdf-prev-page" class="pdf-tool" type="button" title="Previous page" aria-label="Previous page">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button id="pdf-next-page" class="pdf-tool" type="button" title="Next page" aria-label="Next page">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </button>

            <span class="pdf-toolbar__sep" aria-hidden="true"></span>

            <button id="pdf-zoom-out" class="pdf-tool" type="button" title="Zoom out" aria-label="Zoom out">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M8 11h6"/></svg>
            </button>
            <span id="pdf-zoom-level" class="pdf-toolbar__zoom">100%</span>
            <button id="pdf-zoom-in" class="pdf-tool" type="button" title="Zoom in" aria-label="Zoom in">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M11 8v6M8 11h6"/></svg>
            </button>
            <button id="pdf-zoom-reset" class="pdf-tool pdf-tool--text" type="button" title="Reset zoom" aria-label="Reset zoom">1:1</button>

            <span class="pdf-toolbar__sep" aria-hidden="true"></span>

            <button id="pdf-tool-pan" class="pdf-tool is-active" type="button" title="Pan and scroll" aria-label="Pan tool">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8 11V6a2 2 0 114 0v5m0-3V4a2 2 0 114 0v7m0-2a2 2 0 114 0v6a8 8 0 01-8 8h-1a8 8 0 01-6.29-3.05l-2.3-3.5a1.5 1.5 0 012.4-1.8L7 15.5V6a2 2 0 114 0v5"/></svg>
            </button>
            <button id="pdf-tool-pen" class="pdf-tool" type="button" title="Draw on the page" aria-label="Pen tool">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/><path stroke-linecap="round" stroke-linejoin="round" d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            </button>
            <input type="color" id="pdf-pen-color" value="#c8102e" title="Pen colour" aria-label="Pen colour">
            <button id="pdf-tool-eraser" class="pdf-tool" type="button" title="Erase marks" aria-label="Eraser tool">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M20 20H8l-6-6a2 2 0 010-2.8L13.6 2 22 10.4 13.6 18.8"/></svg>
            </button>
            <button id="pdf-undo" class="pdf-tool" type="button" title="Undo last stroke" aria-label="Undo">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 14l-4-4 4-4M5 10h9a5 5 0 010 10h-1"/></svg>
            </button>
            <button id="pdf-clear" class="pdf-tool pdf-tool--text" type="button" title="Clear marks on this page" aria-label="Clear marks">CLR</button>

            <span class="pdf-toolbar__sep" aria-hidden="true"></span>

            <a id="pdf-download" class="pdf-tool" href="#" title="Download PDF" aria-label="Download PDF">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/></svg>
            </a>
            <button id="pdf-modal-close" class="pdf-tool" type="button" title="Close viewer" aria-label="Close viewer">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    <div id="pdf-canvas-container" class="pdf-canvas">
        <div id="pdf-page-wrap" class="pdf-page">
            <canvas id="pdf-render-canvas"></canvas>
            <canvas id="pdf-draw-canvas" class="pdf-draw tool-pan"></canvas>
        </div>

        <div id="pdf-loading-msg" class="pdf-status">
            <div class="pdf-spinner" aria-hidden="true"></div>
            <p>Rendering document</p>
        </div>

        <div id="pdf-error-msg" class="pdf-status is-hidden">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--signal-bright)" stroke-width="1.6" aria-hidden="true">
                <circle cx="12" cy="12" r="9"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01"/>
            </svg>
            <p class="pdf-status__title">Could not load this document</p>
            <p>Try again later or download the file directly.</p>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    /* Keep the modal and toast outside the page stacking context. */
    ['pdf-viewer-modal', 'pdfNotification'].forEach(id => {
        const element = document.getElementById(id);
        if (element) document.body.appendChild(element);
    });

    /* Notice toast */
    const toast = document.getElementById('pdfNotification');
    const toastText = document.getElementById('notificationText');
    let toastTimer = null;

    window.showNotification = function (message) {
        if (!toast || !toastText) return;
        toastText.textContent = message;
        toast.classList.add('is-visible');
        window.clearTimeout(toastTimer);
        toastTimer = window.setTimeout(window.hideNotification, 4500);
    };

    window.hideNotification = function () {
        if (toast) toast.classList.remove('is-visible');
    };

    /* PDF viewer */
    if (window.pdfjsLib) {
        pdfjsLib.GlobalWorkerOptions.workerSrc =
            'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
    }

    const $ = id => document.getElementById(id);
    const modal = $('pdf-viewer-modal');
    const titleEl = $('pdf-modal-title');
    const pageInfoEl = $('pdf-page-info');
    const container = $('pdf-canvas-container');
    const pageWrap = $('pdf-page-wrap');
    const renderCanvas = $('pdf-render-canvas');
    const drawCanvas = $('pdf-draw-canvas');
    const zoomLevelEl = $('pdf-zoom-level');
    const loadingMsg = $('pdf-loading-msg');
    const errorMsg = $('pdf-error-msg');
    const downloadLink = $('pdf-download');
    const prevBtn = $('pdf-prev-page');
    const nextBtn = $('pdf-next-page');
    const zoomInBtn = $('pdf-zoom-in');
    const zoomOutBtn = $('pdf-zoom-out');
    const zoomResetBtn = $('pdf-zoom-reset');
    const panBtn = $('pdf-tool-pan');
    const penBtn = $('pdf-tool-pen');
    const eraserBtn = $('pdf-tool-eraser');
    const penColorInput = $('pdf-pen-color');
    const undoBtn = $('pdf-undo');
    const clearBtn = $('pdf-clear');
    const closeBtn = $('pdf-modal-close');

    const BASE_SCALE = 1.25;
    const MIN_SCALE = 0.5;
    const MAX_SCALE = 3.5;

    let loadingTask = null;
    let pdfDoc = null;
    let currentPage = 1;
    let currentScale = BASE_SCALE;
    let currentTool = 'pan';
    let strokesByPage = {};
    let activeStroke = null;
    let isPointerDown = false;
    let renderToken = 0;
    let renderTask = null;
    let lastTrigger = null;

    function setTool(tool) {
        currentTool = tool;
        [panBtn, penBtn, eraserBtn].forEach(button => button.classList.remove('is-active'));
        drawCanvas.classList.remove('tool-pan', 'tool-pen', 'tool-eraser');
        ({ pan: panBtn, pen: penBtn, eraser: eraserBtn })[tool].classList.add('is-active');
        drawCanvas.classList.add('tool-' + tool);
    }

    const clampScale = scale => Math.min(MAX_SCALE, Math.max(MIN_SCALE, scale));

    function updateZoomLabel() {
        zoomLevelEl.textContent = Math.round((currentScale / BASE_SCALE) * 100) + '%';
    }

    function updateNavButtons() {
        if (!pdfDoc) return;
        prevBtn.disabled = currentPage <= 1;
        nextBtn.disabled = currentPage >= pdfDoc.numPages;
        pageInfoEl.textContent = 'Page ' + currentPage + ' / ' + pdfDoc.numPages;
    }

    function normalizedPoint(event) {
        const rect = drawCanvas.getBoundingClientRect();
        return {
            x: Math.min(1, Math.max(0, (event.clientX - rect.left) / rect.width)),
            y: Math.min(1, Math.max(0, (event.clientY - rect.top) / rect.height)),
        };
    }

    function drawStroke(context, stroke) {
        if (!stroke.points || stroke.points.length < 1) return;
        context.save();
        context.globalCompositeOperation = stroke.erase ? 'destination-out' : 'source-over';
        context.strokeStyle = stroke.color;
        context.lineWidth = stroke.width;
        context.lineCap = context.lineJoin = 'round';
        context.beginPath();
        stroke.points.forEach((point, index) => {
            const x = point.x * drawCanvas.width;
            const y = point.y * drawCanvas.height;
            index === 0 ? context.moveTo(x, y) : context.lineTo(x, y);
        });
        context.stroke();
        context.restore();
    }

    function redrawAnnotations() {
        const context = drawCanvas.getContext('2d');
        context.clearRect(0, 0, drawCanvas.width, drawCanvas.height);
        (strokesByPage[currentPage] || []).forEach(stroke => drawStroke(context, stroke));
    }

    function showError() {
        loadingMsg.classList.add('is-hidden');
        errorMsg.classList.remove('is-hidden');
        pageWrap.style.opacity = '0';
    }

    function renderPage(number) {
        if (!pdfDoc) return;
        const myToken = ++renderToken;
        if (renderTask) {
            try { renderTask.cancel(); } catch (_) {}
        }
        pageWrap.style.opacity = '0.5';

        pdfDoc.getPage(number).then(page => {
            if (myToken !== renderToken) return;
            const viewport = page.getViewport({ scale: currentScale });
            renderCanvas.width = drawCanvas.width = viewport.width;
            renderCanvas.height = drawCanvas.height = viewport.height;
            pageWrap.style.width = viewport.width + 'px';
            pageWrap.style.height = viewport.height + 'px';

            renderTask = page.render({ canvasContext: renderCanvas.getContext('2d'), viewport });
            return renderTask.promise.then(() => {
                if (myToken !== renderToken) return;
                pageWrap.style.opacity = '1';
                loadingMsg.classList.add('is-hidden');
                redrawAnnotations();
                updateZoomLabel();
                updateNavButtons();
            });
        }).catch(error => {
            if (error && error.name === 'RenderingCancelledException') return;
            if (myToken === renderToken) showError();
        });
    }

    function destroyLoadingTask() {
        const task = loadingTask;
        loadingTask = null;
        if (!task) return;

        /* Destroy only after the task has settled. Destroying a pending pdf.js
           worker rejects an internal promise that cannot be caught here. */
        task.promise.then(() => {
            try {
                const result = task.destroy();
                if (result && typeof result.catch === 'function') result.catch(() => {});
            } catch (_) {}
        }, () => {});
    }

    window.openPdfViewer = function (url, title, download) {
        if (!url || url === '#') {
            window.showNotification('This document is not yet available on the server.');
            return;
        }
        if (!window.pdfjsLib) {
            window.open(url, '_blank', 'noopener');
            return;
        }

        lastTrigger = document.activeElement;
        currentPage = 1;
        currentScale = BASE_SCALE;
        strokesByPage = {};
        titleEl.textContent = title || 'Document';
        downloadLink.href = download || url;
        errorMsg.classList.add('is-hidden');
        loadingMsg.classList.remove('is-hidden');
        pageWrap.style.opacity = '0';

        modal.hidden = false;
        document.body.classList.add('pdf-modal-open');
        setTool('pan');
        closeBtn.focus();

        destroyLoadingTask();
        loadingTask = pdfjsLib.getDocument(url);
        const task = loadingTask;

        task.promise.then(document => {
            if (task !== loadingTask) {
                Promise.resolve(document.destroy()).catch(() => {});
                return;
            }
            pdfDoc = document;
            renderPage(currentPage);
        }).catch(() => {
            if (task === loadingTask) showError();
        });
    };

    function closePdfViewer() {
        modal.hidden = true;
        document.body.classList.remove('pdf-modal-open');
        renderToken++;
        if (renderTask) {
            try { renderTask.cancel(); } catch (_) {}
            renderTask = null;
        }
        destroyLoadingTask();
        pdfDoc = null;
        lastTrigger?.focus();
    }

    closeBtn.addEventListener('click', closePdfViewer);
    document.addEventListener('keydown', event => {
        if (modal.hidden) return;

        if (event.key === 'Escape') {
            closePdfViewer();
            return;
        }

        if (event.key === 'Tab') {
            const focusables = Array.from(
                modal.querySelectorAll('button:not([disabled]), a[href], input:not([disabled])')
            ).filter(element => element.offsetParent !== null);

            if (focusables.length === 0) return;

            const first = focusables[0];
            const last = focusables[focusables.length - 1];

            if (event.shiftKey && document.activeElement === first) {
                event.preventDefault();
                last.focus();
            } else if (!event.shiftKey && document.activeElement === last) {
                event.preventDefault();
                first.focus();
            }
        }
    });

    prevBtn.addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            renderPage(currentPage);
        }
    });

    nextBtn.addEventListener('click', () => {
        if (pdfDoc && currentPage < pdfDoc.numPages) {
            currentPage++;
            renderPage(currentPage);
        }
    });

    zoomInBtn.addEventListener('click', () => {
        currentScale = clampScale(currentScale + 0.25);
        renderPage(currentPage);
    });

    zoomOutBtn.addEventListener('click', () => {
        currentScale = clampScale(currentScale - 0.25);
        renderPage(currentPage);
    });

    zoomResetBtn.addEventListener('click', () => {
        currentScale = BASE_SCALE;
        renderPage(currentPage);
    });

    container.addEventListener('wheel', event => {
        if (!event.ctrlKey) return;
        event.preventDefault();
        currentScale = clampScale(currentScale + (event.deltaY < 0 ? 0.15 : -0.15));
        renderPage(currentPage);
    }, { passive: false });

    panBtn.addEventListener('click', () => setTool('pan'));
    penBtn.addEventListener('click', () => setTool('pen'));
    eraserBtn.addEventListener('click', () => setTool('eraser'));

    undoBtn.addEventListener('click', () => {
        (strokesByPage[currentPage] || []).pop();
        redrawAnnotations();
    });

    clearBtn.addEventListener('click', () => {
        strokesByPage[currentPage] = [];
        redrawAnnotations();
    });

    drawCanvas.addEventListener('pointerdown', event => {
        if (currentTool === 'pan') return;
        isPointerDown = true;
        drawCanvas.setPointerCapture(event.pointerId);
        activeStroke = {
            color: currentTool === 'eraser' ? '#000000' : penColorInput.value,
            width: currentTool === 'eraser' ? 22 : 3,
            erase: currentTool === 'eraser',
            points: [normalizedPoint(event)],
        };
    });

    drawCanvas.addEventListener('pointermove', event => {
        if (!isPointerDown || !activeStroke) return;
        activeStroke.points.push(normalizedPoint(event));
        redrawAnnotations();
        drawStroke(drawCanvas.getContext('2d'), activeStroke);
    });

    function finishStroke() {
        if (activeStroke && activeStroke.points.length > 1) {
            (strokesByPage[currentPage] = strokesByPage[currentPage] || []).push(activeStroke);
        }
        activeStroke = null;
        isPointerDown = false;
        redrawAnnotations();
    }

    drawCanvas.addEventListener('pointerup', finishStroke);
    drawCanvas.addEventListener('pointercancel', finishStroke);
    drawCanvas.addEventListener('pointerleave', () => {
        if (isPointerDown) finishStroke();
    });
});
</script>
@endpush
