<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function index($order_id)
    {
        $items = OrderItem::where('order_id', $order_id)->get();
        return response()->json($items);
    }

    public function store(Request $request, $order_id)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        $item = new OrderItem($request->all());
        $item->order_id = $order_id;
        $item->save();

        return response()->json($item, 201);
    }

    public function update(Request $request, $order_id, $item_id)
    {
        $item = OrderItem::where('order_id', $order_id)->findOrFail($item_id);
        $request->validate([
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        $item->update($request->all());

        return response()->json($item);
    }

    public function destroy($order_id, $item_id)
    {
        $item = OrderItem::where('order_id', $order_id)->findOrFail($item_id);
        $item->delete();

        return response()->json(['message' => 'Item removed from order']);
    }
}
