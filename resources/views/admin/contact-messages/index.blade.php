@php
    $age = function ($date) {
        $d = $date ? (int) $date->diffInDays(now()) : 0;
        if ($d > 30) return ['dot' => 'bg-red-500',     'pill' => 'bg-red-50 text-red-700',         'label' => $d . ' days ago'];
        if ($d > 7)  return ['dot' => 'bg-amber-500',   'pill' => 'bg-amber-50 text-amber-800',     'label' => $d . ' days ago'];
        return              ['dot' => 'bg-emerald-500', 'pill' => 'bg-emerald-50 text-emerald-800', 'label' => optional($date)->diffForHumans() ?? '-'];
    };

    $focus      = 'focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#0A2540]';
    $btn        = "inline-flex items-center justify-center rounded-full bg-[#eef5fb] px-3.5 py-1.5 text-xs font-semibold text-[#0A2540] transition hover:bg-[#dce8f5] $focus";
    $btnPrimary = "inline-flex items-center justify-center gap-1.5 rounded-full bg-[#0A2540] px-4 py-1.5 text-xs font-bold text-white transition hover:bg-[#13385e] $focus";
    $btnDanger  = "inline-flex items-center justify-center rounded-full bg-red-50 px-3.5 py-1.5 text-xs font-semibold text-red-700 transition hover:bg-red-100 $focus";
    $card       = 'bg-white rounded-2xl shadow-sm border border-slate-100';
@endphp

