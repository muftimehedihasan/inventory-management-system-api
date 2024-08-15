<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Generate an inventory status report.
     */
    public function inventory()
    {
        $inventoryReport = Product::select('id', 'name', 'quantity')
            ->get();

        return response()->json($inventoryReport);
    }

    /**
     * Generate a sales report.
     */
    public function sales(Request $request)
    {
        $startDate = $request->input('start_date', now()->subMonth());
        $endDate = $request->input('end_date', now());

        $salesReport = Order::whereBetween('created_at', [$startDate, $endDate])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_price) as total_sales'))
            ->groupBy('date')
            ->get();

        return response()->json($salesReport);
    }

    /**
     * Generate an order report.
     */
    public function orders(Request $request)
    {
        $startDate = $request->input('start_date', now()->subMonth());
        $endDate = $request->input('end_date', now());

        $orderReport = Order::whereBetween('created_at', [$startDate, $endDate])
            ->with('items')
            ->get();

        return response()->json($orderReport);
    }

    /**
     * Generate a report on low-stock items.
     */
    public function lowStock()
    {
        $lowStockReport = Product::where('quantity', '<', 10)
            ->select('id', 'name', 'quantity')
            ->get();

        return response()->json($lowStockReport);
    }
}
