<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplyFormRequest extends FormRequest
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
            'selected' => 'nullable|required_without_all:input,photo',
            'input' => 'nullable|between:2,255',
            'photo' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'selected.required_without_all' => '未选择任何选项',
            'input.between' => '输入的文字应该在2到127个字之间',
        ];
    }
}
