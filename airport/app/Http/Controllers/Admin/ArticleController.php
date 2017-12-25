<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        return view('admin.article', [
            'articles' => Article::with('activities','help_articles')->orderBy('updated_at', 'desc')->paginate(8),
        ]);
    }

    public function articleForm(Request $request)
    {
        Article::updateOrCreate(
            $request->only('id'),
            $request->only(['title', 'content'])
        );
        return back()->with('success', $request->id ? '文章修改成功' : '新文章上传成功');
    }

    public function delete($id)
    {
        if (Activity::where('article_id', $id)->exists()) {
            return back()->with('error', '该文章已经绑定活动，无法删除');
        }

        Article::find($id)->delete();

        return back()->with('success', '文章删除成功');
    }

    public function getContent($id)
    {
        return Article::find($id)->toJson();
    }

    public function search(Request $request)
    {
        return view('admin.article', [
            'articles' => Article::with('activities')
                ->where('title', 'like', '%' . $request->title . '%')
                ->orderBy('updated_at', 'desc')
                ->paginate(8),
            'title'=>$request->title,
        ]);
    }

    public function searchResults(Request $request)
    {
        return Article::with('activities')
            ->where('title', 'like', '%' . $request->title . '%')
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get()
            ->toJson();
    }
}
