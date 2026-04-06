@extends ('layouts.index')

@section ('content')
    <h1 class="text-2xl font-semibold mb-6">Add Faculty</h1>
     @if ($errors->any())
    <div>
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif
    <form
        action="{{ isset($faculty) ? route('faculty.update', $faculty->id) : route('faculty.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="bg-white p-6 rounded-lg shadow w-full max-w-md"
    >
        @csrf
        @if (isset($faculty))
            @method ('PUT')
        @endif
        @if (isset($faculty) && $faculty->image)
            <img
                src="{{ $faculty->image }}"
                width="100"
                class="mb-3"
            />
        @endif
        @error ('name')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
        <input
            type="text"
            name="name"
            placeholder="Name"
            class="w-full mb-4 p-2 border rounded"
            value="{{ old('name', $faculty->name ?? '') }}"
        />
        @error ('email')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        <input
            type="email"
            name="email"
            placeholder="Email"
            class="w-full mb-4 p-2 border rounded"
            value="{{ old('email', $faculty->user->email ?? '') }}"
        />
         @if (!isset($faculty))
            <input
                type="password"
                name="password"
                placeholder="password"
                class="w-full mb-2 p-2 border rounded"
            />
            @error ('password')
                <div class="text-red-500 mb-2">{{ $message }}</div>
            @enderror
        @endif
        @error ('phone')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
        <input
            type="text"
            name="phone"
            placeholder="Phone"
            class="w-full mb-4 p-2 border rounded"
            value="{{ old('phone', $faculty->phone ?? '') }}"
        />
         <input
            type="text"
            name="address"
            placeholder="Address"
            class="w-full mb-2 p-2 border rounded"
            value="{{ old('address', $faculty->address ?? '') }}"
        />
        @error ('address')
            <div class="text-red-500 mb-2">{{ $message }}</div>
        @enderror
        @error ('designation')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
        <input
            type="text"
            name="designation"
            placeholder="Designation"
            class="w-full mb-4 p-2 border rounded"
            value="{{ old('designation', $faculty->designation ?? '') }}"
        />
        @error ('department_id')
            <div style="color: red">{{ $message }}</div>
        @enderror
        <select name="department_id" class="w-full mb-4 p-2 border rounded">
            <option value="">Select Department</option>
            @foreach ($departments as $department)
                <option
                    value="{{ $department->id }}"
                    {{ old('department_id', $faculty->department_id ?? '') == $department->id ? 'selected' : '' }}
                >
                    {{ $department->name }}
                </option>
            @endforeach
        </select>

        @error ('image')
            <div style="color: red">{{ $message }}</div>
        @enderror
        <input
            type="file"
            name="image"
            class="w-full mb-4 p-2 border rounded"
        />

        <button
            type="submit"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
        >
            {{ isset($faculty) ? 'Update' : 'Create' }}
        </button>
    </form>

@endsection
