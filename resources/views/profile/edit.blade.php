{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

             <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div> 
        </div>
    </div>
</x-app-layout> --}}

    <h1 class="text-2xl font-semibold mb-6">
        {{ isset($user) ? 'Edit Profile' : 'Add Profile' }}
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
        action="{{ isset($user) ? route('profile.update') : route('user.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="bg-white p-6 rounded-lg shadow w-full max-w-md"
    >
        @csrf
        @if (isset($user))
            @method ('PATCH')
        @endif

        {{-- Image Preview --}}
        @if (isset($admin) && $admin->image)
            <img
                src="{{ asset('storage/' . $admin->image) }}"
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
            value="{{ old('name', $admin->name ?? '') }}"
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


        {{-- Phone --}}
        <input
            type="text"
            name="phone"
            placeholder="Phone"
            class="w-full mb-2 p-2 border rounded"
            value="{{ old('phone', $admin->phone ?? '') }}"
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
            value="{{ old('address', $admin->address ?? '') }}"
        />
        @error ('address')
            <div class="text-red-500 mb-2">{{ $message }}</div>
        @enderror

        {{-- Role --}}
        {{-- <select name="role_id" id="role" class="w-full mb-2 p-2 border rounded">
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
        @enderror --}}

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


