<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CouponRequest extends FormRequest
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
            'code'=>["required",
                Rule::unique('coupons', 'code')->ignore($this->coupon)],
            'type'=>['required', Rule::in(['fixed', 'percent'])],
            'value'=>'required',
            'cart_value'=>'required',
            'valid_from'=>'required|before:valid_until',
            'valid_until'=>'required|after:valid_from',
        ];
    }
}
