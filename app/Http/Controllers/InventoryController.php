<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json(['quantity' => $product->quantity]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $request->validate(['quantity' => 'required|integer']);

        $product->quantity = $request->quantity;
        $product->save();

        return response()->json(['quantity' => $product->quantity]);
    }

    public function history($id)
    {
        // Example: Retrieving history from a hypothetical `inventory_transactions` table
        // You would need to implement this according to your application's needs.
        $product = Product::findOrFail($id);
        $history = $product->inventoryTransactions; // Assume `inventoryTransactions` is a defined relationship

        return response()->json($history);
    }
}

