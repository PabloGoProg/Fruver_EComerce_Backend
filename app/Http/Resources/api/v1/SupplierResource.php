<?php

namespace App\Http\Resources\api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\api\v1\UserTypeResource;

class SupplierResource extends JsonResource
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
            'RUT' => $this->RUT,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'phone_number' => $this->user->phone_number,
            'birthday' => $this->user->birthday,
            'address' => $this->user->address,
            'status' => $this->user->status,
            'user_type' => new UserTypeResource($this->user->userType),
        ];
    }
}