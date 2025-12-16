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
<div class="min-h-screen flex bg-white">
    <!-- Left Side (Blue Background with Content) -->
    <!-- Left Side (Blue Background with Content) -->
    <div class="hidden lg:flex w-1/2 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 flex-col justify-center items-center relative overflow-hidden">
        
        <!-- Animated / Decorative Background Shapes -->
        <div class="absolute inset-0 w-full h-full pointer-events-none overflow-hidden">
             <!-- Top Left Blob -->
            <div class="absolute -top-20 -left-20 w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
            <!-- Top Right Blob -->
            <div class="absolute top-0 -right-20 w-96 h-96 bg-cyan-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
            <!-- Bottom Left Blob -->
            <div class="absolute -bottom-32 -left-20 w-96 h-96 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
             <!-- Bottom Right Blob -->
            <div class="absolute -bottom-32 -right-20 w-80 h-80 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>
            
            <!-- Glassy Overlay Elements -->
             <div class="absolute top-1/4 left-10 w-24 h-24 bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 transform rotate-12"></div>
             <div class="absolute bottom-1/3 right-10 w-16 h-16 bg-white/10 backdrop-blur-md rounded-xl border border-white/20 transform -rotate-12"></div>
        </div>

        <!-- content -->
        <div class="relative z-10 text-center text-white p-10">
           <div class="mb-8 relative">
                <div class="relative z-10">
                     <h2 class="text-4xl font-bold mb-6 tracking-tight">Streamlined Project<br>Admin Dashboard</h2>
                     <p class="text-blue-100 max-w-sm mx-auto text-lg">Manage your content, real-time updates and analytics in one place.</p>
                     
                     <!-- Pagination dots -->
                     <div class="flex justify-center gap-2 mt-8">
                         <div class="w-2.5 h-2.5 rounded-full bg-white/30 hover:bg-white cursor-pointer transition"></div>
                         <div class="w-8 h-2.5 rounded-full bg-white cursor-pointer"></div>
                         <div class="w-2.5 h-2.5 rounded-full bg-white/30 hover:bg-white cursor-pointer transition"></div>
                     </div>
                </div>
           </div>
        </div>
    </div>

    <!-- Right Side (Form) -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 bg-white">
        <div class="w-full max-w-md">
            {{ $slot }}
        </div>
    </div>
</div>

@livewireScripts
</body>
</html>
