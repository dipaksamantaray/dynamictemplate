<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\RoleRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use App\Traits\AuthorizationChecker;

class RolesController extends Controller
{
    use AuthorizationChecker; // Add this line

    /**
     * Display a listing of the resource.
     */
    public function index(): Renderable
    {
     
        $this->checkAuthorization(auth()->user(), ['role.view']); 

        return view('livewire.index', [
            'roles' => Role::all(),
           
        ]);
    }
 
    public function create(): Renderable
    {
        $this->checkAuthorization(auth()->user(), ['role.create']);

        return view('pages.roles.create', [
            'all_permissions' => Permission::all(),
            'permission_groups' => User::getpermissionGroups(),
        ]);
    }



  
     public function store(RoleRequest $request): RedirectResponse
    {
        // dd($request->all());
        $this->checkAuthorization(auth()->user(), ['role.create']);
        Log::info('Role creation data: ', $request->all());

        // Process Data.
        $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);

        // $role = DB::table('roles')->where('name', $request->name)->first();
        $permissions = $request->input('permissions');

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }

        session()->flash('success', 'Role has been created.');
        return redirect()->route('admin.roles.index');
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): Renderable|RedirectResponse
    {
        $this->checkAuthorization(auth()->user(), ['role.edit']); 

        $role = Role::findById($id, 'web');
        if (!$role) {
            session()->flash('error', 'Role not found.');
            return back();
        }

        // return view('livewire.role-edit', [
            return view('pages.roles.edit', [

            'role' => $role,
            'all_permissions' => Permission::all(),
            'permission_groups' => User::getpermissionGroups(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $this->checkAuthorization(auth()->user(), ['role.edit']); // Using the trait method

        $role = Role::findById($id, 'web');
        if (!$role) {
            session()->flash('error', 'Role not found.');
            return back();
        }

        $permissions = $request->input('permissions');
        if (!empty($permissions)) {
            $role->name = $request->name;
            $role->save();
            $role->syncPermissions($permissions);
        }

        session()->flash('success', 'Role has been updated.');
        return redirect(route('admin.roles.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->checkAuthorization(auth()->user(), ['role.delete']); 

        $role = Role::findById($id, 'web');
        if (!$role) {
            session()->flash('error', 'Role not found.');
            return back();
        }

        $role->delete();
        session()->flash('success', 'Role has been deleted.');
        return redirect()->route('admin.roles.index');
    }
}