@extends ('layouts.index')

@section ('content')
    <h1 class="text-2xl font-semibold mb-6">Add Student</h1>
    @if ($errors->any())
    <div>
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif
    <form
        action="{{ isset($student) ? route('student.update', $student->id) : route('student.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="bg-white p-6 rounded-lg shadow w-full max-w-md"
    >
        @csrf

        @if (isset($student))
            @method ('PUT')
        @endif
        @if (isset($student) && $student->image)
            <img
                src="{{ $student->image }}"
                width="100"
                class="mb-3"
            />
        @endif
        @error ('name')
            <div style="color: red">{{ $message }}</div>
        @enderror
        <input
            type="text"
            name="name"
            placeholder="Name"
            class="w-full mb-4 p-2 border rounded"
            value="{{ old('name', $student->name ?? '') }}"
        />

        @error ('email')
            <div style="color: red">{{ $message }}</div>
        @enderror
        <input
            type="email"
            name="email"
            placeholder="Email"
            class="w-full mb-4 p-2 border rounded"
            value="{{ old('email', $student->user->email ?? '') }}"
        />

        @if (!isset($student))
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

        {{-- Phone --}}
        <input
            type="text"
            name="phone"
            placeholder="Phone"
            class="w-full mb-2 p-2 border rounded"
            value="{{ old('phone', $student->phone ?? '') }}"
        />
        @error ('phone')
            <div class="text-red-500 mb-2">{{ $message }}</div>
        @enderror

        {{-- address --}}
        <input
            type="text"
            name="address"
            placeholder="Address"
            class="w-full mb-2 p-2 border rounded"
            value="{{ old('address', $student->address ?? '') }}"
        />
        @error ('address')
            <div class="text-red-500 mb-2">{{ $message }}</div>
        @enderror

         <input
            type="text"
            name="roll_no"
            placeholder="Roll_no"
            class="w-full mb-2 p-2 border rounded"
            value="{{ old('roll_no', $student->roll_no ?? '') }}"
        />
        @error ('roll_no')
            <div class="text-red-500 mb-2">{{ $message }}</div>
        @enderror
        
        @error ('classroom_id')
            <div style="color: red">{{ $message }}</div>
        @enderror
        <select name="classroom_id" class="w-full mb-4 p-2 border rounded">
            <option value="">Select Classroom</option>
            @foreach ($classrooms as $classroom)
                <option
                    value="{{ $classroom->id }}"
                    {{ old('classroom_id', $student->classroom_id ?? '') == $classroom->id ? 'selected' : '' }}
                >
                    {{ $classroom->name }}
                </option>
            @endforeach
        </select>

        @error ('course_id')
            <div style="color: red">{{ $message }}</div>
        @enderror
        <select name="course_id" class="w-full mb-4 p-2 border rounded">
            <option value="">Select Course</option>
            @foreach ($courses as $course)
                <option
                    value="{{ $course->id }}"
                    {{ old('course_id', $student->course_id ?? '') == $course->id ? 'selected' : '' }}
                >
                    {{ $course->name }}
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
            {{ isset($student) ? 'Update' : 'Create' }}
        </button>
    </form>

@endsection
