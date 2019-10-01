<?php

namespace App\Http\Requests;

use App\Http\Requests\CustomFormRequest;

class DeliveryPriceRequest extends CustomFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fromState' => 'required|exists:states,code',
            'toState' => 'required|exists:states,code',
            'weight' => 'required|numeric',
        ];
    }
}
