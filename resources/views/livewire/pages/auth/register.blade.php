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
//     public function register(): void
// {
//     $validated = $this->validate([
//         'name' => ['required', 'string', 'max:255'],
//         'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
//         'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
//     ]);

//     // Hash the password before saving
//     $validated['password'] = Hash::make($validated['password']);

//     // Create the user
//     event(new Registered($user = User::create($validated)));

//     // Check if the user has any role
//     if ($user->roles->isEmpty()) {
//         // Logout the user if they have no roles
//         Auth::logout();

//         // Optionally, you can set a flash message or custom message
//         session()->flash('error', 'You are not authorized to login because you have no role.');

//         // Redirect or return a 403 response
//         abort(403, 'Your registraion successfuly but you have  not authorized to login because you have no permission to login please contact to your admin.');
//     }

//     // If the user has roles, log them in
//     Auth::login($user);

//     // Redirect to the dashboard
//     $this->redirect(route('admin.dashboard', absolute: false), navigate: true);
// }


// new reg
// public function register()
// {
//     $validated = $this->validate([
//         'name' => ['required', 'string', 'max:255'],
//         'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
//         'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
//     ]);

//     // Hash the password before saving
//     $validated['password'] = Hash::make($validated['password']);

//     // Create the user in the central database
//     $user = User::create($validated);

//     // Prepare the tenant ID and domain
//     $tenantId = strtolower($user->name) . '_tenant';
//     $domain = 'app.' . strtolower($user->name) . '.com';

//     // Create the tenant in the tenants table
//     $tenant = Tenant::create([
//         'id' => $tenantId,
//         'name' => $user->name,
//         'email' => $user->email,
//         'password' => $user->password,
//         'data' => json_encode(['registered_at' => now()]),
//     ]);

//     // Create the domain for this tenant
//     $tenant->domains()->create([
//         'domain' => $domain,
//     ]);

//     // Initialize the tenant (optional but recommended)
//     tenancy()->initialize($tenant);

//     // Check if the user has any roles
//     if ($user->roles->isEmpty()) {
//         session()->flash('error', 'You are not authorized to log in because you have no role.');
//         Auth::logout();

//         // Use Livewire's redirect() method
//         return $this->redirect(route('login'));
//     }

//     // Log the user in and redirect
//     Auth::login($user);

//     // Use Livewire's redirect() method
//     return $this->redirect(route('admin.dashboard'));
// }

public function register(): void
{
    $validated = $this->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
        'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
    ]);

    // Hash the password before saving
    $validated['password'] = Hash::make($validated['password']);

    // Create the user
    event(new Registered($user = User::create($validated)));

    // Create a tenant for the user using Stancl's Tenancy
    $tenantId = strtolower($validated['name']); // Convert name to lowercase for consistency
    $domain = "app.{$tenantId}"; // Create a subdomain (e.g., app.dipak)

    // Create the tenant
    $tenant = Tenant::create([
        'id' => $tenantId,
         'name' => $validated['name'],  
        'email' => $validated['email'],
        'password' => $validated['password'],
        'data' => [],
    ]);

    // Attach the domain to the tenant
    $tenant->domains()->create([
        'domain' => $domain,
    ]);
    // Check if the user has any role
    if ($user->roles->isEmpty()) {
        // Logout the user if they have no roles
        Auth::logout();

        // Optionally, you can set a flash message or custom message
        session()->flash('error', 'You are not authorized to login because you have no role.');

        // Redirect or return a 403 response
        abort(403, 'Your registration was successful, but you are not authorized to log in because you have no permission. Please contact your admin.');
    }

    // If the user has roles, log them in
    Auth::login($user);

    // Redirect to the dashboard
    $this->redirect(route('admin.dashboard', absolute: false), navigate: true);
}

// end new reg




}; ?>

<div>
    <form wire:submit="register">
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

            <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</div>
