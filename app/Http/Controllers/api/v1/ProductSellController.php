<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\api\v1\SellResource;
use App\Models\Product;
use App\Models\Sell;
use App\Http\Requests\api\v1\SellStoreRequest;
use App\Http\Requests\api\v1\SellUpdateRequest;

class ProductSellController extends Controller
{
    //

       /**
     * Display sells associated with a product.
     */

     public function index($productId)
     {
         $product = Product::find($productId);

         if (!$product) {
             // Manejar el caso en el que el producto no se encuentra
             abort(404);
         }

         // Utiliza la relación 'sells' para obtener las ventas asociadas al producto
         $sell = $product->sells->first();

         return view('products', compact('product', 'sell'));
     }

   
}





