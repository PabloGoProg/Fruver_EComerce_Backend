<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Http\Resources\api\v1\SupplierResource;
use App\Http\Requests\api\v1\SupplierUpdateRequest;
use App\Http\Resources\api\v1\SupplierCollection;
use App\Models\Product;
use App\Models\User;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activeSuppliers = Supplier::with('user')
            ->whereHas('user', function ($query) {
                $query->where('status', 'active');
            })
            ->orderBy('id', 'asc')
            ->paginate(5);

        return new SupplierCollection($activeSuppliers);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $supplier = Supplier::findOrFail($id);
        $realted_user = User::findOrFail($supplier->user_id);

        if ($realted_user->status == 'inactive') {
            return response()->json([
                'data' => 'User not found',
            ], 200);
        }

        return response()->json([
            'data' => new SupplierResource($supplier),
        ], 200);
    }

    /**
     * get all products from a supplier.
     */
    public function getProducts(string $id)
    {
        $supplier = Supplier::findOrFail($id);

        $realted_user = User::findOrFail($supplier->user_id);

        if ($realted_user->status == 'inactive') {
            return response()->json([
                'data' => 'User not found',
            ], 200);
        }

        $products = $supplier->products;

        return response()->json([
            'data' => $products,
        ], 200);
    }

    /**
     * attach a product to a supplier.
     */
    public function attachProduct(string $id, string $product_id)
    {
        $supplier = Supplier::findOrFail($id);

        $realted_user = User::findOrFail($supplier->user_id);

        if ($realted_user->status == 'inactive') {
            return response()->json([
                'data' => 'User not found',
            ], 200);
        }

        $productos = $supplier->products;

        foreach ($productos as $product) {
            if ($product->id == $product_id) {
                return response()->json([
                    'data' => 'Product already exists',
                ], 200);
            }
        }

        $supplier->products()->attach($product_id);
        return response()->json([
            'data' => new SupplierResource($supplier),
        ], 200);
    }

    /**
     * detach a product from a supplier.
     */
    public function detachProduct(string $id, string $product_id)
    {
        $supplier = Supplier::findOrFail($id);

        $realted_user = User::findOrFail($supplier->user_id);

        if ($realted_user->status == 'inactive') {
            return response()->json([
                'data' => 'User not found',
            ], 200);
        }

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

        $realted_user = User::findOrFail($supplier->user_id);

        if ($realted_user->status == 'inactive') {
            return response()->json([
                'data' => 'User not found',
            ], 200);
        }

        $realted_user = User::findOrFail($supplier->user_id);

        $realted_user->update($request->all());

        $supplier->update(
            [
                'RUT' => $request->RUT,
            ]
        );

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
        $realted_user = User::findOrFail($supplier->user_id);

        $supplier->products()->detach();

        $realted_user->update(
            [
                'status' => 'inactive',
            ]
        );

        return response()->json(null, 204);
    }
}
