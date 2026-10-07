<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-[#0A2540]">Manajemen User</h2>
                <p class="text-xs text-gray-500 mt-1">Kelola semua user yang memiliki akses ke admin panel</p>
            </div>
            <a href="{{ route('users.create') }}"
               class="inline-flex items-center gap-1.5 bg-[#0A2540] hover:bg-[#132f4c] text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition-all shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah User
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-800 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-800 rounded-lg text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-md rounded-2xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b-2 border-gray-100 text-gray-500 text-xs uppercase bg-gray-50/50">
                                <th class="py-3.5 px-4 font-bold">Nama</th>
                                <th class="py-3.5 px-4 font-bold">Email</th>
                                <th class="py-3.5 px-4 font-bold">Role</th>
                                <th class="py-3.5 px-4 font-bold">Dibuat</th>
                                <th class="py-3.5 px-4 text-center font-bold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-4 font-semibold text-[#0A2540]">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-red-500 to-red-700 flex items-center justify-center text-xs font-bold text-white">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            {{ $user->name }}
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-gray-600">{{ $user->email }}</td>
                                    <td class="py-4 px-4">
                                        <form action="{{ route('users.update-role', $user) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="role" onchange="this.form.submit()"
                                                    class="text-xs font-semibold rounded-md border-gray-200 py-1 pl-2 pr-6
                                                        {{ $user->role === 'super_admin' ? 'bg-red-50 text-red-700' : '' }}
                                                        {{ $user->role === 'admin' ? 'bg-blue-50 text-blue-700' : '' }}
                                                        {{ $user->role === 'editor' ? 'bg-gray-50 text-gray-700' : '' }}">
                                                <option value="super_admin" @selected($user->role==='super_admin')>Super Admin</option>
                                                <option value="admin" @selected($user->role==='admin')>Admin</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="py-4 px-4 text-gray-500 text-xs">{{ $user->created_at->format('d M Y') }}</td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('users.edit', $user) }}"
                                               class="inline-flex items-center gap-1 text-amber-700 font-semibold text-xs bg-amber-50 px-3 py-1.5 rounded-md border border-amber-200 hover:bg-amber-100">
                                                Edit
                                            </a>
                                            @if($user->id !== auth()->id())
                                                <form action="{{ route('users.destroy', $user) }}" method="POST"
                                                      onsubmit="return confirm('Hapus user ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center gap-1 text-red-700 font-semibold text-xs bg-red-50 px-3 py-1.5 rounded-md border border-red-200 hover:bg-red-100">
                                                        Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-gray-400">Belum ada user.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>   