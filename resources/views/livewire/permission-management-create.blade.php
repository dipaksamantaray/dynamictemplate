<div class="p-6">
    <h1 class="text-2xl font-bold">Create Permission</h1>

    <div class="mt-6 bg-white p-6 rounded-xl shadow-md">
        <form wire:submit.prevent="createPermission">
            <div class="mb-4">
                <label for="permissionName" class="block text-sm font-medium">Permission Name</label>
                <input type="text" id="permissionName" wire:model.blur="permissionName" class="input input-bordered w-full" />
                @error('permissionName') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            <div class="mb-4">
                <label for="guardName" class="block text-sm font-medium">Guard Name</label>
                <input type="text" id="guardName" wire:model.blur="guardName" class="input input-bordered w-full" />
                @error('guardName') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            <div class="mb-4">
                <label for="groupName" class="block text-sm font-medium">Group Name</label>
                <input type="text" id="groupName" wire:model.blur="groupName" class="input input-bordered w-full" />
                @error('groupName') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            <div class="mb-4">
                <button type="submit" class="btn btn-primary w-full">Create Permission</button>
            </div>
        </form>
    </div>
</div>


