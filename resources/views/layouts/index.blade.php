<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link
        rel="icon"
        type="image/png"
        href="{{ asset('images/favicon.png') }}"
    />
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.tailwindcss.com"></script>
@vite (['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans">
    <!-- Sidebar -->
    <aside
        class="bg-gray-800 w-72 fixed left-0 top-0 flex h-full items-center p-5 flex-col"
    >
        @include ('layouts.sidebar')
    </aside>

    <!-- Main -->
    <section class="pl-72">
        <!-- Topbar -->
        <header
            class="bg-white shadow-2xs w-full p-1 flex items-center fixed z-[1000]"
        >
            @include ('layouts.header')
        </header>

        <main class="px-3 flex flex-col gap-3 py-20">
            @yield('content') 
        </main>
    </section>
</body>
</html>
