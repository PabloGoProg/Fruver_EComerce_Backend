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
        $sells = User::find($user)->sells()->get();

        return response()->json([
            'data' => new sellResource($sells),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function GenerateSell(SellStoreRequest $request)
    {
        // Gets the current authUser
        $user = User::find(Auth::user()->id);
        // Gets the products from the user cart
        $products = User::find($user)->products()->get();

        if ($products->isEmpty()) {
            return response()->json([
                'message' => 'No hay productos en el carrito de compras'
            ], 400);
        }

        // Creates the sell
        $sell = Sell::create(
            [
                'totalPrice' => $request->totalPrice,
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
            $user->products()->detach($product->id);
        }

        return response()->json([
            'data' => new SellResource($sell)
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
