<?php
namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Illuminate\Support\Facades\Session;
use App\Traits\AuthorizationChecker;

class PermissionManagement extends Component
{
    use AuthorizationChecker;
    public $permissions;
    public $permissionName;
    public $guardName = 'web'; 
    public $groupName;
    public $permissionId;
    public $isEditMode = false;

    // Initial load of permissions
    public function mount()
    {
        $this->permissions = SpatiePermission::all();
    }

    // Rendering the component view with a custom layout
    public function render()
    {
        // $this->checkAuthorization(auth()->user(), ['permission.view']); 

        return view('livewire.permission-management')->layout('layouts.app');
    }

    // Create a new permission
    public function createPermission()
    {
        $this->validate([
            'permissionName' => 'required|unique:permissions,name',
            // No need to validate guardName, it's fixed to 'web'
            'groupName' => 'nullable|string|max:255',
        ]);

        SpatiePermission::create([
            'name' => $this->permissionName,
            'guard_name' => $this->guardName, // Always 'web'
            'group_name' => $this->groupName,
        ]);

        Session::flash('message', 'Permission created successfully.');

        $this->resetForm();
        $this->permissions = SpatiePermission::all(); // Refresh list
    }

    // Start editing a permission
    public function editPermission($id)
    {
        // $this->checkAuthorization(auth()->user(), ['permission.edit']); 

        $permission = SpatiePermission::find($id);
        $this->permissionId = $permission->id;
        $this->permissionName = $permission->name;
        $this->guardName = $permission->guard_name; // This will still show the correct guard_name
        $this->groupName = $permission->group_name;
        $this->isEditMode = true;
    }

    // Update the permission
    public function updatePermission()
    {
        // $this->checkAuthorization(auth()->user(), ['permission.edit']); 

        $this->validate([
            'permissionName' => 'required|unique:permissions,name,' . $this->permissionId,
            // No need to validate guardName, it's fixed to 'web'
            'groupName' => 'nullable|string|max:255',
        ]);

        $permission = SpatiePermission::find($this->permissionId);
        $permission->name = $this->permissionName;
        $permission->guard_name = $this->guardName; // Always 'web'
        $permission->group_name = $this->groupName;
        $permission->save();

        Session::flash('message', 'Permission updated successfully.');

        $this->resetForm();
        $this->permissions = SpatiePermission::all(); // Refresh list
    }

    // Delete a permission
    public function deletePermission($id)
    {
        // $this->checkAuthorization(auth()->user(), ['permission.delete']); 

        SpatiePermission::find($id)->delete();
        Session::flash('message', 'Permission deleted successfully.');

        $this->permissions = SpatiePermission::all(); // Refresh list
    }

    // Reset form fields
    private function resetForm()
    {
        $this->permissionName = '';
        $this->guardName = 'web'; // Reset guardName to default value
        $this->groupName = '';
        $this->permissionId = null;
        $this->isEditMode = false;
    }
}
