    <!-- Page Title Area -->
    <div>
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

    <!-- Main Content -->
    <div class="main-content-inner">
        <div class="row">
            <!-- Data Table Start -->
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title float-left">{{ __('Roles') }}</h4>
                        <p class="float-right mb-2">
                            @if (Auth::user()->can('role.create'))
                                <button wire:click="showCreateModal" class="btn btn-primary text-white">{{ __('Create New Role') }}</button>
                            @endif
                        </p>
                        <div class="clearfix"></div>

                        <div class="data-tables">
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
                                            @if (auth()->user()->can('role.edit'))
                                                <button wire:click="showEditModal({{ $role->id }})" class="btn btn-success text-white">{{ __('Edit') }}</button>
                                            @endif

                                            @if (auth()->user()->can('role.delete'))
                                                <button wire:click="confirmDelete({{ $role->id }})" class="btn btn-error text-white">{{ __('Delete') }}</button>
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
            <!-- Data Table End -->
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
        <x-modal wire:model="showDeleteModal">
            <h3>{{ __('Are you sure you want to delete this role?') }}</h3>
            <button wire:click="deleteRole" class="btn btn-danger">{{ __('Yes, Delete') }}</button>
            <button wire:click="cancelDelete" class="btn btn-secondary">{{ __('Cancel') }}</button>
        </x-modal>
    @endif

    <!-- Create/Edit Role Modal -->
    @if($showCreateOrEditModal)
        <x-modal wire:model="showCreateOrEditModal">
            <div>
                <h3>{{ $roleId ? __('Edit Role') : __('Create Role') }}</h3>
                <form wire:submit.prevent="{{ $roleId ? 'updateRole' : 'storeRole' }}">
                    <div class="form-group">
                        <label for="roleName">{{ __('Role Name') }}</label>
                        <input type="text" id="roleName" wire:model="roleName" class="form-input" placeholder="Role Name" required>
                    </div>

                    <div class="form-group">
                        <label>{{ __('Permissions') }}</label>
                        @foreach($permissions as $permission)
                            <label class="mr-2">
                                <input type="checkbox" wire:model="selectedPermissions" value="{{ $permission->id }}">
                                {{ $permission->name }}
                            </label>
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-primary">{{ $roleId ? __('Update Role') : __('Create Role') }}</button>
                </form>
            </div>
        </x-modal>
    @endif


<script>
    document.addEventListener("livewire:load", function() {
        if ($('#dataTable').length) {
            $('#dataTable').DataTable({
                responsive: true
            });
        }
    });
</script>
    </div>
