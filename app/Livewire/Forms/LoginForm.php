<?php

namespace App\Livewire\Forms;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\User;

class LoginForm extends Form
{

  
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    #[Validate('boolean')]
    public bool $remember = false;

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    // public function authenticate(): void
    // {
    //     $admins = User::with('roles')->get();
      
    //     // foreach()
    //     // dd($request->all());
    //     // dd(request()->all()); 
       
    //     $this->ensureIsNotRateLimited();

    //     if (! Auth::attempt($this->only(['email', 'password']), $this->remember)) {
    //         RateLimiter::hit($this->throttleKey());

    //         throw ValidationException::withMessages([
    //             'form.email' => trans('auth.failed'),
    //         ]);
    //     }

    //     RateLimiter::clear($this->throttleKey());
    // }

//     public function authenticate(): void
// {
//     // Step 1: Ensure the user is not rate-limited
//     $this->ensureIsNotRateLimited();

//     // Step 2: Attempt to authenticate the user with email and password
//     if (! Auth::attempt($this->only(['email', 'password']), $this->remember)) {
//         RateLimiter::hit($this->throttleKey());

//         // Step 3: Throw validation error if login fails
//         throw ValidationException::withMessages([
//             'form.email' => trans('auth.failed'),
//         ]);
//     }

//     // Step 4: Get the authenticated user
//     $user = Auth::user();

//     // Step 5: Load the user's roles (in case they aren't loaded already)
//     $user->load('roles');

//     // Step 6: Check if the user has any roles
//     if ($user->roles->isEmpty()) {
//         // Step 7: If no roles assigned, deny access and throw 403 Forbidden error
//         abort(403, 'You are not authorized to login.');
//     }

//     // Step 8: Clear the rate limiter and allow login if roles exist
//     RateLimiter::clear($this->throttleKey());
// }
// public function authenticate(): void
// {
//     // Step 1: Ensure the user is not rate-limited
//     $this->ensureIsNotRateLimited();

//     // Step 2: Attempt to authenticate the user with email and password
//     if (!Auth::attempt($this->only(['email', 'password']), $this->remember)) {
//         RateLimiter::hit($this->throttleKey());

//         // Step 3: Throw validation error if login fails
//         throw ValidationException::withMessages([
//             'form.email' => trans('auth.failed'),
//         ]);
//     }

//     // Step 4: Get the authenticated user
//     $user = Auth::user();

//     // Step 5: Check if the user's email is verified
//     if (!$user->hasVerifiedEmail()) {
//         // Log out the user
//         Auth::logout();

//         // Return an error message
//         throw ValidationException::withMessages([
//             'form.email' => 'Your email address is not verified. Please verify your email to continue.',
//         ]);
//     }

//     // Step 6: Load the user's roles
//     $user->load('roles');

//     // Step 7: Check if the user has any roles
//     if ($user->roles->isEmpty()) {
//         // Log out the user
//         Auth::logout();

//         // Deny access with a 403 Forbidden error
//         abort(403, 'You are not authorized to login.');
//     }

//     // Step 8: Clear the rate limiter and allow login if all checks pass
//     RateLimiter::clear($this->throttleKey());
// }

public function authenticate(): void
{
    // Step 1: Ensure the user is not rate-limited
    $this->ensureIsNotRateLimited();

    // Step 2: Attempt to authenticate the user with email and password
    if (!Auth::attempt($this->only(['email', 'password']), $this->remember)) {
        RateLimiter::hit($this->throttleKey());

        // Step 3: Throw validation error if login fails
        throw ValidationException::withMessages([
            'form.email' => trans('auth.failed'),
        ]);
    }

    // Step 4: Get the authenticated user
    $user = Auth::user();

    // Step 5: Check if the user's email is verified
    if (!$user->hasVerifiedEmail()) {
        // Log out the user
        $user->sendEmailVerificationNotification();
        Auth::logout();

        // Return an error message
        throw ValidationException::withMessages([
            'form.email' => 'Your email address is not verified. Please check and verify your email to continue to login.',
        ]);
    }

    // Step 6: Load the user's roles
    $user->load('roles');

    // Step 7: Check if the user has any roles
    if ($user->roles->isEmpty()) {
        // Log out the user
        Auth::logout();

        // Deny access with a 403 Forbidden error
        abort(403, 'You are not authorized to login.');
    }

    // Step 8: Clear the rate limiter and allow login if all checks pass
    RateLimiter::clear($this->throttleKey());
}

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'form.email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}