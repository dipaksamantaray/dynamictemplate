<div>
    <!-- Page Title Area Start -->
    <div class="page-title-area mb-6">
        <div class="container">
            <div class="breadcrumbs-area flex items-center space-x-2 ml-6">
                <h4 class="page-title font-semibold text-xl">{{ __('Permissions') }}</h4>
                <span class="text-gray-500">/</span>
                <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800">{{ __('Dashboard') }}</a>
                <span class="text-gray-500">/</span>
                <span>{{ __('Permission Management') }}</span>
            </div>
        </div>
    </div>
    <!-- Page Title Area End -->

    <!-- Main Content -->
    <div class="main-content-inner flex justify-center">
        <!-- DaisyUI Card -->
        <div class="card bg-base-100 w-full max-w-6xl shadow-xl">
            <div class="card-body">
                <!-- Header Section: Both buttons on the same line -->
                <div class="flex justify-between items-center mb-4">
                    <!-- "Create New Permission" button on the left -->
                    <p class="mb-2">
                        <a class="btn btn-primary text-white" href="{{ route('admin.permissions.create') }}">
                            <i class="fas fa-plus"></i> {{ __('Create Permission') }}
                        </a>
                    </p>

                         <!-- "Export Admins" button on the right -->
                    <!-- Export Admins Button -->
<div x-data="{ open: false }" class="relative inline-block text-left">
    <!-- Button to trigger the dropdown -->
    <button type="button" class="btn btn-accent" @click="open = !open">
        {{ __('Export Admins') }}
    </button>

    <!-- Dropdown menu -->
    <div x-show="open" x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 transform scale-95" 
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95" 
        class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-10">
        <div class="py-1">
            <!-- CSV Option -->
            <a href="#" wire:click="exportCSV" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                {{ __('Export CSV') }}
            </a>
            <!-- PDF Option -->
            <a href="#" wire:click="exportPDF" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                {{ __('Export PDF') }}
            </a>
        </div>
    </div>
</div>
                </div>

                <!-- Data Table -->
                <div class="data-tables">
                    <table id="permissionsTable" class="table-auto w-full">
                        <thead class="bg-base-200 text-capitalize">
                            <tr>
                                <th class="px-4 py-2 text-left">{{ __('Permission Name') }}</th>
                                <th class="px-4 py-2 text-left">{{ __('Guard Name') }}</th>
                                <th class="px-4 py-2 text-left">{{ __('Group Name') }}</th>
                                <th class="px-4 py-2 text-left">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $permission)
                                <tr>
                                    <td class="px-4 py-2">{{ $permission->name }}</td>
                                    <td class="px-4 py-2">{{ $permission->guard_name }}</td>
                                    <td class="px-4 py-2">{{ $permission->group_name ?? 'N/A' }}</td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('admin.permissions.edit', ['permission' => $permission->id]) }}" class="btn btn-sm btn-primary">{{ __('Edit') }}</a>
                                        <button wire:click="deletePermission({{ $permission->id }})" class="btn btn-sm btn-error">{{ __('Delete') }}</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTable Script -->
    <script>
        $(document).ready(function() {
            $('#permissionsTable').DataTable({
                responsive: true,
                language: {
                    paginate: {
                        previous: '<span class="btn btn-info px-4 py-2">Previous</span>',
                        next: '<span class="btn btn-info px-4 py-2">Next</span>',
                    }
                },
                "paging": true, // Enables paging
                "searching": true, // Enables search
                "info": true, // Display info like 'Showing x to y of z records'
                // Adjust margin below the DataTable controls
                "initComplete": function() {
                    $('.dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_length').css('margin-bottom', '1.5rem');
                }
            });
        });
    </script>
</div>
