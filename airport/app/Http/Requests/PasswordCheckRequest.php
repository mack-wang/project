<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordCheckRequest extends FormRequest
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
        ];
    }
    public function messages()
    {
        return [
            'password.required' => '密码不能为空',
            'password.min' => '密码最少为6位',
            'password.max' => '密码最大为30位',
        ];
    }
}
