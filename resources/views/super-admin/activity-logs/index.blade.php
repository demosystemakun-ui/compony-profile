@php
    $age = function ($date) {
        $d = $date ? (int) $date->diffInDays(now()) : 0;
        if ($d > 30) return ['dot' => 'bg-red-500',     'pill' => 'bg-red-50 text-red-700',         'label' => $d . ' days ago'];
        if ($d > 7)  return ['dot' => 'bg-amber-500',   'pill' => 'bg-amber-50 text-amber-800',     'label' => $d . ' days ago'];
        return              ['dot' => 'bg-emerald-500', 'pill' => 'bg-emerald-50 text-emerald-800', 'label' => optional($date)->diffForHumans() ?? '-'];
    };

    $actionBadge = function ($action) {
        return match ($action) {
            'created' => 'bg-emerald-50 text-emerald-800',
            'updated' => 'bg-[#eef5fb] text-[#0A2540]',
            'deleted' => 'bg-red-50 text-red-700',
            'login'   => 'bg-amber-50 text-amber-800',
            default   => 'bg-slate-100 text-slate-700',
        };
    };

    $focus      = 'focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#0A2540]';
    $btnPrimary = "inline-flex items-center justify-center gap-1.5 rounded-full bg-[#0A2540] px-4 py-1.5 text-xs font-bold text-white transition hover:bg-[#13385e] $focus";
    $card       = 'bg-white rounded-2xl shadow-sm border border-slate-100';
@endphp

