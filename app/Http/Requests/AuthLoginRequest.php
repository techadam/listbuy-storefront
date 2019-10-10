<?php

namespace App\Http\Requests;

use App\Http\Requests\CustomFormRequest;

class AuthLoginRequest extends CustomFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email_phone' => 'required',
            'password' => 'required',
        ];
    }
}
