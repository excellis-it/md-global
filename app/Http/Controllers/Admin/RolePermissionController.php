<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class RolePermissionController extends Controller
{
    public function index()
    {

        $users = User::whereHas('roles', function ($query) {
            $query->where('id', '>=', 5); // Only get users whose role ID is >= 5
        })->with('roles.permissions')->get();
        // return $users;
        $roles = Role::where('id', '>=', 5)->with('permissions')->get();
        return view('admin.roles.index', compact('roles', 'users'));
    }

    public function create()
    {
        $permissions = Permission::all(); // Fetch all available permissions
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        try {
            $role = Role::create(['name' => $request->name]);
            $role->syncPermissions($request->permissions);

            // Session::flash('success', 'Role created successfully.');

            return redirect()->route('admin.manage-roles')->with('message', 'Role created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    // Edit Role Page
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    // Update Role
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        try {
            $role->update(['name' => $request->name]);

            $role->syncPermissions($request->permissions ?? []); // If no permissions are selected, remove all

            return redirect()->route('admin.manage-roles')->with('success', 'Role updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    // Delete Role
    public function destroy(Role $role)
    {
        try {
            $role->delete();
            return redirect()->route('admin.manage-roles')->with('success', 'Role deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Cannot delete role: ' . $e->getMessage());
        }
    }

    public function getPermissions(Request $request)
    {
        $role = Role::findOrFail($request->role_id);
        return response()->json($role->permissions);
    }
}
