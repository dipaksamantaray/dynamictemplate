<div>
    <x-app-layout>
        <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
            <!-- Title and header -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Edit Role - {{ $roleName ?? 'Role' }}</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li><a href="{{ route('admin.roles.index') }}">All Roles</a></li>
                                <li><span>Edit Role</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <div class="main-content-inner">
                <div class="row">
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <form wire:submit.prevent="update">
                                    @csrf
                                    <!-- Role Name -->
                                    <div class="form-group">
                                        <label for="roleName">Role Name</label>
                                        <input type="text" id="roleName" wire:model="roleName" class="form-control"
                                            placeholder="Enter Role Name" required>
                                        @error('roleName') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Permissions Section -->
                                    <div class="form-group">
                                        <label>Permissions</label>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="checkPermissionAll"
                                                wire:click="toggleSelectAll" 
                                                {{ count($selectedPermissions ?? []) === $allPermissions->count() ? 'checked' : '' }}>
                                            <label class="form-check-label" for="checkPermissionAll">All</label>
                                        </div>
                                        <hr>

                                        @foreach ($permissionGroups as $groupName => $permissions)
                                            <div class="row">
                                                <!-- Group Checkbox -->
                                                <div class="col-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="group-{{ $loop->index }}" 
                                                            wire:click="toggleGroup('{{ $groupName }}')"
                                                            {{ count(array_intersect($selectedPermissions ?? [], $permissions->pluck('name')->toArray())) === $permissions->count() ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="group-{{ $loop->index }}">{{ $groupName }}</label>
                                                    </div>
                                                </div>

                                                <!-- Permissions Under Group -->
                                                <div class="col-9">
                                                    @foreach ($permissions as $permission)
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input"
                                                                wire:model="selectedPermissions" value="{{ $permission->name }}"
                                                                id="permission-{{ $permission->id }}">
                                                            <label class="form-check-label"
                                                                for="permission-{{ $permission->id }}">{{ $permission->name }}</label>
                                                        </div>
                                                    @endforeach
                                                    <br>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary pr-4 pl-4">Save</button>
                                        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary pr-4 pl-4">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
</div>
