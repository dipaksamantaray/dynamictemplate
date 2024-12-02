<?php
namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Http\Requests\RoleRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use App\Traits\AuthorizationChecker;
use Auth;

// use App\Traits\AuthorizationChecker;

class PermissionManagementCreate extends Component
{
    use AuthorizationChecker;

    public $permissionName;
    public $guardName = 'web';
    public $groupName;

    public function render()
    {
        return view('livewire.permission-management-create')->layout('layouts.app');
    }

    public function createPermission()
    {
        $this->checkAuthorization(auth()->user(), ['role.create']);

        $this->validate([
            'permissionName' => 'required|unique:permissions,name',
            'groupName' => 'nullable|string|max:255',
        ]);

        SpatiePermission::create([
            'name' => $this->permissionName,
            'guard_name' => $this->guardName,
            'group_name' => $this->groupName,
        ]);

        flash()->success('Permission Create successfully.');


        return redirect()->route('admin.permissions');
    }
}
