<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class UserController extends Controller
{
    //

    public function create()
    {
        // Get roles where ID is greater than or equal to 5
        $roles = Role::where('id', '>=', 5)->get();
        return view('admin.manage-users.create', compact('roles'));
    }


    public function store(Request $request)
    {
        // Validate input
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'status' => 'required|boolean',
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // Check validation
        // if (!$validate) {
        //     return redirect()->back()->withInput()->with('error', 'Please fillup all fields!');
        // }

        $count = User::where('email', $request->email)->count();
        if ($count > 0) {
            return redirect()->back()->with('error', 'Email already exists');
        } else {

            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'status' => $request->status,
            ]);

            // Assign the role to the user
            $role = Role::findOrFail($request->role_id);
            $user->roles()->attach($role);

            // Attach permissions if selected
            // if ($request->permissions) {
            //     $user->permissions()->sync($request->permissions);
            // }

            return redirect()->route('admin.manage-roles')->with('message', 'User created successfully!');
        }
    }


    // Show the form for editing a user
    public function edit($id)
    {
        // Get user by id along with roles
        $user = User::with('roles')->findOrFail($id);
        // Get roles with id >= 5
        $roles = Role::where('id', '>=', 5)->get();

        return view('admin.manage-users.edit', compact('user', 'roles'));
    }

    // Update the specified user
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|confirmed|min:6',
            'status' => 'required|in:0,1',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($id);

        // Update user details
        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = $request->status;

        // Update password if provided
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        // Sync role
        $user->roles()->sync([$request->role_id]);

        $user->save();

        return redirect()->route('admin.manage-roles')->with('message', 'User updated successfully.');
    }
}
