<div>
    <form method="POST" action="{{ route('tenants.store') }}">
        @csrf  <!-- Laravel CSRF protection -->
        
        <div>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" wire:model="name">
            @error('name') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" wire:model="email">
            @error('email') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" wire:model="password">
            @error('password') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" wire:model="password_confirmation">
            @error('password_confirmation') <span class="error">{{ $message }}</span> @enderror
        </div>

        <button type="submit">Register Tenant</button>

        @if(session()->has('message'))
            <div>{{ session('message') }}</div>
        @endif
    </form>
</div>
