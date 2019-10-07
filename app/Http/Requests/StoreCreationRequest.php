<?php

namespace App\Http\Requests;

class StoreCreationRequest extends CustomFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:stores|string|max:50',
            'email_address' => 'required|email|max:50',
            'description' => 'required',
            'buyers_location' => 'required',
            'products_type' => 'required',
            'accepted_currencies' => 'required|array',
            'state_code' => 'required|exists:states,code',
            'country_code' => 'required',
        ];
    }
}
