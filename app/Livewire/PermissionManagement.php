<?php
namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Http\Requests\RoleRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

use Auth;
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
        $this->checkAuthorization(auth()->user(), 'role.view'); 

        $this->permissions = SpatiePermission::all();
    }

    public function render()
    {
      
        $this->checkAuthorization(auth()->user(), 'role.view'); 

        return view('livewire.permission-management')->layout('layouts.app');
    }

    public function deletePermission($id)
    {
        $this->checkAuthorization(auth()->user(), 'role.delete'); 


        SpatiePermission::find($id)->delete();
        // $this->dispatch('toast', 'error', 'Delete was successful!');
        flash()->error('Permission Delted successfully.');
        $this->permissions = SpatiePermission::all(); 
    }

    private function resetForm()
    {
        $this->permissionName = '';
        $this->guardName = 'web'; // Reset guardName to default value
        $this->groupName = '';
        $this->permissionId = null;
        $this->isEditMode = false;
    }
}
