<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    /**
     * 📊 Central Dashboard Statistics & Visual Analytics Matrix
     */
    public function dashboard()
    {
        // 1. Fetch Lifetime Total Orders Count
        $totalOrdersCount = Order::count();

        // 2. Calculate Gross Valuation (Sum of all total_price values)
        $grossValuation = Order::sum('total_price');

        // 3. Calculate Current Month's Revenue Earnings
        $monthlyRevenue = Order::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_price');

        // 4. Load Recent Customer Orders with User Relationships Included
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        // 5. Generate Monthly Performance Chart Aggregates Matrix
        // We force LOWERCASE on the month string inside the DB query for absolute matching safety
        $salesData = Order::select(
            DB::raw('sum(total_price) as total'),
            DB::raw("LOWER(DATE_FORMAT(created_at, '%b')) as month_key")
        )
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month_key')
            ->get()
            ->keyBy('month_key');

        $maxSales = $salesData->max('total') ?: 1; 
        $months = collect([]);
        
        // Build chronological list placeholders for the past 6 months
        for ($i = 5; $i >= 0; $i--) {
            $carbonDate = Carbon::now()->subMonths($i);
            // Label is what users see (e.g., "Jun"), key is for matching data arrays safely (e.g., "jun")
            $months->put(strtolower($carbonDate->format('M')), $carbonDate->format('M'));
        }

        $monthlyData = [];
        foreach ($months as $searchKey => $displayLabel) {
            $total = $salesData->has($searchKey) ? $salesData[$searchKey]->total : 0;
            
            $monthlyData[$displayLabel] = [
                'total' => $total,
                'percentage' => min(round(($total / $maxSales) * 100), 100)
            ];
        }

        // Return your main dashboard blade layout page with contextual properties
        return view('admin.dashboard', compact(
            'totalOrdersCount',
            'grossValuation',
            'monthlyRevenue',
            'recentOrders',
            'monthlyData'
        ));
    }

    /**
     * 🛒 List all customer orders on the dedicated management table
     */
   public function index()
    {
        // Eager load the user relationship to protect performance against N+1 loop bugs
        $orders = Order::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * 🔄 Update order status via admin panel
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:preparing,with courier,served & done,cancelled']
        ]);

        $order = Order::findOrFail($id);
        $order->status = $validated['status'];
        $order->save();

        return redirect()->route('admin.orders.index')->with('success', 'Order status updated successfully.');
    }

    /**
     * 🔍 View breakdown items inside a single order checkout ticket
     */
    public function show($id)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }
}