<x-admin-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-base sm:text-lg font-bold text-[#0A2540] leading-tight tracking-tight">
                {{ __('Activity Logs') }}
            </h2>
            <p class="text-xs text-slate-500">Monitor user activity recorded in the admin panel</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">

        <section class="{{ $card }} overflow-hidden">

            {{-- Top Bar: Title & Filter --}}
            <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4 px-5 pt-5 pb-4">
                <div>
                    <h3 class="text-base font-bold text-[#0A2540]">Audit trail</h3>
                    <p class="mt-0.5 text-xs text-slate-500">Recorded events across admin and super admin accounts</p>
                </div>

                <form method="GET" action="{{ route('activity-logs.index') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 w-full xl:w-auto m-0">
                    <select name="action"
                            aria-label="Filter by action"
                            onchange="this.form.submit()"
                            class="cursor-pointer rounded-full border border-slate-200 bg-[#f6f9fc] px-3.5 py-1.5 text-xs font-semibold text-[#0A2540] transition hover:bg-[#eef5fb] focus:border-[#0A2540] focus:outline-none">
                        <option value="">All actions</option>
                        @foreach(['created','updated','deleted','login','logout'] as $act)
                            <option value="{{ $act }}" @selected(request('action') === $act)>{{ ucfirst($act) }}</option>
                        @endforeach
                    </select>

                    <input type="date"
                           name="date"
                           aria-label="Filter by date"
                           value="{{ request('date') }}"
                           class="rounded-full border border-slate-200 bg-[#f6f9fc] px-3.5 py-1.5 text-xs font-semibold text-[#0A2540] transition focus:border-[#0A2540] focus:bg-white focus:outline-none">

                    <button type="submit" class="{{ $btnPrimary }} shrink-0">
                        Filter
                    </button>

                    @if(request()->anyFilled(['action', 'date']))
                        <a href="{{ route('activity-logs.index') }}"
                           class="inline-flex items-center justify-center rounded-full px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-50 transition {{ $focus }}">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- Tabel (Desktop) --}}
            <div class="hidden md:block overflow-x-auto px-3 pb-3">
                <table class="w-full text-left text-sm">
                    <thead class="text-xs text-slate-500">
                        <tr class="bg-[#f6f9fc]">
                            <th scope="col" class="rounded-l-xl px-4 py-2.5 font-semibold">Time</th>
                            <th scope="col" class="px-3 py-2.5 font-semibold">User</th>
                            <th scope="col" class="px-3 py-2.5 font-semibold">Action</th>
                            <th scope="col" class="px-3 py-2.5 font-semibold">Description</th>
                            <th scope="col" class="rounded-r-xl px-4 py-2.5 text-right font-semibold">IP</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($logs as $log)
                            @php
                                $a = $age($log->created_at);
                                $userName = $log->user->name ?? 'System';
                            @endphp
                            <tr class="hover:bg-[#f6f9fc] transition-colors">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold {{ $a['pill'] }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $a['dot'] }}" aria-hidden="true"></span>
                                        {{ $a['label'] }}
                                    </span>
                                    <p class="mt-1 text-xs text-slate-500">
                                        {{ $log->created_at?->timezone(config('app.timezone'))->format('d M Y, H:i:s') }}
                                    </p>
                                </td>

                                <td class="px-3 py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-2 font-semibold text-[#0A2540]">
                                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-[#0A2540] text-[10px] font-bold text-white" aria-hidden="true">
                                            {{ strtoupper(substr($userName, 0, 1)) }}
                                        </span>
                                        {{ $userName }}
                                    </span>
                                </td>

                                <td class="px-3 py-3 whitespace-nowrap">
                                    <span class="inline-block rounded-full px-2.5 py-0.5 text-xs font-semibold uppercase {{ $actionBadge($log->action) }}">
                                        {{ $log->action }}
                                    </span>
                                </td>

                                <td class="px-3 py-3 text-slate-700">
                                    {{ $log->description }}
                                </td>

                                <td class="px-4 py-3 text-right whitespace-nowrap font-mono text-xs text-slate-500">
                                    {{ $log->ip_address }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-12 text-center">
                                    <p class="text-sm font-semibold text-slate-700">No activities available</p>
                                    <p class="mt-1 text-xs text-slate-500">Logged actions will appear here once recorded.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- List (Mobile) --}}
            <ul class="md:hidden space-y-3 px-3 pb-3">
                @forelse($logs as $log)
                    @php
                        $a = $age($log->created_at);
                        $userName = $log->user->name ?? 'System';
                    @endphp
                    <li class="rounded-xl bg-[#f6f9fc] p-3.5">
                        <div class="flex items-start justify-between gap-2.5">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-[#0A2540] text-[10px] font-bold text-white" aria-hidden="true">
                                    {{ strtoupper(substr($userName, 0, 1)) }}
                                </span>
                                <p class="truncate text-sm font-semibold text-[#0A2540]">{{ $userName }}</p>
                            </div>

                            <span class="shrink-0 rounded-full px-2.5 py-0.5 text-xs font-semibold uppercase {{ $actionBadge($log->action) }}">
                                {{ $log->action }}
                            </span>
                        </div>

                        <p class="mt-2 text-xs text-slate-700">{{ $log->description }}</p>

                        <div class="mt-2.5 flex flex-wrap items-center gap-2 text-xs">
                            <span class="inline-flex items-center gap-1.5 rounded-full px-2 py-0.5 font-semibold {{ $a['pill'] }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ $a['dot'] }}" aria-hidden="true"></span>{{ $a['label'] }}
                            </span>
                            <span class="text-slate-400">
                                {{ $log->created_at?->timezone(config('app.timezone'))->format('d M Y, H:i:s') }}
                            </span>
                            @if($log->ip_address)
                                <span class="font-mono text-slate-400">{{ $log->ip_address }}</span>
                            @endif
                        </div>
                    </li>
                @empty
                    <li class="px-4 py-10 text-center text-sm text-slate-500">
                        No activities available.
                    </li>
                @endforelse
            </ul>

            {{-- Pagination Footer --}}
            @if($logs->hasPages())
                <div class="border-t border-slate-100 px-5 py-3.5">
                    {{ $logs->withQueryString()->links() }}
                </div>
            @endif

        </section>

    </div>
</x-admin-layout> 