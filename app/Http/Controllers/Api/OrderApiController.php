<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderApiController extends Controller
{
    /**
     * Display a listing of the authenticated client's purchases.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Retrieve orders associated with the logged-in customer user token
        $orders = Order::where('user_id', $user->id)
                       ->latest()
                       ->get();

        return response()->json([
            'status' => 'success',
            'count' => $orders->count(),
            'data' => $orders
        ], 200);
    }

    /**
     * Store a newly created order execution ticket within the dataset.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'total_price' => ['required', 'numeric', 'min:0'],
            'items_summary' => ['required', 'string', 'max:500'], // e.g., "2x Pepperoni Pizza, 1x Coca Cola"
            'notes' => ['nullable', 'string', 'max:255'],
        ]);

        // Formulate standard default 'pending' order parameters
        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => $validated['total_price'],
            'total_amount' => $validated['total_price'],
            'items_summary' => $validated['items_summary'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending', // Will trigger "Preparing" badge on your dashboard view
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Your food kitchen order ticket has been successfully registered!',
            'data' => $order
        ], 201);
    }

    /**
     * Fetch explicit profile statuses for an explicit item transaction code.
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();
        
        $order = Order::where('id', $id)
                      ->where('user_id', $user->id)
                      ->first();

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order document entry not found or unauthorized access.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $order
        ], 200);
    }
}
