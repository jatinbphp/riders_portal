<div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4">Athlete Login</h2>
    
    @if (session()->has('error'))
        <div class="text-red-500 mb-3">{{ session('error') }}</div>
    @endif

    <form wire:submit.prevent="login">
        <div class="mb-3">
            <label class="block text-sm">Email</label>
            <input type="email" wire:model="email" class="w-full p-2 border rounded">
        </div>

        <div class="mb-3">
            <label class="block text-sm">Password</label>
            <input type="password" wire:model="password" class="w-full p-2 border rounded">
        </div>

        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Login</button>
    </form>
</div>
