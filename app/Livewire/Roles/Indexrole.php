<?php
namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Traits\AuthorizationChecker;

class Indexrole extends Component
{
    use AuthorizationChecker;

    public $roles;

    public function mount()
    {
        // Authorization check for role.view
        $this->checkAuthorization(auth()->user(), ['role.view']);
        // Fetch roles
        $this->roles = Role::with('permissions')->get();
    }

    // Delete role
    public function deleteRole($roleId)
    {
        $this->checkAuthorization(auth()->user(), ['role.delete']);
        $role = Role::findOrFail($roleId);
        $role->delete();
        $this->roles = Role::with('permissions')->get();  // Refresh the roles after deletion
        session()->flash('message', 'Role deleted successfully!');
    }

    public function render()
    {
        // Authorization check for role.view
        $this->checkAuthorization(auth()->user(), ['role.view']);
        return view('livewire.roles.indexrole')->layout('layouts.app');
    }
}
