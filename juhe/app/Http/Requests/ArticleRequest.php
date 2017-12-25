<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'brand' => 'required|max:32',
            'title' => 'required|max:64',
            'content' => 'required',
            'brief' => 'required|max:255',
            'image' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '标题不能为空',
            'title.max' => '标题不能超过 :max 个字符',
            'content.required' => '文章内容不能为空',
            'brand.required' => '品牌不能为空',
            'brand.max' => '标题不能超过 :max 个字符',
            'brief.required' => '简介不能为空',
            'brief.max' => '简介不能超过 :max 个字符',
            'image.required' => '标题图不能为空',
        ];
    }
}
