<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
              // Get the current user ID from route for unique email validation
        $userId = $this->route('user')?->id;
 return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userId,
            'roles' => 'nullable|array', // optional, must be array if provided
            'roles.*' => 'integer|exists:roles,id' // each item must be a valid role ID
        ];
    }
}
