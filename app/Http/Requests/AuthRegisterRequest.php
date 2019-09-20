<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Request;

class AuthRegisterRequest extends CustomFormRequest
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
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|unique:users',
            'password' => 'string|min:6',
            'role' => 'required|In:seller,buyer',
            'phone' => [
                'required',
                Rule::phone()->countryField('country_code'),
                Rule::unique('users')->where(function ($query) use ($data) {
                    return $query->where([['phone', '=', $data['phone']], ['role', '=', $data['role']]]);
                }),
            ],
            'country_code' => 'required',

        ];
    }

/**
 * Get the error messages for the defined validation rules.
 *
 * @return array
 */
    public function messages()
    {
        return [
            'phone.phone' => "Invalid phone number for selected country",
        ];
    }
}
