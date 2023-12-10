<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class CustomerStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:1|max:255|regex:/^[\pL\s]+$/u',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|string|min:8|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser un texto',
            'name.min' => 'El nombre debe ser de minimo 1 caracter',
            'name.max' => 'El nombre debe ser maximo de 255 caracteres',
            'name.regex' => 'Debe contener solo letras',

            'email.required' => 'El email es requerido',
            'email.email' => 'El email debe ser un email valido',
            'email.unique' => 'El email ya existe',

            'password.required' => 'La contraseña es requerida',
            'password.string' => 'La contraseña debe ser un texto',
            'password.min' => 'La contraseña debe ser de minimo 8 caracteres',
            'password.max' => 'La contraseña debe ser maximo de 255 caracteres',
        ];
    }
}
