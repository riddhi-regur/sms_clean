@extends ('layouts.index')

@section ('content')
<div class="flex justify-between items-center">
    <h1 class="text-2xl font-semibold">Department</h1>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
    @if (Auth::user()->isAdmin())
        <a
            href="{{ route('department.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
        >
            + Add Department
        </a>
    @endif
</div>

<div class="bg-white shadow rounded-lg overflow-hidden py-3 ">
    <table id="department-table" class="w-full text-left py-3">
     <thead class="bg-gray-200">
            <tr>
                <th class="p-3">Name</th>
                <th class="p-3">Code</th>
                <th class="p-3">Description</th>
                <th class="p-3">Actions</th>
            </tr>
        </thead>

       </thead>
        
</table>

<script>
    window.routes = {
        departmentData: "{{ route('department.data') }}"
    };
</script>

</div>
@endsection