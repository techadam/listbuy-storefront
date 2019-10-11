<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\CustomFormRequest;

class UpdateUserRequest extends CustomFormRequest
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
            'firstname' => 'min:0|string|max:255',
            'lastname' => 'min:0|string|max:255',
            'email' => 'min:0|unique:users',
            'password' => 'string|min:6',
            'role' => 'min:0|In:seller,buyer',
            'phone' => [
                'min:0',
                Rule::phone()->countryField('country_code'),
                Rule::unique('users')->where(function ($query) use ($data) {
                    return $query->where([['phone', '=', $data['phone']], ['role', '=', $data['role']]]);
                }),
            ],
            'country_code' => 'min:0',

        ];

    }
}
