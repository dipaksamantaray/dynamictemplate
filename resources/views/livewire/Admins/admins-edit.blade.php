<div>
    <!-- Admin Edit Form -->
    {{-- <div class="bg-gray-100 p-4 rounded-lg">
        <h1 class="text-xl font-bold text-gray-800">Edit Admin</h1>
    </div> --}}

     <!-- Page Title Area Start -->
     <div class="page-title-area mb-6">
        <div class="container">
            <div class="breadcrumbs-area flex items-center space-x-2 ml-6">
                <h4 class="page-title font-semibold text-xl">{{ __('EditAdmin') }}</h4>
                <span class="text-gray-500">/</span>
                <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800">{{ __('Dashboard') }}</a>
                <span class="text-gray-500">/</span>
                <span>{{ __('Edit Admin') }}</span>
            </div>
        </div>
    </div>

    <div class="main-content-inner flex justify-center mt-5">
        <div class="card bg-base-100 w-full max-w-6xl shadow-xl dark:bg-gray-800 dark:text-gray-200">
            <div class="card-body">
                <div class="flex justify-between items-center mb-6">
                    <h4 class="header-title font-semibold text-xl">{{ __('Edit Admin') }}</h4>
                    <a href="{{ route('admin.admins.index') }}" class="btn btn-accent">{{ __('Back to Admins') }}</a>
                </div>

                <form wire:submit.prevent="update">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Admin Name -->
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="input input-bordered w-full bg-white dark:bg-gray-700 dark:text-gray-200" id="name" wire:model.defer="name" required>
                            @error('name') <span class="text-error">{{ $message }}</span> @enderror
                        </div>

                        <!-- Admin Email -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="input input-bordered w-full bg-white dark:bg-gray-700 dark:text-gray-200"" id="email" wire:model.defer="email" required>
                            @error('email') <span class="text-error">{{ $message }}</span> @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="password">Password (Leave blank to keep current)</label>
                            <input type="password" class="input input-bordered w-full bg-white dark:bg-gray-700 dark:text-gray-200"" id="password" wire:model.defer="password">
                            @error('password') <span class="text-error">{{ $message }}</span> @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" class="input input-bordered w-full bg-white dark:bg-gray-700 dark:text-gray-200"" id="password_confirmation" wire:model.defer="password_confirmation">
                            @error('password_confirmation') <span class="text-error">{{ $message }}</span> @enderror
                        </div>

                        <!-- Roles -->
                        <div class="form-group">
                            <label for="roles">Roles</label>
                            <div x-data="{ open: false, selectedRole: @entangle('roles') }" class="relative">
                                <button type="button" 
                                    class="select select-bordered w-full bg-white dark:bg-gray-700 dark:text-gray-200" 
                                    @click="open = !open">
                                    <span x-text="selectedRole ? selectedRole : 'Select Role'"></span>
                                </button>
                        
                                <ul x-show="open" 
                                    @click.outside="open = false" 
                                    class="absolute bg-white dark:bg-gray-700 dark:text-gray-200 shadow-lg w-full mt-2 rounded-md z-10 max-h-48 overflow-auto">
                                    @foreach ($availableRoles as $role)
                                        <li>
                                            <button type="button" 
                                                class="block w-full text-left p-2 hover:bg-gray-100 dark:hover:bg-gray-600"
                                                @click="selectedRole = '{{ $role->name }}'; open = false; $wire.set('roles', selectedRole)">
                                                <span x-text="selectedRole === '{{ $role->name }}' ? '✔ ' : ''"></span>{{ $role->name }}
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
