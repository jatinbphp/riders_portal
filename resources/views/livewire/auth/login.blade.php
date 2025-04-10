<form wire:submit.prevent="login" class="space-y-5 max-w-md mx-auto p-6 rounded ">

    {{-- Email --}}
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
        <input
            wire:model="email"
            id="email"
            type="email"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:outline-none focus:ring focus:border-blue-400"
            placeholder="you@example.com"
        />
        @error('email') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
    </div>

    {{-- Password + Forgot Link --}}
    <div>
        <div class="flex items-center justify-between mt-1">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <a href="{{ route('password.request') }}" class="text-sm text-blue-500 hover:underline">
                Forgot password?
            </a>
        </div>
        <input
            wire:model="password"
            id="password"
            type="password"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:outline-none focus:ring focus:border-blue-400"
            placeholder="••••••••"
        />
        @error('password') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
    </div>

    {{-- Remember Me --}}
    <div class="flex items-center mt-1">
        <input type="checkbox" id="remember" wire:model="remember" class="mr-2 rounded border-gray-300 text-blue-600">
        <label for="remember" class="text-sm text-gray-700 ml-1"> Remember me</label>
    </div>

    {{-- Submit Button --}}
    <div>
        <button
            type="submit"
            class="w-full border border-gray-300 py-2 rounded text-black mt-1"
        >
            Login
        </button>
    </div>

    {{-- Register Link --}}
    <div class="text-center text-sm text-gray-600 mt-2">
        Don't have an account?
        <a href="{{ route('register') }}" class="text-blue-600 underline hover:text-blue-800">Register here</a>
    </div>

</form>
