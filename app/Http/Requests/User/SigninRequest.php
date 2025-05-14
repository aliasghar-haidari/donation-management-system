<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class SigninRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'userName' => 'required|string|max:255',
            'password' => 'required|string',
        ];
    }

    public function credentials(): array
    {
        return [
            'user_name' => $this->input('userName'),
            'password' => $this->input('password'),
        ];
    }
}