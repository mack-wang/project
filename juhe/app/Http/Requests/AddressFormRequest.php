<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressFormRequest extends FormRequest
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
            'real_name' => 'min:2|max:6',
            'province' => 'numeric',
            'city' => 'numeric',
            'area' => 'numeric',
            'address' => 'min:2',
            'mail_phone' => 'required|digits:11',
            'id' => 'nullable|numeric',
        ];
    }

    public function messages()
    {
        return [
            'real_name.min' => '真实姓名应该在2到6个字之间',
            'province.numeric' => '省份填写有误',
            'city.numeric' => '城市填写有误',
            'area.numeric' => '街道地区填写有误',
            'address.min' => '具体地址至少填写2个字',
            'mail_phone.required' => '邮寄手机号不能为空',
            'mail_phone.digits' => '邮寄手机号为11位数字',
        ];
    }
}
