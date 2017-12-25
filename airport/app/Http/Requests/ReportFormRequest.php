<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportFormRequest extends FormRequest
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
            'scores' => 'required',
            'smoke' => 'required|max:250|min:20',
            'images' => 'required',
            'activity_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'scores.required' => '测评评分不能为空',
            'smoke.max' => '填写感受不能超过 :max 个字符',
            'smoke.min' => '填写感受不能少于 :max 个字符',
            'smoke.required' => '填写感受不能为空',
            'images.required' => '测评产品照片不能为空',
            'activity_id.required' => '非法上传',
        ];
    }
}
