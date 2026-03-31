<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Student Management System</title>
    @vite (['resources/css/app.css', 'resources/js/app.js'])
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap"
        rel="stylesheet"
    />
    <link
        rel="icon"
        type="image/png"
        href="{{ asset('images/favicon.png') }}"
    />
</head>
<body
    class="bg-slate-50 flex justify-center items-center flex-col h-screen gap-10"
>
    @auth
        @if (auth()->user()->role_id != 1)
            <div class="text-red-500 text-center mt-10">
                You are not authorized to access this page.
            </div>
        @else
            <h2 class="text-3xl font-bold leading-tight">
                Sign Up your account
            </h2>
            <div class="bg-white p-10 w-full max-w-md mx-auto">
                <form method="POST" action="/register" class="flex flex-col">
                    @csrf

                    @if (session('error'))
                        <p class="text-red-500">{{ session('error') }}</p>
                    @endif
                    <div class="flex flex-col gap-5">
                        <div class="flex flex-col gap-3">
                            <h5 class="text-base font-medium">Email Address</h5>
                            <input
                                name="email"
                                class="w-full p-1 border border-slate-300 rounded-sm hover:border-slate-500"
                            />
                        </div>
                        <div class="flex flex-col gap-3">
                            <h5 class="text-base font-medium">Name</h5>
                            <input
                                name="name"
                                class="w-full p-1 border border-slate-300 rounded-sm hover:border-slate-500"
                            />
                        </div>
                        <div class="flex flex-col gap-3">
                            <h5 class="text-base font-medium">Password</h5>
                            <input
                                type="password"
                                name="password"
                                class="w-full p-1 border border-slate-300 rounded-sm hover:border-slate-500"
                            />
                        </div>

                        <button
                            class="bg-blue-600 text-white p-1 rounded-sm text-base font-medium hover:bg-blue-800 hover:p-2 transition duration-300 ease-in-out cursor-pointer"
                            "
                        >
                            Sign Up
                        </button>
                        <div class="flex items-center justify-center gap-2.5">
                            <h5 class="text-base font-medium">
                                Already have account?
                            </h5>
                            <a href="/login">
                                <h5
                                    class="text-base font-medium text-blue-600 hover:underline hover:text-blue-800"
                                >
                                    Login
                                </h5>
                            </a>
                            </p>
                        </div>
                </form>
            </div>
        @endif
    @endauth
</body>
</html>
