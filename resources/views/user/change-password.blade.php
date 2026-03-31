@extends ('layouts.index')

@section ('content')
    @if (session('success'))
        <div style="color: green">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div style="color: red; margin-bottom: 10px">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h1 class="text-2xl font-semibold mb-6">Update Password</h1>
    <form
        method="POST"
        action="{{ route('password.update') }}"
        class="bg-white p-6 rounded-lg shadow w-full max-w-md"
    >
        @csrf
        @error ('current_password')
            <div style="color: red">{{ $message }}</div>
        @enderror
        <input
            type="password"
            name="current_password"
            placeholder="Current Password"
            class="w-full mb-4 p-2 border rounded"
        />
        @error ('password')
            <div style="color: red">{{ $message }}</div>
        @enderror
        <input
            type="password"
            name="password"
            placeholder="New Password"
            class="w-full mb-4 p-2 border rounded"
        />

        <input
            type="password"
            name="password_confirmation"
            placeholder="Confirm Password"
            class="w-full mb-4 p-2 border rounded"
        />

        <button
            type="submit"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
        >
            Update Password
        </button>
    </form>
@endsection
