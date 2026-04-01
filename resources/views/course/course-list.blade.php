<div class="flex justify-between items-center">
    <h1 class="text-2xl font-semibold">Course</h1>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
    @if (Auth::user()->isAdmin())
        <a
            href="{{ route('course.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
        >
            + Add Course
        </a>
    @endif
</div>

<div class="bg-white shadow rounded-lg overflow-hidden py-3 ">
    <table id="course-table" class="w-full text-left py-3">
     <thead class="bg-gray-200">
            <tr>
                <th class="p-3">Name</th>
                <th class="p-3">Code</th>
                <th class="p-3">Duration</th>
                <th class="p-3">Department</th>
                <th class="p-3">Fees</th>
                <th class="p-3">Description</th>
                <th class="p-3">Actions</th>
            </tr>
        </thead>
        
</table>

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- jQuery + DataTables -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(function () {
    $('#course-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('course.data') }}",
        columns: [
            { data: 'name', name: 'name' },
            { data: 'code', name: 'code' },
            { data: 'duration', name: 'duration' },
             { data: 'department', name: 'department.name' },
              { data: 'fees', name: 'fees' },
              { data: 'description', name: 'description' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});
</script>

</div>
