<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo/>
        </x-slot>

        <div class="space-y-6">


            <x-validation-errors class="rounded-2xl border border-rose-100 bg-rose-50/80 p-4 text-sm text-rose-700"/>

            @session('status')
            <div
                class="rounded-2xl border border-emerald-100 bg-emerald-50/80 p-4 text-sm font-medium text-emerald-700">
                {{ $value }}
            </div>
            @endsession

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div class="space-y-2">
                    <x-label for="email" value="{{ __('Email') }}"
                             class="text-sm font-semibold tracking-wide text-slate-600"/>
                    <x-input id="email"
                             class="block w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 text-slate-900 placeholder:text-slate-400 focus:border-cyan-400 focus:ring-cyan-400/40"
                             type="email" name="email" :value="old('email')" required autofocus
                             autocomplete="username"/>
                </div>

                <div class="space-y-2">
                    <x-label for="password" value="{{ __('Password') }}"
                             class="text-sm font-semibold tracking-wide text-slate-600"/>
                    <x-input id="password"
                             class="block w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 text-slate-900 placeholder:text-slate-400 focus:border-indigo-400 focus:ring-indigo-400/40"
                             type="password" name="password" required autocomplete="current-password"/>
                </div>

                <div
                    class="flex flex-col gap-3 rounded-2xl border border-slate-200 bg-white/80 p-4 sm:flex-row sm:items-center sm:justify-between">
                    <label for="remember_me" class="flex items-center gap-2 text-sm font-medium text-slate-600">
                        <x-checkbox id="remember_me" name="remember"/>
                        <span>{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <x-button
                        class="ms-0 inline-flex items-center justify-center rounded-2xl border-0 bg-slate-900 px-6 py-3 text-base font-semibold text-white transition hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900/20">
                        {{ __('Log in') }}
                    </x-button>
                </div>
            </form>
        </div>
    </x-authentication-card>
</x-guest-layout>
