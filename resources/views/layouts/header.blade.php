@vite (['resources/css/app.css', 'resources/js/app.js'])
<div class="flex items-center">
    <img
        src="{{ asset('images/university.jpg') }}"
        alt=""
        class="rounded-full size-16"
    />
    <h2 class="text-base font-medium">Shree Ganesh Vidhyamandir</h2>
</div>
<div class="flex items-center gap-3 fixed right-6">
    <div class="relative">
        <button id="profileBtn" class="cursor-pointer">
            @if (auth()->user()->admin->image)
                <img
                    src="{{  auth()->user()->admin->image }}"
                    class="rounded-full size-10"
                    alt="profile-pic"
                />
            @else
                <img
                    src="{{ asset('images/user.png') }}"
                    class="rounded-full size-10 bg-blue-200"
                    alt="profile-pic"
                />
            @endif
        </button>
        <!-- Dropdown -->
        <div
            id="profileDropdown"
            class="hidden absolute right-0 size-80 bg-slate-100 rounded-lg shadow-lg p-5"
        >
            <div class="flex flex-col justify-center items-center gap-5">
                @if (auth()->user()->admin->image)
                    <img
                        src="{{auth()->user()->admin->image }}"
                        class="rounded-full size-24"
                        alt="profile-pic"
                    />
                @else
                    <img
                        src="{{ asset('images/user.png') }}"
                        class="rounded-full size-24 bg-blue-200"
                        alt="profile-pic"
                    />
                @endif
                <div class="flex flex-col justify-center items-center gap-2">
                    <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                    <h1 class="font-semibold text-3xl">
                        Hi, {{ auth()->user()->admin->name ?  auth()->user()->admin->name : explode('@', auth()->user()->email)[0]}}!
                    </h1>
                </div>
                <div class="flex gap-3 items-center justify-center">
                    <form
                        method="GET"
                        action="{{ route('profile.edit')}}"
                    >
                        @csrf
                        <button
                            class="bg-blue-500 w-full text-white font-medium px-4 py-2 hover:bg-blue-600 cursor-pointer rounded-sm flex gap-2 justify-center items-center"
                        >
                            <img
                                src="{{ asset('images/user.png') }}"
                                alt=""
                                class="size-5"
                            />
                            Profile
                        </button>
                    </form>
                    <form method="GET" 
                    action="{{ route('password.edit') }}"
                    >
                        @csrf
                        <button
                            class="bg-blue-500 w-full text-white font-medium px-4 py-2 hover:bg-blue-600 cursor-pointer rounded-sm flex gap-2 justify-center items-center"
                        >
                            Update Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="flex justify-center items-center gap-3">
        <span class="text-sm text-gray-500"
            >Hi, {{ auth()->user()->admin->name ?  auth()->user()->admin->name : explode('@', auth()->user()->email)[0]}}!</span
        >
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                class="bg-blue-500 w-full text-white font-medium px-2 py-2 hover:bg-red-600 cursor-pointer rounded-sm flex gap-2 justify-center items-center"
            >
                <img
                    src="{{ asset('images/switch.png') }}"
                    alt=""
                    class="size-5"
                />
            </button>
        </form>
    </div>
</div>
