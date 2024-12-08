<div>
    <div class="page-title-area">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="breadcrumbs-area clearfix">
                    <h4 class="page-title pull-left">Role Create</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('admin.roles.index') }}">All Roles</a></li>
                        <li><span>Create Role</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="main-content-inner">
        <div class="row">
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.roles.store') }}" method="POST">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <h4 class="header-title">Create New Role</h4>
                                </div>
                                <div class="text-right">
                                    @if (Auth::user()->can('role.create'))
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    @endif
                                </div>
                            </div>

                            <!-- Role Name Input -->
                            <div class="form-control mb-4">
                                <label for="name" class="label">
                                    <span class="label-text">Role Name</span>
                                </label>
                                <input type="text" class="input input-bordered" id="name" name="name" placeholder="Enter a Role Name" required autofocus value="{{ old('name') }}">
                            </div>

                            <!-- Permissions Section -->
                            <div class="form-control mb-4">
                                <label class="label">
                                    <span class="label-text">Permissions</span>
                                </label>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="checkbox" id="checkPermissionAll" wire:click="toggleAllPermissions" value="1">
                                    <label class="label-text" for="checkPermissionAll">All</label>
                                </div>
                                <hr class="my-2">

                                @php $i = 1; @endphp
                                @foreach ($permission_groups as $group)
                                    <div class="row mb-4">
                                        <!-- Group Checkbox -->
                                        <div class="col-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="checkbox" id="group-{{ $i }}Management" wire:click="toggleGroupPermissions('{{ $group->name }}')">
                                                <label class="label-text" for="group-{{ $i }}Management">{{ $group->name }}</label>
                                            </div>
                                        </div>

                                        <!-- Permissions Under Group -->
                                        <div class="col-9 role-{{ $i }}-management-checkbox">
                                            @php
                                                $permissions = App\Models\User::getpermissionsByGroupName($group->name);
                                                $j = 1;
                                            @endphp
                                            @foreach ($permissions as $permission)
                                                <div class="form-check">
                                                    <input type="checkbox" class="checkbox" name="permissions[]" value="{{ $permission->name }}" wire:model="permissions">
                                                    <label class="label-text" for="checkPermission{{ $permission->id }}">{{ $permission->name }}</label>
                                                </div>
                                                @php $j++; @endphp
                                            @endforeach
                                        </div>
                                    </div>
                                    @php $i++; @endphp
                                @endforeach
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Livewire Scripts -->
    @livewireScripts

    <script>
        document.addEventListener('livewire:load', function () {
            // Initialize checkbox functionality on page load
            initPermissions();
        });

        document.addEventListener('livewire:update', function () {
            // Reinitialize checkbox functionality after Livewire updates the DOM
            initPermissions();
        });

        function initPermissions() {
            $("#checkPermissionAll").click(function() {
                if ($(this).is(':checked')) {
                    $('input[type=checkbox]').prop('checked', true);
                } else {
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
        }
    </script>
</div>
