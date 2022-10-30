<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Worksome\RequestFactories\Concerns\HasFactory;

class SignUpRequest extends FormRequest
{
    use HasFactory;

    public function authorize(): bool
    {
        return auth()->guest();
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
        $preparedEmail = str($this->email)
            ->squish()
            ->lower()
            ->value();

        $this->merge([
            'email' => $preparedEmail,
        ]);
    }
}
