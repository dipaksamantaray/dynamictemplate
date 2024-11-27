<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (!auth()->check()) {
            return false;
        }
    
        // Now check permissions
        if ($this->isMethod('post')) {
            return auth()->user()->can('admins.create');
        }
    
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            return auth()->user()->can('admins.update');
        }
    
        if ($this->isMethod('delete')) {
            return auth()->user()->can('admins.delete');
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
        return [
            //
        ];
    }
}
