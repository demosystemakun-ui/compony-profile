@extends('layouts.admin')

@section('title', 'Detail Pesan — Admin')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.contact-messages.index') }}"
           class="inline-flex items-center gap-2 text-sm font-bold text-slate-600 hover:text-red-600 transition">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke daftar pesan
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">

        <div class="border-b border-slate-200 px-6 py-5 bg-slate-50">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">
                        {{ $contactMessage->subject ?: 'Inquiry from Website' }}
                    </h1>
                    <p class="text-xs text-slate-500 mt-1">
                        Dikirim {{ $contactMessage->created_at->format('d M Y, H:i') }}
                    </p>
                </div>
                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500">
                    <span class="h-2 w-2 rounded-full {{ $contactMessage->is_read ? 'bg-slate-300' : 'bg-red-600' }}"></span>
                    {{ $contactMessage->is_read ? 'Read' : 'Unread' }}
                </span>
            </div>
        </div>

        <div class="px-6 py-5 grid sm:grid-cols-3 gap-4 border-b border-slate-200">
            <div>
                <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Nama</div>
                <div class="font-bold text-slate-900">{{ $contactMessage->name }}</div>
            </div>
            <div>
                <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Email</div>
                <a href="mailto:{{ $contactMessage->email }}"
                   class="font-semibold text-red-600 hover:underline break-all">
                    {{ $contactMessage->email }}
                </a>
            </div>
            <div>
                <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">WhatsApp / Phone</div>
                <div class="font-semibold text-slate-800">{{ $contactMessage->whatsapp }}</div>
            </div>
        </div>

        <div class="px-6 py-6">
            <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-3">Pesan</div>
            <div class="text-sm text-slate-700 leading-relaxed whitespace-pre-line">
                {{ $contactMessage->message }}
            </div>
        </div>

        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 text-xs text-slate-400 flex flex-wrap gap-x-6 gap-y-1">
            <span>IP: {{ $contactMessage->ip_address ?: '-' }}</span>
            <span>ID: #{{ $contactMessage->id }}</span>
        </div>

        <div class="px-6 py-4 border-t border-slate-200 flex flex-wrap items-center gap-3">
            @if(! $contactMessage->is_read)
                <form action="{{ route('admin.contact-messages.read', $contactMessage) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-slate-800 transition">
                        Tandai Sudah Dibaca
                    </button>
                </form>
            @endif

            <a href="mailto:{{ $contactMessage->email }}?subject={{ urlencode('Re: ' . ($contactMessage->subject ?: 'Your Inquiry')) }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-red-600 text-white text-xs font-bold hover:bg-red-700 transition">
                Balas via Email
            </a>

            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contactMessage->whatsapp) }}"
               target="_blank" rel="noopener"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-600 text-white text-xs font-bold hover:bg-emerald-700 transition">
                Chat WhatsApp
            </a>

            <form action="{{ route('admin.contact-messages.destroy', $contactMessage) }}" method="POST"
                  class="ml-auto"
                  onsubmit="return confirm('Hapus pesan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-red-200 text-red-600 text-xs font-bold hover:bg-red-50 transition">
                    Hapus Pesan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection