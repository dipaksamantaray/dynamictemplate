<div>
    <!-- Page Title Area Start -->
    <div class="page-title-area mb-6">
        <div class="container">
            <div class="breadcrumbs-area flex items-center space-x-2 ml-6">
                <h4 class="page-title font-semibold text-xl">{{ __('Admins') }}</h4>
                <span class="text-gray-500 dark:text-gray-400">/</span>
                <a href="{{ route('admin.dashboard') }}"
                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400">{{ __('Dashboard') }}</a>
                <span class="text-gray-500 dark:text-gray-400">/</span>
                <span class="dark:text-gray-200">{{ __('All Admins') }}</span>
            </div>
        </div>
    </div>
    <!-- Page Title Area End -->

    <!-- Main Content -->
    <div class="main-content-inner flex justify-center">
        <!-- DaisyUI Card -->
        <div class="card bg-base-100 w-full max-w-6xl shadow-xl dark:bg-gray-800 dark:text-gray-200">
            <div class="card-body">
                <!-- Header Section -->
                <div class="flex justify-between items-center mb-4">
                    <p class="mb-2">
                        @if (auth()->user()->can('admin.edit'))
                            <a class="btn btn-primary text-white" href="{{ route('admin.admins.create') }}">
                                {{ __('Create New Admin') }}
                            </a>
                        @endif
                    </p>
                    <div x-data="{ open: false }" class="relative inline-block text-left">
                        <button type="button" class="btn btn-accent" @click="open = !open">
                            {{ __('Export Admins') }}
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 border border-gray-200 rounded-md shadow-lg z-10">
                            <div class="py-1">
                                <a href="#" wire:click="exportCSV"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200">
                                    {{ __('Export CSV') }}
                                </a>
                                <a href="#" wire:click="exportPDF"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200">
                                    {{ __('Export PDF') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Table -->
                <div class="data-tables">
                    <table id="dataTable"
                        class="table w-full text-center dark:bg-gray-900 dark:text-gray-200">
                        <thead class="bg-base-200 text-capitalize dark:bg-gray-700 dark:text-gray-200">
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
                                <tr class="dark:bg-gray-800 dark:hover:bg-gray-700">
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

    <!-- DataTable Customization -->
    <style>
        /* Light mode styles */
        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            background-color: white;
            border: 1px solid #ddd;
            color: black;
        }
        .dark .dataTables_filter label, 
    .dark .dataTables_length label, 
    .dark .dataTables_info {
        color: gray !important; /* Dark mode text color */
    }
        /* Dark mode styles */
        .dark .dataTables_wrapper .dataTables_filter input,
        .dark .dataTables_wrapper .dataTables_length select {
            background-color:#1F2937;
            border: 1px solid gray;
            color: white;
        }
    </style>

    <!-- DataTable Initialization Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if ($('#dataTable').length) {
                $('#dataTable').DataTable({
                    responsive: true,
                    language: {
                        paginate: {
                            previous: '<span class="btn btn-info px-4 py-2">Previous</span>',
                            next: '<span class="btn btn-info px-4 py-2">Next</span>',
                        }
                    },
                    initComplete: function() {
                        $('.dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_length')
                            .css('margin-bottom', '1.5rem');
                    },
                });
            }
        });
    </script>
</div>
