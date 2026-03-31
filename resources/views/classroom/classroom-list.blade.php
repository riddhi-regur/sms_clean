<div class="flex justify-between items-center">
    <h1 class="text-2xl font-semibold">Classroom</h1>

    @if (Auth::user()->isAdmin())
        <a
            href="/classroom/create"
            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
        >
            + Add Classroom
        </a>
    @endif
</div>
<div class="bg-white shadow rounded-lg overflow-hidden py-3 ">
    <table id="classroom-table" class="w-full text-left py-3">
     <thead class="bg-gray-200">
            <tr>
                <th class="p-3">Name</th>
                <th class="p-3">Section</th>
                <th class="p-3">Year</th>
                <th class="p-3">Course</th>
                <th class="p-3">Department</th>
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
    $('#classroom-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('classroom.data') }}",
        columns: [
            { data: 'name', name: 'name' },
            { data: 'section', name: 'section' },
            { data: 'year', name: 'year' },
            { data: 'course', name: 'course.name' },
             { data: 'department', name: 'department.name' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});
</script>

</div>
