@extends ('layouts.index')

@section ('content')
    <h1 class="text-2xl font-semibold mb-6">
        {{ isset($user) ? 'Edit User' : 'Add User' }}
    </h1>
    @if ($errors->any())
        <div class="text-red-500 mb-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form
        action="{{ isset($user) ? route(auth()->user()->getRoutePrefix(). '.user.update', $user->id) : route(auth()->user()->getRoutePrefix(). '.user.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="bg-white p-6 rounded-lg shadow w-full max-w-md"
    >
        @csrf
        @if (isset($user))
            @method ('PUT')
        @endif

        {{-- Image Preview --}}
        @if (isset($user) && $user->image)
            <img
                src="{{ asset('storage/' . $user->image) }}"
                width="100"
                class="mb-3"
            />
        @endif

        {{-- Name --}}
        <input
            type="text"
            name="name"
            placeholder="Name"
            class="w-full mb-2 p-2 border rounded"
            value="{{ old('name', $user->name ?? '') }}"
        />
        @error ('name')
            <div class="text-red-500 mb-2">{{ $message }}</div>
        @enderror

        {{-- Email --}}
        <input
            type="email"
            name="email"
            placeholder="Email"
            class="w-full mb-2 p-2 border rounded"
            value="{{ old('email', $user->email ?? '') }}"
        />
        @error ('email')
            <div class="text-red-500 mb-2">{{ $message }}</div>
        @enderror

        {{-- password --}}
        @if (!isset($user))
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
            value="{{ old('phone', $user->phone ?? '') }}"
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
            value="{{ old('address', $user->address ?? '') }}"
        />
        @error ('address')
            <div class="text-red-500 mb-2">{{ $message }}</div>
        @enderror

        {{-- Role --}}
        <select name="role_id" id="role" class="w-full mb-2 p-2 border rounded">
            <option value="">Select Role</option>
            @foreach ($roles as $role)
                <option
                    value="{{ $role->id }}"
                    {{ old('role_id', $user->role_id ?? '') == $role->id ? 'selected' : '' }}
                >
                    {{ ucfirst($role->name) }}
                </option>
            @endforeach
        </select>
        @error ('role_id')
            <div class="text-red-500 mb-2">{{ $message }}</div>
        @enderror

        {{-- Image --}}
        <input
            type="file"
            name="image"
            class="w-full mb-2 p-2 border rounded"
        />
        @error ('image')
            <div class="text-red-500 mb-2">{{ $message }}</div>
        @enderror

        <button
            type="submit"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full mt-3"
        >
            {{ isset($user) ? 'Update' : 'Create' }}
        </button>
    </form>

@endsection
