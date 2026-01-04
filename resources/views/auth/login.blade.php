<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo/>
        </x-slot>

            <x-validation-errors class="mb-4 text-red-600"/>

            @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
            @endsession

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div class="relative">
                    <x-input id="email" class="block w-full py-3 px-4 rounded-xl border-gray-200 bg-slate-50 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500"
                             type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                             placeholder="Email" />
                    <!-- At Icon -->
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Zm0 0c0 1.657 1.007 3 2.25 3S21 13.657 21 12a9 9 0 1 0-2.636 6.364M16.5 12V8.25" />
                        </svg>
                    </div>
                </div>

                <!-- Password -->
                <div class="relative">
                    <x-input id="password" class="block w-full py-3 px-4 rounded-xl border-gray-200 bg-slate-50 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500"
                             type="password" name="password" required autocomplete="current-password"
                             placeholder="Password" />
                    <!-- Lock Icon -->
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mt-4">
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember" class="text-blue-600 rounded border-gray-300 focus:ring-blue-500" />
                        <span class="ms-2 text-sm text-gray-400">{{ __('Remember Me') }}</span>
                    </label>


                </div>

                <!-- Buttons -->
                <div class="flex flex-col gap-4 mt-8">
                    <button class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 transition-colors cursor-pointer">
                        {{ __('Login') }}
                    </button>

                    <button type="button" onclick="
                        const webAuthn = new WebAuthn({
                            loginOptions: '{{ route('webauthn.login.options') }}',
                            login: '{{ route('webauthn.login') }}'
                        });

                        webAuthn.login({
                            email: document.getElementById('email').value
                        })
                        .then(response => {
                             window.location.reload();
                        })
                        .catch(error => {
                            console.error('WebAuthn Error:', error);
                            alert('WebAuthn Error: ' + error.message);
                        });
                     " class="w-full flex justify-center py-3 px-4 border border-gray-200 rounded-xl shadow-sm text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition-colors cursor-pointer">
                        {{ __('Sign in with Passkey') }}
                    </button>
                    
                    @once
                        <script src="{{ asset('js/vendor/webauthn/webauthn.js') }}"></script>
                    @endonce

                    <a href="{{ route('login.github') }}" class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-gray-200 rounded-xl shadow-sm text-sm font-semibold text-gray-600 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition-colors cursor-pointer">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ __('Sign in with Github') }}</span>
                    </a>

                    <a href="{{ route('login.google') }}" class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-gray-200 rounded-xl shadow-sm text-sm font-semibold text-gray-600 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition-colors cursor-pointer">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
                            <path d="M23.766 12.2764c0-.882-.0828-1.728-.2387-2.5388H12.2V14.524h6.5021c-.2878 1.5034-1.1448 2.778-2.4277 3.6302v3.0125h3.9168c2.296-2.1158 3.6198-5.2325 3.6198-8.7903Z" fill="#4285F4"/>
                            <path d="M12.2001 24.0008c3.2466 0 5.9763-1.0776 7.969-2.9152l-3.9168-3.0124c-1.084.7265-2.469 1.1578-4.0522 1.1578-3.132 0-5.7831-2.112-6.732-4.9602H1.4707v3.1256C3.4754 21.396 8.5284 24.0008 12.2001 24.0008Z" fill="#34A853"/>
                            <path d="M5.4678 14.2708c-.2393-.7254-.374-1.5035-.374-2.3106 0-.8072.1347-1.5853.374-2.3106V6.524H1.4707C.652 8.169.1996 10.027.1996 12.0002c0 1.9732.4523 3.8312 1.271 5.4762l3.9972-3.1656Z" fill="#FBBC05"/>
                            <path d="M12.2001 5.3788c1.7681 0 3.3514.6083 4.5986 1.8028l3.4373-3.4373C17.8488 1.488 15.263 .1996 12.2001.1996 8.5284.1996 3.4754 2.8044 1.4707 6.6438l3.9972 3.1656c.9489-2.8482 3.5999-4.9602 6.732-4.9602Z" fill="#EA4335"/>
                        </svg>
                        <span>{{ __('Sign in with Google') }}</span>
                    </a>    
                </div>
            </form>


    </x-authentication-card>
</x-guest-layout>
