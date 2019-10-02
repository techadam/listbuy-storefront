<?php

namespace App\Http\Requests;

use App\Http\Requests\CustomFormRequest;

class UpdateBankDetailsRequest extends CustomFormRequest
{
/**
 * Get the validation rules that apply to the request.
 *
 * @return array
 */
    public function rules()
    {
        return [
            'bank_name' => 'string|min:1',
            'account_number' => 'numeric|min:10',
            'account_name' => 'string|min:1',
        ];
    }
}
