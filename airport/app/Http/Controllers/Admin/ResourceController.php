<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResourceController extends Controller
{
    public function getExcel($name)
    {
        switch ($name) {
            case 'shops_template':
                return response()->download(public_path() .
                '/storage/excel/shops_template.xls', '店铺上传模板.xls');
                break;
            case 'analyze':
                return response()->download(public_path() .
                    '/storage/excel/analyze.xls', '用户分析表2017-04-15.xls');
                break;
        }

        return '非法请求';
    }
}
