<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // REGISTER
    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'contact' => 'required|string',
            'username' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'contact' => $validated['contact'],
            'username' => $validated['username'],
            'password' => bcrypt($validated['password']),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User Registered Successfully',
            'user' => $user
        ], 200);
    }

  
}
