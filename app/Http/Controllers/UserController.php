<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index()
    {
        return inertia('users/Index', [
            'users' => User::select('id', 'name', 'email')
                           ->with('roles:id,name') // eager load roles
                           ->orderBy('id', 'desc')
                           ->get(),
        ]);
    }
   
public function edit(User $user)
{
    return inertia('users/Edit', [
        'user' => $user->load('roles'), // load assigned roles
        'roles' => Role::select('id','name')->get(), 
    ]);
}

public function update(UserRequest $request, User $user)
    {
       $user->update([
        'name' => $request->name,
        'email' => $request->email,
    ]);

    // Convert role IDs to role names for syncRoles
    $roleNames = Role::whereIn('id', $request->roles ?? [])
                     ->pluck('name')
                     ->toArray();

    $user->syncRoles($roleNames);

    return redirect()->route('users.index')
                     ->with('success', 'Assign user role successfully!');
}
}