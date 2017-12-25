<?php

use App\Models\Activity;
use App\Models\ResultApply;
use Illuminate\Foundation\Inspiring;
use App\Http\Controllers\Admin\Helper;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('elect', function () {
    $unElects = Activity::with('activity_prizes')
        ->where('type', 'apply')
        ->where('elect', 0)
        ->whereDate('end_at', '<', date('Y-m-d H:i:s'))
        ->get();
    foreach ($unElects as $unElect) {
        $elects = ResultApply::with('activity_attrs', 'user_infos')
            ->where('activity_id', $unElect->id)
            ->inRandomOrder()
            ->take($unElect->activity_prizes->count)
            ->get();
        foreach ($elects as $elect) {
            $elect->status = 1;
            $elect->save();
            Helper::sendMessage($elect->user_infos->phone, "博烟荟萃免费试用申请通知，您申请的（" . $elect->activity_attrs->title . "）申请成功！试用产品将于7日之内邮寄到您的注册地址，请注意查收。完成产品试用后，请登入博烟荟萃微信公众号-个人中心，填写试用评价，感谢您的参与！");
        };
        $unElect->elect = 2;
        $unElect->save();
    };

})->describe('系统选择申领成功用户');

