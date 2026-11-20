@extends('layouts.admin')

@section('title', 'Contact Messages — Admin')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 py-4 sm:py-8 min-w-0">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4 mb-5 sm:mb-8">
        <div class="min-w-0">
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Contact Messages</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1 flex flex-wrap items-center gap-1.5">
                <span>Pesan masuk dari form kontak website.</span>
                @if($unreadCount > 0)
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-red-600 text-white text-[11px] font-bold shrink-0">
                        {{ $unreadCount }} unread
                    </span>
                @endif
            </p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 sm:mb-6 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 text-xs sm:text-sm">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" class="flex flex-col sm:flex-row gap-2.5 sm:gap-3 mb-5 sm:mb-6">
        <input type="text" name="q" value="{{ request('q') }}"
               placeholder="Cari nama, email, atau subject..."
               class="w-full sm:flex-1 px-3.5 sm:px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-sm focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/10">

        <select name="status"
                class="w-full sm:w-auto px-3.5 sm:px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-sm focus:outline-none focus:border-red-500">
            <option value="">Semua Status</option>
            <option value="unread" @selected(request('status') === 'unread')>Unread</option>
            <option value="read"   @selected(request('status') === 'read')>Read</option>
        </select>

        <div class="flex items-center gap-2">
            <button type="submit"
                    class="flex-1 sm:flex-initial px-5 py-2.5 rounded-xl bg-slate-900 text-white text-sm font-bold hover:bg-slate-800 transition cursor-pointer">
                Filter
            </button>
            @if(request()->hasAny(['q', 'status']))
                <a href="{{ route('admin.contact-messages.index') }}"
                   class="px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-slate-700 text-sm font-bold hover:bg-slate-50 transition text-center">
                    Reset
                </a>
            @endif
        </div>
    </form>

    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto w-full">
            <table class="w-full min-w-[640px] text-xs sm:text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-left text-[11px] sm:text-xs uppercase tracking-wider text-slate-500 font-bold">
                        <th class="px-3.5 sm:px-5 py-3">Status</th>
                        <th class="px-3.5 sm:px-5 py-3">Pengirim</th>
                        <th class="px-3.5 sm:px-5 py-3">Subject</th>
                        <th class="px-3.5 sm:px-5 py-3">Tanggal</th>
                        <th class="px-3.5 sm:px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($messages as $msg)
                        <tr class="hover:bg-slate-50/60 transition {{ $msg->is_read ? '' : 'bg-red-50/30' }}">
                            <td class="px-3.5 sm:px-5 py-3.5 sm:py-4 whitespace-nowrap">
                                @if($msg->is_read)
                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-400">
                                        <span class="h-2 w-2 rounded-full bg-slate-300"></span> Read
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-red-600">
                                        <span class="h-2 w-2 rounded-full bg-red-600 animate-pulse"></span> New
                                    </span>
                                @endif
                            </td>
                            <td class="px-3.5 sm:px-5 py-3.5 sm:py-4">
                                <div class="font-bold text-slate-900 break-words">{{ $msg->name }}</div>
                                <div class="text-xs text-slate-500 break-all">{{ $msg->email }}</div>
                                <div class="text-xs text-slate-400">{{ $msg->whatsapp }}</div>
                            </td>
                            <td class="px-3.5 sm:px-5 py-3.5 sm:py-4">
                                <div class="font-semibold text-slate-800">{{ $msg->subject }}</div>
                                <div class="text-xs text-slate-500 line-clamp-1 max-w-[200px] sm:max-w-xs">
                                    {{ \Illuminate\Support\Str::limit($msg->message, 80) }}
                                </div>
                            </td>
                            <td class="px-3.5 sm:px-5 py-3.5 sm:py-4 text-xs text-slate-500 whitespace-nowrap">
                                {{ $msg->created_at->format('d M Y') }}<br>
                                <span class="text-slate-400">{{ $msg->created_at->format('H:i') }}</span>
                            </td>
                            <td class="px-3.5 sm:px-5 py-3.5 sm:py-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('admin.contact-messages.show', $msg) }}"
                                       class="inline-flex items-center px-2.5 sm:px-3 py-1.5 rounded-lg bg-slate-900 text-white text-xs font-bold hover:bg-slate-800 transition">
                                        Lihat
                                    </a>
                                    <form action="{{ route('admin.contact-messages.destroy', $msg) }}" method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('Hapus pesan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center px-2.5 sm:px-3 py-1.5 rounded-lg bg-red-600 text-white text-xs font-bold hover:bg-red-700 transition cursor-pointer">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-slate-400 text-sm">
                                Belum ada pesan masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-5 sm:mt-6">
        {{ $messages->links() }}
    </div>
</div>
@endsection

<!-- admin -->