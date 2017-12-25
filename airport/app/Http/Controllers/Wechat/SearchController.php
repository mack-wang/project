<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use App\Models\Cigarette;
use App\Models\City;
use App\Models\FetchCigarette;
use App\Models\Question;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //显示香烟视图
    public function cigarette()
    {
        $cigarettes = Cigarette::simplePaginate(10);
        return view('wechat.home.cigarette', [
                'cigarettes' => $cigarettes]
        );
    }

    //根据香烟名返回香烟的json信息
    public function search(Request $request)
    {
        return FetchCigarette::where('name', 'like', '%' . $request->cigarette . '%')
            ->get(['cigarette_id', 'name'])
            ->toJson();
    }

    //根据香烟名，搜索出香烟的结果，并返回香烟视图
    public function searchByName(Request $request)
    {
        $cigarettes = Cigarette::where('cigarette', 'like', '%' . $request->cigarette . '%')
            ->simplePaginate(10);
        return view('wechat.home.cigarette', [
            'cigarettes' => $cigarettes
        ]);
    }

    //显示地址表单视图
    public function address($phone)
    {
        return view('wechat.home.address', [
            'phone' => $phone,
        ]);
    }

    //根据pid来返回城市名的json信息
    public function city($pid)
    {
        return City::where('pid', $pid)
            ->get(['id', 'name'])
            ->toJson();
    }


    //根据题目内容来返回具体题目
    public function question(Request $request)
    {
        return Question::where('question', 'like', '%' . $request->question . '%')
            ->get(['id', 'question'])
            ->toJson();
    }
}
