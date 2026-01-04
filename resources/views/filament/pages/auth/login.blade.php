<x-filament-panels::page.simple>
    @if (filament()->hasRegistration())
        <x-slot name="subheading">
            {{ __('filament-panels::pages/auth/login.actions.register.before') }}

            {{ $this->registerAction }}
        </x-slot>
    @endif

    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE, scopes: $this->getRenderHookScopes()) }}

    <x-filament-panels::form id="form" wire:submit="authenticate">
        {{ $this->form }}

        <x-filament::button type="submit" form="form" class="w-full">
            {{ __('filament-panels::pages/auth/login.form.actions.authenticate.label') }}
        </x-filament::button>
        
        <x-filament::button 
            type="button" 
            color="gray"
            class="w-full"
            onclick="
                const webAuthn = new WebAuthn({
                    loginOptions: '{{ route('webauthn.login.options') }}',
                    login: '{{ route('webauthn.login') }}'
                });

                webAuthn.login({
                    email: document.getElementById('data.email').value 
                })
                .then(response => {
                    window.location.reload();
                })
                .catch(error => {
                    console.error('WebAuthn Error:', error);
                    alert('WebAuthn Error: ' + error.message);
                });
            "
        >
            {{ __('Sign in with Passkey') }}
        </x-filament::button>
        
        @once
            <script src="{{ asset('js/vendor/webauthn/webauthn.js') }}"></script>
        @endonce
    </x-filament-panels::form>

    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}
</x-filament-panels::page.simple>
