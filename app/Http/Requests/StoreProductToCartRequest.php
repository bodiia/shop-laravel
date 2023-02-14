<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductToCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|int|exists:products,id',
            'quantity' => 'required|int',
            'option_values' => 'nullable|array',
        ];
    }
}
