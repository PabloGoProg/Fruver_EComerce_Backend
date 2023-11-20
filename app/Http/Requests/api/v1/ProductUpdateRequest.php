<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'name' => 'required|regex:/^[\pL\s]+$/u|max:255|min:7|string',
            'description' => 'required|string|min:5|max:255|regex:/^[\pL\s\d]+$/u',
            'price' => 'required|numeric|integer|min:1',
            'category' => 'required|numeric|integer',
            'status' => 'required|string|min:3|max:255|regex:/^[\pL\s]+$/u',
            'product_type' => 'required|numeric|integer',
            'quantity' => 'required|numeric|integer|min:0',
            'img' => 'image'
        ];
    }

    public function messages():array{
        return [
            'name.required' => 'El nombre es requerido',
            'name.regex' => 'El nombre solo puede contener letras',
            'name.max' => 'El nombre no puede tener mas de 255 caracteres',
            'name.min' => 'El nombre no puede tener menos de 7 caracteres',
            'description.required' => 'La descripcion es requerida',
            'description.string' => 'La descripcion debe ser un texto',
            'description.min' => 'La descripcion debe tener al menos 10 caracteres',
            'description.max' => 'La descripcion no puede tener mas de 255 caracteres',
            'description.regex' => 'La descripcion solo puede contener letras y numeros',
            'price.required' => 'El precio es requerido',
            'price.numeric' => 'El precio debe ser un numero',
            'price.integer' => 'El precio debe ser un numero entero',
            'price.min' => 'El precio debe ser mayor a 0',
            'category.required' => 'La categoria es requerida',
            'category.numeric' => 'La categoria debe ser un numero',
            'category.integer' => 'La categoria debe ser un numero entero',
            'status.required' => 'El estado es requerido',
            'status.string' => 'El estado debe ser un texto',
            'status.min' => 'El estado debe tener al menos 3 caracteres',
            'status.max' => 'El estado no puede tener mas de 255 caracteres',
            'status.regex' => 'El estado solo puede contener letras',
            'product_type.required' => 'El tipo de producto es requerido',
            'product_type.numeric' => 'El tipo de producto debe ser un numero',
            'product_type.integer' => 'El tipo de producto debe ser un numero entero',
            'quantity.required' => 'La cantidad es requerida',
            'quantity.numeric' => 'La cantidad debe ser un numero',
            'quantity.integer' => 'La cantidad debe ser un numero entero',
            'quantity.min' => 'La cantidad debe ser mayor a 0',
            'img.image' => 'La imagen debe ser un archivo de imagen',
        ];
    }
}
