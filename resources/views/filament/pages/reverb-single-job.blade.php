<x-filament-panels::page>
    @push('styles')
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endpush

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @livewire('reverb-test01')
        </div>
    </div>
</x-filament-panels::page>
