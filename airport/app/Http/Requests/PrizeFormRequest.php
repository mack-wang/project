<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrizeFormRequest extends FormRequest
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
            'image_path' => 'required',
            'name' => 'required|max:125',
            'count' => 'required|numeric',
            'cost' => 'required|numeric',
            'type' => 'required|numeric',
            'expire' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'image_path.required' => '奖品图片不能为空',
            'name.required' => '奖品名称不能为空',
            'count.required' => '奖品数量不能为空',
            'cost.required' => '消耗礼品券数量不能为空',
            'type.required' => '奖品类型不能为空',
            'expire.required' => '二维码过期时间不能为空',
            'name.max' => '奖品名称字符不能超过 :max',
            'count.numeric' => '奖品数量应该为数字',
            'cost.numeric' => '消耗礼品券数量应该为数字',
            'type.numeric' => '非法上传奖品类型',
            'expire.numeric' => '二维码过期时间应该为数字',
        ];
    }
}
