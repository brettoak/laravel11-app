<div class="border-blue-300 border-4 p-4 mt-4">
    <h2 class="text-xl font-bold mb-2">详细信息</h2>
    @foreach($users as $user)
        <div class="mb-4 p-4 border border-gray-300 rounded">
            <h3 class="text-lg font-semibold mb-2">用户 ID: {{ $user['id'] }}</h3>
            <p><strong>姓名:</strong> {{ $user['name'] }}</p>
            <p><strong>电子邮件:</strong> {{ $user['email'] }}</p>
        </div>
    @endforeach
</div>

