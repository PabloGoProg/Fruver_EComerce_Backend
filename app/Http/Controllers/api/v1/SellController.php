<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Sell;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\api\v1\SellResource;
use App\Http\Requests\api\v1\SellStoreRequest;
use App\Http\Requests\api\v1\SellUpdateRequest;

class SellController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sells = Sell::with('products')->orderBy('created_at', 'desc')->get();
        return response()->json(['data' => SellResource::collection($sells)], 200);
    }

    public function store(SellStoreRequest $request)
    {
        $sell = Sell::create($request->all());
        $products = User::find($request->user_id)->products()->get();
        $user = User::find($request->user_id);
        // Attach products to the sell if provided in the request
        foreach ($products as $product) {
            $sell->products()->attach(
                $product->id,
                ['orderedQuantity' => $product->pivot->orderedQuantity]
            );
            $user->products()->detach($product->id);
        }
        return response()->json(['data' => $sell], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sell $sell)
    {
        $sell->load('products');
        return response()->json(['data' => new SellResource($sell)], 200);
    }

    public function showSellProducts($id_sell)
    {
        $sell = Sell::findOrFail($id_sell);
        $products = $sell->products;
        return response()->json(['data' => $products], 200);
    }

    public function showProduct($id_sell, $id_product)
    {

        $sell = Sell::findOrFail($id_sell);
        $product = $sell->products()->findOrFail($id_product);
        return response()->json(['sell' => $sell, 'product' => $product]);
    }

    public function showUserSells($id_user)
    {
        $user = User::findOrFail($id_user);
        $sells = $user->sells;
        return response()->json(['data' => SellResource::collection($sells)], 200);
    }

    public function showUserSell($id_user, $id_sell)
    {
        $user = User::findOrFail($id_user);
        $sell = $user->sells()->findOrFail($id_sell);
        return response()->json(['user' => $user, 'sell' => $sell]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SellUpdateRequest $request, Sell $sell)
    {
        $sell->update($request->all());
        // Sync products for the sell if provided in the request
        if ($request->has('products')) {
            $sell->products()->sync($request->input('products'));
        }
        return response()->json(['data' => $sell], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sell $sell)
    {
        $sell->products()->detach(); // Detach products before deleting the sell
        $sell->delete();
        return response()->json(null, 204);
    }
}
