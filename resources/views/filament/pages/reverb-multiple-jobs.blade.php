<x-filament-panels::page>
    @push('scripts')
        @vite(['resources/js/app.js'])
    @endpush
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            @livewire('reverb-multiple-jobs')
        </div>
    </div>
</x-filament-panels::page>
