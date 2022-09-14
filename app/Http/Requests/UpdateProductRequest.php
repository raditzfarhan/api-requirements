<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $product = $this->route('product');

        return [
            'sku' => [
                'sometimes', 'required', 'string', 'max:6',
                Rule::unique('products')->ignore($product->id)
            ],
            'name' => 'sometimes|required|string|max:255',
            'category' => [
                'sometimes', 'required', 'string', 'max:50',
                Rule::in(['vehicle', 'insurance']),
            ],
            'price' => 'sometimes|required|integer',
        ];
    }
}
