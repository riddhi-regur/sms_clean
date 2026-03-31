<div class="flex justify-center items-center min-h-screen bg-gray-900">
    <form
        method="POST"
        action="{{ route('password.email') }}"
        class="bg-gray-800 p-8 rounded-lg w-96 space-y-4"
    >
        @csrf

        <h2 class="text-white text-2xl font-bold">Forgot Password</h2>

        <input
            type="email"
            name="email"
            placeholder="Email"
            class="w-full p-2 rounded bg-gray-700 text-white"
        />

        <button class="w-full bg-blue-500 py-2 rounded text-white">
            Send Reset Link
        </button>

        <a href="/login" class="text-sm text-gray-400">Back to Login</a>
    </form>
</div>
