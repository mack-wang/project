<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResourceController extends Controller
{
    public function qrcode()
    {
        return response()->download(public_path()
            . '/storage/qrcode/invite-friend.png', '二维码.png');
    }
}
