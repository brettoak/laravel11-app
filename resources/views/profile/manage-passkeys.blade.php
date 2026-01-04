<x-action-section>
    <x-slot name="title">
        {{ __('Passkeys') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Manage your passkeys for passwordless authentication.') }}
    </x-slot>

    <x-slot name="content">
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Passkeys allow you to sign in safely and securely using your fingerprint, face recognition, or a hardware security key.') }}
                </div>
            </div>

            <!-- Passkey List -->
            @if (count($keys) > 0)
                <div class="space-y-4">
                    @foreach ($keys as $key)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-500 mr-2">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                                </svg>

                                <div>
                                    <div class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                                        {{ $key->alias ?? 'Passkey' }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $key->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <button wire:click="delete('{{ $key->id }}')" class="cursor-pointer ml-6 text-sm text-red-500 focus:outline-none">
                                    {{ __('Remove') }}
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-sm text-gray-500">
                    {{ __('You have not registered any passkeys.') }}
                </div>
            @endif

            <div class="flex items-center mt-5">
                <x-confirms-password wire:then="registerPasskey">
                     <x-button type="button" 
                        x-data=""
                        x-on:click.prevent="
                            new WebAuthn({
                                registerOptions: '{{ route('webauthn.register.options') }}',
                                register: '{{ route('webauthn.register') }}'
                            }).register()
                            .then(response => {
                                $wire.$refresh();
                            })
                            .catch(error => {
                                console.error('WebAuthn Error:', error);
                                alert('WebAuthn Error: ' + error.message);
                            });
                        "
                     >
                        {{ __('Register Passkey') }}
                    </x-button>
                </x-confirms-password>
            </div>
            
             <!-- WebAuthn Scripts -->
             {{-- Check if the script is already loaded to avoid duplication if multiple components use it --}}
             @once
                <script src="{{ asset('js/vendor/webauthn/webauthn.js') }}"></script>
             @endonce
        </div>
    </x-slot>
</x-action-section>
