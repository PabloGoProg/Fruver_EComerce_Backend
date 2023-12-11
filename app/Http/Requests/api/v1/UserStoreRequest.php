<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'name'    => 'required|regex:/^[\pL\s]+$/u|max:255|min:7|string',
            'email'   => 'required|max:255|min:7|string|email|unique:users,email',
            'password' => 'required|min:8|max:255|string|confirmed',
            'user_type' => 'exists:user_types,id',
            'RUT' => 'max:255|string|unique:suppliers,RUT|nullable'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es requerido',
            'name.regex' => 'El nombre solo puede contener letras',
            'name.min' => 'El nombre debe tener al menos 7 caracteres',

            'email.required' => 'El email es requerido',
            'email.email' => 'El email debe ser válido',
            'email.unique' => 'El email ya existe verifica que no tengas una cuenta creada',
            'email.min' => 'El email debe tener al menos 7 caracteres',

            'password.required' => 'La contraseña es requerida',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',

            'user_type.exists' => 'El tipo de usuario no existe',

            'RUT.unique' => 'El RUT ya existe',
            'name.confirmed' => 'Las contraseñas no coinciden'
        ];
    }
}
