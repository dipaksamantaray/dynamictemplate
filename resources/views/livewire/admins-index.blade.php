<div>
    <!-- Page Title Area Start -->
    <div class="page-title-area mb-6">
        <div class="container">
            <div class="breadcrumbs-area flex items-center space-x-2 ml-6">
                <h4 class="page-title font-semibold text-xl">{{ __('Admins') }}</h4>
                <span class="text-gray-500">/</span>
                <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800">{{ __('Dashboard') }}</a>
                <span class="text-gray-500">/</span>
                <span>{{ __('All Admins') }}</span>
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
                    <!-- "Create New Admin" button on the left -->
                    <p class="mb-2">
                        @if (auth()->user()->can('admin.edit'))
                            <a class="btn btn-primary text-white" href="{{ route('admin.admins.create') }}">
                                {{ __('Create New Admin') }}
                            </a>
                        @endif
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
                    <table id="dataTable" class="table table-zebra w-full text-center ">
                        <thead class="bg-base-200 text-capitalize">
                            <tr>
                                <th>{{ __('Sl') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Roles') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $admin)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>
                                        @foreach ($admin->roles as $role)
                                            <span class="badge badge-primary">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td class="flex justify-center gap-2">
                                        @if (auth()->user()->can('admin.edit'))
                                            <a class="btn btn-success text-white"
                                               href="{{ route('admin.admins.edit', $admin->id) }}">
                                                {{ __('Edit') }}
                                            </a>
                                        @endif

                                        @if (auth()->user()->can('admin.delete'))
                                            <button class="btn btn-error text-white"
                                                    wire:click="deleteAdmin({{ $admin->id }})">
                                                {{ __('Delete') }}
                                            </button>
                                        @endif
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
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script>
        if ($('#dataTable').length) {
            $('#dataTable').DataTable({
                responsive: true,
                language: {
                    paginate: {
                        previous: '<span class="btn btn-info px-4 py-2">Previous</span>',
                        next: '<span class="btn btn-info px-4 py-2">Next</span>',
                    }
                },
                // Ensure proper spacing after initialization
                initComplete: function () {
                    // Add margin to the DataTables wrapper using a class
                    $('.dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_length')
                        .css('margin-bottom', '1.5rem'); // Apply margin directly below the filter and length
                },
            });
        }
    </script>
    
</div>
