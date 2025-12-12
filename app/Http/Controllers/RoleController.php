<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

public function store(Request $request)

{
    $request->validate([
        'name' => 'required|unique:roles,name|min:3',
        'permissions' => 'array'
    ]);

    $role = Role::create(['name' => $request->name]);

    if ($request->permissions) {
        $role->syncPermissions($request->permissions);
    }

    return redirect()->route('roles.index')
        ->with('success', 'Role created successfully!');
}



public function edit(Role $role)
{
    return inertia('roles/Edit', [
        'role' => $role->load('permissions:id,name'), // current permissions
        'permissions' => Permission::select('id','name')->get(), // all permissions
    ]);
}

  public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'array',
        ]);

        // Update role name
        $role->update(['name' => $request->name]);

        // Sync permissions directly by IDs
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
