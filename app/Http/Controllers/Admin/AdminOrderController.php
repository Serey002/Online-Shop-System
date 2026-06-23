<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class AdminOrderController extends Controller
{
    // List all customer orders on the dashboard management view
    public function index()
    {
        // Eager load the user who bought it to prevent N+1 performance bugs
        $orders = Order::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.orders.index', compact('orders'));
    }

    // View specific items inside a single order receipt
    public function show($id)
    {
        // Load the order, along with its specific items and the related products
        $order = Order::with(['user', 'items.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }
}
