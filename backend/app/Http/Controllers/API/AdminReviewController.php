<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('user:id,name', 'product:id,name')
            ->latest()
            ->get()
            ->map(fn ($review) => [
                'id'          => $review->id,
                'user_name'   => $review->user->name ?? 'Anonymous',
                'product_name' => $review->product->name ?? 'Unknown',
                'rating'      => $review->rating,
                'comment'     => $review->comment,
                'reply'       => $review->reply,
                'replied_at'  => $review->replied_at,
                'is_visible'  => $review->is_visible,
                'created_at'  => $review->created_at,
            ]);

        return response()->json([
            'success' => true,
            'data'    => $reviews,
        ]);
    }

    public function reply(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'reply' => 'required|string|min:1|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $review->update([
            'reply'      => $request->reply,
            'replied_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Balasan berhasil ditambahkan',
            'data'    => [
                'id'         => $review->id,
                'reply'      => $review->reply,
                'replied_at' => $review->replied_at,
            ],
        ]);
    }

    public function toggleVisibility($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['is_visible' => !$review->is_visible]);

        return response()->json([
            'success' => true,
            'message' => 'Visibilitas review berhasil diubah',
            'data'    => [
                'id'         => $review->id,
                'is_visible' => $review->is_visible,
            ],
        ]);
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Review berhasil dihapus',
        ]);
    }
}
