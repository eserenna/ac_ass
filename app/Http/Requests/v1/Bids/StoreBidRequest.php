<?php

namespace App\Http\Requests\v1\Bids;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Bid;

class StoreBidRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'user_id'   => [
                'required',
                'numeric',
            ],
            'price'     => [
                'required',
                'regex:/^[0-9]+(\.[0-9]{1,2})?$/',
                'gt:' . Bid::max('price'),
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required'  => 'The user id is required!',
            'price.required'    => 'The bid price is required!',
            'price.regex'       => 'The price format is invalid.',
            'price.gt'          => 'The bid price cannot be lower than ' . number_format(Bid::max('price') + 1, 2, '.', ''),
        ];
    }
}
