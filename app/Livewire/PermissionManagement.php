<?php
namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Exports\PermissionsExport;
use App\Http\Requests\RoleRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
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
        flash()->warning('Permission Delted successfully.');
        $this->permissions = SpatiePermission::all(); 
    }
    public function exportCSV()
    {
        return Excel::download(new PermissionsExport, 'permission.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    // permission pdf


    public function exportPDF()
    {
        // Get the data from the database or any static data
        $permissions = SpatiePermission::get();
        // dd( $permissions);

        $data = [
            'title' => 'Welcome to Permission Portal',
            'date' => date('m/d/Y'),
            'permissions' => $permissions
        ];

        // Load the view and pass the data
        $pdf = PDF::loadView('admins.permissionpdf', $data);

        // Generate the PDF and return the content (use output() here)
        $pdfContent = $pdf->output();

        // Return the response with a proper content type to trigger download
        return response()->stream(
            function() use ($pdfContent) {
                echo $pdfContent;
            },
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="permission.pdf"',
            ]
        );
    }
    private function resetForm()
    {
        $this->permissionName = '';
        $this->guardName = 'web';
        $this->groupName = '';
        $this->permissionId = null;
        $this->isEditMode = false;
    }
}
