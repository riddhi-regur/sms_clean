<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link
        rel="icon"
        type="image/png"
        href="{{ asset('images/favicon.png') }}"
    />
    @vite ('resources/css/app.css')
</head>
<body class="bg-gray-50 font-sans">
    <!-- Sidebar -->
    <aside
        class="bg-gray-800 w-2xs fixed left-0 top-0 flex h-full items-center p-5 flex-col"
    >
        @include ('layouts.sidebar')
    </aside>

    <!-- Main -->
    <section class="pl-72">
        <!-- Topbar -->
        <header
            class="bg-white shadow-2xs w-full p-5 h-15 flex items-center fixed"
        >
            @include ('layouts.header')
        </header>

        <main class="px-6 flex flex-col gap-3 py-20">
            @yield ('content')
        </main>
    </section>
</body>
</html>
