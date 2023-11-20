<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class ProductTypeUpdateRequest extends FormRequest
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
            'name' => 'required|string|min:1|max:255|regex:/^[\pL\s]+$/u'
        ];
    }

    public function messages():array{
        return[
            'name.required'=> 'El nombre es requerido',
            'name.string' => 'El nombre debe ser un texto',
            'name.min' => 'El nombre debe ser de minimo 1 caracter',
            'name.max' => 'El nombre debe ser maximo de 255 caracteres',
            'name.regex' => 'Debe contener solo letras'
        ];
    }
}
