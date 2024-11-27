<x-app-layout>

<!-- page title area start -->
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
<!-- page title area end -->

<div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                        <h4 class="header-title">{{ __('Admins') }}</h4>
                        <p class="float-right mb-2">
                            @if (auth()->user()->can('admin.edit'))
                                <a class="btn btn-primary text-white" href="{{ route('admin.admins.create') }}">
                                    {{ __('Create New Admin') }}
                                </a>
                            @endif
                        </p>
                    <div class="data-tables">
                        {{-- @include('backend.layouts.partials.messages') --}}
                        <table id="dataTable" class="table table-zebra w-full text-center">
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
                                            <a class="btn btn-success text-white" href="{{ route('admin.admins.edit', $admin->id) }}">
                                                {{ __('Edit') }}
                                            </a>
                                        @endif
                                        
                                        @if (auth()->user()->can('admin.delete'))
                                            <a class="btn btn-error text-white" href="javascript:void(0);"
                                            onclick="event.preventDefault(); if(confirm('Are you sure you want to delete?')) { document.getElementById('delete-form-{{ $admin->id }}').submit(); }">
                                                {{ __('Delete') }}
                                            </a>

                                            <form id="delete-form-{{ $admin->id }}" action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST" style="display: none;">
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
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    
    <script>
       if ($('#dataTable').length) {
           $('#dataTable').DataTable({
               responsive: true
           });
       }
    </script>
    </script>