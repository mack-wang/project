<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Headline;
use App\Http\Controllers\Controller;
use App\Http\Requests\NavRequest;
use App\SlideImage;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function nav()
    {
        $navs = SlideImage::with('articles')
            ->paginate(6);
        return view('admin.nav', [
            'navs' => $navs,
        ]);
    }

    public function searchArticle(Request $request)
    {
        return Article::where('title', 'like', '%' . $request->title . '%')
            ->get(['id', 'title'])
            ->toJson();
    }

    public function navToggle($id)
    {
        $nav = SlideImage::find($id);
        $nav->state ? $nav->state = 0 : $nav->state = 1;
        $nav->save();
    }

    public function navDelete($id)
    {
        SlideImage::find($id)->delete();
        return back()->with('success', '删除成功');

    }

    public function getNav($id)
    {
        return SlideImage::find($id)->toJson();
    }

    public function navForm(NavRequest $request)
    {
        SlideImage::updateOrCreate(
            $request->only('id'),
            $request->only('article_id', 'redirect_path', 'image_path')
        );

        return back()->with('success', $request->id ? '修改成功' : '上传成功');
    }

    public function headline()
    {
        return view('admin.headline', [
            'headlines' => Headline::with('articles')->paginate(8),
        ]);
    }

    //ajax记录钜合头条浏览数
    public function increaseHeadlineView($id)
    {
        Headline::find($id)->increment('view');
    }

    public function headlineForm(Request $request)
    {
        Headline::updateOrCreate(
            $request->only('id'),
            $request->only('article_id', 'headline')
        );

        return back()->with('success', $request->id ? '修改成功' : '上传成功');
    }

    public function delHeadline($id)
    {
        Headline::find($id)->delete();
        return back()->with('success', '删除成功');
    }

    public function getHeadline($id)
    {
        return Headline::find($id)->toJson();
    }



}
