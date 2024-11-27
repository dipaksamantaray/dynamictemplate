<?php

// app/Http/Livewire/EditCustomer.php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Customer;

class EditCustomer extends Component
{
    public $customerId;
    public $name;
    public $email;
    public $mobile;

    public function mount($customerId)
    {
        $customer = Customer::find($customerId);
        $this->customerId = $customer->id;
        $this->name = $customer->name;
        $this->email = $customer->email;
        $this->mobile = $customer->mobile;
    }

    public function updateCustomer()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|string|max:20',
        ]);

        $customer = Customer::find($this->customerId);
        $customer->update([
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
        ]);

        session()->flash('message', 'Customer updated successfully!');
        return redirect()->route('customers.view'); // Or wherever you want to redirect
    }

    public function render()
    {
        return view('livewire.edit-customer');
    }
}
