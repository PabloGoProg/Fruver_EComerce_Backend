<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductQuantityRequest extends FormRequest
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
            "orderedQuantity" => "required|integer|min:1",
        ];
    }

    public function messages(): array
    {
        return [
            'orderedQuantity.required' => 'The orderedQuantity field is required.',
            'orderedQuantity.integer' => 'The orderedQuantity field must be an integer.',
            'orderedQuantity.min' => 'The orderedQuantity field must be at least 1.',
        ];
    }
}
