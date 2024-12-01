
{{-- @extends('backend.layouts.master')

@section('title')
Role Edit - Admin Panel
@endsection

@section('styles')
<style>
    .form-check-label {
        text-transform: capitalize;
    }
</style>
@endsection --}}


{{-- @section('admin-content') --}}
<x-app-layout>

<!-- page title area start -->


<div class="bg-gray-100 p-4 rounded-lg">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Role Edit</h1>
            <nav class="text-sm breadcrumbs">
                <ul>
                    <li><a href="{{ route('admin.dashboard') }}" class="text-blue-500">Dashboard</a></li>
                    <li><a href="{{ route('admin.admins.index') }}" class="text-blue-500">All Admins</a></li>
                    {{-- <li class="text-gray-600">Edit Admin - {{ $admin->name }}</li> --}}
                </ul>
            </nav>
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
                    <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <h4 class="header-title">Role Edit - {{ $role->name }}</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="submit" class="btn btn-primary pr-4 pl-4">Save</button>
                            </div>
                        </div>

                        {{-- @include('backend.layouts.partials.messages') --}}
                        <div class="form-group">
                            <label for="name">Role Name</label>
                            <input type="text" class="form-control" id="name" value="{{ $role->name }}" name="name" placeholder="Enter a Role Name" required autofocus>
                        </div>

                        <div class="form-group">
                            <label for="name">Permissions</label>

                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkPermissionAll" value="1" {{ App\Models\User::roleHasPermissions($role, $all_permissions) ? 'checked' : '' }}>
                                <label class="form-check-label" for="checkPermissionAll">All</label>
                            </div>
                            <hr>
                            @php $i = 1; @endphp
                            @foreach ($permission_groups as $group)
                                <div class="row">
                                    @php
                                        $permissions = App\Models\User::getpermissionsByGroupName($group->name);
                                        $j = 1;
                                    @endphp
                                    
                                    <div class="col-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="{{ $i }}Management" value="{{ $group->name }}" onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)" {{ App\Models\User::roleHasPermissions($role, $permissions) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="checkPermission">{{ $group->name }}</label>
                                        </div>
                                    </div>

                                    <div class="col-9 role-{{ $i }}-management-checkbox">
                                        @foreach ($permissions as $permission)
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" onclick="checkSinglePermission('role-{{ $i }}-management-checkbox', '{{ $i }}Management', {{ count($permissions) }})" name="permissions[]" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }} id="checkPermission{{ $permission->id }}" value="{{ $permission->name }}">
                                                <label class="form-check-label" for="checkPermission{{ $permission->id }}">{{ $permission->name }}</label>
                                            </div>
                                            @php $j++; @endphp
                                        @endforeach
                                        <br>
                                    </div>
                                </div>
                                @php  $i++; @endphp
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save</button>
                        {{-- <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary mt-4 pr-4 pl-4">Cancel</a> --}}
                    </form>
                </div>
            </div>
        </div>
        <!-- data table end -->
    </div>
</div>
</x-app-layout>


<script>
    /**
     * Check all the permissions
     */
    $("#checkPermissionAll").click(function() {
        if ($(this).is(':checked')) {
            // Check all the checkboxes (both parent and sub-permissions)
            $('input[type=checkbox]').prop('checked', true);
        } else {
            // Uncheck all the checkboxes (both parent and sub-permissions)
            $('input[type=checkbox]').prop('checked', false);
        }
    });

    // Function to handle toggling group permissions (for example, admin group)
    function checkPermissionByGroup(className, checkThis) {
        const groupIdName = $("#" + checkThis.id);
        const classCheckBox = $('.' + className + ' input');

        // Check or uncheck all checkboxes in the group based on the parent checkbox
        if (groupIdName.is(':checked')) {
            classCheckBox.prop('checked', true);
        } else {
            classCheckBox.prop('checked', false);
        }

        // After toggling group permissions, implement logic for "Select All" checkbox
        implementAllChecked();
    }

    // Handle individual permission toggling inside a group (admin->create, admin->edit, etc.)
    function checkSinglePermission(groupClassName, groupID, countTotalPermission) {
        const classCheckbox = $('.' + groupClassName + ' input');
        const groupIDCheckBox = $("#" + groupID);

        // Check if all permissions in the group are selected
        if ($('.' + groupClassName + ' input:checked').length == countTotalPermission) {
            groupIDCheckBox.prop('checked', true);
        } else {
            groupIDCheckBox.prop('checked', false);
        }

        // Implement logic for "Select All" checkbox
        implementAllChecked();
    }

    // Implement logic for "Select All" checkbox
    function implementAllChecked() {
        const countPermissions = {{ count($all_permissions) }};
        const countPermissionGroups = {{ count($permission_groups) }};

        if ($('input[type="checkbox"]:checked').length >= (countPermissions + countPermissionGroups)) {
            $("#checkPermissionAll").prop('checked', true);
        } else {
            $("#checkPermissionAll").prop('checked', false);
        }
    }

    // Event listener for clicking on a permission checkbox to handle the state of parent checkbox
    $(document).on('change', 'input[type="checkbox"]', function() {
        const groupClassName = $(this).closest('div').find('.group-class').attr('data-group-class');
        const groupID = $(this).closest('.group-class').attr('data-group-id');
        const countTotalPermission = $(this).closest('.permissions-group').find('input[type="checkbox"]').length;

        checkSinglePermission(groupClassName, groupID, countTotalPermission);
    });
</script>