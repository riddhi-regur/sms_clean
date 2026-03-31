<div class="flex justify-center items-center min-h-screen bg-gray-900">
    <form
        method="POST"
        action="{{ route('password.update') }}"
        class="bg-gray-800 p-8 rounded-lg w-96 space-y-4"
    >
        @csrf

        <input type="hidden" name="token" value="{{ $token }}" />

        <h2 class="text-white text-2xl font-bold">Reset Password</h2>

        <input
            type="email"
            name="email"
            placeholder="Email"
            class="w-full p-2 rounded bg-gray-700 text-white"
        />

        <input
            type="password"
            name="password"
            placeholder="New Password"
            class="w-full p-2 rounded bg-gray-700 text-white"
        />

        <input
            type="password"
            name="password_confirmation"
            placeholder="Confirm Password"
            class="w-full p-2 rounded bg-gray-700 text-white"
        />

        <button class="w-full bg-green-500 py-2 rounded text-white">
            Reset Password
        </button>
    </form>
</div>
