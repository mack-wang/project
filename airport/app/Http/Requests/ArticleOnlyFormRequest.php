<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleOnlyFormRequest extends FormRequest
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
            'message' => 'required|max:100',
            'article_id' => 'required_without:link',
            'count' => 'required|numeric',
            'end_at' => 'required',
            'start_at' => 'required',
            'exp' => 'required_without:level',
            'image_path' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'message.required' => '活动标题不能为空',
            'message.max' => '活动标题不能超过 :max 个字符',
            'article_id.required_without' => '文章或活动链接不能同时为空',
            'count.required' => '活动名额不能为空',
            'count.numeric' => '活动名额必须为数字',
            'start_at.required' => '开始日期不能为空',
            'end_at.required' => '结束日期不能为空',
            'exp.required_without'  => '活动条件不能为空',
            'image_path.required'  => '活动首页图不能为空',
        ];
    }
}
