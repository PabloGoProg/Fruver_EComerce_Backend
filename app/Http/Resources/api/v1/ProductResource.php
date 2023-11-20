<?php

namespace App\Http\Resources\api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\api\v1\CategoryResource;
use App\Http\Resources\api\v1\ProductTypeResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product_name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'product_category' => new CategoryResource($this->product_categories),
            'product_status' => $this->status,
            'product_type' => new ProductTypeResource($this->product_types),
            'quantity' => $this->quantity,
            'img' => $this->img
        ];
    }
}
