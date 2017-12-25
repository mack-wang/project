<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NavRequest extends FormRequest
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
            'article_id' => 'required_without:redirect_path',
            'image_path' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'article_id.required_without' => '文章和路径需要填写其中一项',
            'image_path.required' => '导航图不能为空',
        ];
    }
}
