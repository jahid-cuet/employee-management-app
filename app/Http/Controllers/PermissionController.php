<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;

use Inertia\Inertia;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    
public function index() {
    $permissions = Permission::orderBy('created_at','ASC')->get();

    return Inertia::render('permissions/Index', [
        'permissions' => $permissions
    ]);
}

  
    public function create(){
         return Inertia::render('permissions/Create');

    }

public function store(PermissionRequest $request)
{
   
   Permission::create($request->validated());
   return redirect()
   ->route('permissions.index')
   ->with('success', 'Permission added successfully!');

}


public function edit(Permission $permission)
{
    return inertia('permissions/Edit', [
        'permission' => $permission
    ]);
}

    
public function update(PermissionRequest $request, Permission $permission)
{
   $permission->update($request->validated());

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
