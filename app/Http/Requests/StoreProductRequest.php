<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
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
        return [
            'sku' => 'required|string|max:6|unique:products',
            'name' => 'required|string|max:255',
            'category' => [
                'required', 'string', 'max:50',
                Rule::in(['vehicle', 'insurance']),
            ],
            'price' => 'required|integer',
        ];
    }
}
