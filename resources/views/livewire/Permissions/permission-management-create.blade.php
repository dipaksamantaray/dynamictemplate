<div >



    <div class="page-title-area mb-6">
        <div class="container">
            <div class="breadcrumbs-area flex items-center space-x-2 ml-6">
                <h4 class="page-title font-semibold text-xl">{{ __('Create New Permission') }}</h4>
                <span class="text-gray-500">/</span>
                <a href="{{ route('admin.permissions') }}" class="text-blue-600 hover:text-blue-800">{{ __('Dashboard') }}</a>
                <span class="text-gray-500">/</span>
                <span>{{ __('Create Permission') }}</span>
            </div>
        </div>
    </div>

    <div class="main-content-inner flex justify-center mt-5">
        <div class="card bg-base-100 w-full max-w-6xl shadow-xl dark:bg-gray-800 dark:text-gray-200">
            <div class="card-body">
                <div class="flex justify-between items-center mb-6">
                    <h4 class="header-title font-semibold text-xl">{{ __('Create New permission') }}</h4>
                    <a href="{{ route('admin.permissions') }}" class="btn btn-accent">{{ __('Back to Permission') }}</a>
                </div>

        <form wire:submit.prevent="createPermission">
            <div class="mb-4">
                <label for="permissionName" class="block text-sm font-medium">Permission Name</label>
                <input type="text" id="permissionName" wire:model.blur="permissionName" class="input input-bordered w-full bg-white dark:bg-gray-700 dark:text-gray-200" />
                @error('permissionName') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            <div class="mb-4">
                <label for="guardName" class="block text-sm font-medium">Guard Name</label>
                <input type="text" id="guardName" wire:model.blur="guardName" class="input input-bordered w-full bg-white dark:bg-gray-700 dark:text-gray-200" />
                @error('guardName') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            <div class="mb-4">
                <label for="groupName" class="block text-sm font-medium">Group Name</label>
                <input type="text" id="groupName" wire:model.blur="groupName" class="input input-bordered w-full bg-white dark:bg-gray-700 dark:text-gray-200" />
                @error('groupName') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            {{-- <div class="mb-4">
                <button type="submit" class="btn btn-primary w-full">Create Permission</button>
            </div> --}}
            <div class="flex justify-end gap-4 mt-6">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                <a href="{{ route('admin.permissions') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
            </div>
        </form>
            </div>
        </div>
    </div>
</div>


