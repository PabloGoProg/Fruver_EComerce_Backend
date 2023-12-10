<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\api\v1\ProductResource;
use App\Http\Requests\api\v1\ProductStoreRequest;
use App\Http\Requests\api\v1\ProductUpdateRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('crudProduct', compact('products'));
    }



    public function store(ProductStoreRequest $request)
    {
        try {
            $product = Product::create($request->all());
            return response()->json([
                'data' => new ProductResource($product),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al crear el producto',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function update(ProductUpdateRequest $request, Product $product)
    {
        $product->update($request->all());
        return response()->json([
            "data" => new ProductResource($product),
        ], 200);
    }
    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json([
            "data" => new ProductResource($product),
        ], 200);
    }
    public function showProductSells($id_product)
    {
        $product = Product::findOrFail($id_product);
        $sells = $product->sells;
        return response()->json(['data' => $sells], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(null, 204);
    }
}
