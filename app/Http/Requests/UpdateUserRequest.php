<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->route('user'))],
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:admin,supervisor,capturista',
            'almacen_id' => 'nullable|integer|exists:almacenes,id|required_if:role,capturista',
        ];
    }

    public function messages(): array
    {
        return [
            'almacen_id.required_if' => 'El almacén es obligatorio para el rol Capturista.',
        ];
    }
}
