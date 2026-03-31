@extends ('layouts.index')

@section ('content')
    <h1 class="text-2xl font-semibold mb-6">Add department</h1>
    <form
        action="{{ isset($department) ? route(auth()->user()->getRoutePrefix(). '.department.update', $department->id) : route(auth()->user()->getRoutePrefix(). '.department.store') }}"
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

@endsection
