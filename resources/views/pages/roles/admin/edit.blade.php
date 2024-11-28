<x-app-layout>
    <!-- Page title area start -->
    <div class="bg-gray-100 p-4 rounded-lg">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Admin Edit</h1>
                <nav class="text-sm breadcrumbs">
                    <ul>
                        <li><a href="{{ route('admin.dashboard') }}" class="text-blue-500">Dashboard</a></li>
                        <li><a href="{{ route('admin.admins.index') }}" class="text-blue-500">All Admins</a></li>
                        <li class="text-gray-600">Edit Admin - {{ $admin->name }}</li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page title area end -->

    <!-- Main content -->
    <div class="main-content-inner mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h2 class="text-lg font-semibold mb-4">Edit Admin - {{ $admin->name }}</h2>

                        <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST" class="space-y-4">
                            @method('PUT')
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Admin Name</label>
                                    <input type="text" id="name" name="name" placeholder="Enter Name" class="input input-bordered w-full" value="{{ $admin->name }}" required autofocus>
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Admin Email</label>
                                    <input type="email" id="email" name="email" placeholder="Enter Email" class="input input-bordered w-full" value="{{ $admin->email }}" required>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700">Password (Optional)</label>
                                    <input type="password" id="password" name="password" placeholder="Enter Password" class="input input-bordered w-full">
                                </div>
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password (Optional)</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Enter Password" class="input input-bordered w-full">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="roles" class="block text-sm font-medium text-gray-700">Assign Roles</label>
                                    <select name="roles[]" id="roles" class="select select-bordered w-full" required>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}" 
                                                @if($admin->hasRole($role->name)) 
                                                    selected 
                                                @endif>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="username" class="block text-sm font-medium text-gray-700">Admin Username</label>
                                    <input type="text" id="username" name="username" placeholder="Enter Username" class="input input-bordered w-full" value="{{ $admin->username }}" required>
                                </div>
                            </div>

                            <div class="flex items-center space-x-4">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript for DaisyUI Dropdown -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectElement = document.getElementById('roles');
            selectElement.addEventListener('focus', function () {
                this.classList.add('focus:ring', 'focus:ring-blue-300');
            });
            selectElement.addEventListener('blur', function () {
                this.classList.remove('focus:ring', 'focus:ring-blue-300');
            });
        });
    </script>
</x-app-layout>
