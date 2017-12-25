<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterFormRequest extends FormRequest
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
            'sex' => 'in:0,1',
            'cigarette_age' => 'required|numeric|between:0,100',
            'age' => 'required|numeric|between:18,120',
            'price' => 'required|numeric|between:0,1000',
            'real_name' => 'nullable|min:2|max:6',
            'province' => 'nullable|numeric',
            'city' => 'nullable|numeric',
            'area' => 'nullable|numeric',
            'address' => 'nullable|min:2',
            'mail_phone' => 'required|digits:11',
        ];
    }

    public function messages()
    {
        return [
            'sex.in' => '非法填写性别',
            'age.required' => '年龄不能为空',
            'age.numeric' => '年龄必须为数字',
            'age.between' => '年龄应该在18岁到120岁之间',
            'cigarette_age.required' => '烟龄不能为空,不满1年按1年算',
            'cigarette_age.numeric' => '烟龄必须为数字',
            'cigarette_age.between' => '烟龄应该在1岁到100之间',
            'price.required' => '日常购买卷烟单包价格不能为空',
            'price.numeric' => '价格必须为数字',
            'price.between' => '日常购买卷烟单包价格应该在0到1000元之间',
            'real_name.min' => '真实姓名应该在2到6个字符之间',
            'province.numeric' => '省份填写有误',
            'city.numeric' => '城市填写有误',
            'area.numeric' => '街道地区填写有误',
            'address.min' => '具体地址至少填写2个字符',
            'mail_phone.required' => '邮寄手机号不能为空',
            'mail_phone.digits' => '邮寄手机号为11位数字',
        ];
    }
}
