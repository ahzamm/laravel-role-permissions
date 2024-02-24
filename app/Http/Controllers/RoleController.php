<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function createRole(Request $request)
    {
        if (!Auth::user()->hasRole('admin')) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'permissions' => 'required|array',
            'permissions.*' => 'required|string',
        ]);

        $validator->after(function ($validator) use ($request) {
            $missingPermissions = collect($request->permissions)->filter(function ($permission) {
                return !Permission::where('name', $permission)->exists();
            });

            if ($missingPermissions->isNotEmpty()) {
                $validator->errors()->add('permissions', 'The following permissions do not exist: ' . $missingPermissions->implode(', '));
            }
        });

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            DB::beginTransaction();

            $role = Role::create(['name' => $request->name]);

            $permissions = Permission::whereIn('name', $request->permissions)
                ->where('guard_name', 'sanctum')
                ->get();

            $role->syncPermissions($permissions);

            DB::commit();

            return response()->json(['message' => 'Role added successfully']);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['error' => 'Failed to create role: ' . $e->getMessage()], 500);
        }
    }

    public function listRoles()
    {
        if (!Auth::user()->hasRole('admin')) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        return Role::get()->pluck('name');
    }
}
