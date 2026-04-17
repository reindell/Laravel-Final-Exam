<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('username', $request->username)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return response()->json(['user' => $user], 200);
    }

    // Fixed Registration
    public function register(Request $request)
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'contact' => $request->contact,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);
        return response()->json(['user' => $user], 201);
    }

    // Fixed Profile Update
    public function updateProfile(Request $request)
    {
        $user = User::find($request->id);
        if (!$user) return response()->json(['message' => 'Not Found'], 404);

        $user->update($request->only(['first_name', 'last_name', 'email', 'contact']));
        return response()->json(['user' => $user], 200);
    }
    public function getFoods()
{
    // This fetches everything from your 'foods' table
    return response()->json(\App\Models\Food::all(), 200);
}
    public function order(Request $request)
    {
        $order = Order::create([
            'user_id' => $request->user_id,
            'total' => $request->total ?? 0,
        ]);

        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'food_id' => $item['food_id'] ?? 1,
                'quantity' => $item['qty'] ?? 1,
                'price' => $item['price'] ?? 0,
            ]);
        }
        return response()->json(['message' => 'Order saved successfully'], 201);
    }
}
