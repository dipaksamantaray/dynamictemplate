<?php
namespace App\Livewire\Admins;
use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\RoleRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\AuthorizationChecker;
use Spatie\Permission\Models\Permission;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AdminsExport;
use App\Imports\AdminImport;
use Livewire\WithFileUploads;
use PDF;



class AdminsIndex extends Component
{
    public $admins;
    use AuthorizationChecker;
    use WithFileUploads;
    public $file;
    public function mount()
    {
        $this->checkAuthorization(auth()->user(), ['admin.view']);
        $this->admins = User::with('roles')->get();
    }

    public function deleteAdmin($adminId)
    {
        $this->checkAuthorization(auth()->user(),['admin.delete']);
        $admin = User::findOrFail($adminId);
        $admin->delete();
        $this->admins = User::with('roles')->get();
        flash()->warning('Admin Delted successfully.');

        return redirect()->route('admin.admins.index');

    }
    
    public function exportCSV()
    {
        
        return Excel::download(new AdminsExport, 'admins.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function exportPDF()
    {
        // Get the data from the database or any static data
        $roles = User::get();
        // dd( $roles);

        $data = [
            'title' => 'Welcome to Admins Portal',
            'date' => date('m/d/Y'),
            'roles' => $roles
        ];

        // Load the view and pass the data
        $pdf = PDF::loadView('PDF.admissionpdf', $data);

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
                'Content-Disposition' => 'attachment; filename="admin.pdf"',
            ]
        );
    }
    
   
    
    public function render()
    {
        $this->checkAuthorization(auth()->user(), ['admin.view']);

        return view('livewire.Admins.admins-index')->layout('layouts.app');
    }
}
