<div class="flex justify-between items-center">
    <h1 class="text-2xl font-semibold">Course</h1>

    @if (Auth::user()->isAdmin())
        <a
            href="/course/create"
            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
        >
            + Add Course
        </a>
    @endif
</div>
{{-- <form method="GET" class="flex gap-2">
    <input
        type="text"
        name="search"
        placeholder="Search..."
        class="border p-2 rounded w-64"
    />

    <button class="bg-blue-500 text-white px-4 rounded">Search</button>
</form> --}}
{{-- <div class="mt-4">{{ $course->links() }}</div> --}}
<div class="bg-white shadow rounded-lg overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-3">Name</th>
                <th class="p-3">Code</th>
                <th class="p-3">Duration</th>
                <th class="p-3">Department</th>
                <th class="p-3">Fees</th>
                <th class="p-3">Description</th>
                <th class="p-3">Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($course as $course)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3">{{ $course->name }}</td>
                    <td class="p-3">{{ $course->code }}</td>
                    <td class="p-3">{{ $course->duration }}</td>
                    <td class="p-3">{{ $course->department->name }}</td>
                    <td class="p-3">{{ $course->fees }}</td>
                    <td class="p-3">{{ $course->description }}</td>
                    <td class="p-3 flex gap-2">
                        <a
                            href="/course/{{ $course->id }}/edit"
                            class="bg-yellow-400 px-3 py-1 rounded text-sm"
                        >
                            Edit
                        </a>

                        <form
                            action="/course/{{ $course->id }}"
                            method="POST"
                        >
                            @csrf
                            @method ('DELETE')
                            <button
                                class="bg-red-500 text-white px-3 py-1 rounded text-sm"
                            >
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
