<?php
namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission as SpatiePermission;
// use App\Traits\AuthorizationChecker;

class PermissionManagementCreate extends Component
{
    // use AuthorizationChecker;

    public $permissionName;
    public $guardName = 'web';
    public $groupName;

    public function render()
    {
        return view('livewire.permission-management-create')->layout('layouts.app');
    }

    public function createPermission()
    {
        // $this->checkAuthorization(auth()->user(), ['permission.create']); 

        $this->validate([
            'permissionName' => 'required|unique:permissions,name',
            'groupName' => 'nullable|string|max:255',
        ]);

        SpatiePermission::create([
            'name' => $this->permissionName,
            'guard_name' => $this->guardName,
            'group_name' => $this->groupName,
        ]);

        session()->flash('message', 'Permission created successfully!');

        return redirect()->route('admin.permissions'); // Redirect back to the list after creation
    }
}
