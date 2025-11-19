<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>
<body class="antialiased font-sans bg-slate-50 text-slate-700">
<div class="min-h-screen">
    <div class="flex min-h-screen flex-col px-6 py-8 lg:px-14">
        <header class="flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Full-Stack Development</p>
                <h1 class="text-2xl font-semibold text-slate-900">{{ config('app.name', 'Laravel') }}</h1>
            </div>
        </header>

        <main class="mt-10 flex flex-1 flex-col items-center justify-center">
            <div class="grid w-full max-w-6xl place-items-center">
                <section class="w-full max-w-xl mx-auto">
                    <div
                        class="rounded-3xl border border-slate-200 bg-white p-8 shadow-lg">
                        {{ $slot }}
                    </div>
                </section>
            </div>
        </main>

        <footer class="mt-10 flex flex-col items-center justify-between gap-2 text-xs text-slate-400 sm:flex-row">
            <span>© {{ now()->year }} {{ config('app.name', 'Laravel') }} · Modular Tech Dashboard</span>
            <span>Laravel · Livewire · Vite</span>
        </footer>
    </div>
</div>

@livewireScripts
</body>
</html>
