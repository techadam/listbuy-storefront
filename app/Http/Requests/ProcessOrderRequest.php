<?php

namespace App\Http\Requests;

use App\Helpers\Constants;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProcessOrderRequest extends CustomFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $data = $request->all();
        return [
            'store_id' => 'required|exists:stores,id',
            'buyer_name' => 'required',
            'buyer_email' => 'required|email',
            'buyer_phone' => 'required',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|numeric',
            'currency' => 'required',
            'payment_method' => [
                'required',
                Rule::in(Constants::STRIPE_PAYMENT, Constants::VOGUE_PAYMENT),
            ],
            'reference_id' => Rule::requiredIf($data['payment_method'] != Constants::STRIPE_PAYMENT),
            'dest_state' => 'required|exists:states,code',
            'dest_country' => 'required',
            'shipping_address' => 'required',
            'stripe_source' => Rule::requiredIf($data['payment_method'] == Constants::STRIPE_PAYMENT),
        ];
    }
}
