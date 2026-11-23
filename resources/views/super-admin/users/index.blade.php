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
        <div>
            <h2 class="text-base sm:text-lg font-bold text-[#0A2540] leading-tight tracking-tight">
                {{ __('User Management') }}
            </h2>
            <p class="text-xs text-slate-500">Manage users with access to the PICT admin panel</p>
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

        @if(session('error'))
            <div role="alert" class="rounded-xl bg-red-50 px-4 py-3 text-sm text-red-800 ring-1 ring-red-200">
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <section class="{{ $card }} overflow-hidden">

            {{-- Top Bar --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-5 pt-5 pb-4">
                <div>
                    <h3 class="text-base font-bold text-[#0A2540]">Admin &amp; super admin users</h3>
                    <p class="mt-0.5 text-xs text-slate-500">Accounts and role permissions for the portal</p>
                </div>

                <a href="{{ route('users.create') }}" class="{{ $btnPrimary }} shrink-0">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 5v14M5 12h14"/>
                    </svg>
                    Add user
                </a>
            </div>

            {{-- Tabel (Desktop) --}}
            <div class="hidden md:block overflow-x-auto px-3 pb-3">
                <table class="w-full text-left text-sm">
                    <thead class="text-xs text-slate-500">
                        <tr class="bg-[#f6f9fc]">
                            <th scope="col" class="rounded-l-xl px-4 py-2.5 font-semibold">Name</th>
                            <th scope="col" class="px-3 py-2.5 font-semibold">Email</th>
                            <th scope="col" class="px-3 py-2.5 font-semibold">Role</th>
                            <th scope="col" class="px-3 py-2.5 font-semibold">Created</th>
                            <th scope="col" class="rounded-r-xl px-4 py-2.5 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($users as $user)
                            @php $a = $age($user->created_at); @endphp
                            <tr class="hover:bg-[#f6f9fc] transition-colors">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center gap-2.5">
                                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#0A2540] text-xs font-bold text-white" aria-hidden="true">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </span>
                                        <span class="font-semibold text-[#0A2540]">{{ $user->name }}</span>
                                    </div>
                                </td>

                                <td class="px-3 py-3 text-slate-600">
                                    {{ $user->email }}
                                </td>

                                <td class="px-3 py-3 whitespace-nowrap">
                                    <form action="{{ route('users.update-role', $user) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role"
                                                aria-label="Role for {{ $user->name }}"
                                                onchange="this.form.submit()"
                                                class="cursor-pointer rounded-full border-0 px-3 py-1 text-xs font-semibold transition focus:ring-2 focus:ring-[#0A2540]
                                                    {{ $user->role === 'super_admin' ? 'bg-red-50 text-red-700 hover:bg-red-100' : 'bg-[#eef5fb] text-[#0A2540] hover:bg-[#dce8f5]' }}">
                                            <option value="super_admin" @selected($user->role === 'super_admin')>Super Admin</option>
                                            <option value="admin" @selected($user->role === 'admin')>Admin</option>
                                        </select>
                                    </form>
                                </td>

                                <td class="px-3 py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold {{ $a['pill'] }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $a['dot'] }}" aria-hidden="true"></span>
                                        {{ $a['label'] }}
                                    </span>
                                    <p class="mt-1 text-xs text-slate-400">
                                        {{ $user->created_at->format('d M Y') }}
                                    </p>
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('users.edit', $user) }}" class="{{ $btn }}">
                                            Edit
                                        </a>
                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('users.destroy', $user) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Hapus user ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="{{ $btnDanger }}">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-12 text-center">
                                    <p class="text-sm font-semibold text-slate-700">No users found</p>
                                    <p class="mt-1 text-xs text-slate-500">Click &ldquo;Add user&rdquo; above to create an account.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- List (Mobile) --}}
            <ul class="md:hidden space-y-3 px-3 pb-3">
                @forelse($users as $user)
                    @php $a = $age($user->created_at); @endphp
                    <li class="rounded-xl bg-[#f6f9fc] p-3.5">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#0A2540] text-xs font-bold text-white" aria-hidden="true">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-[#0A2540]">{{ $user->name }}</p>
                                    <p class="truncate text-xs text-slate-500">{{ $user->email }}</p>
                                </div>
                            </div>

                            <form action="{{ route('users.update-role', $user) }}" method="POST" class="shrink-0">
                                @csrf
                                @method('PATCH')
                                <select name="role"
                                        aria-label="Role for {{ $user->name }}"
                                        onchange="this.form.submit()"
                                        class="cursor-pointer rounded-full border-0 px-2.5 py-1 text-xs font-semibold
                                            {{ $user->role === 'super_admin' ? 'bg-red-50 text-red-700' : 'bg-white text-[#0A2540] ring-1 ring-slate-200/70' }}">
                                    <option value="super_admin" @selected($user->role === 'super_admin')>Super Admin</option>
                                    <option value="admin" @selected($user->role === 'admin')>Admin</option>
                                </select>
                            </form>
                        </div>

                        <div class="mt-2.5 flex flex-wrap items-center gap-2 text-xs">
                            <span class="inline-flex items-center gap-1.5 rounded-full px-2 py-0.5 font-semibold {{ $a['pill'] }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ $a['dot'] }}" aria-hidden="true"></span>{{ $a['label'] }}
                            </span>
                            <span class="text-slate-400">{{ $user->created_at->format('d M Y') }}</span>
                        </div>

                        <div class="mt-3 flex gap-2">
                            <a href="{{ route('users.edit', $user) }}" class="{{ $btn }} !bg-white flex-1">
                                Edit
                            </a>
                            @if($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user) }}"
                                      method="POST"
                                      class="flex-1"
                                      onsubmit="return confirm('Hapus user ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="{{ $btnDanger }} w-full">
                                        Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    </li>
                @empty
                    <li class="px-4 py-10 text-center text-sm text-slate-500">
                        No users found.
                    </li>
                @endforelse
            </ul>

            {{-- Pagination Footer --}}
            @if($users->hasPages())
                <div class="border-t border-slate-100 px-5 py-3.5">
                    {{ $users->links() }}
                </div>
            @endif

        </section>

    </div>
</x-admin-layout>