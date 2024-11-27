<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleEdit extends Component
{
    public $roleId;
    public $roleName;
    public $allPermissions; // All permissions
    public $permissionGroups; // Grouped permissions
    public $selectedPermissions = []; // Currently selected permissions

    public function mount($roleId)
    {
        // Load the role
        $role = Role::findOrFail($roleId);
        // dd($role);
        $this->roleId = $role->id;
        $this->roleName = $role->name;

        // Fetch all permissions
        $this->allPermissions = Permission::all();

        // Group permissions by 'group_name' column (ensure this column exists in your database)
        $this->permissionGroups = $this->allPermissions->groupBy('group_name');

        // Fetch currently assigned permissions
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
    }

    public function toggleSelectAll()
    {
        // Select/Deselect all permissions
        if (count($this->selectedPermissions) === $this->allPermissions->count()) {
            $this->selectedPermissions = [];
        } else {
            $this->selectedPermissions = $this->allPermissions->pluck('name')->toArray();
        }
    }

    public function toggleGroup($groupName)
    {
        $groupPermissions = $this->permissionGroups[$groupName]->pluck('name')->toArray();

        // If all permissions in the group are selected, deselect them; otherwise, select them
        if (count(array_intersect($this->selectedPermissions, $groupPermissions)) === count($groupPermissions)) {
            $this->selectedPermissions = array_diff($this->selectedPermissions, $groupPermissions);
        } else {
            $this->selectedPermissions = array_merge($this->selectedPermissions, $groupPermissions);
        }
    }

    public function update()
    {
        // Validate the input
        $this->validate([
            'roleName' => 'required|max:255',
            'selectedPermissions' => 'required|array|min:1',
        ]);

        // Update the role
        $role = Role::findOrFail($this->roleId);
        // dd($role);
        $role->update(['name' => $this->roleName]);

        // Sync the permissions
        $role->syncPermissions($this->selectedPermissions);

        // Notify the user
        session()->flash('success', 'Role updated successfully.');

        // Redirect to the roles list
        return redirect()->route('admin.roles.index');
    }

    public function render()
    {
        dd("hello");
        return view('livewire.role-edit');
    }
}
