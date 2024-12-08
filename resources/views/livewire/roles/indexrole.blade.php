<div>

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

    <div class="main-content-inner">
        <div class="row">
            <!-- data table start -->
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title float-left">{{ __('Roles') }}</h4>
                        <p class="float-right mb-2">
                            @if (Auth::user()->can('role.create'))
                                <a class="btn btn-primary text-white" href="{{ route('admin.roles.create') }}">Create New Role</a>
                            @endif
                        </p>
                        <div class="clearfix"></div>
                        <div class="data-tables">
                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                            @endif
                            <table id="dataTable" class="text-center">
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
                                                <span class="badge badge-info mr-1">
                                                    {{ $permission->name }}
                                                </span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if (Auth::user()->can('admin.edit'))
                                                <a class="btn btn-primary text-white" href="{{ route('admin.roles.edit', $role->id) }}">Edit</a>
                                            @endif

                                            @if (Auth::user()->can('role.delete'))
                                                <button class="btn btn-error text-white" wire:click="deleteRole({{ $role->id }})">
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
            <!-- data table end -->
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script>
    function initializeDataTable() {
        $('#dataTable').DataTable({
            responsive: true,
            destroy: true // Ensures reinitialization works
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initializeDataTable(); // Initialize DataTable on page load
    });

    Livewire.on('refreshTable', function () {
        $('#dataTable').DataTable().destroy(); // Destroy existing DataTable instance
        initializeDataTable(); // Reinitialize after Livewire updates
    });
</script>
