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

    public function login(): void
    {
        // Step 1: Validate the form data
        $credentials = $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Step 2: Ensure the user is not rate-limited
        $this->ensureIsNotRateLimited();

        // Step 3: Attempt to authenticate the user
        if (Auth::attempt($credentials, $this->remember)) {
            $user = Auth::user();

            // Step 4: Check if the user's email is verified
            if (!$user->hasVerifiedEmail()) {
                // Log the user out
                Auth::logout();

                // Invalidate and regenerate the session to prevent persistence
                request()->session()->invalidate();
                request()->session()->regenerateToken();

                // Redirect to the email verification notice page
                $this->redirect(route('verification.notice'));

                return; // Prevent further execution
            }

            // Step 5: Redirect to the dashboard after successful login
            $this->redirect(route('dashboard'));

            return;
        }

        // Step 6: Handle failed login attempt
        $this->addError('email', __('These credentials do not match our records.'));
    }

    /**
     * Ensure the authentication request is not rate-limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
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
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }
}
