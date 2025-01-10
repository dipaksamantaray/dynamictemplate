<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Tenant;
use Illuminate\Support\Facades\Hash;

class TenantForm extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    // Validation rules
    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:tenants,email',
        'password' => 'required|string|min:8|confirmed',  // password confirmation
    ];

    // Handle the form submission
    public function submit()
    {
        // Validate the form fields
        $validatedData = $this->validate();

        // Password hash
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Create the tenant
        Tenant::create($validatedData);

        // Flash success message and reset the form fields
        session()->flash('message', 'Tenant registered successfully.');
        $this->reset(['name', 'email', 'password', 'password_confirmation']);
    }

    public function render()
    {
        return view('livewire.tenant-form');
    }
}
