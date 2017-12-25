<?php

namespace App\Http\Controllers\Wechat;

use App\Article;
use App\Catalog;
use App\CompanyInfo;
use App\Contact;
use App\Headline;
use App\Http\Controllers\Controller;
use App\SlideImage;
use App\UserAvatar;
use App\WechatConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class HomeController extends Controller
{
    public function home()
    {
        $navs = SlideImage::all();
        $headlines = Headline::all();
        $catalogs = Catalog::where('off', 0)
            ->where('recommend', 1)
            ->orderBy('top', 'desc')
            ->get();

        return view("wechat.home", [
            'navs' => $navs,
            'headlines' => $headlines,
            'catalogs' => $catalogs,
        ]);
    }


    public function product()
    {
        $catalogs = Catalog::where('off', 0)
            ->orderBy('top', 'desc')
            ->simplePaginate(4);

        $menus = Catalog::where('off', 0)
            ->orderBy('top', 'desc')
            ->get();

        return view("wechat.product", [
            'catalogs' => $catalogs,
            'menus' => $menus,
        ]);
    }

    public function connect()
    {
        return view("wechat.connect", [
            'contact' => Contact::find(1),
        ]);
    }

    public function company()
    {
        $article = Article::find(CompanyInfo::find(1)->article_id);
        return view("wechat.company", [
            'article' => $article
        ]);
    }


    public function article($id)
    {
        return view('wechat.article', [
            'article' => Article::find($id),
        ]);
    }

    public function catalog($id)
    {
        return view('wechat.catalog', [
            'articles' => Article::where('catalog_id', $id)
                ->orderBy('top','desc')
                ->paginate(5),
        ]);
    }

    public function reset()
    {
        Auth::logout();
        return redirect('/password/reset');
    }

    public function avatar(Request $request)
    {

        $id = Auth::id();

        //获取图片后缀
        $image = $request->file('avatar');
        $ext = $image->extension();
        //创建日期文件夹，以免同一个文件夹下文件太多
        $date = date('Ymd');
        //生成日期文件夹
        $dir = public_path() . '/uploads/avatar/' . $date . '/';
        //生成日期文件夹，因为Image这个拓展不能自动创建文件夹
        File::exists($dir) or File::makeDirectory($dir);
        //生成文件名
        $name = str_random(6) . dechex($id) . '.' . $ext;
        //调整图片的尺寸，并把文件保存到上面的路径中，根目录是public/，save可以接受第二个数字参数，压缩比
        Image::make($image)->widen(300)->crop(300, 300)->save($dir . $name);
        //把所有的图片地址打包成一个字符串，用逗号分隔
        $image_path = '/uploads/avatar/' . $date . '/' . $name;

        UserAvatar::updateOrCreate(
            ['user_id' => $id],
            ['image_path' => $image_path]
        );

        return back();
    }
}
