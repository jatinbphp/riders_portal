<div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4">Welcome, {{ $user->name }}</h2>
    <p>Email: {{ $user->email }}</p>
 

    <button wire:click="logout" class="w-full bg-red-500 text-white p-2 mt-4 rounded">Logout</button>
</div>

