<div>
    <!-- Admin Edit Form -->
    <div class="bg-gray-100 p-4 rounded-lg">
        <h1 class="text-xl font-bold text-gray-800">Edit Admin</h1>
    </div>

    <div class="main-content-inner mt-5">
        <div class="card shadow-lg">
            <div class="card-body">
                <h4 class="header-title">Edit Admin Details</h4>

                <form wire:submit.prevent="update">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Admin Name -->
                        <div>
                            <label for="name">Name</label>
                            <input type="text" class="input input-bordered w-full" id="name" wire:model.defer="name" required>
                            @error('name') <span class="text-error">{{ $message }}</span> @enderror
                        </div>

                        <!-- Admin Email -->
                        <div>
                            <label for="email">Email</label>
                            <input type="email" class="input input-bordered w-full" id="email" wire:model.defer="email" required>
                            @error('email') <span class="text-error">{{ $message }}</span> @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password">Password (Leave blank to keep current)</label>
                            <input type="password" class="input input-bordered w-full" id="password" wire:model.defer="password">
                            @error('password') <span class="text-error">{{ $message }}</span> @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" class="input input-bordered w-full" id="password_confirmation" wire:model.defer="password_confirmation">
                            @error('password_confirmation') <span class="text-error">{{ $message }}</span> @enderror
                        </div>

                        <!-- Roles -->
                        <div>
                            <label for="roles">Roles</label>
                            <div x-data="{ open: false, selectedRoles: @entangle('roles') }" class="relative">
                                <button type="button" 
                                    class="select select-bordered w-full" 
                                    @click="open = !open">
                                    <span x-text="selectedRoles.length ? selectedRoles.join(', ') : 'Select Roles'"></span>
                                </button>

                                <ul x-show="open" 
                                    @click.outside="open = false" 
                                    class="absolute bg-white shadow-lg w-full mt-2 rounded-md z-10 max-h-48 overflow-auto">
                                    @foreach ($availableRoles as $role)
                                        <li>
                                            <button type="button" 
                                                class="block w-full text-left p-2 hover:bg-gray-100"
                                                @click="selectedRoles.includes('{{ $role->name }}') 
                                                    ? selectedRoles = selectedRoles.filter(r => r !== '{{ $role->name }}') 
                                                    : selectedRoles.push('{{ $role->name }}')">
                                                <span x-text="selectedRoles.includes('{{ $role->name }}') ? '✔ ' : ''"></span>{{ $role->name }}
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            @error('roles') <span class="text-error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-4">Update Admin</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
