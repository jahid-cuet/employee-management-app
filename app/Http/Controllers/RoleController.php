<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        return inertia('roles/Index', [
            'roles' => Role::select('id', 'name')
                ->with(['permissions:id,name'])
                ->orderBy('id', 'desc')
                ->get(),
        ]);
    }

    public function create()
    {
        return inertia('roles/Create', [
            'permissions' => Permission::select('id', 'name')->get(),
        ]);
    }

    public function store(RoleRequest $request)
    {
        $role = Role::create(['name' => $request->name]);

        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('roles.index')
            ->with('success', 'Role created successfully!');
    }

    public function edit(Role $role)
    {
        return inertia('roles/Edit', [
            'role' => $role->load('permissions:id,name'), // current permissions
            'permissions' => Permission::select('id', 'name')->get(), // all permissions
        ]);
    }

    public function update(RoleRequest $request, Role $role)
    {
        $role->update(['name' => $request->name]);

        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully!');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully!');
    }
}
