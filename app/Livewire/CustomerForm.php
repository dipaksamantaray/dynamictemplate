<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;
use Auth;
class CustomerForm extends Component
{
    public $name, $email, $mobile,$subscription, $gender, $dob, $additional_info, $preferences = [];

    // Method to handle form submission
    public function submit()
    {
        // Validate input data
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|string|max:15',
            'subscription' => 'required|string|max:10', // Assuming subscription has specific options
            'gender' => 'required|string|max:6',
            'dob' => 'required|date',
            'additional_info' => 'nullable|string|max:500',
            'preferences' => 'nullable|array',
        ]);

        // Logic to store customer data
        Customer::create([
            'user_id'=> Auth::user()->id,
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'subscription' => $this->subscription,
            'gender' => $this->gender,
            'dob' => $this->dob,
            'additional_info' => $this->additional_info,
            'preferences' => json_encode($this->preferences),
        ]);
        // dd(Auth::user()->id);

        // Success message after form submission
        session()->flash('success', 'Customer added successfully!');

        // Reset form fields after successful submission
        $this->reset();
    }

    public function render()
    {
        return view('livewire.customer-form');
    }
}
