<div class="flex justify-between items-center">
    <h1 class="text-2xl font-semibold">Classroom</h1>

    @if (Auth::user()->isAdmin())
        <a
            href="/{{ auth()->user()->getRoutePrefix() }}/classroom/create"
            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
        >
            + Add Classroom
        </a>
    @endif
</div>
<form method="GET" class="flex gap-2">
    <input
        type="text"
        name="search"
        placeholder="Search..."
        class="border p-2 rounded w-64"
    />

    <button class="bg-blue-500 text-white px-4 rounded">Search</button>
</form>
<div class="mt-4">{{ $classroom->links() }}</div>
<div class="bg-white shadow rounded-lg overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-3">Name</th>
                <th class="p-3">Section</th>
                <th class="p-3">Year</th>
                <th class="p-3">Course</th>
                <th class="p-3">Department</th>
                <th class="p-3">Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($classroom as $classroom)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3">{{ $classroom->name }}</td>
                    <td class="p-3">{{ $classroom->section }}</td>
                    <td class="p-3">{{ $classroom->year }}</td>
                    <td class="p-3">{{ $classroom->course->name }}</td>
                    <td class="p-3">{{ $classroom->department->name }}</td>
                    <td class="p-3 flex gap-2">
                        <a
                            href="/{{ auth()->user()->getRoutePrefix() }}/classroom/{{ $classroom->id }}/edit"
                            class="bg-yellow-400 px-3 py-1 rounded text-sm"
                        >
                            Edit
                        </a>

                        <form
                            action="/{{ auth()->user()->getRoutePrefix() }}/classroom/{{ $classroom->id }}"
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
