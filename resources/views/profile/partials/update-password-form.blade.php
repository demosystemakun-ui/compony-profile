@php
    $focus      = 'focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#0A2540]';
    $input      = "mt-1 block w-full rounded-xl border border-slate-200 bg-[#f6f9fc] px-3.5 py-2.5 text-sm text-[#0A2540] placeholder-slate-400 transition focus:border-[#0A2540] focus:bg-white focus:outline-none";
    $btnPrimary = "inline-flex items-center justify-center rounded-full bg-[#0A2540] px-5 py-2 text-xs sm:text-sm font-bold text-white transition hover:bg-[#13385e] $focus";
@endphp

<section>
    <header>
        <h2 class="text-base font-bold text-[#0A2540] tracking-tight">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-xs text-slate-500">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-5 space-y-5">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password"
                           :value="__('Current Password')"
                           class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5" />
            <x-text-input id="update_password_current_password"
                          name="current_password"
                          type="password"
                          class="{{ $input }}"
                          autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1.5" />
        </div>

        <div>
            <x-input-label for="update_password_password"
                           :value="__('New Password')"
                           class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5" />
            <x-text-input id="update_password_password"
                          name="password"
                          type="password"
                          class="{{ $input }}"
                          autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1.5" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation"
                           :value="__('Confirm Password')"
                           class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5" />
            <x-text-input id="update_password_password_confirmation"
                          name="password_confirmation"
                          type="password"
                          class="{{ $input }}"
                          autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1.5" />
        </div>

        <div class="flex flex-wrap items-center justify-between gap-4 pt-4 border-t border-slate-100">
            <div class="flex items-center gap-3">
                <button type="submit" class="{{ $btnPrimary }}">
                    {{ __('Save') }}
                </button>

                @if (session('status') === 'password-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-xs font-semibold text-emerald-700"
                    >{{ __('Saved.') }}</p>
                @endif
            </div>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="text-xs font-semibold text-[#0A2540] hover:text-[#EC2029] underline underline-offset-2 {{ $focus }}">
                    {{ __('Lupa sandi saat ini?') }}
                </a>
            @endif
        </div>
    </form>
</section>