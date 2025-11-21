<div class="relative">
    <div class="flex flex-col gap-8 rounded-[32px] border border-slate-200 bg-white px-8 py-10 text-slate-700 shadow-xl">
        <div class="flex flex-col items-center text-center">
            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-50 text-cyan-700 ring-1 ring-slate-200">
                {{ $logo }}
            </div>
            <div class="mt-4 space-y-2">
                <p class="text-[11px] uppercase tracking-[0.35em] text-slate-400">Account Access</p>
                <h2 class="text-2xl font-semibold text-slate-900">Sign in to continue</h2>
            </div>
        </div>

        <div class="w-full space-y-6">
            {{ $slot }}
        </div>
    </div>
</div>

