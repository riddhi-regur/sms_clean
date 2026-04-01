@extends ('layouts.index')

@section ('content')
    <h1 class="text-2xl font-semibold mb-6">Add classroom</h1>
    <form
        action="{{ isset($classroom) ? route('classroom.update', $classroom->id) : route('classroom.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="bg-white p-6 rounded-lg shadow w-full max-w-md"
    >
        @csrf
        @if (isset($classroom))
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
            value="{{ old('name', $classroom->name ?? '') }}"
        />
        @error ('section')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        <input
            type="section"
            name="section"
            placeholder="Section"
            class="w-full mb-4 p-2 border rounded"
            value="{{ old('section', $classroom->section ?? '') }}"
        />
        @error ('year')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
        <input
            type="text"
            name="year"
            placeholder="Year"
            class="w-full mb-4 p-2 border rounded"
            value="{{ old('year', $classroom->year ?? '') }}"
        />
        @error ('course_id')
            <div style="color: red">{{ $message }}</div>
        @enderror
        <select name="course_id" class="w-full mb-4 p-2 border rounded">
            <option value="">Select Course</option>
            @foreach ($courses as $course)
                <option
                    value="{{ $course->id }}"
                    {{ old('course_id', $classroom->course_id ?? '') == $course->id ? 'selected' : '' }}
                >
                    {{ $course->name }}
                </option>
            @endforeach
        </select>
        @error ('department_id')
            <div style="color: red">{{ $message }}</div>
        @enderror
        <select name="department_id" class="w-full mb-4 p-2 border rounded">
            <option value="">Select Department</option>
            @foreach ($departments as $department)
                <option
                    value="{{ $department->id }}"
                    {{ old('department_id', $classroom->department_id ?? '') == $department->id ? 'selected' : '' }}
                >
                    {{ $department->name }}
                </option>
            @endforeach
        </select>
        <button
            type="submit"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
        >
            {{ isset($classroom) ? 'Update' : 'Create' }}
        </button>
    </form>
@endsection
