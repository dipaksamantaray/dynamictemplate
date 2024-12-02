<div class="p-6">
    <h1 class="text-2xl font-bold">Edit Permission</h1>

    <div class="mt-6 bg-white p-6 rounded-xl shadow-md">
        <form wire:submit.prevent="updatePermission">
            <div class="mb-4">
                <label for="permissionName" class="block text-sm font-medium">Permission Name</label>
                <input type="text" id="permissionName" wire:model="permissionName" class="input input-bordered w-full" />
                @error('permissionName') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            <div class="mb-4">
                <label for="guardName" class="block text-sm font-medium">Guard Name</label>
                <input type="text" id="guardName" wire:model="guardName" class="input input-bordered w-full" />
                @error('guardName') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            <div class="mb-4">
                <label for="groupName" class="block text-sm font-medium">Group Name</label>
                <input type="text" id="groupName" wire:model="groupName" class="input input-bordered w-full" />
                @error('groupName') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            <div class="mb-4">
                <button type="submit" class="btn btn-primary w-full">Update Permission</button>
            </div>
        </form>
    </div>
</div>
