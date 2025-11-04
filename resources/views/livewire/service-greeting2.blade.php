<div class="border-blue-300 border-4 p-4 mt-4">
    <h2 class="text-xl font-bold mb-2">Details</h2>
    @foreach($users as $user)
        <div class="mb-4 p-4 border border-gray-300 rounded">
            <h3 class="text-lg font-semibold mb-2">User ID: {{ $user['id'] }}</h3>
            <p><strong>Name:</strong> {{ $user['name'] }}</p>
            <p><strong>Email:</strong> {{ $user['email'] }}</p>
        </div>
    @endforeach
</div>

