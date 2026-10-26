<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-wrap gap-3 justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-[#0A2540] leading-tight tracking-tight">
                    {{ __('Shipping Routes') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">Kelola rute pelayaran yang tampil di peta publik</p>
            </div>
            <button onclick="openModal('add')" class="bg-[#EC2029] hover:bg-[#961c22] text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                + Tambah Rute
            </button>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-800 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white overflow-hidden shadow-md rounded-2xl border border-gray-100">
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b-2 border-gray-100 text-gray-500 text-xs uppercase tracking-wider">
                            <th class="py-3.5 px-4 font-bold">Pelabuhan</th>
                            <th class="py-3.5 px-4 font-bold">Kategori</th>
                            <th class="py-3.5 px-4 font-bold">Koordinat</th>
                            <th class="py-3.5 px-4 font-bold">Transit</th>
                            <th class="py-3.5 px-4 font-bold">Status</th>
                            <th class="py-3.5 px-4 text-center font-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($routes as $route)
                            <tr class="hover:bg-red-50/30">
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        {{-- Tampilkan flag emoji dari DB; fallback ke kode negara --}}
                                        <span class="text-2xl">{{ $route->flag ?: '🏳️' }}</span>
                                        <div>
                                            <p class="font-bold text-[#0A2540]">{{ $route->name }}</p>
                                            <p class="text-gray-500 text-xs">{{ $route->country }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="text-[10px] font-bold px-2 py-1 rounded uppercase
                                        @if($route->category === 'hub') bg-red-100 text-red-700
                                        @elseif($route->category === 'domestic') bg-blue-100 text-blue-700
                                        @else bg-amber-100 text-amber-700 @endif">
                                        {{ $route->category }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-xs text-slate-600 font-mono">
                                    {{ number_format($route->latitude, 4) }},<br>
                                    {{ number_format($route->longitude, 4) }}
                                </td>
                                <td class="py-4 px-4 text-sm">{{ $route->transit_days ?? '-' }} hari</td>
                                <td class="py-4 px-4">
                                    @if($route->is_active)
                                        <span class="text-[10px] font-bold px-2 py-1 rounded bg-green-100 text-green-700 uppercase">Aktif</span>
                                    @else
                                        <span class="text-[10px] font-bold px-2 py-1 rounded bg-gray-100 text-gray-500 uppercase">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <button onclick='openModal("edit", @json($route))'
                                                class="text-amber-700 text-xs font-semibold bg-amber-50 px-3 py-1.5 rounded-md border border-amber-200 hover:bg-amber-100">
                                            Edit
                                        </button>
                                        <form action="{{ route('shipping-routes.destroy', $route) }}" method="POST"
                                              onsubmit="return confirm('Hapus rute ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-700 text-xs font-semibold bg-red-50 px-3 py-1.5 rounded-md border border-red-200 hover:bg-red-100">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-gray-400 text-sm">
                                    Belum ada rute. Klik "+ Tambah Rute" untuk memulai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Form --}}
    <div id="routeModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-3xl max-h-[90vh] overflow-y-auto">
            <form id="routeForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="p-6 border-b border-slate-100 flex justify-between items-center sticky top-0 bg-white z-10">
                    <h3 id="modalTitle" class="text-lg font-bold text-[#0A2540]">Tambah Rute Baru</h3>
                    <button type="button" onclick="closeModal()" class="text-slate-400 hover:text-slate-600 text-2xl leading-none">&times;</button>
                </div>

                <div class="p-6 space-y-4">
                    {{-- Peta interaktif --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">
                            📍 Klik peta untuk menentukan lokasi
                        </label>
                        <div id="mapPicker" class="w-full h-80 rounded-xl border border-slate-200"></div>
                        <p class="text-[10px] text-slate-400 mt-1">Klik marker dan drag untuk reposisi. Zoom dengan scroll.</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Pelabuhan</label>
                            <input type="text" name="name" id="inputName" required
                                   class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Negara</label>
                            <input type="text" name="country" id="inputCountry" required
                                   class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Kategori</label>
                            <select name="category" id="inputCategory" required
                                    class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
                                <option value="hub">Hub</option>
                                <option value="domestic">Domestic</option>
                                <option value="international">International</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Warna</label>
                            <input type="color" name="color" id="inputColor" value="#0EA5E9"
                                   class="w-full h-10 border border-slate-300 rounded-lg">
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Latitude</label>
                            <input type="text" name="latitude" id="inputLat" required
                                   class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm bg-slate-50">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Longitude</label>
                            <input type="text" name="longitude" id="inputLng" required
                                   class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm bg-slate-50">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Flag (Emoji)</label>
                            <select name="flag" id="inputFlag"></select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Transit (hari)</label>
                            <input type="number" name="transit_days" id="inputTransit" value="0"
                                   class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Sort Order</label>
                            <input type="number" name="sort_order" id="inputSort" value="0"
                                   class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Deskripsi</label>
                        <textarea name="description" id="inputDesc" rows="2"
                                  class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm"></textarea>
                    </div>

                    <div>
                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" name="is_active" id="inputActive" value="1" checked
                                   class="rounded border-slate-300 text-[#EC2029]">
                            <span class="text-sm font-medium text-slate-700">Aktifkan rute ini</span>
                        </label>
                    </div>
                </div>

                <div class="p-6 border-t border-slate-100 flex justify-end gap-3 sticky bottom-0 bg-white">
                    <button type="button" onclick="closeModal()"
                            class="px-5 py-2.5 rounded-lg text-sm font-semibold text-slate-600 hover:bg-slate-100">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-5 py-2.5 rounded-lg text-sm font-semibold text-white bg-[#EC2029] hover:bg-[#961c22]">
                        Simpan
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

   <script>
    // Menggunakan route() helper agar URL menyesuaikan prefix 'pict-internal-admin-portal'
    const SHIPPING_ROUTE_BASE = "{{ route('shipping-routes.index') }}";
    const SHIPPING_ROUTE_STORE = "{{ route('shipping-routes.store') }}";

    let map, marker;
    let flagSelect = null;

    const flagOptions = [
        { value: '🇮🇩', text: '🇮🇩 Indonesia' },
        { value: '🇹🇭', text: '🇹🇭 Thailand' },
        { value: '🇸🇬', text: '🇸🇬 Singapore' },
        { value: '🇲🇾', text: '🇲🇾 Malaysia' },
        { value: '🇵🇭', text: '🇵🇭 Philippines' },
        { value: '🇻🇳', text: '🇻🇳 Vietnam' },
        { value: '🇨🇳', text: '🇨🇳 China' },
        { value: '🇯🇵', text: '🇯🇵 Japan' },
        { value: '🇰🇷', text: '🇰🇷 South Korea' },
        { value: '🇦🇺', text: '🇦🇺 Australia' },
        { value: '🇺🇸', text: '🇺🇸 United States' },
        { value: '🇳🇱', text: '🇳🇱 Netherlands' },
        { value: '🇬🇧', text: '🇬🇧 United Kingdom' },
        { value: '🇮🇳', text: '🇮🇳 India' },
        { value: '🇦🇪', text: '🇦🇪 United Arab Emirates' },
        { value: '🇲🇽', text: '🇲🇽 Mexico' }
    ];

    function initFlagSelect() {
        if (flagSelect) return;
        flagSelect = new TomSelect("#inputFlag", {
            options: flagOptions,
            create: false,
            searchField: ['text'],
            sortField: { field: "text", direction: "asc" },
            render: {
                option: (data, escape) => '<div>' + escape(data.text) + '</div>',
                item:   (data, escape) => '<div class="text-xl">' + escape(data.value) + '</div>'
            }
        });
    }

    function initMap() {
        if (map) return;
        map = L.map('mapPicker').setView([10, 100], 3);
        L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles © Esri',
            maxZoom: 19,
        }).addTo(map);

        marker = L.marker([-2, 108], { draggable: true }).addTo(map);
        map.on('click', (e) => { marker.setLatLng(e.latlng); updateCoords(e.latlng); });
        marker.on('dragend', () => updateCoords(marker.getLatLng()));
    }

    function updateCoords(latlng) {
        document.getElementById('inputLat').value = Number(latlng.lat).toFixed(6);
        document.getElementById('inputLng').value = Number(latlng.lng).toFixed(6);
    }

    function setFlagValue(raw) {
        if (!flagSelect) return;
        if (!raw) { flagSelect.clear(); return; }

        const val = String(raw).trim();
        const match = flagOptions.find(o =>
            o.value === val ||
            o.text.includes(val) ||
            val.includes(o.value)
        );

        if (match) {
            flagSelect.setValue(match.value);
        } else {
            flagSelect.addOption({ value: val, text: val });
            flagSelect.setValue(val);
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
            title.innerText = 'Tambah Rute Baru';
            form.action  = SHIPPING_ROUTE_STORE;
            method.value = 'POST';

            form.reset();
            if (flagSelect) flagSelect.clear();

            marker.setLatLng([-2, 108]);
            map.setView([10, 100], 3);
            updateCoords({ lat: -2, lng: 108 });

            document.getElementById('inputActive').checked = true;
            document.getElementById('inputColor').value = '#0EA5E9';
        } else {
            title.innerText = 'Edit Rute';
            // PERBAIKAN URL PUT DI SINI
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
                marker.setLatLng([lat, lng]);
                map.setView([lat, lng], 6);
            }
        }
    }

    function closeModal() {
        const modal = document.getElementById('routeModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.addEventListener('DOMContentLoaded', initFlagSelect);
</script>
</x-admin-layout>