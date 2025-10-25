<div class="mt-10 text-center">
    <div class="float-left">
        <table class="border-collapse border border-gray-600">
            <thead>
            <tr class="bg-gray-200 text-red-600">
                <th class="border border-red-900">Service Name</th>
                <th class="border border-red-900">Greeting Message</th>
            </tr>
            </thead>
            <tbody>
            @foreach($greetings as $service => $vv)
                <tr class="hover:bg-red-700 text-3xl">
                    <td class="border border-red-600 text-cyan-400 px-32">{{ $service }}</td>
                    <td class="border border-red-600 text-cyan-400 px-32">{{ $vv }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="float-left ml-4">
        <table class="border border-green-700">
            <thead>
            <tr>
                <th class="border border-blue-300">Service Name</th>
                <th class="border border-blue-300">Status</th>
            </tr>
            </thead>
            <tbody>
            @foreach($statuses as $service => $status)
                <tr class="text-3xl hover:bg-red-700 text-purple-600">
                    <td class="border border-red-600 px-32">{{ $status }}</td>
                    <td class="border border-red-600 px-32">{{ $service }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>


    <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded"
            onclick="document.getElementById('fileInput').click();">
        上传文件
        <input id="fileInput" type="file" class="hidden"/>
    </button>

    <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded" wire:click="refresh" >刷新</button>


    <div>{{$message}}</div>

    <div wire:loading wire:target="refresh" class="mt-2">
        <svg class="animate-spin h-6 w-6 text-blue-500 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
        </svg>
        正在刷新...
    </div>

    @if($show)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded shadow-lg w-1/4 h-1/5 text-center">
                <div class="mb-4">刷新完成！</div>
                <button wire:click="closeModal" class="bg-red-500 text-white px-4 py-2 rounded">关闭</button>
            </div>
        </div>
    @endif


    <div x-data="{ open: false }">
        <button @click="open = true">打开弹出层</button>

        <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded shadow-lg w-96">
                <h2 class="text-xl font-bold mb-4">弹出层标题</h2>
                <button @click="open = false" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    关闭
                </button>
            </div>
        </div>
    </div>

</div>




