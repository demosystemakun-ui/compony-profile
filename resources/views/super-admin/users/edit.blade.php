<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-[#0A2540]">Edit User</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-2xl border border-gray-100 p-6">
                <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    {{-- Nama --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                        <input type="text" name="name" 
                               value="{{ old('name', $user->name) }}" required
                               class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 text-sm">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" 
                               value="{{ old('email', $user->email) }}" required
                               class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 text-sm">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Password <span class="text-gray-400 font-normal">(Kosongkan jika tidak diubah)</span>
                        </label>
                        <input type="password" name="password"
                               placeholder="••••••••"
                               class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 text-sm">
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation"
                               placeholder="••••••••"
                               class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 text-sm">
                    </div>

                    {{-- Role --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <select name="role" required
                                class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 text-sm">
                            <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
                            <option value="super_admin" @selected(old('role', $user->role) === 'super_admin')>Super Admin</option>
                        </select>
                        @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end gap-2 pt-3">
                        <a href="{{ route('users.index') }}"
                           class="px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-lg transition">
                            Batal
                        </a>
                        <button type="submit"
                                class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg transition shadow-md">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>