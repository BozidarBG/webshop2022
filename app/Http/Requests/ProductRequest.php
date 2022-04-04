<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|max:250',
            'category'=>'required|numeric',
            'short_description'=>'required|max:250',
            'description' => 'required',
            'acc_code'=>'required|max:20',
            'regular_price'=>'integer|min:0',
            'action_price'=>'integer|min:0',
            'stock'=>'integer|min:0',
            'image' => 'image|mimes:jpg,jpeg,png,svg,gif|max:2048',
        ];
    }
}
