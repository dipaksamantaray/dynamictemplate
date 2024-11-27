<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <div>
        <!-- Page Title -->
        <div class="page-title-area">
            <h4 class="page-title text-xl font-semibold">Create Role</h4>
        </div>

        <!-- Success Message -->
        @if (session()->has('message'))
            <div class="alert alert-success text-green-700 bg-green-100 border-l-4 border-green-500 mb-4 p-4 rounded">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="saveRole" class="space-y-6">
            <!-- Role Name Input -->
            <div class="form-group">
                <label for="name" class="text-sm font-medium">Role Name</label>
                <input type="text" class="input input-bordered w-full" id="name" wire:model="name" placeholder="Enter a Role Name" required>
                @error('name') 
                    <span class="text-sm text-red-500">{{ $message }}</span> 
                @enderror
            </div>

            <!-- Permissions -->
            <div class="form-group">
                <label class="text-sm font-medium">Permissions</label>
                
                <!-- Select All Permissions -->
                <div class="flex items-center space-x-2 mb-4">
                    <input type="checkbox" class="checkbox checkbox-primary" id="checkPermissionAll" wire:click="$set('selected_permissions', $permission_groups.flatMap(group => group.permissions.map(permission => permission.name)))">
                    <label class="text-sm" for="checkPermissionAll">Select All</label>
                </div>

                <!-- Loop through permission groups -->
                @foreach ($permission_groups as $group)
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" class="checkbox checkbox-secondary" wire:click="toggleGroupPermissions('{{ $group->name }}')" id="{{ $group->name }}">
                            <label class="text-sm font-medium" for="{{ $group->name }}">{{ $group->name }}</label>
                        </div>

                        <!-- Loop through permissions in each group -->
                        <div class="pl-6">
                            @foreach ($group->permissions as $permission)
                                <div class="flex items-center space-x-2 mb-2">
                                    <input type="checkbox" class="checkbox checkbox-accent" wire:model="selected_permissions" id="checkPermission{{ $permission->id }}" value="{{ $permission->name }}">
                                    <label class="text-sm" for="checkPermission{{ $permission->id }}">{{ $permission->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary w-full">Save</button>
        </form>
    </div>
    </div>
</x-app-layout>
<script>
    /**
     * Handle the "Select All" checkbox behavior
     */
    $("#checkPermissionAll").click(function() {
        if ($(this).is(':checked')) {
            // Select all checkboxes (permissions and groups)
            $('input[type="checkbox"]').prop('checked', true);
        } else {
            // Unselect all checkboxes (permissions and groups)
            $('input[type="checkbox"]').prop('checked', false);
        }
    });

    /**
     * Handle the group-level checkbox toggle (admin, role, etc.)
     */
    $(document).on('change', '.checkbox-secondary', function() {
        const groupId = $(this).attr('id');
        const permissions = $('#' + groupId).closest('.space-y-2').find('.checkbox-accent');

        if ($(this).prop('checked')) {
            permissions.prop('checked', true);
        } else {
            permissions.prop('checked', false);
        }
    });

    /**
     * Check/uncheck the parent checkbox based on individual permission checkboxes
     */
    $(document).on('change', '.checkbox-accent', function() {
        const groupId = $(this).closest('.space-y-2').find('.checkbox-secondary');
        const totalPermissions = $(this).closest('.space-y-2').find('.checkbox-accent').length;
        const checkedPermissions = $(this).closest('.space-y-2').find('.checkbox-accent:checked').length;

        // If all permissions are selected, check the parent checkbox
        if (totalPermissions === checkedPermissions) {
            groupId.prop('checked', true);
        } else {
            groupId.prop('checked', false);
        }

        // Update "Select All" checkbox status
        const totalCheckboxes = $('input[type="checkbox"]').length;
        const checkedCheckboxes = $('input[type="checkbox"]:checked').length;
        $('#checkPermissionAll').prop('checked', totalCheckboxes === checkedCheckboxes);
    });
</script>

