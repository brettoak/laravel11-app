<div>

    <h3 class="text-4xl font-black text-white bg-gradient-to-r from-purple-500 to-pink-500 p-6 rounded-xl shadow-lg transform rotate mt-1.5">{{ $message }}</h3>
    <p class="text-2xl text-indigo-800 font-bold mt-4">🔥 计数: <span class="font-extrabold text-orange-600 bg-yellow-200 px-3 py-1 rounded-full">{{ $count }}</span></p>

    <div class="space-x-4 mt-6">
        <button wire:click="increment" class="bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white px-6 py-3 rounded-lg font-bold shadow-lg transform hover:scale-105 transition-all duration-200">
            🚀 增加计数
        </button>
        <button wire:click="refresh" class="bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white px-6 py-3 rounded-lg font-bold shadow-lg transform hover:scale-105 transition-all duration-200">
            🔄 刷新消息
        </button>
    </div>

    <div wire:loading class="text-center mt-4">
        <div class="inline-flex items-center px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full font-semibold">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            ⚡ 正在处理中...
        </div>
    </div>
</div>
