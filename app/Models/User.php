<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'contact',
        'email',
        'username',
        'password',
        'address',
        'name',  // Added this to prevent errors with default Laravel logic
        'email', // Added this as a backup
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Disable timestamp requirement if your table doesn't have created_at/updated_at
     * If you still get errors, uncomment the line below:
     */
    // public $timestamps = false;
public function updateProfile(Request $request) {
    // Find user by ID sent from Flutter
    $user = User::find($request->id);

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    // Update only the allowed fields
    $user->update($request->only(['first_name', 'last_name', 'email', 'contact']));

    return response()->json([
        'message' => 'Profile updated successfully',
        'user' => $user
    ], 200);
}
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
