<?php

namespace App\Http\Requests;

use App\Http\Requests\CustomFormRequest;

class AddBankDetailsRequest extends CustomFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'bank_name' => 'required',
            'account_number' => 'required|numeric|min:10',
            'account_name' => 'required',
        ];
    }
}
