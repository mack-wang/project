<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'image' => 'required|max:255',
            'phone' => 'required|max:16',
            'time' => 'required|max:32',
            'content' => 'required|max:125',
        ];
    }

    public function messages()
    {
        return [
            'image.required' => '联系图片不能为空',
            'image.max' => '联系图片的链接不能超过255个字符',
            'phone.required' => '联系电话不能为空',
            'phone.max' => '联系电话不能超过16个字符',
            'time.required' => '团购热线服务时间不能为空',
            'time.max' => '团购热线服务时间最多为32个字符',
            'content.required' => '团购热线服务说明不能为空',
            'content.max' => '团购热线服务说明最多为125个字符',
        ];
    }
}
