<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    public function __construct()
    {

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

    public function store(EmployeeRequest $request)
    {
        Employee::create($request->validated());

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

    public function update(EmployeeRequest $request, Employee $employee)
    {
        $employee->update($request->validated());

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
