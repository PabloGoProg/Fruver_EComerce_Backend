<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\SellStoreRequest;
use App\Http\Resources\api\v1\sellResource;
use App\Models\Sell;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSellsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexUserSells()
    {
        // Gets the current authUser
        $user = User::find(Auth::user()->id);
        // Gets the sells from the user
        $sells = $user->sells;

        return response()->json([
            'data' => sellResource::collection($sells),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function generateSell(Request $request)
    {
        // Gets the current authUser
        $user = User::find(auth()->user()->id);

        if (!$user) {
            return response()->json([
                'message' => 'User not authenticated'
            ], 401);
        }

        // Gets the products from the user cart
        $products = $user->products;

        if ($products->isEmpty()) {
            return response()->json([
                'message' => 'No hay productos en el carrito de compras'
            ], 400);
        }

        // Creates the sell
        $sell = Sell::create(
            [
                'total_price' => 0,
                'user_id' => $user->id,
                'status' => 'pending'
            ]
        );

        // Attach products to the sell if provided in the request
        foreach ($products as $product) {
            $sell->products()->attach(
                $product->id,
                ['orderedQuantity' => $product->pivot->orderedQuantity]
            );
            $sell->total_price += $product->pivot->orderedQuantity * $product->price;
            $user->products()->detach($product->id);
        }

        return response()->json([
            'data' => new SellResource($sell)
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function showSingleSell(string $id)
    {
        $sell = Sell::findOrFail($id);

        return response()->json([
            'data' => new SellResource($sell),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function cancelSell(string $id)
    {
        $sell = Sell::findOrFail($id);
        $sell->status = 'cancelled';
        $sell->save();

        return response()->json([
            'data' => new SellResource($sell),
        ], 200);
    }
}
