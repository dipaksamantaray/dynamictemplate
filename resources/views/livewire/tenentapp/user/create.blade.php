<x-app-tenentapp-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tenancy') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- {{ __("You're logged in!") }} --}}
                   
                    {{-- <a class="btn btn-primary" href="{{route('tenants.index')}}">Tenancy</a> --}}
                    
                    <div>
                        <h1>This is the create page</h1>
                        {{-- @livewire('tenant-form') --}}

                        {{-- for simple data save in the datbase --}}

                        <div>
    <form method="POST" action="{{ route('tenants.store') }}">
        @csrf  <!-- Laravel CSRF protection -->
        
        <div>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" 
            {{-- wire:model="name"> --}}
            @error('name') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" 
            {{-- wire:model="email"> --}}
            @error('email') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" 
            {{-- wire:model="password"> --}}
            @error('password') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" 
            {{-- wire:model="password_confirmation"> --}}
            @error('password_confirmation') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="domain_name">Domain Name</label>
            <input type="text" id="domain" name="domain" 
            {{-- wire:model="password_confirmation"> --}}
            @error('domain') <span class="error">{{ $message }}</span> @enderror
        </div>

        <button type="submit">Register Tenant</button>

        @if(session()->has('message'))
            <div>{{ session('message') }}</div>
        @endif
    </form>
</div>


                    </div>
                    

                </div>

            </div>
        </div>
    </div>
    
</x-app-tenentapp-layout>
