<form wire:submit.prevent="register">
    <h2 class="text-xl font-semibold mb-4">Register</h2>

    <div class="mb-4">
        <label for="firstname">First Name</label>
        <input wire:model="firstname" id="firstname" type="text" class="w-full border p-2 rounded mt-1">
        @error('firstname') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label for="lastname">Last Name</label>
        <input wire:model="lastname" id="lastname" type="text" class="w-full border p-2 rounded mt-1">
        @error('lastname') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label for="email">Email</label>
        <input wire:model="email" id="email" type="email" class="w-full border p-2 rounded mt-1">
        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label for="password">Password</label>
        <input wire:model="password" id="password" type="password" class="w-full border p-2 rounded mt-1">
    </div>

    <div class="mb-4">
        <label for="password_confirmation">Confirm Password</label>
        <input wire:model="password_confirmation" id="password_confirmation" type="password" class="w-full border p-2 rounded mt-1">
    </div>

    <button type="submit" class="w-full border border-gray-300 text-black p-2 rounded hover:bg-gray-100">
        Register
    </button>

    <p class="mt-4 text-sm text-center">
        Already have an account?
        <a href="{{ route('login') }}" class="text-blue-600 underline hover:text-blue-800">Login here</a>
    </p>

</form>
