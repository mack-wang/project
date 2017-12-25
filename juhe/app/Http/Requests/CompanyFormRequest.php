<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyFormRequest extends FormRequest
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
            'company' => 'required|max:125',
            'size' => 'required|numeric',
            'industry' => 'required|max:125',
        ];
    }

    public function messages()
    {
        return [
            'company.required' => '公司名称不能为空',
            'company.max' => '公司名称不能大于 :max 个字',
            'industry.max' => '行业不能大于 :max 个字',
            'industry.required' => '行业不能为空',
            'size.required' => '企业规模不能为空',
            'size.numeric' => '企业规模为数字',
        ];
    }
}
