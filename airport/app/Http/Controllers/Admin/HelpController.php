<?php

namespace App\Http\Controllers\Admin;

use App\Models\HelpArticle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HelpController extends Controller
{
    public function index()
    {
        return view('admin.help');
    }

    public function setHelp($article_id)
    {
        if (HelpArticle::where('article_id', $article_id)->exists()) {
            HelpArticle::where('article_id', $article_id)->delete();
        } else {
            HelpArticle::create([
                'article_id' => $article_id
            ]);
        }
    }

}
