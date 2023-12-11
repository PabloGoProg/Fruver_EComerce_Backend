<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\AttachProductoToCartRequest;
use App\Http\Resources\api\v1\CartProductResource;
use App\Http\Requests\api\v1\UpdateProductQuantityRequest;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    /**
     * Attach a product to the user cart
     */
    public function attachProduct(AttachProductoToCartRequest $request)
    {
        try {
            // Get the authenticated user
            $user = User::find(Auth::user()->id);

            // Check if the user is authenticated
            if (!$user) {
                return response()->json([
                    'message' => 'User not authenticated'
                ], 401);
            }

            $productos = $user->products;

            foreach ($productos as $product) {
                if ($product->id == $request->product_id) {
                    return response()->json([
                        'data' => 'Product already exists',
                    ], 200);
                }
            }

            // Find the target product
            $targetProduct = Product::findOrFail($request->product_id);

            // Attach the product to the user's cart
            $user->products()->attach([
                $targetProduct->id => [
                    'orderedQuantity' => $request->orderedQuantity
                ]
            ]);

            // Return the updated user cart
            return response()->json([
                'data' => 'Product added to cart',
            ], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'User or product not found'
            ], 404);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'An error occurred'
            ], 500);
        }
    }

    /**
     * Detach a product from the user cart
     */
    public function detachProduct(string $product_id)
    {
        try {
            $user = User::find(Auth::user()->id);
            $targetProduct = Product::findOrFail($product_id);

            // Check if the product is in the user cart
            $relatedProduct = $user->products()->wherePivot('product_id', $targetProduct->id);

            $productos = $user->products;
            $found = false;
            foreach ($productos as $product) {
                if ($product->id == $product_id) {
                    $found = true;
                }
            }

            if (!$found) {
                return response()->json([
                    'data' => 'Product not found',
                ], 200);
            }

            $user->products()->detach($targetProduct);
            return response()->json([
                'data' => 'Product removed successfully',
            ], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'User or product not found'
            ], 404);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'An error occurred'
            ], 500);
        }
    }

    public function updateProductQuantity(string $product_id, UpdateProductQuantityRequest $request)
    {
        $user = User::find(Auth::user()->id);
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
    public function getShoppingCart()
    {
        try {
            $user = User::find(Auth::user()->id);

            // If the user is authenticated, return the shopping cart
            return response()->json([
                'data' => CartProductResource::collection($user->products),
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'An error occurred',
            ], 500);
        }
    }
}
