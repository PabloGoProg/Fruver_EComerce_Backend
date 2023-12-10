<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class SupplierStoreRequest extends FormRequest
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
            //que quiere decir unique:suppliers,RUT
            'RUT' => 'required|string|max:255|unique:suppliers,RUT',
            'user_id' => 'required|integer|exists:users,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'RUT.required' => 'El RUT es requerido',
            'RUT.string' => 'El RUT debe ser un texto',
            'RUT.max' => 'El RUT no puede tener mas de 255 caracteres',
            'RUT.unique' => 'El RUT ya existe',
            'user_id.required' => 'El id del usuario es requerido',
            'user_id.integer' => 'El id del usuario debe ser un numero',
            'user_id.exists' => 'El id del usuario no existe',
        ];
    }
}
