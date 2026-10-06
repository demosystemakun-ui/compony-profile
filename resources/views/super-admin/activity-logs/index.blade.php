<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-[#0A2540]">Log Aktivitas</h2>
                <p class="text-xs text-gray-500 mt-1">Pantau semua aktivitas user di admin panel</p>
            </div>
            <form action="{{ route('activity-logs.clear') }}" method="POST"
                  onsubmit="return confirm('Hapus semua log? Tindakan ini tidak bisa dibatalkan.');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center gap-1.5 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition-all shadow-md">
                    Bersihkan Log
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Filter --}}
            <div class="bg-white shadow-md rounded-2xl border border-gray-100 p-4 mb-6">
                <form method="GET" class="flex flex-wrap gap-3 items-end">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Action</label>
                        <select name="action" class="rounded-lg border-gray-300 text-sm">
                            <option value="">Semua</option>
                            @foreach(['created','updated','deleted','login','logout'] as $act)
                                <option value="{{ $act }}" @selected(request('action')===$act)>{{ ucfirst($act) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Tanggal</label>
                        <input type="date" name="date" value="{{ request('date') }}"
                               class="rounded-lg border-gray-300 text-sm">
                    </div>
                    <button type="submit"
                            class="px-4 py-2 bg-[#0A2540] text-white text-sm font-semibold rounded-lg hover:bg-[#132f4c] transition">
                        Filter
                    </button>
                    <a href="{{ route('activity-logs.index') }}"
                       class="px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-lg transition">
                        Reset
                    </a>
                </form>
            </div>

            {{-- Tabel Log --}}
            <div class="bg-white shadow-md rounded-2xl border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b-2 border-gray-100 text-gray-500 text-xs uppercase bg-gray-50/50">
                                <th class="py-3.5 px-4 font-bold">Waktu</th>
                                <th class="py-3.5 px-4 font-bold">User</th>
                                <th class="py-3.5 px-4 font-bold">Action</th>
                                <th class="py-3.5 px-4 font-bold">Deskripsi</th>
                                <th class="py-3.5 px-4 font-bold">IP</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($logs as $log)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-3 px-4 text-xs text-gray-500 whitespace-nowrap">
                                        {{ $log->created_at->format('d M Y, H:i:s') }}
                                    </td>
                                    <td class="py-3 px-4 font-semibold text-[#0A2540]">
                                        {{ $log->user->name ?? 'System' }}
                                    </td>
                                    <td class="py-3 px-4">
                                        @php
                                            $colors = [
                                                'created' => 'bg-green-50 text-green-700 border-green-200',
                                                'updated' => 'bg-blue-50 text-blue-700 border-blue-200',
                                                'deleted' => 'bg-red-50 text-red-700 border-red-200',
                                                'login'   => 'bg-purple-50 text-purple-700 border-purple-200',
                                                'logout'  => 'bg-gray-50 text-gray-700 border-gray-200',
                                            ];
                                            $color = $colors[$log->action] ?? 'bg-gray-50 text-gray-700';
                                        @endphp
                                        <span class="inline-block text-[10px] font-bold uppercase px-2 py-0.5 rounded border {{ $color }}">
                                            {{ $log->action }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-gray-700">{{ $log->description }}</td>
                                    <td class="py-3 px-4 text-xs text-gray-400 font-mono">{{ $log->ip_address }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-gray-400">Belum ada aktivitas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $logs->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>