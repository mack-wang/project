<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
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
            'password' => 'required|min:6|max:30',
            'phone' => 'required|digits:11',
            'code' => 'required|digits:6',
        ];
    }
    public function messages()
    {
        return [
            'password.required' => '密码不能为空',
            'password.min' => '密码最少为6位',
            'password.max' => '密码最大为30位',
            'phone.required' => '手机号不能为空',
            'code.required' => '短信验证码不能为空',
            'phone.digits' => '手机号为11位数字',
            'code.digits'  => '短信验证码为6位数字',
        ];
    }
}
