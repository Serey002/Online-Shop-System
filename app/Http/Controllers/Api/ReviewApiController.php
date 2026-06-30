<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review; // Matches your Review.php model configuration
use Illuminate\Http\Request;

class ReviewApiController extends Controller
{
    /**
     * Get all public client reviews for an individual food item.
     */
    public function getProductReviews($product_id)
    {
        // Pull reviews along with the customer's profile name
        $reviews = Review::where('product_id', $product_id)
                         ->with('user:id,name,image')
                         ->latest()
                         ->get();

        $reviews->transform(function($review) {
            if ($review->user) {
                $review->user->image_url = $review->user->image ? asset('storage/' . $review->user->image) : null;
            }
            return $review;
        });

        return response()->json([
            'status' => 'success',
            'count' => $reviews->count(),
            'data' => $reviews
        ], 200);
    }

    /**
     * Store a client review ticket entry inside the database storage link.
     */
    public function store(Request $request, $productId) // 🔧 FIXED: Accept $productId from the URL routing
    {
        $user = $request->user();

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'], // Forces valid 1-5 star matrix criteria
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        // Prevent duplicated spam reviews by a single user on the same product item if desired
        $existingReview = Review::where('user_id', $user->id)
                                ->where('product_id', $productId) // 🔧 FIXED: Use the URL parameter
                                ->first();

        if ($existingReview) {
            return response()->json([
                'status' => 'error',
                'message' => 'You have already submitted a review score for this item!'
            ], 422);
        }

        $review = Review::create([
            'user_id' => $user->id,
            'product_id' => $productId, // 🔧 FIXED: Use the URL parameter
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Thank you! Your feedback has been published securely.',
            'data' => $review
        ], 201);
    }
}