<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    
    public function __construct()
{
    $this->middleware('auth'); // only authenticated users can access

    // Employee permissions
    $this->middleware('permission:view employees')->only('index');
    $this->middleware('permission:create employees')->only(['create', 'store']);
    $this->middleware('permission:edit employees')->only(['edit', 'update']);
    $this->middleware('permission:delete employees')->only('destroy');
}


    public function index()
    {
        $employees = Employee::latest()->paginate(10);

        return Inertia::render('employees/Index', [
            'employees' => $employees,
        ]);
    }

    public function create()
    {
        return Inertia::render('employees/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|unique:employees',
            'name'        => 'required|min:3',
            'email'       => 'required|email|unique:employees',
            'salary'      => 'required|numeric|min:0',
            'designation' => 'required|min:2',
        ]);

        Employee::create($validated);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee created successfully!');
    }

    public function edit(Employee $employee)
    {
        return Inertia::render('employees/Edit', [
            'employee' => $employee,
        ]);
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'employee_id' => 'required|unique:employees,employee_id,' . $employee->id,
            'name'        => 'required|min:3',
            'email'       => 'required|email|unique:employees,email,' . $employee->id,
            'salary'      => 'required|numeric|min:0',
            'designation' => 'required|min:2',
        ]);

        $employee->update($validated);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee updated successfully!');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee deleted successfully!');
    }
}
