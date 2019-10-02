<?php

namespace App\Http\Requests;

use App\Http\Requests\CustomFormRequest;

class AddProductRequest extends CustomFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:500',
            'price' => 'required|numeric',
            'product_type' => 'required|string',
            'weight' => 'required|string',
            'stock' => 'required|numeric',
            'status' => 'required|string',
            'shipping_option' => 'required|string|In:in_app_shipping,store_shipping',
            'images' => 'required|array',
            'images.*' => 'bail|required|string|base64image|base64mimes:jpeg,png,jpg,svg|base64max:5048',
        ];
    }
}