<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center gap-2">
            <h2 class="text-base sm:text-lg font-bold text-[#0A2540] leading-tight tracking-tight">
                {{ __('Contact Messages') }}
            </h2>
            @if($unreadCount > 0)
                <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-semibold text-red-700">
                    {{ $unreadCount }} unread
                </span>
            @endif
        </div>
        <p class="text-xs text-slate-500">Incoming messages from the website contact form</p>
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

        <section class="{{ $card }} overflow-hidden">

            {{-- Top Bar: Title, Search, Status Filter --}}
            <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4 px-5 pt-5 pb-4">
                <div>
                    <h3 class="text-base font-bold text-[#0A2540]">Messages inbox</h3>
                    <p class="mt-0.5 text-xs text-slate-500">Inquiries submitted by visitors</p>
                </div>

                <form action="{{ route('admin.contact-messages.index') }}" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 w-full xl:w-auto m-0">
                    <div class="relative w-full sm:w-64">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text"
                               name="q"
                               value="{{ request('q') }}"
                               placeholder="Search name, email, subject..."
                               class="block w-full rounded-full border border-slate-200 bg-[#f6f9fc] py-1.5 pl-9 pr-3.5 text-xs font-medium text-[#0A2540] placeholder-slate-400 transition focus:border-[#0A2540] focus:bg-white focus:outline-none">
                    </div>

                    <select name="status"
                            onchange="this.form.submit()"
                            class="cursor-pointer rounded-full border border-slate-200 bg-[#f6f9fc] px-3.5 py-1.5 text-xs font-semibold text-[#0A2540] transition hover:bg-[#eef5fb] focus:border-[#0A2540] focus:outline-none">
                        <option value="">All statuses</option>
                        <option value="unread" @selected(request('status') === 'unread')>Unread</option>
                        <option value="read"   @selected(request('status') === 'read')>Read</option>
                    </select>

                    <button type="submit" class="{{ $btnPrimary }} shrink-0">
                        Filter
                    </button>

                    @if(request()->hasAny(['q', 'status']))
                        <a href="{{ route('admin.contact-messages.index') }}"
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
                            <th scope="col" class="rounded-l-xl px-4 py-2.5 font-semibold">Status</th>
                            <th scope="col" class="px-3 py-2.5 font-semibold">Sender</th>
                            <th scope="col" class="px-3 py-2.5 font-semibold">Subject</th>
                            <th scope="col" class="px-3 py-2.5 font-semibold">Received</th>
                            <th scope="col" class="rounded-r-xl px-4 py-2.5 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($messages as $msg)
                            @php $a = $age($msg->created_at); @endphp
                            <tr class="hover:bg-[#f6f9fc] transition-colors {{ $msg->is_read ? '' : 'bg-[#f6f9fc]/60' }}">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if($msg->is_read)
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">
                                            <span class="h-1.5 w-1.5 rounded-full bg-slate-400" aria-hidden="true"></span>
                                            Read
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-red-500" aria-hidden="true"></span>
                                            New
                                        </span>
                                    @endif
                                </td>

                                <td class="px-3 py-3">
                                    <div class="flex items-center gap-2.5">
                                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-[#0A2540] text-[10px] font-bold text-white" aria-hidden="true">
                                            {{ strtoupper(substr($msg->name, 0, 1)) }}
                                        </span>
                                        <div class="min-w-0">
                                            <p class="truncate font-semibold text-[#0A2540]">{{ $msg->name }}</p>
                                            <p class="truncate text-xs text-slate-500">{{ $msg->email }}</p>
                                            @if($msg->whatsapp)
                                                <p class="truncate text-xs text-slate-400">{{ $msg->whatsapp }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td class="max-w-xs px-3 py-3">
                                    <p class="truncate font-semibold text-[#0A2540]">{{ $msg->subject }}</p>
                                    <p class="mt-0.5 line-clamp-1 text-xs text-slate-500">
                                        {{ \Illuminate\Support\Str::limit($msg->message, 80) }}
                                    </p>
                                </td>

                                <td class="px-3 py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold {{ $a['pill'] }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $a['dot'] }}" aria-hidden="true"></span>
                                        {{ $a['label'] }}
                                    </span>
                                    <p class="mt-1 text-xs text-slate-400">
                                        {{ $msg->created_at->format('d M Y, H:i') }}
                                    </p>
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.contact-messages.show', $msg) }}" class="{{ $btn }}">
                                            View
                                        </a>
                                        <form action="{{ route('admin.contact-messages.destroy', $msg) }}"
                                              method="POST"
                                              onsubmit="return confirm('Hapus pesan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="{{ $btnDanger }}">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-12 text-center">
                                    <p class="text-sm font-semibold text-slate-700">No messages found</p>
                                    <p class="mt-1 text-xs text-slate-500">Incoming messages from the contact form will appear here.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- List (Mobile) --}}
            <ul class="md:hidden space-y-3 px-3 pb-3">
                @forelse($messages as $msg)
                    @php $a = $age($msg->created_at); @endphp
                    <li class="rounded-xl bg-[#f6f9fc] p-3.5">
                        <div class="flex items-start justify-between gap-2.5">
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-[#0A2540] truncate">{{ $msg->name }}</p>
                                <p class="text-xs text-slate-500 truncate">{{ $msg->email }}</p>
                                @if($msg->whatsapp)
                                    <p class="text-xs text-slate-400 truncate">{{ $msg->whatsapp }}</p>
                                @endif
                            </div>

                            @if($msg->is_read)
                                <span class="shrink-0 rounded-full bg-white px-2.5 py-0.5 text-xs font-semibold text-slate-500">Read</span>
                            @else
                                <span class="inline-flex shrink-0 items-center gap-1 rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-semibold text-red-700">
                                    <span class="h-1.5 w-1.5 rounded-full bg-red-500" aria-hidden="true"></span>New
                                </span>
                            @endif
                        </div>

                        <div class="mt-2">
                            <p class="text-xs font-semibold text-[#0A2540]">{{ $msg->subject }}</p>
                            <p class="mt-0.5 text-xs text-slate-500 line-clamp-2">{{ $msg->message }}</p>
                        </div>

                        <div class="mt-2.5 flex flex-wrap items-center gap-2 text-xs">
                            <span class="inline-flex items-center gap-1.5 rounded-full px-2 py-0.5 font-semibold {{ $a['pill'] }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ $a['dot'] }}" aria-hidden="true"></span>{{ $a['label'] }}
                            </span>
                            <span class="text-slate-400">{{ $msg->created_at->format('d M Y, H:i') }}</span>
                        </div>

                        <div class="mt-3 flex gap-2">
                            <a href="{{ route('admin.contact-messages.show', $msg) }}" class="{{ $btn }} !bg-white flex-1">
                                View
                            </a>
                            <form action="{{ route('admin.contact-messages.destroy', $msg) }}"
                                  method="POST"
                                  class="flex-1"
                                  onsubmit="return confirm('Hapus pesan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="{{ $btnDanger }} w-full">Delete</button>
                            </form>
                        </div>
                    </li>
                @empty
                    <li class="px-4 py-10 text-center text-sm text-slate-500">
                        No messages found.
                    </li>
                @endforelse
            </ul>

            {{-- Pagination Footer --}}
            @if($messages instanceof \Illuminate\Contracts\Pagination\Paginator && $messages->hasPages())
                <div class="border-t border-slate-100 px-5 py-3.5">
                    {{ $messages->withQueryString()->links() }}
                </div>
            @endif

        </section>

    </div>
</x-admin-layout>