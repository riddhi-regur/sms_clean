<div class="flex justify-between items-center">
    <h1 class="text-2xl font-semibold">Department</h1>

    @if (Auth::user()->isAdmin())
        <a
            href="/department/create"
            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
        >
            + Add Department
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
</form>
<div class="mt-4">{{ $department->links() }}</div> --}}
<div class="bg-white shadow rounded-lg overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-3">Name</th>
                <th class="p-3">Code</th>
                <th class="p-3">Description</th>
                <th class="p-3">Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($department as $department)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3">{{ $department->name }}</td>
                    <td class="p-3">{{ $department->code }}</td>
                    <td class="p-3">{{ $department->description }}</td>
                    <td class="p-3 flex gap-2">
                        <a
                            href="/department/{{ $department->id }}/edit"
                            class="bg-yellow-400 px-3 py-1 rounded text-sm"
                        >
                            Edit
                        </a>

                        <form
                            action="/department/{{ $department->id }}"
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
