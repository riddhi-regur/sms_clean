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
        class="bg-gray-800 w-72 fixed left-0 top-0 flex h-full items-center p-5 flex-col"
    >
        @include ('layouts.sidebar')
    </aside>

    <!-- Main -->
    <section class="pl-72">
        <!-- Topbar -->
        <header
            class="bg-white shadow-2xs w-full p-1 flex items-center fixed"
        >
            @include ('layouts.header')
        </header>

        <main class="px-3 flex flex-col gap-3 py-20">
    <h1 class="text-2xl font-semibold mb-6">Add department</h1>
    <form
        action="{{ isset($department) ? route('department.update', $department->id) : route('department.store') }}"
        method="POST"
        class="bg-white p-6 rounded-lg shadow w-full max-w-md"
    >
        @csrf
        @if (isset($department))
            @method ('PUT')
        @endif
        @error ('name')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
        <input
            type="text"
            name="name"
            placeholder="Name"
            class="w-full mb-4 p-2 border rounded"
            value="{{ old('name', $department->name ?? '') }}"
        />
        @error ('code')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        <input
            type="text"
            name="code"
            placeholder="Code"
            class="w-full mb-4 p-2 border rounded"
            value="{{ old('code', $department->code ?? '') }}"
        />
        @error ('description')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
        <input
            type="text"
            name="description"
            placeholder="Description"
            class="w-full mb-4 p-2 border rounded"
            value="{{ old('description', $department->description ?? '') }}"
        />

        <button
            type="submit"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
        >
            {{ isset($department) ? 'Update' : 'Create' }}
        </button>
    </form>

 </main>
    </section>
</body>
</html>
