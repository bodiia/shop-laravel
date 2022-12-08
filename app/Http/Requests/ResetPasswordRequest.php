<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guest();
    }

    public function rules(): array
    {
        return [
            'token' => ['required'],
            'email' => ['required', 'email:dns'],
            'password' => ['required', 'confirmed', Password::default()],
        ];
    }
}
