<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleFormRequest extends FormRequest
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
            'title' => 'required|max:100',
            'article_id' => 'required',
            'count' => 'required|numeric',
            'description' => 'nullable|max:125',
            'end_at' => 'required',
            'start_at' => 'required',
            'elect'=>'required|in:0,1',
            'exp' => 'required_without:level',
            'cigarette_id' => 'required|numeric',
            'image_path' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '活动标题不能为空',
            'title.max' => '活动标题不能超过 :max 个字',
            'article_id.required' => '文章选择不能为空',
            'count.required' => '测评名额不能为空',
            'count.numeric' => '测评名额必须为数字',
            'description.max' => '奖品描述不能超过 :max 个字符',
            'elect.required' => '筛选方式不能为空',
            'elect.in' => '筛选方式只能填0或1',
            'start_at.required' => '开始日期不能为空',
            'end_at.required' => '结束日期不能为空',
            'exp.required_without'  => '活动条件不能为空',
            'cigarette_id.required'  => '未从搜索结果中选择测评卷烟品牌',
            'cigarette_id.numeric'  => '非法选择卷烟品牌',
            'image_path.required'  => '活动轮播轮播图不能为空',
        ];
    }
}
