<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Sell;
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(SellStoreRequest $request)
    {
        $sell = Sell::create($request->all());
        // Attach products to the sell if provided in the request
        if ($request->has('products')) {
            $sell->products()->attach($request->input('products'));
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
