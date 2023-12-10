<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\api\v1\SupplierResource;
use App\Models\Product;
use App\Models\Supplier;
use App\Http\Requests\api\v1\SupplierStoreRequest;
use App\Http\Requests\api\v1\SupplierUpdateRequest;

class ProductSupplierController extends Controller
{
    //
    /**
     * Display suppliers associated with a product.
     */
    public function showSuppliers($productId)
    {
        $product = Product::findOrFail($productId);
        $suppliers = $product->suppliers;
        return response()->json(['data' => SupplierResource::collection($suppliers)], 200);
    }

        public function addSupplier($productId, SupplierStoreRequest $request)
    {
        $product = Product::findOrFail($productId);
        $supplier = Supplier::create($request->all());

        // Asociar el proveedor con el producto
        $product->suppliers()->attach($supplier->id);

        return response()->json(['data' => $supplier], 201);
    }
    /**
     * Update supplier associated with a product.
     */
        public function updateSupplier($productId, $supplierId, SupplierUpdateRequest $request)
    {
        $product = Product::findOrFail($productId);
        $supplier = Supplier::findOrFail($supplierId);
        $supplier->update($request->all());

        return response()->json(['data' => $supplier], 200);
    }

        /**
     * Remove a supplier associated with a product.
     */
    public function removeSupplier($productId, $supplierId)
    {
        $product = Product::findOrFail($productId);
        $product->suppliers()->detach($supplierId);

        return response()->json(null, 204);
    }


    /**
     * Buscar proveedores asociados a productos específicos.
     */
    public function searchSuppliersForProducts(Request $request)
    {
        // Obtener los IDs de productos desde la solicitud
        $productIds = $request->input('product_ids', []);

        // Buscar proveedores asociados a los productos específicos
        $suppliers = Supplier::whereHas('products', function ($query) use ($productIds) {
            $query->whereIn('supplier_product.product_id', $productIds);
        })->get();

        return response()->json(['data' => SupplierResource::collection($suppliers)], 200);
    }


}
