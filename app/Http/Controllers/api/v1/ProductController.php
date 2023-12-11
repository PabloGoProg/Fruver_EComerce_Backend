<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\api\v1\ProductResource;
use App\Http\Requests\api\v1\ProductStoreRequest;
use App\Http\Requests\api\v1\ProductUpdateRequest;
use App\Models\ProductCategory;
use App\Models\ProductType;
use App\Http\Resources\api\v1\ProductCollection;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('category')){
            $category_name = $request->category;
            $category = ProductCategory::where('name', $category_name)->first();
            $products = $category->products;
            return response()->json(['data' => ProductResource::collection($products)], 200);
        }
        if($request->has('type')){
            $type_name = $request->type;
            $type = ProductType::where('name', $type_name)->first();
            $products = $type->products;
            return response()->json(['data' => ProductResource::collection($products)], 200);
        }
        $products = Product::all();
        return new ProductCollection(Product::paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        $product = Product::create($request->all());
        return response()->json([
            "data" => new ProductResource($product),
        ], 201);
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
     * Show since the lower price to the higher product price
     */
    public function lower()
    {
        $products = Product::orderBy('price', 'asc')->get();
        return response()->json(['data' => ProductResource::collection($products)], 200);
    }

    /**
     * Show since the higher price to the lower product price
     */
    public function higher()
    {
        $products = Product::orderBy('price', 'desc')->get();
        return response()->json(['data' => ProductResource::collection($products)], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $product->update($request->all());
        return response()->json([
            "data" => new ProductResource($product),
        ], 200);
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
