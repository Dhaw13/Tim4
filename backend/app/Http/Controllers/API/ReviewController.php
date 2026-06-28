<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('user:id,name')
            ->where('is_visible', true)
            ->latest()
            ->get()
            ->map(fn ($review) => $this->format($review));

        return response()->json([
            'success' => true,
            'data'    => $reviews,
        ]);
    }

    public function show($id)
    {
        $review = Review::with('user:id,name')->findOrFail($id);

        if (!$review->is_visible) {
            return response()->json([
                'success' => false,
                'message' => 'Review tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $this->format($review),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_id'   => 'sometimes|exists:orders,id',
            'rating'     => 'required|integer|min:1|max:5',
            'comment'    => 'required|string|min:10|max:1000',
        ]);

        $review = Review::create([
            'user_id'    => $request->user()->id,
            'product_id' => $validated['product_id'],
            'order_id'   => $validated['order_id'] ?? null,
            'rating'     => $validated['rating'],
            'comment'    => $validated['comment'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review berhasil dikirim',
            'data'    => $this->format($review->load('user:id,name')),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        if ($review->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk mengubah review ini',
            ], 403);
        }

        $validated = $request->validate([
            'rating'  => 'sometimes|integer|min:1|max:5',
            'comment' => 'sometimes|string|min:10|max:1000',
        ]);

        $review->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Review berhasil diupdate',
            'data'    => $this->format($review->load('user:id,name')),
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        if ($review->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk menghapus review ini',
            ], 403);
        }

        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Review berhasil dihapus',
        ]);
    }

    public function productReviews($productId)
    {
        $product = Product::findOrFail($productId);

        $reviews = $product->reviews()
            ->with('user:id,name')
            ->where('is_visible', true)
            ->latest()
            ->get()
            ->map(fn ($review) => $this->format($review));

        return response()->json([
            'success' => true,
            'data'    => [
                'product'      => $product->name,
                'total_review' => $reviews->count(),
                'avg_rating'   => round($reviews->avg('rating'), 1),
                'reviews'      => $reviews,
            ],
        ]);
    }

    private function format(Review $review): array
    {
        return [
            'id'         => $review->id,
            'user_name'  => $review->user->name ?? 'Anonymous',
            'product_id' => $review->product_id,
            'rating'     => $review->rating,
            'comment'    => $review->comment,
            'reply'      => $review->reply,
            'replied_at' => $review->replied_at,
            'created_at' => $review->created_at,
        ];
    }
}
