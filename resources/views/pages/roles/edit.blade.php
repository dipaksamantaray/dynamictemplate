<x-app-layout>

    <div class="page-title-area mb-6">
        <div class="container">
            <div class="breadcrumbs-area flex items-center space-x-2 ml-6">
                <h4 class="page-title font-semibold text-xl text-gray-800 dark:text-gray-200">{{ __('Role Edit') }}</h4>
                <span class="text-gray-500 dark:text-gray-400">/</span>
                <a href="{{ route('admin.dashboard') }}"
                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400">{{ __('Dashboard') }}</a>
                <span class="text-gray-500 dark:text-gray-400">/</span>
                <a href="{{ route('admin.roles.index') }}" class="dark:text-gray-300">All Roles</a>
                <span class="text-gray-500 dark:text-gray-400">/</span>
                <span class="dark:text-gray-300">{{ __('Edit Role') }}</span>
            </div>
        </div>
    </div>
    <!-- page title area start -->



    <!-- page title area end -->

    <div class="main-content-inner flex mt-5 ml-12">

        <div class="card bg-base-100 w-full max-w-6xl shadow-xl dark:bg-gray-800 dark:text-gray-200">
            <div class="card-body">
                <div class="flex justify-between items-center mb-6">
                    <h4 class="header-title font-semibold text-xl">{{ __('Edit Role') }}-({{ $role->name }})</h4>
                    <a href="{{ route('admin.roles.index') }}"
                        class="btn btn-accent dark:bg-gray-600 dark:text-gray-200">{{ __('Back to Roles') }}</a>
                </div>
        <div class="row">
            <!-- data table start -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                           
                            <div class="form-control mb-4">
                                <label for="name" class="label">
                                    <span class="label-text text-gray-800 dark:text-gray-200">Role Name</span>
                                </label>
                                <input type="text" class="input input-bordered w-full bg-white dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"" id="name" value="{{ $role->name }}"
                                    name="name" placeholder="Enter a Role Name" required autofocus>
                            </div>

                            <div class="form-control mb-4">
                                <label class="label">
                                    <span class="label-text text-gray-800 dark:text-gray-200">Permissions</span>
                                </label>

                                <div class="form-check  mb-2">
                                    <input type="checkbox" class="checkbox dark:checkbox-gray-600 peer dark:border-gray-500 dark:bg-gray-700 dark:checked:bg-gray-500 dark:checked:border-gray-400" id="checkPermissionAll"
                                        value="1"
                                        {{ App\Models\User::roleHasPermissions($role, $all_permissions) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="checkPermissionAll">All</label>
                                </div>
                                <hr class="my-2 border-gray-300 dark:border-gray-600">
                                @php $i = 1; @endphp
                                @foreach ($permission_groups as $group)
                                    <div class="row mb-4">
                                        @php
                                            $permissions = App\Models\User::getpermissionsByGroupName($group->name);
                                            $j = 1;
                                        @endphp

                                        <div class="col-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="checkbox dark:checkbox-gray-600 peer dark:border-gray-500 dark:bg-gray-700 dark:checked:bg-gray-500 dark:checked:border-gray-400"
                                                    id="{{ $i }}Management" value="{{ $group->name }}"
                                                    onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)"
                                                    {{ App\Models\User::roleHasPermissions($role, $permissions) ? 'checked' : '' }}>
                                                <label class="label-text dark:text-gray-200"
                                                    for="checkPermission">{{ $group->name }}</label>
                                            </div>
                                        </div>

                                        <div class="col-9 role-{{ $i }}-management-checkbox">
                                            @foreach ($permissions as $permission)
                                                <div class="form-check">
                                                    <input type="checkbox" class="checkbox dark:checkbox-gray-600 peer dark:border-gray-500 dark:bg-gray-700 dark:checked:bg-gray-500 dark:checked:border-gray-400""
                                                        onclick="checkSinglePermission('role-{{ $i }}-management-checkbox', '{{ $i }}Management', {{ count($permissions) }})"
                                                        name="permissions[]"
                                                        {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                                        id="checkPermission{{ $permission->id }}"
                                                        value="{{ $permission->name }}">
                                                    <label class="label-text dark:text-gray-200"
                                                        for="checkPermission{{ $permission->id }}">{{ $permission->name }}</label>
                                                </div>
                                                @php $j++; @endphp
                                            @endforeach
                                            <br>
                                        </div>
                                    </div>
                                    @php  $i++; @endphp
                                @endforeach
                            </div>
                                    <div class="text-right">

                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save</button>
                            {{-- <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary mt-4 pr-4 pl-4">Cancel</a> --}}
                            <a href="{{ route('admin.roles.index') }}"
                                            class="btn btn-secondary dark:bg-gray-600 dark:text-gray-200">{{ __('Cancel') }}</a>
                                    </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- data table end -->
        </div>
            </div>
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
        const countTotalPermission = $(this).closest('.permissions-group').find('input[type="checkbox"]')
        .length;

        checkSinglePermission(groupClassName, groupID, countTotalPermission);
    });
</script>
