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
            @foreach($greetings as $service => $message)
                <tr class="hover:bg-red-700 text-3xl">
                    <td class="border border-red-600 text-cyan-400 px-32">{{ $service }}</td>
                    <td class="border border-red-600 text-cyan-400 px-32">{{ $message }}</td>
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

</div>




