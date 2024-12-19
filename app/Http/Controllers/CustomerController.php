<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Exports\CustomersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CustomersImport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function create(Request $request){
return view('customers');
     }
    public function index(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $customers = Customer::query();

            return DataTables::of($customers)
                ->addColumn('actions', function ($row) {
                    // Define URLs for Edit and Delete actions
                    $editUrl = route('customers.edit', $row->id);
                    $deleteUrl = route('customers.destroy', $row->id);

                    // Return HTML for buttons
                    return '
                        <a href="' . $editUrl . '" class="text-blue-500 hover:text-blue-700">Edit</a>
                        <a href="javascript:void(0);" data-id="' . $row->id . '" class="text-red-500 hover:text-red-700 ml-3 delete-btn">Delete</a>
                    ';
                })
                ->rawColumns(['actions']) // Ensure HTML is rendered for the actions column
                ->make(true);
        }
    }

    /**
     * Show the customer listing page (though no view part here as per request).
     */
    public function view()
    {
        // Return the Blade view directly in the routes
        return view('customers.show');
    }

    /**
     * Delete a customer.
     */
    public function destroy($id)
    {
        // Find and delete the customer
        $customer = Customer::findOrFail($id);
        $customer->delete();

        // Return success response after deletion
        return response()->json(['success' => 'Customer deleted successfully']);
    }

    /**
     * Edit a customer (future functionality).
     */
    public function edit($id)
    {
        // Example: Can show edit form
        $customer = Customer::findOrFail($id);
        return view('customers.edit', compact('customer'));
    }
    



public function update(Request $request, $id)
{
    // Validate the incoming request data
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:customers,email,' . $id,
        'mobile' => 'required|string|max:15',
    ]);

    // Find the customer by ID
    $customer = Customer::findOrFail($id);

    // Update customer data
    $customer->name = $request->input('name');
    $customer->email = $request->input('email');
    $customer->mobile = $request->input('mobile');

    // Save the updated customer
    $customer->save();

    // Redirect to the 'customers.view' route
    return redirect()->route('customers.view')->with('success', 'Customer updated successfully');
}

// public function import(Request $request)
// {
//     $request->validate([
//         'file' => 'required|file|mimes:xlsx,xls',
//     ]);

//     Excel::import(new CustomersImport, $request->file('file'));

//     return redirect()->route('customers.index')->with('success', 'File imported successfully!');
// }
// public function import(Request $request)
// {

//     // dd($request->file('file'));
//     // Validate the file
//     $request->validate([
//         'file' => 'required|file|mimes:xlsx,xls',
//     ]);

//     // Import the file using the import class
//     Excel::import(new CustomersImport, $request->file('file'));

//     // Return a success message
//     return redirect()->route('customers.index')->with('success', 'File imported successfully!');
// }


// public function export()
// {
//     // Generate the download response without dd()
//     return Excel::download(new CustomersExport, 'customers.xlsx');
// }



    
}
