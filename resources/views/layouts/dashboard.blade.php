
    <div class="flex justify-center gap-2.5">
        <div
            class="bg-white flex justify-center items-center flex-1 flex-col p-5 rounded-xl shadow-lg"
        >
            <h3 class="text-2xl font-normal">Total Students</h3>
            {{-- <h3 class="text-3xl font-semibold">{{ $students->count() }}</h3> --}}
             <h3 class="text-3xl font-semibold">23</h3>
        </div>
        <div
            class="bg-white flex justify-center items-center flex-1 flex-col p-5 rounded-xl shadow-lg"
        >
            <h3 class="text-2xl font-normal">Total Faculty</h3>
            {{-- <h3 class="text-3xl font-semibold">{{ $faculty->count() }}</h3> --}}
             <h3 class="text-3xl font-semibold">23</h3>
        </div>
        <div
            class="bg-white flex justify-center items-center flex-1 flex-col p-5 rounded-xl shadow-lg"
        >
            <h3 class="text-2xl font-normal">Total Dpartments</h3>
            {{-- <h3 class="text-3xl font-semibold">{{ $department->count() }}</h3> --}}
             <h3 class="text-3xl font-semibold">23</h3>
        </div>
        <div
            class="bg-white flex justify-center items-center flex-1 flex-col p-5 rounded-xl shadow-lg"
        >
            <h3 class="text-2xl font-normal">Active</h3>
            <h3 class="text-3xl font-semibold">100%</h3>
        </div>
    </div>
    <div class="flex flex-col gap-5">
        {{-- @include ('students.student-list')
        @include ('faculty.faculty-list') --}}
        @include ('course.course-list')
    </div>


