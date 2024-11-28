<div class="p-6">
    <!-- Header with Plus Icon Button -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Permission Management</h1>
        <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary rounded-full">
            <i class="fas fa-plus"></i> Create Permission
        </a>
    </div>

    @if(session()->has('message'))
        <div class="alert alert-success my-4">
            {{ session('message') }}
        </div>
    @endif

    <!-- List of Permissions -->
    <div class="mt-6 bg-white p-6 rounded-xl shadow-md">
        <table id="permissionsTable" class="table-auto w-full">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left">Permission Name</th>
                    <th class="px-4 py-2 text-left">Guard Name</th>
                    <th class="px-4 py-2 text-left">Group Name</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($permissions as $permission)
                    <tr>
                        <td class="px-4 py-2">{{ $permission->name }}</td>
                        <td class="px-4 py-2">{{ $permission->guard_name }}</td>
                        <td class="px-4 py-2">{{ $permission->group_name ?? 'N/A' }}</td>
                        <td class="px-4 py-2">
                            <button wire:click="editPermission({{ $permission->id }})" class="btn btn-sm btn-secondary">Edit</button>
                            <button wire:click="deletePermission({{ $permission->id }})" class="btn btn-sm btn-error">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#permissionsTable').DataTable({
            responsive: true,
            "paging": true, // Enables paging
            "searching": true, // Enables search
            "info": true // Display info like 'Showing x to y of z records'
        });
    });
</script>
