<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Sell;
use Illuminate\Http\Request;
use App\Http\Resources\api\v1\SellResource;
use App\Http\Requests\api\v1\SellStoreRequest;
use App\Http\Requests\api\v1\SellUpdateRequest;
use App\Models\User; // Asegúrate de importar el modelo User



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

        // Imprime los productos antes de asociarlos a la venta
        $products = $request->input('products');
        dd($products);
    // Obtiene el usuario usando el user_id proporcionado en la solicitud
    $user = User::findOrFail($request->input('user_id'));

    // Crea la venta asociada al usuario
    $sell = $user->sells()->create([
        'total_price' => $request->input('total_price'),
        'status' => $request->input('status'),
    ]);

    // Adjunta productos a la venta si se proporcionan en la solicitud
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
