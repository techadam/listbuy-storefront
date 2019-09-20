<?php

namespace App\Http\Requests;

class UpdateProductRequest extends CustomFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /* TODO: Use policy for autorization */
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'string|max:50',
            'description' => 'string|max:500',
            'price' => 'numeric',
            'product_type' => 'string',
            'weight' => 'string',
            'stock' => 'numeric',
            'status' => 'string',
            'shipping_option' => 'string|In:in_app_shipping,store_shipping',
        ];
    }
}
