<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Http\Requests\api\v1\AttachProductoToCartRequest;
use App\Http\Resources\api\v1\CartProductResource;
use App\Http\Requests\api\v1\UpdateProductQuantityRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CartController extends Controller
{
    /**
     * Attach a product to the user cart
     */
    public function attachProduct(string $user_id, AttachProductoToCartRequest $request)
    {
        try {
            $user = User::findOrFail($user_id)
                ->where('status', 'active')
                ->first();
            $targetProduct = Product::findOrFail($request->product_id);

            $user->products()->attach([
                $targetProduct->id => [
                    'orderedQuantity' => $request->orderedQuantity
                ]
            ]);

            return response()->json([
                'data' => CartProductResource::collection($user->products),
            ], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'User or product not found'
            ], 404);
        }
    }

    /**
     * Detach a product from the user cart
     */
    public function detachProduct(string $user_id, string $product_id)
    {
        try {
            // Find the user and the product
            $user = User::findOrFail($user_id)
                ->where('status', 'active')
                ->first();
            $targetProduct = Product::findOrFail($product_id);

            // Check if the product is in the user cart
            $relatedProduct = $user->products()->wherePivot('product_id', $targetProduct->id);

            if (!$relatedProduct) {
                return response()->json([
                    'message' => 'Product not found in user cart'
                ], 404);
            }

            // Detach the product from the user cart
            $user->products()->detach($targetProduct);
            return response()->json([
                'data' => CartProductResource::collection($user->products),
            ], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'User or product not found'
            ], 404);
        }
    }

    public function updateProductQuantity(string $user_id, string $product_id, UpdateProductQuantityRequest $request)
    {
        $user = User::find($user_id);
        $targetProduct = Product::find($product_id);

        $user->products()->updateExistingPivot($targetProduct->id, [
            'orderedQuantity' => $request->orderedQuantity
        ]);

        return response()->json([
            'data' => CartProductResource::collection($user->products),
        ], 200);
    }

    /**
     * Get the user cart
     */
    public function getShoppingCart(string $user_id)
    {
        try {
            $user = User::findOrFail($user_id)
                ->where('status', 'active')
                ->first();

            return response()->json([
                'data' => CartProductResource::collection($user->products),
            ], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }
    }
}
