<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Include the reviews relation matrix summary numbers
        $products = $query->with('category')->withCount('reviews')->withAvg('reviews', 'rating')->latest()->get();

        $products->transform(function($product) {
            $product->image_url = $product->image ? asset('storage/' . $product->image) : null;
            // Round the average rating parameter to 1 decimal place safely (e.g., 4.7 stars)
            $product->average_rating = $product->reviews_avg_rating ? round($product->reviews_avg_rating, 1) : 0.0;
            return $product;
        });

        return response()->json([
            'status' => 'success',
            'count' => $products->count(),
            'data' => $products
        ], 200);
    }

    public function show($id)
    {
        // Load up unique details including explicitly attached feedback reviews
        $product = Product::with(['category', 'reviews.user:id,name'])->withCount('reviews')->withAvg('reviews', 'rating')->find($id);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product record item not found'
            ], 404);
        }

        $product->image_url = $product->image ? asset('storage/' . $product->image) : null;
        $product->average_rating = $product->reviews_avg_rating ? round($product->reviews_avg_rating, 1) : 0.0;

        return response()->json([
            'status' => 'success',
            'data' => $product
        ], 200);
    }
}