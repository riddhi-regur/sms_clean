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
    <h1 class="text-2xl font-semibold mb-6">Add course</h1>
    <form
        action="{{ isset($course) ? route('course.update', $course->id) : route('course.store') }}"
        method="POST"
        class="bg-white p-6 rounded-lg shadow w-full max-w-md"
    >
        @csrf
        @if (isset($course))
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
            value="{{ old('name', $course->name ?? '') }}"
        />
        @error ('code')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        <input
            type="text"
            name="code"
            placeholder="Code"
            class="w-full mb-4 p-2 border rounded"
            value="{{ old('code', $course->code ?? '') }}"
        />
        @error ('duration')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
        <input
            type="text"
            name="duration"
            placeholder="Duration"
            class="w-full mb-4 p-2 border rounded"
            value="{{ old('duration', $course->duration ?? '') }}"
        />
        
        @error ('department_id')
            <div style="color: red">{{ $message }}</div>
        @enderror
        <select name="department_id" class="w-full mb-4 p-2 border rounded">
            <option value="">Select Department</option>
            @foreach ($departments as $department)
                <option
                    value="{{ $department->id }}"
                    {{ old('department_id', $course->department_id ?? '') == $department->id ? 'selected' : '' }}
                >
                    {{ $department->name }}
                </option>
            @endforeach
        </select>
        @error ('fees')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
        <input
            type="text"
            name="fees"
            placeholder="Fees"
            class="w-full mb-4 p-2 border rounded"
            value="{{ old('fees', $course->fees ?? '') }}"
        />
        @error ('description')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
        <input
            type="text"
            name="description"
            placeholder="Description"
            class="w-full mb-4 p-2 border rounded"
            value="{{ old('description', $course->description ?? '') }}"
        />

        <button
            type="submit"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
        >
            {{ isset($course) ? 'Update' : 'Create' }}
        </button>
    </form>

</main>
    </section>
</body>
</html>
