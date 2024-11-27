<?php
// app/Http/Livewire/DeleteCustomer.php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Customer;

class DeleteCustomer extends Component
{
    public $customerId;

    public function deleteCustomer()
    {
        $customer = Customer::find($this->customerId);
        if ($customer) {
            $customer->delete();
            session()->flash('message', 'Customer deleted successfully!');
        }
    }

    public function render()
    {
        return view('livewire.delete-customer');
    }
}
