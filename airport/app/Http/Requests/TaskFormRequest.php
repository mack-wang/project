<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskFormRequest extends FormRequest
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
            'message' => 'required|max:8',
            'article_id' => 'required_without:link',
            'prize_count' => 'required|numeric',
            'end_at' => 'required',
            'start_at' => 'required',
            'exp' => 'required_without:level',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '任务标题不能为空',
            'title.max' => '任务标题不能超过 :max 个字符',
            'message.required' => '任务简称不能为空',
            'message.max' => '任务简称不能超过 :max 个字符',
            'article_id.required_without' => '文章或活动链接不能同时为空',
            'prize_count.required' => '奖励奖品数量不能为空',
            'prize_count.numeric' => '奖励奖品数量必须为数字',
            'start_at.required' => '开始日期不能为空',
            'end_at.required' => '结束日期不能为空',
            'exp.required_without'  => '任务条件不能为空',
        ];
    }
}
