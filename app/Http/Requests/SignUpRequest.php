<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class SignUpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guest();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3'],
            'email' => ['required', 'email:dns', 'unique:users'],
            'password' => ['required', 'confirmed', Password::default()],
        ];
    }

    protected function prepareForValidation(): void
    {
        $preparedEmail = Str::of($this->email)
            ->squish()
            ->lower()
            ->value();

        $this->merge([
            'email' => $preparedEmail,
        ]);
    }
}
