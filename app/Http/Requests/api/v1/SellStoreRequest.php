<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class SellStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'user_id' => 'required|exists:users,id',
            'total_price' => 'required|numeric',
            'status' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'El id del usuario es requerido',
            'user_id.exists' => 'El id del usuario no existe',

            'total_price.required' => 'El precio total es requerido',
            'total_price.numeric' => 'El precio total debe ser un numero',

            'status.required' => 'El estado es requerido',
            'status.string' => 'El estado debe ser un string',
        ];
    }
}
