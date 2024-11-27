<x-app-layout>
    <div class="max-w-md mx-auto p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
        <h2 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mb-4">Edit Customer</h2>

        <!-- Success message for update -->
        @if (session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('customers.update', $customer->id) }}" method="POST">
            @csrf
            @method('PUT')  <!-- HTTP method override to use PUT for updating -->

            <!-- Name Field -->
            <div class="form-control mb-4">
                <label class="label">
                    <span class="label-text">Name</span>
                </label>
                <input type="text" id="name" name="name" value="{{ $customer->name }}" class="input input-bordered w-full" placeholder="Enter name" />
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Email Field -->
            <div class="form-control mb-4">
                <label class="label">
                    <span class="label-text">Email</span>
                </label>
                <input type="email" id="email" name="email" value="{{ $customer->email }}" class="input input-bordered w-full" placeholder="Enter email" />
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Mobile Number Field -->
            <div class="form-control mb-4">
                <label class="label">
                    <span class="label-text">Mobile Number</span>
                </label>
                <input type="text" id="mobile" name="mobile" value="{{ $customer->mobile }}" class="input input-bordered w-full" placeholder="Enter mobile number" />
                @error('mobile') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Submit Button -->
            <div class="form-control">
                <button type="submit" class="btn btn-primary w-full">Update</button>
            </div>
        </form>
    </div>
</x-app-layout>
