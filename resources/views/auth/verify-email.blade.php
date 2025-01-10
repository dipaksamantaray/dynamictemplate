<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Thank you for signing up! Please verify your email by clicking the link sent to your email address. If you didn’t receive the email, we can send you another one.') }}
    </div>

    @if (session('message'))
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ session('message') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <x-primary-button>
                {{ __('Resend Verification Email') }}
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                {{ __('Logout') }}
            </button>
        </form>
    </div>
</x-guest-layout>
