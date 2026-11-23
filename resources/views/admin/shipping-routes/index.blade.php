@php
    $focus      = 'focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#0A2540]';
    $input      = "w-full rounded-xl border border-slate-200 bg-[#f6f9fc] px-3.5 py-2 text-sm text-[#0A2540] placeholder-slate-400 transition focus:border-[#0A2540] focus:bg-white focus:outline-none";
    $btn        = "inline-flex items-center justify-center rounded-full bg-[#eef5fb] px-3.5 py-1.5 text-xs font-semibold text-[#0A2540] transition hover:bg-[#dce8f5] $focus";
    $btnPrimary = "inline-flex items-center justify-center gap-1.5 rounded-full bg-[#0A2540] px-4 py-1.5 text-xs font-bold text-white transition hover:bg-[#13385e] $focus";
    $btnDanger  = "inline-flex items-center justify-center rounded-full bg-red-50 px-3.5 py-1.5 text-xs font-semibold text-red-700 transition hover:bg-red-100 $focus";
    $card       = 'bg-white rounded-2xl shadow-sm border border-slate-100';
    $pillGray   = 'inline-block rounded-full bg-[#eef5fb] px-2.5 py-0.5 text-xs font-semibold text-[#0A2540]';
@endphp

<x-admin-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-base sm:text-lg font-bold text-[#0A2540] leading-tight tracking-tight">
                {{ __('Shipping Routes') }}
            </h2>
            <p class="text-xs text-slate-500">Manage shipping routes displayed on the public map</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">

        @if(session('success'))
            <div role="status" class="flex items-start gap-3 rounded-xl bg-emerald-50 px-4 py-3 text-sm text-emerald-900 ring-1 ring-emerald-200">
                <svg class="mt-0.5 h-4 w-4 shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div role="alert" class="rounded-xl bg-red-50 px-4 py-3 text-sm text-red-800 ring-1 ring-red-200">
                <p class="font-semibold mb-1">Please fix the following errors:</p>
                <ul class="list-disc pl-5 space-y-1 text-xs sm:text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="{{ $card }} overflow-hidden">

            {{-- Top Bar --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-5 pt-5 pb-4">
                <div>
                    <h3 class="text-base font-bold text-[#0A2540]">Shipping route list</h3>
                    <p class="mt-0.5 text-xs text-slate-500">Ports and transit corridors shown on the map</p>
                </div>

                <button type="button"
                        onclick="openModal('add')"
                        class="{{ $btnPrimary }} shrink-0">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 5v14M5 12h14"/>
                    </svg>
                    Add route
                </button>
            </div>

            {{-- Tabel (Desktop) --}}
            <div class="hidden md:block overflow-x-auto px-3 pb-3">
                <table class="w-full text-left text-sm">
                    <thead class="text-xs text-slate-500">
                        <tr class="bg-[#f6f9fc]">
                            <th scope="col" class="rounded-l-xl px-4 py-2.5 font-semibold">Port</th>
                            <th scope="col" class="px-3 py-2.5 font-semibold">Category</th>
                            <th scope="col" class="px-3 py-2.5 font-semibold">Coordinates</th>
                            <th scope="col" class="px-3 py-2.5 font-semibold">Transit</th>
                            <th scope="col" class="px-3 py-2.5 font-semibold">Status</th>
                            <th scope="col" class="rounded-r-xl px-4 py-2.5 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($routes as $route)
                            <tr class="hover:bg-[#f6f9fc] transition-colors">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#eef5fb] text-lg">
                                            {{ $route->flag ?: '🏳️' }}
                                        </span>
                                        <div class="min-w-0">
                                            <p class="truncate font-semibold text-[#0A2540]">{{ $route->name }}</p>
                                            <p class="truncate text-xs text-slate-500">{{ $route->country }}</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-3 py-3 whitespace-nowrap">
                                    @if($route->category === 'hub')
                                        <span class="inline-block rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-semibold text-red-700 uppercase">
                                            {{ $route->category }}
                                        </span>
                                    @elseif($route->category === 'domestic')
                                        <span class="{{ $pillGray }} uppercase">{{ $route->category }}</span>
                                    @else
                                        <span class="inline-block rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-semibold text-amber-800 uppercase">
                                            {{ $route->category }}
                                        </span>
                                    @endif
                                </td>

                                <td class="px-3 py-3 whitespace-nowrap font-mono text-xs text-slate-600">
                                    {{ number_format($route->latitude, 4) }},<br>
                                    {{ number_format($route->longitude, 4) }}
                                </td>

                                <td class="px-3 py-3 whitespace-nowrap text-xs font-semibold tabular-nums text-[#0A2540]">
                                    {{ $route->transit_days ?? '-' }} days
                                </td>

                                <td class="px-3 py-3 whitespace-nowrap">
                                    @if($route->is_active)
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-800">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500" aria-hidden="true"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">
                                            <span class="h-1.5 w-1.5 rounded-full bg-slate-400" aria-hidden="true"></span>
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button"
                                                onclick='openModal("edit", @json($route))'
                                                class="{{ $btn }}">
                                            Edit
                                        </button>
                                        <button type="button"
                                                onclick="openDeleteModal('{{ $route->id }}', @js($route->name))"
                                                class="{{ $btnDanger }}">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-12 text-center">
                                    <p class="text-sm font-semibold text-slate-700">No shipping routes available</p>
                                    <p class="mt-1 text-xs text-slate-500">Click &ldquo;Add route&rdquo; above to add a port or route.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- List (Mobile) --}}
            <ul class="md:hidden space-y-3 px-3 pb-3">
                @forelse($routes as $route)
                    <li class="rounded-xl bg-[#f6f9fc] p-3.5">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white text-lg ring-1 ring-slate-200/70">
                                    {{ $route->flag ?: '🏳️' }}
                                </span>
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-[#0A2540]">{{ $route->name }}</p>
                                    <p class="truncate text-xs text-slate-500">{{ $route->country }}</p>
                                </div>
                            </div>

                            @if($route->is_active)
                                <span class="inline-flex shrink-0 items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-800">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500" aria-hidden="true"></span>Active
                                </span>
                            @else
                                <span class="shrink-0 rounded-full bg-white px-2 py-0.5 text-xs font-semibold text-slate-500">Inactive</span>
                            @endif
                        </div>

                        <div class="mt-2.5 flex flex-wrap items-center gap-2 text-xs">
                            @if($route->category === 'hub')
                                <span class="rounded-full bg-red-50 px-2.5 py-0.5 font-semibold text-red-700 uppercase">{{ $route->category }}</span>
                            @elseif($route->category === 'domestic')
                                <span class="{{ $pillGray }} !bg-white uppercase">{{ $route->category }}</span>
                            @else
                                <span class="rounded-full bg-amber-50 px-2.5 py-0.5 font-semibold text-amber-800 uppercase">{{ $route->category }}</span>
                            @endif

                            <span class="font-semibold tabular-nums text-[#0A2540]">{{ $route->transit_days ?? '-' }} days</span>
                            <span class="font-mono text-slate-500">
                                {{ number_format($route->latitude, 4) }}, {{ number_format($route->longitude, 4) }}
                            </span>
                        </div>

                        <div class="mt-3 flex gap-2">
                            <button type="button"
                                    onclick='openModal("edit", @json($route))'
                                    class="{{ $btn }} !bg-white flex-1">
                                Edit
                            </button>
                            <button type="button"
                                    onclick="openDeleteModal('{{ $route->id }}', @js($route->name))"
                                    class="{{ $btnDanger }} flex-1">
                                Delete
                            </button>
                        </div>
                    </li>
                @empty
                    <li class="px-4 py-10 text-center text-sm text-slate-500">
                        No shipping routes available. Click &ldquo;Add route&rdquo; above.
                    </li>
                @endforelse
            </ul>

        </section>

    </div>

    {{-- MODAL KONFIRMASI HAPUS --}}
    <div id="deleteModal"
         role="dialog"
         aria-modal="true"
         aria-labelledby="deleteModalTitle"
         class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 backdrop-blur-sm transition-opacity p-4">
        <div id="deleteModalContent"
             class="w-full max-w-md scale-95 opacity-0 overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-xl transition-all">
            <div class="p-6">
                <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-red-50 text-red-700">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h3 id="deleteModalTitle" class="mb-2 text-center text-base font-bold text-[#0A2540]">Delete this route?</h3>
                <p class="mb-6 text-center text-xs sm:text-sm text-slate-500">
                    Route <span id="deleteRouteName" class="font-semibold text-[#0A2540]"></span> will be permanently deleted and cannot be recovered.
                </p>
                <div class="flex gap-2.5">
                    <button type="button"
                            id="cancelDeleteBtn"
                            class="inline-flex flex-1 items-center justify-center rounded-full bg-[#eef5fb] px-4 py-2 text-xs sm:text-sm font-semibold text-[#0A2540] transition hover:bg-[#dce8f5] {{ $focus }}">
                        Cancel
                    </button>
                    <form id="deleteForm" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex w-full items-center justify-center rounded-full bg-red-600 px-4 py-2 text-xs sm:text-sm font-bold text-white transition hover:bg-red-700 {{ $focus }}">
                            Yes, delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Form --}}
    <div id="routeModal"
         role="dialog"
         aria-modal="true"
         aria-labelledby="modalTitle"
         class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
        <div class="w-full max-w-3xl max-h-[90vh] overflow-y-auto rounded-2xl border border-slate-100 bg-white shadow-xl">
            <form id="routeForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="sticky top-0 z-10 flex items-center justify-between border-b border-slate-100 bg-white px-5 py-4">
                    <h3 id="modalTitle" class="text-base font-bold text-[#0A2540]">Add new route</h3>
                    <button type="button"
                            onclick="closeModal()"
                            aria-label="Close modal"
                            class="flex h-8 w-8 items-center justify-center rounded-full bg-[#eef5fb] text-sm font-bold text-[#0A2540] transition hover:bg-[#dce8f5] {{ $focus }}">
                        &times;
                    </button>
                </div>

                <div class="p-5 space-y-4">
                    {{-- Peta interaktif --}}
                    <div>
                        <span class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                            Click map to set location
                        </span>
                        <div id="mapPicker" class="h-72 sm:h-80 w-full rounded-2xl border border-slate-200 bg-[#f6f9fc]"></div>
                        <p class="mt-1 text-xs text-slate-400">Drag marker to reposition. Scroll to zoom.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="inputName" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                Port name
                            </label>
                            <input type="text" name="name" id="inputName" required class="{{ $input }}">
                        </div>
                        <div>
                            <label for="inputCountry" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                Country
                            </label>
                            <input type="text" name="country" id="inputCountry" required class="{{ $input }}">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="inputCategory" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                Category
                            </label>
                            <select name="category" id="inputCategory" required class="{{ $input }} cursor-pointer">
                                <option value="hub">Hub</option>
                                <option value="domestic">Domestic</option>
                                <option value="international">International</option>
                            </select>
                        </div>
                        <div>
                            <label for="inputColor" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                Color
                            </label>
                            <select name="color" id="inputColor" class="{{ $input }} cursor-pointer">
                                <option value="#0EA5E9">Blue</option>
                                <option value="#f9d716">Yellow</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label for="inputLat" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                Latitude
                            </label>
                            <input type="number" step="any" name="latitude" id="inputLat" required class="{{ $input }} font-mono">
                        </div>
                        <div>
                            <label for="inputLng" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                Longitude
                            </label>
                            <input type="number" step="any" name="longitude" id="inputLng" required class="{{ $input }} font-mono">
                        </div>
                        <div>
                            <label for="inputFlag" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                Flag
                            </label>
                            <select name="flag" id="inputFlag"></select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="inputTransit" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                Transit (days)
                            </label>
                            <input type="number" name="transit_days" id="inputTransit" value="0" class="{{ $input }}">
                        </div>
                        <div>
                            <label for="inputSort" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                Sort order
                            </label>
                            <input type="number" name="sort_order" id="inputSort" value="0" class="{{ $input }}">
                        </div>
                    </div>

                    <div>
                        <label for="inputDesc" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                            Description
                        </label>
                        <textarea name="description" id="inputDesc" rows="2" class="{{ $input }}"></textarea>
                    </div>

                    <div>
                        <label class="inline-flex cursor-pointer items-center gap-2">
                            <input type="checkbox"
                                   name="is_active"
                                   id="inputActive"
                                   value="1"
                                   checked
                                   class="h-4 w-4 rounded border-slate-300 text-[#0A2540] focus:ring-[#0A2540]">
                            <span class="text-xs sm:text-sm font-medium text-slate-700">Activate this route</span>
                        </label>
                    </div>
                </div>

                <div class="sticky bottom-0 flex items-center justify-end gap-2.5 border-t border-slate-100 bg-[#f6f9fc] px-5 py-4">
                    <button type="button"
                            onclick="closeModal()"
                            class="inline-flex items-center justify-center rounded-full bg-white px-4 py-2 text-xs sm:text-sm font-semibold text-[#0A2540] ring-1 ring-slate-200 transition hover:bg-[#eef5fb] {{ $focus }}">
                        Cancel
                    </button>
                    <button type="submit" class="{{ $btnPrimary }} !px-5 !py-2 !text-xs sm:!text-sm">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    {{-- Tom Select (Untuk Flag Searchable) --}}
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    @push('scripts')
    <script>
        const SHIPPING_ROUTE_BASE  = "{{ route('shipping-routes.index') }}";
        const SHIPPING_ROUTE_STORE = "{{ route('shipping-routes.store') }}";

        let map, marker;
        let flagSelect = null;

        const ISO_CODES = `AD AE AF AG AI AL AM AO AQ AR AS AT AU AW AX AZ BA BB BD BE BF BG BH BI BJ BL BM BN BO BQ BR BS BT BV BW BY BZ
CA CC CD CF CG CH CI CK CL CM CN CO CR CU CV CW CX CY CZ DE DJ DK DM DO DZ EC EE EG EH ER ES ET FI FJ FK FM FO FR
GA GB GD GE GF GG GH GI GL GM GN GP GQ GR GS GT GU GW GY HK HM HN HR HT HU ID IE IL IM IN IO IQ IR IS IT JE JM JO JP
KE KG KH KI KM KN KP KR KW KY KZ LA LB LC LI LK LR LS LT LU LV LY MA MC MD ME MF MG MH MK ML MM MN MO MP MQ MR MS MT
MU MV MW MX MY MZ NA NC NE NF NG NI NL NO NP NR NU NZ OM PA PE PF PG PH PK PL PM PN PR PS PT PW PY QA RE RO RS RU RW
SA SB SC SD SE SG SH SI SJ SK SL SM SN SO SR SS ST SV SX SY SZ TC TD TF TG TH TJ TK TL TM TN TO TR TT TV TW TZ UA UG
UM US UY UZ VA VC VE VG VI VN VU WF WS XK YE YT ZA ZM ZW`.split(/\s+/);

        function codeToFlag(code) {
            return String.fromCodePoint(...[...code].map(c => 127397 + c.charCodeAt(0)));
        }

        const regionNames = new Intl.DisplayNames(['id'], { type: 'region' });

        const flagOptions = ISO_CODES.map(code => {
            const flag = codeToFlag(code);
            const name = regionNames.of(code);
            return { value: flag, name: name, text: `${flag} ${name}` };
        });

        function initFlagSelect() {
            if (flagSelect) return;
            flagSelect = new TomSelect("#inputFlag", {
                options: flagOptions,
                create: false,
                maxOptions: null,
                searchField: ['name', 'text'],
                sortField: { field: "name", direction: "asc" },
                onChange(value) {
                    const opt = flagOptions.find(o => o.value === value);
                    const countryInput = document.getElementById('inputCountry');
                    if (opt && countryInput && !countryInput.value.trim()) {
                        countryInput.value = opt.name;
                    }
                },
                render: {
                    option: (data, escape) => '<div>' + escape(data.text) + '</div>',
                    item:   (data, escape) => '<div class="text-xl">' + escape(data.value) + '</div>'
                }
            });
        }

        function nearestLng(lng, ref = 108) {
            while (lng - ref > 180)  lng -= 360;
            while (lng - ref < -180) lng += 360;
            return lng;
        }

        function initMap() {
            if (map) return;
            map = L.map('mapPicker', { minZoom: 2 }).setView([5, 110], 3);

            L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {
                attribution: 'Tiles © Esri',
                maxZoom: 19,
            }).addTo(map);

            marker = L.marker([-2, 108], { draggable: true }).addTo(map);
            map.on('click', (e) => { marker.setLatLng(e.latlng); updateCoords(e.latlng); });
            marker.on('dragend', () => updateCoords(marker.getLatLng()));
        }

        function updateCoords(latlng) {
            const p = L.latLng(latlng.lat, latlng.lng).wrap();
            document.getElementById('inputLat').value = p.lat.toFixed(6);
            document.getElementById('inputLng').value = p.lng.toFixed(6);
        }

        function setFlagValue(raw) {
            if (!flagSelect) return;
            if (!raw) { flagSelect.clear(true); return; }

            const val = String(raw).trim();
            const match = flagOptions.find(o => o.value === val || o.text.includes(val));

            if (match) {
                flagSelect.setValue(match.value, true);
            } else {
                flagSelect.addOption({ value: val, name: val, text: val });
                flagSelect.setValue(val, true);
            }
        }

        function openModal(mode, data = null) {
            const modal  = document.getElementById('routeModal');
            const form   = document.getElementById('routeForm');
            const title  = document.getElementById('modalTitle');
            const method = document.getElementById('formMethod');

            initFlagSelect();
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            setTimeout(() => {
                initMap();
                map.invalidateSize();
            }, 100);

            if (mode === 'add') {
                title.innerText = 'Add new route';
                form.action  = SHIPPING_ROUTE_STORE;
                method.value = 'POST';

                form.reset();
                if (flagSelect) flagSelect.clear(true);

                setTimeout(() => {
                    marker.setLatLng([-2, 108]);
                    map.setView([5, 110], 3);
                    updateCoords({ lat: -2, lng: 108 });
                }, 120);

                document.getElementById('inputActive').checked = true;
                document.getElementById('inputColor').value = '#0EA5E9';
            } else {
                title.innerText = 'Edit route';
                form.action  = SHIPPING_ROUTE_BASE + '/' + data.id;
                method.value = 'PUT';

                document.getElementById('inputName').value     = data.name ?? '';
                document.getElementById('inputCountry').value  = data.country ?? '';
                document.getElementById('inputCategory').value = data.category ?? 'domestic';
                document.getElementById('inputColor').value    = data.color || '#0EA5E9';
                document.getElementById('inputLat').value      = data.latitude ?? '';
                document.getElementById('inputLng').value      = data.longitude ?? '';
                document.getElementById('inputTransit').value  = data.transit_days ?? 0;
                document.getElementById('inputSort').value     = data.sort_order ?? 0;
                document.getElementById('inputDesc').value     = data.description ?? '';
                document.getElementById('inputActive').checked = Boolean(data.is_active);

                setFlagValue(data.flag);

                const lat = parseFloat(data.latitude);
                const lng = parseFloat(data.longitude);
                if (!isNaN(lat) && !isNaN(lng)) {
                    setTimeout(() => {
                        const shown = nearestLng(lng);
                        marker.setLatLng([lat, shown]);
                        map.setView([lat, shown], 5);
                    }, 120);
                }
            }
        }

        function closeModal() {
            const modal = document.getElementById('routeModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function openDeleteModal(id, name) {
            const modal = document.getElementById('deleteModal');
            const content = document.getElementById('deleteModalContent');
            const form = document.getElementById('deleteForm');
            const nameSpan = document.getElementById('deleteRouteName');

            nameSpan.textContent = `"${name}"`;
            form.action = `${SHIPPING_ROUTE_BASE}/${id}`;

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            const content = document.getElementById('deleteModalContent');

            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 200);
        }

        document.addEventListener('DOMContentLoaded', () => {
            initFlagSelect();

            document.getElementById('cancelDeleteBtn').addEventListener('click', closeDeleteModal);
            document.getElementById('deleteModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeDeleteModal();
                }
            });
        });
    </script>
    @endpush
</x-admin-layout>