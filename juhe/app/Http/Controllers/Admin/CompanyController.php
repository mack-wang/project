<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\CompanyInfo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {

        return view('admin.company',[
            'article'=>Article::find(CompanyInfo::find(1)->article_id)
        ]);
    }

    public function form(Request $request)
    {
        CompanyInfo::find(1)->update([
            'article_id' => $request->article_id
        ]);
        return back()->with('success', '修改成功');
    }
}
