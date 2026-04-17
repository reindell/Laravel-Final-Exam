<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // UPDATE PROFILE: Now handles name, email, contact, and address
    public function updateProfile(Request $request) {
        $user = User::find($request->id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->update([
            'first_name' => $request->first_name ?? $user->first_name,
            'last_name'  => $request->last_name ?? $user->last_name,
            'username'       => ($request->first_name . ' ' . $request->last_name) ?? $user->username,
            'email'      => $request->email ?? $user->email,
            'contact'    => $request->contact ?? $user->contact,
            'address'    => $request->address ?? $user->address,
        ]);

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user
        ], 200);
    }
}
