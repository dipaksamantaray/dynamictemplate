<div class="w-[80%] mx-auto p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
    <h2 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mb-4">Add Customer</h2>

    @if (session()->has('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="submit">
        <!-- Name Field -->
        <div class="form-control mb-4">
            <label class="label">
                <span class="label-text">Name</span>
            </label>
            <input type="text" wire:model="name" class="input input-bordered w-full" placeholder="Enter name" />
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Email Field -->
        <div class="form-control mb-4">
            <label class="label">
                <span class="label-text">Email</span>
            </label>
            <input type="email" wire:model="email" class="input input-bordered w-full" placeholder="Enter email" />
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Mobile Number Field -->
        <div class="form-control mb-4">
            <label class="label">
                <span class="label-text">Mobile Number</span>
            </label>
            <input type="text" wire:model="mobile" class="input input-bordered w-full" placeholder="Enter mobile number" />
            @error('mobile') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Dropdown Field -->
        <div class="form-control mb-4">
            <label class="label">
                <span class="label-text">Subscription Type</span>
            </label>
            <select wire:model="subscription" class="select select-bordered w-full">
                <option value="">Select Subscription</option>
                <option value="basic">Basic</option>
                <option value="premium">Premium</option>
                <option value="vip">VIP</option>
            </select>
            @error('subscription') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Radio Button Field -->
        <div class="form-control mb-4">
            <label class="label">
                <span class="label-text">Gender</span>
            </label>
            <div class="flex items-center gap-4">
                <label class="inline-flex items-center">
                    <input type="radio" name="gender" wire:model="gender" value="Male" class="radio" />
                    <span class="ml-2">Male</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="gender" wire:model="gender" value="Female" class="radio" />
                    <span class="ml-2">Female</span>
                </label>
            </div>
            @error('gender') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Date Picker Field -->
        <div class="form-control mb-4">
            <label class="label">
                <span class="label-text">Date of Birth</span>
            </label>
            <input type="date" wire:model="dob" class="input input-bordered w-full" />
            @error('dob') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Textarea Field -->
        <div class="form-control mb-4">
            <label class="label">
                <span class="label-text">Additional Information</span>
            </label>
            <textarea wire:model="additional_info" class="textarea textarea-bordered w-full" rows="4" placeholder="Enter additional information or comments"></textarea>
            @error('additional_info') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Checkbox Field (Single-Select Logic) -->
        <div class="form-control mb-4">
            <label class="label">
                <span class="label-text">Preferences</span>
            </label>
            <div class="flex items-center gap-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" wire:model="preferences" value="email_notifications" class="checkbox" />
                    <span class="ml-2">Email Notifications</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="checkbox" wire:model="preferences" value="sms_notifications" class="checkbox" />
                    <span class="ml-2">SMS Notifications</span>
                </label>
            </div>
            @error('preferences') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Submit Button -->
        <div class="form-control">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Handle the checkbox logic to allow only one checkbox to be selected
        const checkboxes = document.querySelectorAll('.checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                // If the checkbox is checked, uncheck others
                if (this.checked) {
                    checkboxes.forEach(otherCheckbox => {
                        if (otherCheckbox !== this) {
                            otherCheckbox.checked = false;
                        }
                    });
                }
            });
        });
    });
</script>
