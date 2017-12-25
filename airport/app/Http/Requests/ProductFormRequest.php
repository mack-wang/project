<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFormRequest extends FormRequest
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
            'image_url' => 'required',
            'name' => 'required|max:125',
            'brand' => 'required|max:125',
            'status'=>'required|in:0,1',
            'type' => 'required_if:status,0',
            'size' => 'required_if:status,0',
            'price' => 'required_if:status,0|numeric',
            'company' => 'required_if:status,0',
        ];
    }

    public function messages()
    {
        return [
            'image_url' => '产品图片不能为空',
            'name.required' => '产品名称不能为空',
            'name.max' => '产品名称不能超过60个字符',
            'brand.required' => '产品品牌名称不能为空',
            'brand.max' => '产品品牌名称不能超过60个字符',
            'status.required' => '产品类型不能为空',
            'status.max' => '产品类型0为烟类，1为非烟类',
            'type.required_if' => '当前产品为烟类，卷烟类型不能为空',
            'size.required_if' => '当前产品为烟类，卷烟尺寸不能为空',
            'price.required_if' => '当前产品为烟类，卷烟价格不能为空',
            'price.numeric' => '卷烟价格为数字',
            'company.required_if' => '当前产品为烟类，生产公司不能为空',
        ];
    }
}
