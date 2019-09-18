<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStoreRequest extends CustomFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email_address' => 'email|max:50',
            'description' => 'string',
            'buyers_location' => 'string',
            'products_type' => 'string',
            'accepted_currencies' => 'array',
        ];
    }
}
