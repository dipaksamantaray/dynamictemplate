<?php

declare(strict_types=1);

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Traits\AuthorizationChecker;

class CreateRole extends Component
{
    use AuthorizationChecker; // Ensure the trait is included

    public $name;
    public $permissions = [];
    public $permission_groups;

    // Event listener for permission updates
    protected $listeners = ['permissionsUpdated'];

    public function mount()
    {
        // Check authorization for 'role.create'
        $this->checkAuthorization(auth()->user(), ['role.create']);
        
        $this->permission_groups = User::getpermissionGroups();
    }

    // Toggle all permissions (select/deselect all)
    public function toggleAllPermissions()
    {
        $checkAll = !empty($this->permissions); // Check if permissions are already selected
        $this->permissions = $checkAll ? [] : $this->getAllPermissions(); // Select all or deselect all
        $this->emit('permissionsUpdated'); // Emit event for JS to handle updates
    }

    // Toggle group permissions
    public function toggleGroupPermissions($groupName)
    {
        // Get the current selected permissions in this group
        $groupPermissions = $this->getPermissionsByGroup($groupName);
        
        // Toggle the group permissions
        foreach ($groupPermissions as $permission) {
            if (in_array($permission, $this->permissions)) {
                $this->permissions = array_diff($this->permissions, [$permission]); // Remove permission
            } else {
                $this->permissions[] = $permission; // Add permission
            }
        }
        $this->emit('permissionsUpdated'); // Emit event after toggling
    }

    private function getAllPermissions()
    {
        // Use the imported Spatie Permission model to fetch all permissions
        return Permission::pluck('name')->toArray();
    }

    private function getPermissionsByGroup($groupName)
    {
        // Use the imported Spatie Permission model to fetch permissions by group
        return Permission::where('group', $groupName)->pluck('name')->toArray();
    }

    public function store()
    {
        // Check authorization for 'role.create'
        $this->checkAuthorization(auth()->user(), ['role.create']);

        $data = [
            'name' => $this->name,
            'guard_name' => 'web',
        ];

        Log::info('Role creation data: ', $data);

        // Process Data.
        $role = Role::create($data);

        if (!empty($this->permissions)) {
            $role->syncPermissions($this->permissions);
        }

        session()->flash('success', 'Role has been created.');

        return redirect()->route('admin.roles.index');
    }

    public function render()
    {
        return view('livewire.roles.create-role', [
            'all_permissions' => Permission::all(), // Use Spatie's Permission model
            'permission_groups' => $this->permission_groups,
        ])->layout('layouts.app');
    }

    // Listener to handle permission updates
    public function permissionsUpdated()
    {
        $this->dispatchBrowserEvent('livewire:update');
    }
}
