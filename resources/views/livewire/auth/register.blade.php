<div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4">Athlete Registration</h2>
    
    <form wire:submit.prevent="register">
        <div class="mb-3">
            <label class="block text-sm">First Name</label>
            <input type="text" wire:model="firstname" class="w-full p-2 border rounded">
            @error('firstname') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="block text-sm">Last Name</label>
            <input type="text" wire:model="lastname" class="w-full p-2 border rounded">
            @error('lastname') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="block text-sm">Email</label>
            <input type="email" wire:model="email" class="w-full p-2 border rounded">
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- <div class="mb-3">
            <label class="block text-sm">Sport</label>
            <input type="text" wire:model="sport" class="w-full p-2 border rounded">
        </div>

        <div class="mb-3">
            <label class="block text-sm">Profile Photo</label>
            <input type="file" wire:model="profile_photo" class="w-full p-2 border rounded">
        </div> --}}

        <div class="mb-3">
            <label class="block text-sm">Password</label>
            <input type="password" wire:model="password" class="w-full p-2 border rounded">
            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="block text-sm">Confirm Password</label>
            <input type="password" wire:model="password_confirmation" class="w-full p-2 border rounded">
        </div>

        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Register</button>
    </form>
</div>
