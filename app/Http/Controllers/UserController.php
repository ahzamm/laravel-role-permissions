<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // if (!Auth::user()->hasRole('admin')) {
        //     return response()->json(['message' => 'Unauthenticated'], 200);
        // }

        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed',
                'role' => 'required'
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            $role = Role::where('name', $request->role)->where('guard_name', 'sanctum')->first();
            $user->roles()->attach($role);
            $permissions = $role->permissions->where('guard_name', 'sanctum')->pluck('name')->toArray();
            $user->givePermissionTo($permissions);

            $token = $user->createToken('mytoken')->plainTextToken;

            return response([
                'user' => $user,
                'token' => $token
            ], 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()->first()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(),], 500);
        }
    }

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid Credentials']);
        }
        Auth::login($user);
        $token = $user->createToken('mytoken')->plainTextToken;

        return response([
            'user' => $user, 'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken();
        $token->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function logoutFromAllDevices(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }

    public function profile(Request $request)
    {
        $user =  $request->user();

        if ($user->hasRole('admin')) {
            $role = $user->roles->first()->name;
            $permissions = $user->getAllPermissions()->pluck('name')->toArray();

            return response()->json([
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $role,
                    'permissions' => $permissions,
                ]
            ]);
        }
        return response()->json($request->user());
    }

    public function changePassword(Request $request)
    {

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        $user = $request->user();

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['message' => 'wrong old password']);
        }
        $request->user()->tokens()->delete();

        $user->password = Hash::make($request->new_password);
        $user->save();

        $token = $user->createToken('mytoken')->plainTextToken;

        return response()->json(['message' => 'Password changed successfully', 'token' => $token], 200);
    }

    public function adminChangePassword(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required|confirmed',
        ]);

        if (!$request->user()->hasRole('admin')) {
            return response()->json(['message' => 'Unauthenticated'], 200);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->password = Hash::make($request->password);
        $user->save();
        $user->tokens()->delete();

        return response()->json(['message' => 'Password changed successfully'], 200);
    }


    public function adminDeleteUser(Request $request)
    {

        $request->validate([
            'email' => 'required',
        ]);

        if (!$request->user()->hasRole('admin')) {
            return response()->json(['message' => 'Unauthenticated'], 200);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->tokens()->delete();
        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 404);
    }
}
