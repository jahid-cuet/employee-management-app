<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
        $employeeId = $this->route('employee')?->id;

        return [
            'employee_id' => 'required|unique:employees,employee_id,' . $employeeId,
            'name'        => 'required|string|min:3',
            'email'       => 'required|email|unique:employees,email,' . $employeeId,
            'salary'      => 'required|numeric|min:0',
            'designation' => 'required|string|min:2',
        ];
    }
}
