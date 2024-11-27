<x-app-layout>

    <!-- page title area start -->
    <div class="page-title-area">
        <div class="row items-center">
            <div class="col-sm-6">
                <div class="breadcrumbs-area clearfix">
                    <h4 class="page-title">{{ __('Admin Create') }}</h4>
                    <ul class="breadcrumbs">
                        <li><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li><a href="{{ route('admin.admins.index') }}">{{ __('All Admins') }}</a></li>
                        <li><span>{{ __('Create Admin') }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- page title area end -->
    
    <div class="main-content-inner mt-5">
        <div class="row">
            <!-- form start -->
            <div class="col-12">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h4 class="header-title">{{ __('Create New Admin') }}</h4>
                        
                        <form action="{{ route('admin.admins.store') }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="form-group">
                                    <label for="name">{{ __('Admin Name') }}</label>
                                    <input type="text" class="input input-bordered w-full" id="name" name="name" placeholder="Enter Name" required autofocus value="{{ old('name') }}">
                                </div>
    
                                <div class="form-group">
                                    <label for="email">{{ __('Admin Email') }}</label>
                                    <input type="email" class="input input-bordered w-full" id="email" name="email" placeholder="Enter Email" required value="{{ old('email') }}">
                                </div>
    
                                <div class="form-group">
                                    <label for="password">{{ __('Password') }}</label>
                                    <input type="password" class="input input-bordered w-full" id="password" name="password" placeholder="Enter Password" required>
                                </div>
    
                                <div class="form-group">
                                    <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                                    <input type="password" class="input input-bordered w-full" id="password_confirmation" name="password_confirmation" placeholder="Enter Password" required>
                                </div>
    
                                <div class="form-group">
                                    <label for="roles">{{ __('Assign Roles') }}</label>
                                    <!-- Dropdown for roles -->
                                    <div x-data="{ open: false, selectedRole: null }" class="relative">
                                        <button type="button" 
                                            class="select select-bordered w-full" 
                                            @click="open = !open">
                                            <span x-show="!selectedRole">{{ __('Select Role') }}</span>
                                            <span x-show="selectedRole" x-text="selectedRole.name"></span>
                                        </button>
                                        <ul x-show="open" @click.outside="open = false" class="absolute bg-white shadow-lg w-full mt-2 rounded-md z-10">
                                            @foreach ($roles as $role)
                                                <li>
                                                    <button type="button" 
                                                        @click="selectedRole = { name: '{{ $role->name }}', value: '{{ $role->name }}' }; open = false"
                                                        class="block w-full text-left p-2 hover:bg-gray-100">
                                                        {{ $role->name }}
                                                    </button>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <!-- Hidden input to send selected role -->
                                        <input type="hidden" name="roles[]" :value="selectedRole ? selectedRole.value : ''">
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label for="username">{{ __('Admin Username') }}</label>
                                    <input type="text" class="input input-bordered w-full" id="username" name="username" placeholder="Enter Username" required value="{{ old('username') }}">
                                </div>
                            </div>
    
                            <div class="flex justify-end gap-4 mt-6">
                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- form end -->
        </div>
    </div>
    
    </x-app-layout>
    