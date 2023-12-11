<?php

namespace App\Http\Resources\api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\api\v1\UserTypeResource;
use Illuminate\Support\Facades\Auth;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'birthday' => $this->birthday,
            'address' => $this->address,
            'status' => $this->status,
            $this->mergeWhen(Auth::user()->user_type === 1, [
                'user_type' => new UserTypeResource($this->userType),
            ]),
        ];
    }
}
