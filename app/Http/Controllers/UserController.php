<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function create()
    {
        return view('table'); 
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::select(['id', 'name', 'email']);
            return DataTables::of($users)
                ->addColumn('actions', function ($row) {
                    $editUrl = route('user.edit', $row->id);
                    $deleteUrl = route('user.destroy', $row->id);

                    return '
                        <a href="' . $editUrl . '" class="text-blue-500 hover:text-blue-700">Edit</a>
                        <a href="javascript:void(0);" data-id="' . $row->id . '" class="text-red-500 hover:text-red-700 ml-3 delete-btn">Delete</a>
                    ';
                })
                ->rawColumns(['actions']) // Ensure HTML is rendered for the actions column
                ->make(true);
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['success' => 'User deleted successfully!']);
    }
}
