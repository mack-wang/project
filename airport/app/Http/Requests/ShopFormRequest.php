<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopFormRequest extends FormRequest
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
            'name' => 'required|max:100',
            'phone' => 'required|digits:11',
            'cigarette_id' => 'nullable|digits:12',
            'level' => 'nullable|in:1,2,3,4,5',
            'scores' => 'nullable|numeric',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => '店铺名不能为空',
            'name.max' => '店铺名不能超过 :max 个字符',
            'phone.required' => '手机号不能为空',
            'phone.digits' => '手机号为11位数字',
            'cigarette_id.digits'  => '烟草证号为12位数字',
            'level.in'  => '店铺等级为1-5的数字',
            'scores.numeric'  => '店铺积分为数字',
        ];
    }
}
