<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
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
    <section class="pl-70">
        <!-- Topbar -->
        <header
            class="bg-white shadow-2xs w-full p-5 h-15 flex justify-between items-center"
        >
            @include ('layouts.header')
        </header>

        <main class="p-6 flex flex-col gap-3">
            @include ('course.course-list')
        </main>
    </section>
</body>
</html>
