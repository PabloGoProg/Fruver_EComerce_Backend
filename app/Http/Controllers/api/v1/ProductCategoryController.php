<?php

namespace App\Http\Controllers\api\v1;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\api\v1\CategoryResource;
use App\Http\Requests\api\v1\CategoryStoreRequest;
use App\Http\Requests\api\v1\CategoryUpdateRequest;
use App\Http\Resources\api\v1\ProductCategoryCollection;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ProductCategoryCollection(ProductCategory::paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        $productCategory = ProductCategory::create($request->all());
        return response()->json([
            "data" => new CategoryResource($productCategory),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id_product)
    {
        $id_category = Product::find($id_product)->category;
        $category = ProductCategory::find($id_category);

        return response()->json([
            "data" => new CategoryResource($category),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, string $category_id)
    {
        $productCategory = ProductCategory::findOrFail($category_id);
        $productCategory->update($request->all());

        return response()->json([
            "data" => new CategoryResource($productCategory),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory)
    {
        $productCategory->delete();
        return response()->json(null, 204);
    }
}
