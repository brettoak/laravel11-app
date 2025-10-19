<div>
    <h3>{{ $message }}</h3>
    <p>Count: {{ $count }}</p>
    
    <div class="space-x-2">
        <button wire:click="increment" class="bg-blue-500 text-white px-4 py-2 rounded">
            Increment Count
        </button>
        <button wire:click="refresh" class="bg-green-500 text-white px-4 py-2 rounded">
            Refresh Message
        </button>
    </div>
    
    <div wire:loading class="text-gray-500">
        Loading...
    </div>
</div>