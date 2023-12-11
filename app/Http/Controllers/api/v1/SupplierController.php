<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Http\Resources\api\v1\SupplierResource;
use App\Http\Requests\api\v1\SupplierUpdateRequest;
use App\Http\Resources\api\v1\SupplierCollection;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::orderBy('id', 'asc')
            ->where('status', 'active')
            ->paginate(5);

        return new SupplierCollection($suppliers);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $supplier = Supplier::findOrFail($id);

        return response()->json([
            'data' => new SupplierResource($supplier),
        ], 200);
    }

    /**
     * get all products from a supplier.
     */
    public function getProducts(string $id){
        $supplier = Supplier::findOrFail($id);
        $products = $supplier->products;

        return response()->json([
            'data' => $products,
        ], 200);
    }

    /**
     * attach a product to a supplier.
     */
    public function attachProduct(string $id, string $product_id){
        $supplier = Supplier::findOrFail($id);
        $supplier->products()->attach($product_id);

        return response()->json([
            'data' => new SupplierResource($supplier),
        ], 200);
    }

    /**
     * detach a product from a supplier.
     */
    public function detachProduct(string $id, string $product_id){
        $supplier = Supplier::findOrFail($id);
        $supplier->products()->detach($product_id);

        return response()->json([
            'data' => new SupplierResource($supplier),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SupplierUpdateRequest $request, string $id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->all());

        return response()->json([
            'data' => new SupplierResource($supplier),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->status = 'inactive';

        return response()->json(null, 204);
    }
}
