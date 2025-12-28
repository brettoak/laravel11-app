<x-filament-panels::page>
    @push('scripts')
        @vite(['resources/js/app.js'])
    @endpush
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            @livewire('upload-spread-sheet')
        </div>
    </div>
</x-filament-panels::page>
