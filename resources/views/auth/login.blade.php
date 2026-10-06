<x-guest-layout>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- Header --}}
    <div class="pa-head">
        <h2 class="pa-title">{{ __('Welcome Back') }}</h2>
        <p class="pa-sub">{{ __('Please sign in to your account to continue') }}</p>
    </div>

    {{-- Login Form --}}
    <form method="POST" action="{{ route('login') }}" class="pa-form"
          x-data="{ showPassword: false, loading: false }"
          @submit="loading = true">
        @csrf

        {{-- EMAIL --}}
        <div>
            <div class="pa-label-row">
                <label for="email" class="pa-label">{{ __('Email Address') }}</label>
            </div>

            <div class="pa-field">
                <svg class="pa-ico-l" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                </svg>

                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       placeholder="name@company.com"
                       required autofocus autocomplete="username"
                       class="pa-input @error('email') pa-invalid @enderror">
            </div>

            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        {{-- PASSWORD --}}
        <div>
            <div class="pa-label-row">
                <label for="password" class="pa-label">{{ __('Password') }}</label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="pa-link">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <div class="pa-field">
                <svg class="pa-ico-l" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                </svg>

                <input id="password" name="password" type="password"
                       x-bind:type="showPassword ? 'text' : 'password'"
                       placeholder="Enter your password"
                       required autocomplete="current-password"
                       class="pa-input @error('password') pa-invalid @enderror">

                <button type="button" class="pa-ico-r"
                        @click="showPassword = !showPassword"
                        x-bind:aria-label="showPassword ? 'Hide password' : 'Show password'"
                        x-bind:aria-pressed="showPassword">
                    {{-- Eye --}}
                    <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{-- Eye slash --}}
                    <svg x-show="showPassword" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        {{-- REMEMBER ME --}}
        <div>
            <label for="remember_me" class="pa-check">
                <input id="remember_me" type="checkbox" name="remember">
                <span>{{ __('Remember me on this device') }}</span>
            </label>
        </div>

        {{-- SIGN IN --}}
        <div>
            <button type="submit" class="pa-btn" x-bind:disabled="loading">
                <svg x-show="loading" x-cloak class="pa-spin" viewBox="0 0 24 24" fill="none">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" opacity=".25"/>
                    <path fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"/>
                </svg>
                <span x-text="loading ? 'Signing in...' : '{{ __('Sign In') }}'">{{ __('Sign In') }}</span>
            </button>
        </div>

        {{-- REGISTER LINK --}}
        @if (Route::has('register'))
            <hr class="pa-divider">
            <p class="pa-foot">
                {{ __("Don't have an account?") }}
                <a href="{{ route('register') }}" class="pa-link">{{ __('Create account') }}</a>
            </p>
        @endif
    </form>

</x-guest-layout>