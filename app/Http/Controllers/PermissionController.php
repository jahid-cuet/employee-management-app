<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Inertia\Inertia;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    //This method will show Permission page
public function index() {
    $permissions = Permission::orderBy('created_at','ASC')->get();

    return Inertia::render('permissions/Index', [
        'permissions' => $permissions
    ]);
}

    //This method will show Create Permission page
    public function create(){
         return Inertia::render('permissions/Create');

    }

    //This method will insert a Permission in DB
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|unique:permissions|min:3',
    ]);
    Permission::create([
        'name' => $validated['name'],
    ]);
return redirect()->route('permission.index')->with('success', 'Permission added successfully!');

}


    //This method will show edit Permission page
public function edit(Permission $permission)
{
    return inertia('permissions/Edit', [
        'permission' => $permission
    ]);
}

    //This method will show Update Permission in DB
public function update(Request $request, Permission $permission)
{
    $request->validate([
        'name' => 'required|min:3|unique:permissions,name,' . $permission->id
    ]);

    $permission->update([
        'name' => $request->name
    ]);

    return redirect()->route('permissions.index')
        ->with('success', 'Permission updated successfully!');
}


public function destroy(Permission $permission)
{
    $permission->delete();

    return redirect()->route('permissions.index')
        ->with('success', 'Permission deleted successfully!');
}

}
