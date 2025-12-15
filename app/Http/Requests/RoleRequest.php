<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Check if route has a role (update) or not (store)
        $roleId = $this->route('role')?->id;

        return [
            'name' => 'required|min:3|unique:roles,name,' . $roleId,
            'permissions' => 'nullable|array',
        ];
    }
}
