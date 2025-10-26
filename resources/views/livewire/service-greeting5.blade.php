<div class="p-6 bg-gray-100 rounded-lg shadow-md" >
    <h2 class="text-xl font-bold mb-4">Edit Profile</h2>

    <form wire:submit.prevent="save">
        <!-- wire:model.lazy: 失焦时才更新 -->
        <div class="mb-3">
            <label class="block text-sm font-medium">Name</label>
            <input type="text" wire:model.lazy="name" class="border rounded w-full p-2">
        </div>

        <!-- wire:model: 实时更新 -->
        <div class="mb-3">
            <label class="block text-sm font-medium">Email</label>
            <input type="email" wire:model="email" class="border rounded w-full p-2">
        </div>
        {{$email}}

        <!-- wire:model.defer: 延迟到提交时更新 -->
        <div class="mb-3">
            <label class="block text-sm font-medium">Bio</label>
            <textarea wire:model.defer="bio" class="border rounded w-full p-2"></textarea>
        </div>

        <button
            wire:click="save"
            wire:loading.attr="disabled"
            wire:loading.class="opacity-50"
            class="bg-blue-500 text-white px-4 py-2 rounded">
            Save
        </button>

        <!-- 加载提示 -->
        <span wire:loading wire:target="save" class="ml-2 text-gray-500">Saving...</span>
    </form>

    <!-- 数据更改提示 -->
    <div wire:dirty class="text-yellow-600 mt-2">
        You have unsaved changes!
    </div>

    <!-- 离线状态提示 -->
    <div wire:offline class="text-red-600 mt-2">
        You're currently offline!
    </div>
</div>
