<?php
declare(strict_types=1);

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Http\Requests\RoleRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\AuthorizationChecker;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Http\Request;

class AdminsController extends Controller
{
    use AuthorizationChecker;
    /**
     * Display a listing of the resource.
     */
   
    public function index(): Renderable
    {
        $this->checkAuthorization(auth()->user(), ['admin.view']);

        return view('pages.roles.admin.index', [
            'admins' => User::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Renderable
    {
        $this->checkAuthorization(auth()->user(), ['admin.create']);

        return view('pages.roles.admin.create', [
            'roles' => Role::all(),
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    // public function store(AdminRequest $request): RedirectResponse
    public function store(Request $request): RedirectResponse
    {
        // dd($request->all());
        $this->checkAuthorization(auth()->user(), ['admin.create']);

        $admin = new User();
        $admin->name = $request->name;
        // $admin->username = $request->username;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->save();

        if ($request->roles) {
            $admin->assignRole($request->roles);
        }

        session()->flash('success', __('Admin has been created.'));
        return redirect()->route('admin.admins.index');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): Renderable
    {
        $this->checkAuthorization(auth()->user(), ['admin.edit']);

        $admin = User::findOrFail($id);
        return view('pages.roles.admin.edit', [
            'admin' => $admin,
            'roles' => Role::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $this->checkAuthorization(auth()->user(), ['admin.edit']);

        $admin =User::findOrFail($id);
        $admin->name = $request->name;
        $admin->email = $request->email;
        // $admin->username = $request->username;
        if ($request->password) {
            $admin->password = Hash::make($request->password);
        }
        $admin->save();

        $admin->roles()->detach();
        if ($request->roles) {
            $admin->assignRole($request->roles);
        }

        session()->flash('success', 'Admin has been updated.');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
