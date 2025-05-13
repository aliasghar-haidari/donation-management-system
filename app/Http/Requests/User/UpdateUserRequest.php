<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'name' => 'sometimes|string|max:255',
            'user_name' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('users', 'user_name')->ignore($this->user),
            ],
            'email' => [
                'sometimes',
                'email',
                Rule::unique('users', 'email')->ignore($this->user),
            ],
            'password' => 'sometimes|string|min:8|confirmed',
            'avatar' => 'nullable|string',
            'status' => 'sometimes|boolean',
        ];
    }
}
