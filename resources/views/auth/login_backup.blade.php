<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md bg-white shadow-md rounded-lg p-8">
        <h2 class="text-2xl font-semibold text-center mb-6">Login to Your Account</h2>

        <form wire:submit.prevent="login" class="space-y-5">
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

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
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
            <div class="flex items-center">
                <input type="checkbox" id="remember" wire:model="remember" class="mr-2 rounded border-gray-300 text-blue-600">
                <label for="remember" class="text-sm text-gray-700">Remember me</label>
            </div>

            {{-- Submit --}}
            <div>
                <button
                    type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition duration-200"
                >
                    Login
                </button>
            </div>

            {{-- Register link --}}
            <div class="text-center text-sm text-gray-600 mt-4">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Register here</a>
            </div>
        </form>
    </div>
</div>
