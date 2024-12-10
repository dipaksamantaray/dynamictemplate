<x-app-layout>
    <div class="page-title-area mb-6">
        <div class="container">
            <div class="breadcrumbs-area flex items-center space-x-2 ml-6">
                <h4 class="page-title font-semibold text-xl text-gray-800 dark:text-gray-200">{{ __('Create New Role') }}
                </h4>
                <span class="text-gray-500 dark:text-gray-400">/</span>
                <a href="{{ route('admin.dashboard') }}"
                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400">{{ __('Dashboard') }}</a>
                <span class="text-gray-500 dark:text-gray-400">/</span>
                <a href="{{ route('admin.roles.index') }}" class="dark:text-gray-300">All Roles</a>
                <span class="text-gray-500 dark:text-gray-400">/</span>
                <span class="dark:text-gray-300">{{ __('Create Role') }}</span>
            </div>
        </div>
    </div>

    <div class="main-content-inner flex mt-5 ml-12">
        <div class="card bg-base-100 w-full max-w-6xl shadow-xl dark:bg-gray-800 dark:text-gray-200">
            <div class="card-body">
                <div class="flex justify-between items-center mb-6">
                    <h4 class="header-title font-semibold text-xl badge badge-primary">{{ __('Create New Role') }}</h4>
                    <a href="{{ route('admin.roles.index') }}"
                        class="btn btn-accent""><i class="fa-solid fa-circle-arrow-left"></i>{{ __('Back to Roles') }}</a>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.roles.store') }}" method="POST" id="roleForm">
                                    @csrf

                                    <!-- Role Name Input -->
                                    <div class="form-control mb-4">
                                        <label for="name" class="label">
                                            <span class="label-text text-gray-800 dark:text-gray-200">Role Name</span>
                                        </label>
                                        <input type="text"
                                            class="input input-bordered w-full bg-white dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
                                            id="name" name="name" placeholder="Enter a Role Name" required
                                            autofocus value="{{ old('name') }}">
                                        @error('name')
                                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Permissions Section -->
                                    <div class="form-control mb-4">
                                        <label class="label">
                                            <span class="label-text text-gray-800 dark:text-gray-200">Permissions</span>
                                        </label>
                                        <div class="form-check mb-2">
                                            <input type="checkbox"
                                                class="checkbox dark:checkbox-gray-600 peer dark:border-gray-500 dark:bg-gray-700 dark:checked:bg-gray-500 dark:checked:border-gray-400"
                                                id="checkPermissionAll" value="1">
                                            <label class="label-text dark:text-gray-200"
                                                for="checkPermissionAll">All</label>
                                        </div>
                                        <hr class="my-2 border-gray-300 dark:border-gray-600">

                                        @php $i = 1; @endphp
                                        @foreach ($permission_groups as $group)
                                            <div class="row mb-4">
                                                <!-- Group Checkbox -->
                                                <div class="col-3">
                                                    <div class="form-check">
                                                        <input type="checkbox"
                                                            class="checkbox dark:checkbox-gray-600 peer dark:border-gray-500 dark:bg-gray-700 dark:checked:bg-gray-500 dark:checked:border-gray-400"
                                                            id="group-{{ $i }}Management"
                                                            value="{{ $group->name }}"
                                                            onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)">
                                                        <label class="label-text dark:text-gray-200"
                                                            for="group-{{ $i }}Management">{{ $group->name }}</label>
                                                    </div>
                                                </div>

                                                <!-- Permissions Under Group -->
                                                <div class="col-9 role-{{ $i }}-management-checkbox">
                                                    @php
                                                        $permissions = App\Models\User::getpermissionsByGroupName(
                                                            $group->name,
                                                        );
                                                        $j = 1;
                                                    @endphp
                                                    @foreach ($permissions as $permission)
                                                        <div class="form-check">
                                                            <input type="checkbox"
                                                                class="checkbox dark:checkbox-gray-600 peer dark:border-gray-500 dark:bg-gray-700 dark:checked:bg-gray-500 dark:checked:border-gray-400"
                                                                name="permissions[]"
                                                                id="checkPermission{{ $permission->id }}"
                                                                value="{{ $permission->name }}">
                                                            <label class="label-text dark:text-gray-200"
                                                                for="checkPermission{{ $permission->id }}">{{ $permission->name }}</label>
                                                        </div>
                                                        @php $j++; @endphp
                                                    @endforeach
                                                    <!-- Error message for Permissions -->
                                                    @error('permissions')
                                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            @php $i++; @endphp
                                        @endforeach
                                    </div>

                                    <div class="text-right">
                                        @if (Auth::user()->can('role.create'))
                                            <button type="submit"
                                                class="btn btn-primary dark:bg-blue-500 dark:hover:bg-blue-600">{{ __('Save') }}</button>
                                        @endif
                                        <a href="{{ route('admin.roles.index') }}"
                                            class="btn btn-warning dark:bg-warning-600 dark:text-gray-200">{{ __('Cancel') }}</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $("#checkPermissionAll").click(function() {
            if ($(this).is(':checked')) {
                $('input[type=checkbox]').prop('checked', true);
            } else {
                $('input[type=checkbox]').prop('checked', false);
            }
        });

        function checkPermissionByGroup(className, checkThis) {
            const groupIdName = $("#" + checkThis.id);
            const classCheckBox = $('.' + className + ' input');

            if (groupIdName.is(':checked')) {
                classCheckBox.prop('checked', true);
            } else {
                classCheckBox.prop('checked', false);
            }

            implementAllChecked();
        }

        function implementAllChecked() {
            const countPermissions = {{ count($all_permissions) }};
            const countPermissionGroups = {{ count($permission_groups) }};

            if ($('input[type="checkbox"]:checked').length >= (countPermissions + countPermissionGroups)) {
                $("#checkPermissionAll").prop('checked', true);
            } else {
                $("#checkPermissionAll").prop('checked', false);
            }
        }

        $(document).on('change', 'input[type="checkbox"]', function() {
            const groupClassName = $(this).closest('div').find('.group-class').attr('data-group-class');
            const groupID = $(this).closest('.group-class').attr('data-group-id');
            const countTotalPermission = $(this).closest('.permissions-group').find('input[type="checkbox"]')
                .length;

            checkSinglePermission(groupClassName, groupID, countTotalPermission);
        });

        // for real time validation 
        $(document).ready(function () {
    // Real-time Role Name Validation
    $('#name').on('input', function () {
        const roleName = $(this).val().trim();
        $('.role-name-error').remove(); // Remove existing error message

        if (roleName === '') {
            // If the field is empty
            $(this)
                .after('<span class="role-name-error text-red-500 text-sm">Role name cannot be empty.</span>');
            return;
        }

        // AJAX Request to check if the role name is unique
        $.ajax({
            url: $('form#roleForm').attr('action'), // Form action URL
            method: 'POST',
            data: {
                name: roleName,
                _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token for security
                check_name_only: true, // Flag to indicate validation-only request
            },
            success: function (response) {
                if (!response.available) {
                    $('#name').after(
                        '<span class="role-name-error text-red-500 text-sm">This role name is already taken.</span>'
                    );
                }
            },
            error: function () {
                console.error('Error checking role name.');
            },
        });
    });

    // Real-time Permissions Validation
    $('input[name="permissions[]"]').on('change', function () {
        $('.permissions-error').remove(); // Remove any existing error message
        const selectedPermissions = $('input[name="permissions[]"]:checked').length;
        if (selectedPermissions === 0) {
            $('#checkPermissionAll')
                .parent()
                .after('<span class="permissions-error text-red-500 text-sm">At least one permission must be selected.</span>');
        }
    });

    // Form Submit Validation
    $('#roleForm').on('submit', function (e) {
        let isValid = true;

        // Clear previous error messages
        $('.role-name-error, .permissions-error').remove();

        // Validate Role Name
        const roleName = $('#name').val().trim();
        if (roleName === '') {
            $('#name')
                .after('<span class="role-name-error text-red-500 text-sm">Role name cannot be empty.</span>');
            isValid = false;
        }

        // Validate Permissions
        const selectedPermissions = $('input[name="permissions[]"]:checked').length;
        if (selectedPermissions === 0) {
            $('#checkPermissionAll')
                .parent()
                .after('<span class="permissions-error text-red-500 text-sm">At least one permission must be selected.</span>');
            isValid = false;
        }

        // Prevent form submission if validation fails
        if (!isValid) {
            e.preventDefault();
        }
    });

    // Select/Deselect All Permissions
    $('#checkPermissionAll').on('click', function () {
        const checkboxes = $('input[name="permissions[]"]');
        checkboxes.prop('checked', $(this).is(':checked'));
        $('.permissions-error').remove(); // Remove permissions error when toggling all
    });

    // Select/Deselect Group Permissions
    window.checkPermissionByGroup = function (className, checkThis) {
        const checkboxes = $('.' + className + ' input');
        checkboxes.prop('checked', $(checkThis).is(':checked'));
        $('.permissions-error').remove(); // Remove permissions error when toggling a group
    };

    // Dynamic "Select All" Checkbox State
    $('input[name="permissions[]"]').on('change', function () {
        const totalPermissions = $('input[name="permissions[]"]').length;
        const selectedPermissions = $('input[name="permissions[]"]:checked').length;
        $('#checkPermissionAll').prop('checked', totalPermissions === selectedPermissions);
    });
});

    </script>

</x-app-layout>
