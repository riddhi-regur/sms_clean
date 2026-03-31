<div class="flex justify-between items-center">
    <h1 class="text-2xl font-semibold">Faculty</h1>

    @if (Auth::user()->isAdmin())
        <a
            href="/{{ auth()->user()->getRoutePrefix() }}/user/create"
            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
        >
            + Add user
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
{{-- <div class="mt-4">{{ $faculty->links() }}</div> --}}
<div class="bg-white shadow rounded-lg overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-3"></th>
                <th class="p-3">Name</th>
                <th class="p-3">Email</th>
                <th class="p-3">Department</th>
                <th class="p-3">Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($faculty as $faculty)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3">
                        <img
                            src="{{ asset('storage/' . $faculty->image) }}"
                            class="mb-3 size-10"
                        />
                    </td>
                    <td class="p-3">{{ $faculty->name }}</td>
                    <td class="p-3">{{ $faculty->email }}</td>
                    <td class="p-3">
                        {{ $faculty->faculty->department->name }}
                    </td>
                    <td class="p-3 flex gap-2">
                        <a
                            href="/{{ auth()->user()->getRoutePrefix() }}/user/{{ $faculty->id }}/edit"
                            class="bg-yellow-400 px-3 py-1 rounded text-sm"
                        >
                            Edit
                        </a>

                        <form
                            action="/{{ auth()->user()->getRoutePrefix() }}/user/{{ $faculty->id }}"
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
