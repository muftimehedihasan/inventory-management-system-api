<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class EcommerceIntegrationController extends Controller
{
    /**
     * Receive orders from an e-commerce platform.
     */
    public function receiveOrder(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'total_price' => 'required|numeric',
            'status' => 'required|string',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric',
        ]);

        $order = Order::create([
            'user_id' => $validatedData['user_id'],
            'total_price' => $validatedData['total_price'],
            'status' => $validatedData['status'],
        ]);

        foreach ($validatedData['items'] as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        return response()->json($order->load('items'), 201);
    }

    /**
     * Sync inventory with an e-commerce platform.
     */
    public function syncInventory()
    {
        $inventory = Product::select('id', 'name', 'quantity')->get();

        // Here you might send this data to the e-commerce platform's API
        // or return it to be consumed by the e-commerce platform

        return response()->json($inventory);
    }
}

