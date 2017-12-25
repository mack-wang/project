<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ActivityQuestion;
use App\Models\Report;
use App\Models\User;
use App\Models\Shop;
use App\Models\ResultApply;
use App\Models\ResultQuestion;
use App\Models\ResultTask;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class ListController extends Controller
{
    public function index()
    {
        return view('admin.list.list', [
            'activities' => Activity::with('fetch_cigarettes', 'activity_attrs', 'articles')->paginate(8),
        ]);
    }

    public function applyDetail($activity_id)
    {
        $activity = Activity::with(
            'articles',
            'activity_attrs',
            'activity_prizes',
            'activity_requires',
            'activity_headimgs',
            'result_applies',
            'fetch_cigarettes'
        )->find($activity_id);

        $question = ActivityQuestion::with('questions')
            ->where('activity_id', $activity_id)
            ->first();

        $results = [
            'userCount' => ResultApply::where('activity_id', $activity_id)
                ->count(),
            'winnerCount' => ResultApply::where('activity_id', $activity_id)
                ->where('status', 1)
                ->count(),
            'reportCount' => Report::where('activity_id', $activity_id)
                ->count(),
        ];


        return view('admin.list.apply-detail', [
            'activity' => $activity,
            'question' => $question,
            'results' => $results,
        ]);
    }


    public function shopDetail($activity_id)
    {
        $activity = Activity::with('articles', 'activity_shops')
            ->find($activity_id);

        return view('admin.list.shop-detail', [
            'activity' => $activity,
        ]);
    }

    public function taskDetail($activity_id)
    {
        $activity = Activity::with('articles', 'activity_tasks')
            ->find($activity_id);

        $results = [
            'userCount' => ResultTask::where('activity_id', $activity_id)
                ->count(),
            'winnerCount' => ResultTask::where('activity_id', $activity_id)
                ->where('status', 1)
                ->count(),
        ];

        $question = ActivityQuestion::with('questions')
            ->where('activity_id', $activity_id)
            ->first();

        return view('admin.list.task-detail', [
            'activity' => $activity,
            'results' => $results,
            'question' => $question,
        ]);
    }

    public function delete($activity_id)
    {
        if (ResultApply::where('activity_id', $activity_id)->exists()
            || ResultTask::where('activity_id', $activity_id)->exists()
            || ResultQuestion::where('activity_id', $activity_id)->exists()
        ) {
            return back()->with('error', '活动已经产生用户参与数据，不允许删除');
        }

        switch (Activity::find($activity_id)->type) {
            case 'apply':
            case 'kill':
                Activity::find($activity_id)->apply_delete();
                break;
            case 'airport':
            case 'shop':
                Activity::find($activity_id)->shop_delete();
                break;
            case 'task':
                Activity::find($activity_id)->task_delete();
                break;
        }

        return back()->with('success', '删除成功');
    }

    public function applyEdit(Request $request)
    {
        $activity = Activity::find($request->activity_id);

        switch ($request->field) {
            case 'count':
            case 'description':
                $item = $activity->activity_prizes();
                break;
            case 'exp':
            case 'level':
                $item = $activity->activity_requires();
                break;
            case 'image_path':
                $item = $activity->activity_headimgs();
                break;
            case 'title':
                $item = $activity->activity_attrs();
                break;
            case 'question_id':
                $item = $activity->activity_questions();
                if (!ActivityQuestion::where('activity_id', $request->activity_id)->exists()) {
                    ActivityQuestion::create([
                        'activity_id' => $request->activity_id,
                        'question_id' => $request->value,
                    ]);
                    return 1;
                }
                break;
            default:
                $item = $activity;
        }

        $item->update([
            $request->field => $request->value
        ]);

        return 1;
    }

    public function shopEdit(Request $request)
    {
        $activity = Activity::find($request->activity_id);
        $images = str_getcsv($request->value);

        switch ($request->field) {
            case 'exp':
            case 'level':
                $item = $activity->activity_requires();
                break;
            case 'image_path':
            case 'link':
            case 'button':
            case 'message':
                $item = $activity->activity_shops();
                break;
            default:
                $item = $activity;
        }

        if (count($images) > 1) {
            $item->update([
                "image_path" => $images[0],
                "avatar_path" => $images[1],
            ]);
        } else {
            $item->update([
                $request->field => $request->value
            ]);
        }


        return 1;
    }

    public function taskEdit(Request $request)
    {
        $activity = Activity::find($request->activity_id);

        switch ($request->field) {
            case 'exp':
            case 'level':
                $item = $activity->activity_requires();
                break;
            case 'start_at':
            case 'end_at':
            case 'article_id':
                $item = $activity;
                break;
            case 'question_id':
                $item = $activity->activity_questions();
                if (!ActivityQuestion::where('activity_id', $request->activity_id)->exists()) {
                    ActivityQuestion::create([
                        'activity_id' => $request->activity_id,
                        'question_id' => $request->value,
                    ]);
                    return 1;
                }
                break;
                break;
            default:
                $item = $activity->activity_tasks();
        }

        $item->update([
            $request->field => $request->value
        ]);

        return 1;
    }

    public function activitiesToggle($id)
    {
        $activity = Activity::find($id);
        $activity->off ? $activity->off = 0 : $activity->off = 1;
        $activity->save();
    }

    public function applyView($activity_id)
    {
        $results = [
            'userCount' => ResultApply::where('activity_id', $activity_id)
                ->count(),
            'winnerCount' => ResultApply::where('activity_id', $activity_id)
                ->where('status', 1)
                ->count(),
            'reportCount' => Report::where('activity_id', $activity_id)
                ->count(),
        ];

        $users = ResultApply::with(
            'user_wechats',
            'user_attrs',
            'users',
            'user_infos',
            'user_addresses',
            'reports'
        )
            ->where('activity_id', $activity_id)
            ->paginate(Helper::page());

        $activity = Activity::find($activity_id);
        $reportCount = Report::where("activity_id", $activity_id)->count();
        $appliedCount = ResultApply::where('activity_id', $activity_id)->where('status', 1)->count();
        $step = 0;
        if (strtotime($activity->end_at) < time()) {
            $step++;
            if ($activity->elect == 2) {
                $step++;
                if ($reportCount > 0) {
                    $step++;
                    if ($reportCount == $appliedCount) {
                        $step++;
                    }
                }
            }
        }

        $activity = Activity::with('activity_attrs', 'activity_prizes', 'fetch_cigarettes')->find($activity_id);

        return view('admin.list.apply-view', [
            'results' => $results,
            'users' => $users,
            'step' => $step,
            'activity' => $activity,
        ]);
    }

    public function setResultApply($result_apply_id)
    {
        $apply = ResultApply::with('user_infos', 'activity_attrs')->find($result_apply_id);
        if ($apply->status != 1) {
            $apply->status = 1;
            $apply->save();
        }
    }

    public function setElect($activity_id)
    {
        Activity::find($activity_id)->update(['elect' => 2]);
        $elects = ResultApply::with('user_infos', 'activity_attrs')
            ->where('activity_id', $activity_id)
            ->where('status', 1)
            ->get();
        foreach ($elects as $elect) {
            Helper::sendMessage($elect->user_infos->phone, "博烟荟萃免费试用申请通知，您申请的（" . $elect->activity_attrs->title . "）申请成功！试用产品将于7日之内邮寄到您的注册地址，请注意查收。完成产品试用后，请登入博烟荟萃微信公众号-个人中心，填写试用评价，感谢您的参与！");
        }
        return back()->with('success','操作成功');
    }

    public function showReport($report_id)
    {
        $report = Report::with('user_wechats')->find($report_id);
        return view('admin.list.report', [
            'report' => $report,
        ]);
    }

    public function search($key, $value, $activity_id)
    {
        //根据地区，返回所有用户
        $users = $this->searchKey($key, $value)
            ->where('activity_id', $activity_id)
            ->with('user_wechats',
                'user_attrs',
                'users',
                'user_infos',
                'user_addresses',
                'reports')
            ->paginate(Helper::page());

        $results = [
            'userCount' => ResultApply::where('activity_id', $activity_id)
                ->count(),
            'winnerCount' => ResultApply::where('activity_id', $activity_id)
                ->where('status', 1)
                ->count(),
            'reportCount' => Report::where('activity_id', $activity_id)
                ->count(),
        ];

        $activity = Activity::find($activity_id);
        $reportCount = Report::where("activity_id", $activity_id)->count();
        $appliedCount = ResultApply::where('activity_id', $activity_id)->where('status', 1)->count();
        $step = 0;
        if (strtotime($activity->end_at) < time()) {
            $step++;
            if ($activity->elect == 2) {
                $step++;
                if ($reportCount > 0) {
                    $step++;
                    if ($reportCount == $appliedCount) {
                        $step++;
                    }
                }
            }
        }

        $activity = Activity::with('activity_attrs', 'activity_prizes', 'fetch_cigarettes')->find($activity_id);

        return view('admin.list.apply-view', [
            'users' => $users,
            'key' => $key,
            'value' => $value,
            'results' => $results,
            'step' => $step,
            'activity' => $activity,
        ]);
    }


    public function searchKey($key, $value)
    {
        switch ($key) {
            case 'real_name':
                return ResultApply::whereHas('user_attrs', function ($query) use ($value) {
                    $query->where('real_name', '=', $value);
                });
                break;
            case 'phone':
                return ResultApply::whereHas('user_infos', function ($query) use ($key, $value) {
                    $query->where($key, '=', $value);
                });
                break;
            case 'shop_name':
                $users = User::where('shop_id', Shop::where('name', $value)->first()->id)->pluck('id');
                return ResultApply::whereIn('user_id', $users);
                break;
            case 'nickname':
                return ResultApply::whereHas('user_wechats', function ($query) use ($value) {
                    $query->where('nickname', 'like', "%$value%");
                });
                break;
        }
    }

    public function excel($activity_id, $key = null, $value = null)
    {
        //根据地区，返回店铺管理员
        Excel::create($value . '试用申请表' . date("Y-m-d"), function ($excel) use ($key, $value, $activity_id) {

            $excel->sheet('Sheetname', function ($sheet) use ($key, $value, $activity_id) {

                if ($key == null) {
                    $users = ResultApply::with('user_wechats',
                        'user_attrs',
                        'users',
                        'user_infos',
                        'user_addresses',
                        'reports')
                        ->where('activity_id', $activity_id)
                        ->get()
                        ->toArray();
                } else {
                    $users = $this->searchKey($key, $value)
                        ->with('user_wechats',
                            'user_attrs',
                            'users',
                            'user_infos',
                            'user_addresses',
                            'reports')
                        ->where('activity_id', $activity_id)
                        ->get()
                        ->toArray();
                }

                $data = [];

                $title = [
                    '用户编号',
                    '店铺编号',
                    '姓名',
                    '微信昵称',
                    '注册手机号',
                    '邮寄手机号',
                    '终端',
                    '省份',
                    '城市',
                    '县区',
                    '具体地址',
                    '创建时间',
                    '申请状态（1为申请成功）',
                ];

                foreach ($users as $user) {
                    array_push($data, [
                        $user['user_id'],
                        $shop_id = User::find($user['user_id'])->shop_id,
                        $user['user_attrs']['real_name'],
                        $user['user_wechats']['nickname'],
                        $user['user_infos']['phone'],
                        $user['user_addresses']['mail_phone'],
                        Shop::find($shop_id)->name,
                        DB::table('mh_city')->find($user['user_addresses']['province'])->name,
                        DB::table('mh_city')->find($user['user_addresses']['city'])->name,
                        DB::table('mh_city')->find($user['user_addresses']['area'])->name,
                        $user['user_addresses']['address'],
                        $user['created_at'],
                        $user['status'],
                    ]);
                }

                $sheet->appendRow($title);
                $sheet->rows($data);
            });
        })->download('xls');

    }
}
