<div>
    <div class="flex flex-col gap-6 text-center">
        <div class="flex justify-center mb-4">
             <!-- Logo or Icon -->
             <div class="h-12 w-12 text-blue-600">
                 {{ $logo }}
             </div>
        </div>
        
        <div class="space-y-2 mb-6">
            <h2 class="text-3xl font-bold text-slate-800">Hello Again!</h2>
            <p class="text-slate-500 text-sm">Welcome back to your dashboard. Please sign in to continue managing your projects.</p>
        </div>

        <div class="text-left">
            {{ $slot }}
        </div>
    </div>
</div>

