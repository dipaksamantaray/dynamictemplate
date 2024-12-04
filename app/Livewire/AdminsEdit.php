<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Http\Requests\RoleRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\AuthorizationChecker;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminsEdit extends Component
{
    use AuthorizationChecker;

    public $admin;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $roles = [];
    public $availableRoles;

    // Mount the data (instead of adminId, use the injected admin)
    public function mount(User $admin)
    {
        $this->checkAuthorization(auth()->user(), ['admin.edit']);

        // You can directly access the $admin parameter
        $this->admin = $admin;
        $this->name = $admin->name;
        $this->email = $admin->email;
        $this->roles = $admin->roles->pluck('name')->toArray();
        $this->availableRoles = Role::all(); 
    }

    // Update the admin data
    public function update()
    {
        $this->checkAuthorization(auth()->user(), ['admin.edit']);

        // Validate the input data
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->admin->id,
            'password' => 'nullable|min:8|confirmed',
            'roles' => 'array|required'
        ]);

        // Update the admin's data
        $this->admin->name = $this->name;
        $this->admin->email = $this->email;

        // Update password if provided
        if ($this->password) {
            $this->admin->password = Hash::make($this->password);
        }

        $this->admin->save();

        // Sync roles
        $this->admin->syncRoles($this->roles);

        flash()->success('Permission Upadted successfully.');
        return redirect()->route('admin.admins.index'); 
    }

    public function render()
    {
        $this->checkAuthorization(auth()->user(), ['admin.edit']);

        return view('livewire.admins-edit')->layout('layouts.app');
    }
}
