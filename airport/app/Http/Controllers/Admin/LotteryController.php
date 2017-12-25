<?php

namespace App\Http\Controllers\Admin;

use App\Models\QrcodePrize;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LotteryController extends Controller
{
    public function show()
    {
        $prizes = QrcodePrize::paginate(8);
        return view('admin.lottery',[
            'prizes'=>$prizes,
        ]);
    }
}
