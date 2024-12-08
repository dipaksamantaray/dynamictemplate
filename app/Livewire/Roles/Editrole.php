<?php
namespace App\Livewire\Roles;

use Livewire\Component;
use App\Models\Role;

class Editrole extends Component
{
    public $role;
    public $name;
    public $permissions = [];

    // Initialize the component
    public function mount($roleId)
    {
        $this->role = Role::findOrFail($roleId);
        $this->name = $this->role->name;
        $this->permissions = $this->role->permissions->pluck('id')->toArray(); // Assuming the role has permissions
    }

    // Save changes
    public function update()
    {
        $this->role->update(['name' => $this->name]);
        $this->role->syncPermissions($this->permissions);
        
        session()->flash('success', 'Role updated successfully.');
        return redirect()->route('roles.index');
    }

    public function render()
    {
        return view('livewire.roles.editrole');
    }
}
