<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    // Index page
    public function index()
    {
        return inertia('users/Index', [
            'users' => User::select('id', 'name', 'email')
                           ->with('roles:id,name') // eager load roles
                           ->orderBy('id', 'desc')
                           ->get(),
        ]);
    }

    // Edit roles page
   
public function edit(User $user)
{
    return inertia('users/Edit', [
        'user' => $user->load('roles'), // load assigned roles
        'roles' => Role::select('id','name')->get(), // all roles
    ]);
}

public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'roles' => 'array'
        ]);

        // Update user info
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
                         ->with('success', 'User updated successfully!');
    }

}