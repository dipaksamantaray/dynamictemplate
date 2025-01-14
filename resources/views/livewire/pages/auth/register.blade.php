<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Models\Tenant;
// use Stancl\Tenancy\Database\Models\Tenant;
new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    // 


// public function register(): void
// {
//     $validated = $this->validate([
//         'name' => ['required', 'string', 'max:255'],
//         'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
//         'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
//     ]);

//     // Hash the password before saving
//     $validated['password'] = Hash::make($validated['password']);

//     // Create the user
//     // event(new Registered($user = User::create($validated)));
//     $user = User::create($validated);
//     // $user->sendEmailVerificationNotification();
//     $user->assignRole('developer');
//     // Create a tenant for the user using Stancl's Tenancy
//     $tenantId = strtolower($validated['name']); // Convert name to lowercase for consistency
//     $domain = "{$tenantId}.app.localhost"; // Create a subdomain (e.g., app.dipak)

//     // Create the tenant
//     $tenant = Tenant::create([
//         'id' => $tenantId,
//          'name' => $validated['name'],  
//         'email' => $validated['email'],
//         'password' => $validated['password'],
//         'data' => [],
//     ]);

//     // Attach the domain to the tenant
//     $tenant->domains()->create([
//         'domain' => $domain,
//     ]);
//     // Check if the user has any role
//     // if ($user->roles->isEmpty()) {
//     //     // Logout the user if they have no roles
//     //     Auth::logout();

//     //     // Optionally, you can set a flash message or custom message
//     //     session()->flash('error', 'You are not authorized to login because you have no role.');

//     //     // Redirect or return a 403 response
//     //     abort(403, 'please check your email and verify it');
//     // }

//     // If the user has roles, log them in
//     Auth::login($user);

//     // Redirect to the dashboard
//     // $this->redirect(route('admin.dashboard', absolute: false), navigate: true);
//     $this->redirect(route('verification.notice'));

// }

// end new reg
// public function register(): void
// {
//     $validated = $this->validate([
//         'name' => ['required', 'string', 'max:255'],
//         'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
//         'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
//     ]);

//     // Hash the password before saving
//     $validated['password'] = Hash::make($validated['password']);

//     // Create the user
//     $user = User::create($validated);
//     $user->assignRole('developer');

//     // Create a tenant for the user using Stancl's Tenancy
//     $tenantId = strtolower($validated['name']); // Convert name to lowercase for consistency
//     $domain = "{$tenantId}.app.localhost"; // Create a subdomain (e.g., app.dipak)

//     // Create the tenant
//     $tenant = Tenant::create([
//         'id' => $tenantId,
//         'name' => $validated['name'],
//         'email' => $validated['email'],
//         'password' => $validated['password'], // Store hashed password
//         'data' => [],
//     ]);

//     // Attach the domain to the tenant
//     $tenant->domains()->create([
//         'domain' => $domain,
//     ]);

//     // Send the email verification notification
//     $user->sendEmailVerificationNotification();

//     // Log the user in temporarily
//     Auth::login($user);

//     // Immediately check if the email is verified
//     if (!$user->hasVerifiedEmail()) {
//         // Logout the user
//         Auth::logout();

//         // Invalidate the session and regenerate the CSRF token
//         request()->session()->invalidate();
//         request()->session()->regenerateToken();

//         // Redirect to the email verification notice
//         $this->redirect(route('verification.notice'));

//         return; // Prevent further execution
//     }

//     // If the email is verified, redirect to the dashboard or another page
//     $this->redirect(route('dashboard'));
// }

public function register(): void
{
    $validated = $this->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
        'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
    ]);

    $validated['password'] = Hash::make($validated['password']);

    $user = User::create($validated);
    $user->assignRole('developer');

    $tenantId = strtolower($validated['name']);
    $domain = "{$tenantId}.app.localhost";

    $tenant = Tenant::create([
        'id' => $tenantId,
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => $validated['password'],
        'data' => [],
    ]);

    $tenant->domains()->create([
        'domain' => $domain,
    ]);

    // Send email verification notification
    $user->sendEmailVerificationNotification();

    // Log the user in temporarily
    Auth::login($user);

    // Check if the email is verified
    if (!$user->hasVerifiedEmail()) {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        $this->redirect(route('verification.notice'));
        return;
    }

    // Redirect verified users
    $this->redirect(route('dashboard'));
}

// public function register(): void
// {
//     $validated = $this->validate([
//         'name' => ['required', 'string', 'max:255'],
//         'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
//         'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
//     ]);

//     $validated['password'] = Hash::make($validated['password']);

//     // Create the user
//     $user = User::create($validated);
//     $user->assignRole('developer'); // Assign default role

//     // Create a tenant and attach domain
//     $tenantId = strtolower($validated['name']); // Ensure lowercase for consistency
//     $domain = "{$tenantId}.app.localhost"; // Subdomain structure

//     $tenant = Tenant::create([
//         'id' => $tenantId,
//         'name' => $validated['name'],
//         'email' => $validated['email'],
//         'password' => $validated['password'], // Store hashed password
//         'data' => [],
//     ]);

//     $tenant->domains()->create([
//         'domain' => $domain,
//     ]);

//     // Send email verification
//     $user->sendEmailVerificationNotification();

//     // Log the user in
//     Auth::login($user);

//     // Redirect to email verification notice
//     $this->redirect(route('verification.notice'));
// }


}; ?>

<div>
    <form wire:submit.prevent="register">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input wire:model="password" id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Register Button with Loading State -->
        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <!-- Button -->
            <x-primary-button class="ms-4 relative flex justify-center items-center" wire:loading.attr="disabled" style="width: 100px; height: 40px;">
                <!-- Text visible when not loading -->
                <span wire:loading.remove class="absolute">{{ __('Register') }}</span>

                <!-- Loader visible when loading -->
                <span wire:loading class="absolute">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                </span>
            </x-primary-button>
        </div>
    </form>
</div>

