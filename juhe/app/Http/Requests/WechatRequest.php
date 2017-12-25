<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WechatRequest extends FormRequest
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
            'imgUrl' => 'required|max:255',
            'description' => 'required|max:255',
            'title' => 'required|max:255',
            'link' => 'required|max:255',
        ];
    }

    public function messages()
    {
        return [
            'imgUrl.required' => '分享图片不能为空',
            'imgUrl.max' => '分享图片的链接不能超过 :max 个字符',
            'description.required' => '分享内容不能为空',
            'description.max' => '分享内容不能超过 :max 个字符',
            'title.required' => '分享标题不能为空',
            'title.max' => '分享标题最多为 :max 个字符',
            'link.required' => '跳转链接不能为空',
            'link.max' => '跳转链接不能转过 :max 个字符',
        ];
    }
}
