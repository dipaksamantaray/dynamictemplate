<x-app-layout>
    <style>
        .data-tables .badge {
            margin-right: 0.5rem; /* Add a small margin between badges */
            margin-top: 0.5rem; /* Add space between rows of badges if they wrap */
        }

        /* Optional: For more compact badges */
        .data-tables .badge-info {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem; /* Smaller font size */
        }

        /* Light mode DataTable styles */
        #roles {
            background-color: #ffffff; /* Light mode background */
            color: #333333; /* Light text color */
        }

        /* Dark mode DataTable styles */
        .dark #roles {
            background-color: #2D2D2D; /* Dark mode background */
            color: #E5E5E5; /* Light text color for dark mode */
        }

        .dark #roles th {
            background-color: #444444; /* Dark background for table headers */
            color: #E5E5E5; /* Light text color for headers */
        }

        .dark #roles td {
            background-color: #333333; /* Dark background for table rows */
            color: #E5E5E5; /* Light text color for table cells */
        }

        /* Adjust DataTable pagination buttons for dark mode */
        .dark .dataTables_wrapper .dataTables_paginate .paginate_button {
            background-color: #555555 !important; /* Darker background for buttons */
            color: white !important;
        }

        .dark .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #2D2D2D !important; /* Active page background */
            color: white !important;
        }

        /* Pagination and Search Controls Text Color in Dark Mode */
        .dark .dataTables_wrapper .dataTables_info, 
        .dark .dataTables_wrapper .dataTables_length, 
        .dark .dataTables_wrapper .dataTables_filter {
            color: #E5E5E5 !important; /* Light text color for pagination and search in dark mode */
        }

        /* DataTable search input text color */
        .dark .dataTables_wrapper .dataTables_filter input {
            background-color: #444444; /* Dark background for search input */
            color: #E5E5E5; /* Light text color inside search box */
            border: 1px solid #555555; /* Darker border */
        }

        /* DataTable length dropdown background and text color */
        .dark .dataTables_wrapper .dataTables_length select {
            background-color: #444444; /* Dark background for length dropdown */
            color: #E5E5E5; /* Light text color */
            border: 1px solid #555555; /* Dark border */
        }

        /* Light mode card styles */
        .card {
            background-color: #ffffff; /* Light mode background for the card */
            color: #333333; /* Light text color */
        }

        /* Dark mode card styles */
        .dark .card {
            background-color: #333333; /* Dark mode background for the card */
            color: #E5E5E5; /* Light text color for dark mode */
        }

        .dark .card-body {
            background-color: #444444; /* Darker background for card body */
        }
    </style>
    
    <!-- page title area start -->
    <div class="page-title-area mb-6">
        <div class="container">
            <div class="breadcrumbs-area flex items-center space-x-2 ml-6">
                <h4 class="page-title font-semibold text-xl">{{ __('Roles') }}</h4>
                <span class="text-gray-500">/</span>
                <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800">{{ __('Dashboard') }}</a>
                <span class="text-gray-500">/</span>
                <span>{{ __('All Roles') }}</span>
            </div>
        </div>
    </div>
    <!-- page title area end -->

    <div class="main-content-inner flex justify-center">
        <div class="card bg-base-100 w-full max-w-6xl shadow-xl">
            <div class="card-body">
                <div class="flex justify-between items-center mb-4">
                    <p class="float-right mb-2">
                        @if (Auth::user()->can('role.create'))
                            <a class="btn btn-primary text-white" href="{{ route('admin.roles.create') }}">Create New Role <i class="fa-solid fa-plus"></i></a>
                        @endif
                    </p>
                    <div x-data="{ open: false }" class="relative inline-block text-left">
                        <!-- Button to trigger the dropdown -->
                        <button type="button" class="btn btn-accent" @click="open = !open">
                            {{ __('Export Roles') }}<i class="fa-solid fa-download"></i>
                        </button>

                        <!-- Dropdown menu -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 border border-gray-200 rounded-md shadow-lg z-10">
                            <div class="py-1">
                                <!-- CSV Option -->
                                <a href="{{ route('admin.roles.exportCSV') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-black-200">
                                    {{ __('Export CSV') }}&nbsp;&nbsp;<i class="fa-solid fa-file-csv"></i>
                                </a>
                                <!-- PDF Option -->
                                <a href="{{ route('admin.roles.exportPDF') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-black-200">
                                    {{ __('Export PDF') }}&nbsp;&nbsp;<i class="fa-solid fa-file-pdf"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Table -->
                <div class="row">
                    <div class="col-12">
                        <div class="data-tables">
                            <table id="roles" class="text-center table table-striped">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th width="5%">{{ __('Sl') }}</th>
                                        <th width="10%">{{ __('Name') }}</th>
                                        <th width="60%">{{ __('Permissions') }}</th>
                                        <th width="15%">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td>
                                                @foreach ($role->permissions as $permission)
                                                    <span class="badge badge-info">{{ $permission->name }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                @if (auth::user()->can('admin.edit'))
                                                    <a class="btn btn-success text-white" href="{{ route('admin.roles.edit', $role->id) }}">Edit</a>
                                                @endif

                                                @if (auth::user()->can('admin.delete'))
                                                    <a class="btn btn-error text-white" href="javascript:void(0);"
                                                       onclick="event.preventDefault(); if(confirm('Are you sure to delete?')) { document.getElementById('delete-form-{{ $role->id }}').submit(); }">
                                                        {{ __('Delete') }}
                                                    </a>
                                                    <form id="delete-form-{{ $role->id }}"
                                                          action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" style="display: none;">
                                                        @method('DELETE')
                                                        @csrf
                                                    </form>
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
        </div>
    </div>

</x-app-layout>

<!-- DataTable Initialization Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Dynamically add custom CSS for DataTable pagination buttons
        const style = document.createElement('style');
        style.innerHTML = `
            .dataTables_wrapper .dataTables_paginate .paginate_button {
                color: white !important;
                border-radius: 4px;
                padding: 5px 10px;
                margin: 0 2px;
            }
        `;
        document.head.appendChild(style);

        // Initialize the DataTable
        if ($('#roles').length) {
            $('#roles').DataTable({
                responsive: true,
                language: {
                    paginate: {
                        previous: '<span class="btn btn-info px-4 py-2">Previous</span>',
                        next: '<span class="btn btn-info px-4 py-2">Next</span>',
                    },
                },
            });
        }
    });
</script>
