@extends ('layouts.index')

@section ('content')
<div class="flex justify-between items-center">
    <h1 class="text-2xl font-semibold">Students</h1>
@if ($errors->any())
    <div>
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif
    @if (Auth::user()->isAdmin())
        <a
            href="{{ route('student.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
        >
            + Add user
        </a>
    @endif
</div>

<div class="bg-white shadow rounded-lg overflow-hidden">
    <table id="student-table" class="w-full text-left">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-3">Image</th>
                <th class="p-3">Name</th>
                <th class="p-3">Email</th>
                <th class="p-3">Course</th>
                <th class="p-3">Classroom</th>
                <th class="p-3">Phone</th>
                <th class="p-3">Address</th>
                <th class="p-3">Roll_no</th>
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
    $('#student-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('student.data') }}",
        columns: [
             { data: 'image', name: 'image' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'user.email' },
            { data: 'course', name: 'course.name' },
             { data: 'classroom', name: 'classroom.name' },
              { data: 'phone', name: 'phone' },
              { data: 'address', name: 'address' },
                { data: 'roll_no', name: 'roll_no' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});
</script>
</div>
@endsection