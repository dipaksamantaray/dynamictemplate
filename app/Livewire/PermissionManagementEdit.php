<?php
namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Http\Requests\RoleRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Traits\AuthorizationChecker;
use Auth;

class PermissionManagementEdit extends Component
{
    use AuthorizationChecker;

    public $permissionName;
    public $guardName = 'web';
    public $groupName;
    public $permissionId;

    public function mount($permission)
    {
      
        $this->checkAuthorization(auth()->user(), ['role.edit']);
        $permission = SpatiePermission::findOrFail($permission);
        $this->permissionId = $permission->id;
        $this->permissionName = $permission->name;
        $this->guardName = $permission->guard_name;
        $this->groupName = $permission->group_name;
    }

    public function updatePermission()
    {
        $this->checkAuthorization(auth()->user(), ['role.edit']);

        $this->validate([
            'permissionName' => 'required|unique:permissions,name,' . $this->permissionId,
            'groupName' => 'required|string|max:255',
        ]);

        $permission = SpatiePermission::find($this->permissionId);
        $permission->name = $this->permissionName;
        $permission->guard_name = $this->guardName; // Always 'web'
        $permission->group_name = $this->groupName;
        $permission->save();

        flash()->success('Permission Upadted successfully.');

        
        return redirect()->route('admin.permissions');
    }

    // Render the edit form view
    public function render()
    {
        return view('livewire.permission-management-edit')->layout('layouts.app');
    }
}
