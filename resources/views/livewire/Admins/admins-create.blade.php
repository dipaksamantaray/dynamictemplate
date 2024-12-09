<div>
    <!-- Page Title Area Start -->
    <div class="page-title-area mb-6">
        <div class="container">
            <div class="breadcrumbs-area flex items-center space-x-2 ml-6">
                <h4 class="page-title font-semibold text-xl">{{ __('Create New Admin') }}</h4>
                <span class="text-gray-500">/</span>
                <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800">{{ __('Dashboard') }}</a>
                <span class="text-gray-500">/</span>
                <span>{{ __('Create Admin') }}</span>
            </div>
        </div>
    </div>
    <!-- Page Title Area End -->

    <!-- Main Content -->
    <div class="main-content-inner flex justify-center mt-5">
        <!-- DaisyUI Card -->
        <div class="card bg-base-100 w-full max-w-6xl shadow-xl dark:bg-gray-800 dark:text-gray-200">
            <div class="card-body">
                <!-- Header Section -->
                <div class="flex justify-between items-center mb-6">
                    <h4 class="header-title font-semibold text-xl">{{ __('Create New Admin') }}</h4>
                    <a href="{{ route('admin.admins.index') }}" class="btn btn-accent">{{ __('Back to Admins') }}</a>
                </div>

                <!-- Form Start -->
                <form wire:submit.prevent="store">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Admin Name -->
                        <div class="form-group">
                            <label for="name">{{ __('Admin Name') }}</label>
                            <input type="text" class="input input-bordered w-full {{ $errors->has('name') ? 'input-error' : '' }} bg-white dark:bg-gray-700 dark:text-gray-200" id="name" wire:model="name" placeholder="Enter Name" autofocus>
                            @error('name') 
                            <span class="text-red-500 text-sm">{{ $message }}</span> 
                            @enderror
                        </div>

                        <!-- Admin Email -->
                        <div class="form-group">
                            <label for="email">{{ __('Admin Email') }}</label>
                            <input type="email" class="input input-bordered w-full {{ $errors->has('email') ? 'input-error' : '' }} bg-white dark:bg-gray-700 dark:text-gray-200" id="email" wire:model="email" placeholder="Enter Email">
                            @error('email') 
                            <span class="text-red-500 text-sm">{{ $message }}</span> 
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="password">{{ __('Password') }}</label>
                            <input type="password" class="input input-bordered w-full {{ $errors->has('password') ? 'input-error' : '' }} bg-white dark:bg-gray-700 dark:text-gray-200" id="password" wire:model="password" placeholder="Enter Password">
                            @error('password') 
                            <span class="text-red-500 text-sm">{{ $message }}</span> 
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                            <input type="password" class="input input-bordered w-full {{ $errors->has('password_confirmation') ? 'input-error' : '' }} bg-white dark:bg-gray-700 dark:text-gray-200" id="password_confirmation" wire:model="password_confirmation" placeholder="Confirm Password">
                            @error('password_confirmation') 
                            <span class="text-red-500 text-sm">{{ $message }}</span> 
                            @enderror
                        </div>

                        <!-- Assign Roles Dropdown -->
                        <div class="form-group">
                            <label for="roles">{{ __('Assign Roles') }}</label>
                            <div x-data="{ open: false, selectedRole: '{{ $roles[0] ?? '' }}' }" class="relative">
                                <!-- Button -->
                                <button type="button" class="select select-bordered w-full bg-white dark:bg-gray-700 dark:text-gray-200 {{ $errors->has('roles') ? 'input-error' : '' }}" @click="open = !open">
                                    <span x-show="!selectedRole">{{ __('Select Role') }}</span>
                                    <span x-show="selectedRole" x-text="selectedRole"></span>
                                </button>
                        
                                <!-- Dropdown List -->
                                <ul x-show="open" @click.outside="open = false" class="absolute bg-white dark:bg-gray-700 dark:text-gray-200 shadow-lg w-full mt-2 rounded-md z-10 max-h-48 overflow-auto">
                                    @foreach ($availableRoles as $role)
                                        <li>
                                            <button type="button" class="block w-full text-left p-2 hover:bg-gray-100 dark:hover:bg-gray-600" @click="selectedRole = '{{ $role->name }}'; open = false; $wire.set('roles', selectedRole)">
                                                {{ $role->name }}
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            @error('roles') 
                                <span class="text-red-500 text-sm">{{ $message }}</span> 
                            @enderror
                        </div>

                        <!-- Admin Username -->
                        <div class="form-group">
                            <label for="username">{{ __('Admin Username') }}</label>
                            <input type="text" class="input input-bordered w-full {{ $errors->has('username') ? 'input-error' : '' }} bg-white dark:bg-gray-700 dark:text-gray-200" id="username" wire:model="username" placeholder="Enter Username">
                            @error('username') <span class="text-error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end gap-4 mt-6">
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                        <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    </div>
                </form>
                <!-- Form End -->
            </div>
        </div>
    </div>
</div>
