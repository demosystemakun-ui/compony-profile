@extends('layouts.admin')

@section('title', 'Contact Messages — Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Contact Messages</h1>
            <p class="text-sm text-slate-500 mt-1">
                Pesan masuk dari form kontak website.
                @if($unreadCount > 0)
                    <span class="inline-flex items-center gap-1 ml-2 px-2 py-0.5 rounded-full bg-red-600 text-white text-[11px] font-bold">
                        {{ $unreadCount }} unread
                    </span>
                @endif
            </p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" class="flex flex-col sm:flex-row gap-3 mb-6">
        <input type="text" name="q" value="{{ request('q') }}"
               placeholder="Cari nama, email, atau subject..."
               class="flex-1 px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-sm focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/10">

        <select name="status"
                class="px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-sm focus:outline-none focus:border-red-500">
            <option value="">Semua Status</option>
            <option value="unread" @selected(request('status') === 'unread')>Unread</option>
            <option value="read"   @selected(request('status') === 'read')>Read</option>
        </select>

        <button type="submit"
                class="px-5 py-2.5 rounded-xl bg-slate-900 text-white text-sm font-bold hover:bg-slate-800 transition">
            Filter
        </button>
        @if(request()->hasAny(['q', 'status']))
            <a href="{{ route('admin.contact-messages.index') }}"
               class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 text-sm font-bold hover:bg-slate-50 transition text-center">
                Reset
            </a>
        @endif
    </form>

    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-left text-xs uppercase tracking-wider text-slate-500 font-bold">
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Pengirim</th>
                        <th class="px-5 py-3">Subject</th>
                        <th class="px-5 py-3">Tanggal</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($messages as $msg)
                        <tr class="hover:bg-slate-50/60 transition {{ $msg->is_read ? '' : 'bg-red-50/30' }}">
                            <td class="px-5 py-4">
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
                            <td class="px-5 py-4">
                                <div class="font-bold text-slate-900">{{ $msg->name }}</div>
                                <div class="text-xs text-slate-500">{{ $msg->email }}</div>
                                <div class="text-xs text-slate-400">{{ $msg->whatsapp }}</div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="font-semibold text-slate-800">{{ $msg->subject }}</div>
                                <div class="text-xs text-slate-500 line-clamp-1 max-w-xs">
                                    {{ \Illuminate\Support\Str::limit($msg->message, 80) }}
                                </div>
                            </td>
                            <td class="px-5 py-4 text-xs text-slate-500 whitespace-nowrap">
                                {{ $msg->created_at->format('d M Y') }}<br>
                                <span class="text-slate-400">{{ $msg->created_at->format('H:i') }}</span>
                            </td>
                            <td class="px-5 py-4 text-right whitespace-nowrap">
                                <a href="{{ route('admin.contact-messages.show', $msg) }}"
                                   class="inline-flex items-center px-3 py-1.5 rounded-lg bg-slate-900 text-white text-xs font-bold hover:bg-slate-800 transition">
                                    Lihat
                                </a>
                                <form action="{{ route('admin.contact-messages.destroy', $msg) }}" method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('Hapus pesan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-3 py-1.5 rounded-lg bg-red-600 text-white text-xs font-bold hover:bg-red-700 transition">
                                        Hapus
                                    </button>
                                </form>
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

    <div class="mt-6">
        {{ $messages->links() }}
    </div>
</div>
@endsections