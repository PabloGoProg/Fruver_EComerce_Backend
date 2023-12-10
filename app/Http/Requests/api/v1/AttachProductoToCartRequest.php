<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class AttachProductoToCartRequest extends FormRequest
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
            "orderedQuantity" => "integer|min:1",
        ];
    }

    public function messages(): array
    {
        return [
            'orderedQuantity.integer' => 'La cantidad debe ser un numero',
            'orderedQuantity.min' => 'La cantidad debe ser mayor a 0',
        ];
    }
}
