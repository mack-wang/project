<?php

namespace App\Http\Controllers\Wechat;

use App\Models\HelpArticle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HelpController extends Controller
{
    public function index()
    {
        $helps = HelpArticle::with('articles')->get();
        return view('wechat.home.help-list',[
            'helps'=>$helps
        ]);
    }
}
