<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleCreate extends Component
{
    public $name;
    public $permission_groups = [];
    public $selected_permissions = [];

    public function mount()
    {
        // Fetch permission groups and their permissions dynamically
        $this->permission_groups = \App\Models\User::getpermissionGroups();
    }

    public function toggleGroupPermissions($groupName)
    {
        $group = collect($this->permission_groups)->firstWhere('name', $groupName);
        $permissions = $group->permissions->pluck('name')->toArray();

        if ($this->isGroupChecked($groupName)) {
            $this->selected_permissions = array_merge($this->selected_permissions, $permissions);
        } else {
            $this->selected_permissions = array_diff($this->selected_permissions, $permissions);
        }
    }

    public function saveRole()
    {
        // Validate inputs
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'selected_permissions' => 'required|array',
        ]);

        // Create the role and assign permissions
        $role = Role::create([
            'name' => $validatedData['name'],
            'guard_name' => 'web', // Use the correct guard name
        ]);

        if (!empty($validatedData['selected_permissions'])) {
            $role->syncPermissions($validatedData['selected_permissions']);
        }

        session()->flash('message', 'Role has been created successfully!');
        return redirect()->route('roles.index'); // Ensure the route is correct
    }

    public function render()
    {
        return view('livewire.role-create');
    }

    private function isGroupChecked($groupName)
    {
        return in_array($groupName, $this->selected_permissions);
    }
}
