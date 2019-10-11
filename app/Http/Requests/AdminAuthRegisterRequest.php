<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class AdminAuthRegisterRequest extends CustomFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // if (auth()->user()->isAdmin()) {
        //     return true;
        // } else {
        //     return false;
        // }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|In:admin',
            'phone' => [
                'required',
                Rule::phone()->countryField('country_code'),
            ],
            'country_code' => 'required',
        ];
    }
}
