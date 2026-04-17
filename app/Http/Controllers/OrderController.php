<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // 1. Create the main order record
        $order = Order::create([
            'user_id' => $request->user_id ?? 1, // Fallback to ID 1 for testing
            'status' => 'pending',
            'total_price' => 0 // Calculated below
        ]);

        $total = 0;

        // 2. Loop through the cart items sent from Flutter
        foreach ($request->items as $item) {
            $itemPrice = (float)$item['price'];
            $itemQty = (int)$item['qty'];

            OrderItem::create([
                'order_id' => $order->id,
                'food_name' => $item['name'],
                'quantity' => $itemQty,
                'price' => $itemPrice,
            ]);

            $total += ($itemPrice * $itemQty);
        }

        // 3. Update the final total
        $order->update(['total_price' => $total]);

        return response()->json([
            'message' => 'Order saved successfully!',
            'order_id' => $order->id
        ], 201);
    }
}
