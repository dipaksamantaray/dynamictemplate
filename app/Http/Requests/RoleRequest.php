<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
// use Illuminate\Support\Facades\Gate;
class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     if ($this->isMethod('post')) {
    //         // 'role.create' permission for creating a new role
    //         return auth()->user()->can('role.create');
    //     }

    //     if ($this->isMethod('put') || $this->isMethod('patch')) {
    //         // 'role.update' permission for editing an existing role
    //         return auth()->user()->can('role.update');
    //     }

    //     if ($this->isMethod('delete')) {
    //         // 'role.delete' permission for deleting a role
    //         return auth()->user()->can('role.delete');
    //     }
    //     return false;
    // }
    public function authorize(): bool
{
    // Check if the user is authenticated
    if (!auth()->check()) {
        return false;
    }

    // Now check permissions
    if ($this->isMethod('post')) {
        return auth()->user()->can('role.create');
    }

    if ($this->isMethod('put') || $this->isMethod('patch')) {
        return auth()->user()->can('role.update');
    }

    if ($this->isMethod('delete')) {
        return auth()->user()->can('role.delete');
    }

    return false;
}


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $roleId = $this->route('role') ?? 'NULL';
        // dd($roleId);
        return [
          'name' => 'required|max:100|unique:roles,name,' . $roleId,
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'string|exists:permissions,name',
        ];
    }
}
