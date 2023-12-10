<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Http\Resources\api\v1\ProductCartResource;

class CartController extends Controller
{


    public function attachProduct(string $user_id, Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'orderedQuantity' => 'required|integer|min:1',
        ]);

        $user = User::find($user_id);
        $targetProduct = Product::find($request->product_id);

        $user->products()->attach([
            $targetProduct->id => [
                'orderedQuantity' => $request->orderedQuantity
            ]
        ]);

        return response()->json([
            'data' => new $user->products,
        ], 200);
    }

    public function detachProduct(string $user_id, string $product_id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $user = User::find($user_id);
        $targetProduct = Product::find($product_id);
        $user->products()->detach($targetProduct);

        return response()->json([
            'data' => $user->products,
        ], 200);
    }

    public function getShoppingCart(string $user_id)
    {
        $user = User::find($user_id);

        return response()->json([
            'data' => ProductCartResource::collection($user->products),
        ], 200);
    }
}
