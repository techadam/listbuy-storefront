<?php

namespace App\Http\Requests;

class UpdateOrderRequest extends CustomFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => 'in:pending,shipped,completed,cancelled',
        ];
    }
}
