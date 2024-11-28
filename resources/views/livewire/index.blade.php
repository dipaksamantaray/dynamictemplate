
<x-app-layout>

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
                        {{-- @include('backend.layouts.partials.messages') --}}
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
                                        @if (auth::user()->can('admin.edit'))
                                            <a class="btn btn-success text-white" href="{{ route('admin.roles.edit', $role->id) }}">Edit</a>
                                        @endif

                                        @if (auth::user()->can('admin.edit'))
                                            <a class="btn btn-error text-white" href="javascript:void(0);"
                                                onclick="event.preventDefault(); if(confirm('Are you sure to delete?')) { document.getElementById('delete-form-{{ $role->id }}').submit(); }">
                                                {{ __('Delete') }}
                                            </a>

                                            <form id="delete-form-{{ $role->id }}" action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" style="display: none;">
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
        <!-- data table end -->
    </div>
</div>
</x-app-layout>


<script>
     <!-- Start datatable js -->
     <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
     
     <script>
        if ($('#dataTable').length) {
            $('#dataTable').DataTable({
                responsive: true
            });
        }
     </script>
     </script>
