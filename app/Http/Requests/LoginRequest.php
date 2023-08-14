<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email обязателен.',
            'email.email' => 'Email должен быть действительным адресом электронной почты.',
            'password.required' => 'Пароль обязателен.',
        ];
    }
}
