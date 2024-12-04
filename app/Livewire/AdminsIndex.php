<?php
namespace App\Livewire;
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
// use Barryvdh\DomPDF\Facade as PDF;
// use PDF;
use Barryvdh\DomPDF\Facade\Pdf;


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
        $this->checkAuthorization(auth()->user(), ['admin.delete']);
        $admin = User::findOrFail($adminId);
        $admin->delete();
        $this->admins = User::with('roles')->get();
        flash()->warning('Permission Delted successfully.');

        return redirect()->route('admin.admins.index');

    }
    // public function exportAdmins()
    // {
    //     return Excel::download(new AdminsExport, 'admins.xlsx');
    // }
   
    // public function importAdmins()
    // {
    //     // Ensure file is uploaded
    //     $this->validate([
    //         'file' => 'required|mimes:xlsx,csv'
    //     ]);

    //     // Perform the import using Livewire's uploaded file property
    //     Excel::import(new AdminImport, $this->file);

    //     // Flash message to indicate success
    //     session()->flash('message', 'Admins imported successfully!');

    //     // Optionally redirect to another page
    //     return redirect()->route('admin.admins.index');
    // }
    public function exportCSV()
    {
        // Export admins as CSV
        return Excel::download(new AdminsExport, 'admins.csv', \Maatwebsite\Excel\Excel::CSV);
    }


    public function exportPDF()
    {
        $users = ["hello", "hii", "welcome"];
    
        // Ensure UTF-8 encoding for the data
        $data = [
            'title' => mb_convert_encoding('Welcome to ItSolutionStuff.com', 'UTF-8'),
            'date' => date('m/d/Y'),
            'users' => array_map(function($user) {
                return mb_convert_encoding($user, 'UTF-8');
            }, $users),
        ];
    
        try {
            // Generate the PDF with encoding options
            $pdf = PDF::loadView('admins.pdf', $data)
                      ->setOption('isHtml5ParserEnabled', true)
                      ->setOption('isPhpEnabled', true)
                      ->setOption('encoding', 'UTF-8');
    
            return $pdf->download('itsolutionstuff.pdf');
        } catch (\Exception $e) {
            // Handle the error gracefully
            return response()->json(['error' => 'PDF generation failed: ' . $e->getMessage()]);
        }
    }
    
    
    public function render()
    {
        $this->checkAuthorization(auth()->user(), ['admin.view']);

        return view('livewire.admins-index')->layout('layouts.app');
    }
}
