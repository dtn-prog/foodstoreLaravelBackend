<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        // Validate the role name, ensuring it is unique
        $request->validate(['name' => 'required|unique:roles']);

        // Create the role
        $role = Role::create(['name' => $request->name]);

        // Assign selected permissions by name
        if ($request->has('permissions')) {
            $role->givePermissionTo($request->permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('name')->toArray(); // Get assigned permission names
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        // Validate the role name, ensuring it is unique
        $request->validate(['name' => 'required|unique:roles,name,' . $role->id]);

        // Update the role name
        $role->update(['name' => $request->name]);

        // Check if permissions were submitted
        if ($request->has('permissions')) {
            // Get the submitted permission names
            $permissionNames = $request->permissions;

            // Sync permissions using names
            $role->syncPermissions($permissionNames);
        } else {
            // If no permissions are submitted, clear all permissions
            $role->syncPermissions([]);
        }

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
