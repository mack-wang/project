<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Catalog;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function article()
    {
        $articles = Article::with('catalogs')->paginate(4);
        return view('admin.article', ['articles' => $articles]);
    }

    public function catalog()
    {
        $catalogs = Catalog::with('articles')->paginate(6);
        return view('admin.catalog', ['catalogs' => $catalogs]);
    }

    public function editArticle($id = null)
    {
        $catalogs = Catalog::all();
        return view('admin.editArticle', [
            'catalogs' => $catalogs,
            'id' => $id,
        ]);
    }

    //返回ajax一篇文章的json信息
    public function getArticle($id)
    {
        return Article::find($id)->toJson();
    }

    public function addArticle(ArticleRequest $request)
    {
        Article::updateOrCreate(
            ['id' => $request->id],
            $request->only([
                'catalog_id',
                'brand',
                'image',
                'title',
                'brief',
                'content',
            ]));
        return back()->with('success', $request->id == null ? '新文章添加成功' : '文章修改成功')
            ->withInput();
    }

    public function addCatalog(Request $request)
    {
        if (strlen($request->catalog) == 0 || strlen($request->catalog) > 32) {
            return back()->with('error', '目录长度为1-32个字符')->withInput();
        }

        Catalog::updateOrCreate(
            ['id' => $request->id],
            ["catalog" => $request->catalog]
        );

        return back()->with('success', $request->id == null ? '新目录添加成功' : '目录修改成功');
    }

    public function delCatalog($id)
    {
        if (Catalog::find($id)->auth == 1) {
            return back()->with('error', '重要目录，只允许修改，不允许删除');
        }

        Catalog::find($id)->delete();
        return back()->with('success', '目录软删除成功');
    }

    public function recommendCatalog($id)
    {
        $catalog = Catalog::find($id);
        $catalog->recommend ? $catalog->recommend = 0 : $catalog->recommend = 1;
        $catalog->save();
    }

    public function topCatalog($id)
    {
        $catalog = Catalog::find($id);
        $catalog->top ? $catalog->top = 0 : $catalog->top = 1;
        $catalog->save();
    }

    public function offCatalog($id)
    {
        $catalog = Catalog::find($id);
        $catalog->off ? $catalog->off = 0 : $catalog->off = 1;
        $catalog->save();
    }


    public function delArticle($id)
    {
        Article::find($id)->delete();
        return back()->with('success', '文章删除成功');
    }


    //根据搜索的参数，来显示所有文章
    public function search(Request $request)
    {
        $articles = $this->searchKey($request->search, $request->value)
            ->paginate(5);

        return view('admin.article', [
            'articles' => $articles,
        ]);
    }

    public function searchKey($key, $value)
    {
        switch ($key) {
            case 'catalog':
                return Article::where('catalog_id',Catalog::where('catalog',$value)->first()->id);
                break;
            case 'title':
                return Article::where('title','like','%'.$value.'%');
                break;
            default :
                return Article::where($key, $value);
        }
    }

    public function topArticle($id)
    {
        $article = Article::find($id);
        $article->top ? $article->top = 0 : $article->top = 1;
        $article->save();
    }
}
