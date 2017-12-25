<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplyFormRequest;
use App\Models\Activity;
use App\Models\User;
use App\Models\ActivityPrize;
use App\Models\ActivityQuestion;
use App\Models\ActivityRequire;
use App\Models\ActivityTask;
use App\Models\DoneTask;
use App\Models\GrassAttr;
use App\Models\Question;
use App\Models\Report;
use App\Models\ResultApply;
use App\Models\ResultQuestion;
use App\Models\ResultTask;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ActivityController extends Controller
{

    public function apply($activity_id, $report = "activity")
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

        $applied = ResultApply::where('activity_id', $activity_id)
            ->where('user_id', session('user_id'))
            ->exists();

        $question = ActivityQuestion::with('questions')
            ->where('activity_id', $activity_id)
            ->first();

        if ($report == 'report') {
            $users = ResultApply::with('user_wechats')
                ->where('activity_id', $activity_id)
                ->where('status', 1)
                ->get();
            $reports = Report::with('user_wechats')
                ->where("activity_id", $activity_id)
                ->get();
            return view('wechat.report.apply', [
                'activity' => $activity,
                'question' => $question,
                'applied' => $applied,
                'reports' => $reports,
                'users' => $users,
            ]);
        }

        return view('wechat.activity.apply', [
            'activity' => $activity,
            'question' => $question,
            'applied' => $applied,
        ]);

    }

    public function kill($activity_id, $report = "kill")
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

        $applied = ResultApply::where('activity_id', $activity_id)
            ->where('user_id', session('user_id'))
            ->exists();

        if ($report == 'report') {
            $users = ResultApply::with('user_wechats')
                ->where('activity_id', $activity_id)
                ->where('status', 1)
                ->get();
            $reports = Report::with('user_wechats')
                ->where("activity_id", $activity_id)
                ->get();
            return view('wechat.report.kill', [
                'activity' => $activity,
                'applied' => $applied,
                'reports' => $reports,
                'users' => $users,
            ]);
        }

        return view('wechat.activity.kill', [
            'activity' => $activity,
            'applied' => $applied,
        ]);
    }

    public function task($activity_id)
    {
        $activity = Activity::with(
            'articles',
            'result_tasks',
            'activity_requires',
            'activity_tasks'
        )->find($activity_id);

        $result_task = ResultTask::where('user_id', session('user_id'))
            ->where('activity_id', $activity_id)
            ->first();
        return view('wechat.activity.task', [
            'activity' => $activity,
            'result_task' => $result_task,
        ]);
    }

    public function task_cancel($activity_id)
    {
        ResultTask::where('user_id', session("user_id"))
            ->where('activity_id', $activity_id)
            ->update([
                "status" => 0
            ]);
    }

    public function get_task($activity_id)
    {
        $id = session("user_id");
        $done = ResultTask::where('user_id', $id)
            ->where('activity_id', $activity_id)
            ->where('status', 1)
            ->exists();
        $task_count = ResultTask::where('user_id', $id)
            ->where('status', null)
            ->count();

        if ($task_count == 4) {
            return Response::json(['message' => '最多同时进行4个任务', 'className' => 'error']);
        }

        if ($done) {
            $this->give_task_prize($activity_id, $id);
            return Response::json(['message' => '任务已完成', 'className' => 'success']);
        } else {
            ResultTask::create([
                'user_id' => $id,
                'activity_id' => $activity_id,
            ]);
            return Response::json(['message' => '已领取任务', 'className' => 'run']);
        }
    }

    public function task_list()
    {
        $user_tasks = ResultTask::where('user_id', session('user_id'))
            ->with('activities', 'activity_tasks')
            ->orderBy('created_at', 'desc')
            ->paginate(4);

        $hasTasks = ResultTask::where('user_id', session('user_id'))->exists();
        return view('wechat.activity.task-list', [
            'user_tasks' => $user_tasks,
            'hasTasks' => $hasTasks,
        ]);
    }

    public function task_question($activity_id)
    {
        $question = ActivityQuestion::where('activity_id', $activity_id)
            ->with('questions')
            ->first();
        return view('wechat.activity.task-question', [
            'question' => $question
        ]);
    }

    public function shop($activity_id)
    {
        $activity = Activity::with('articles')->find($activity_id);
        return view('wechat.activity.shop', [
            'activity' => $activity,
        ]);
    }

    public function airport($activity_id)
    {
        $activity = Activity::with('articles')->find($activity_id);
        return view('wechat.activity.airport', [
            'activity' => $activity,
        ]);
    }

    public function requires($activity_id)
    {
        if (Auth::guard('wechat')->guest()) {
            return "unlogin";
        }
        $user = UserInfo::where('user_id', session('user_id'))->first();
        $auth = ActivityRequire::where('activity_id', $activity_id)->first();
        if(User::find(session('user_id'))->shop_id == null){
            return "shop_error";
        }
        if ($auth->exp != null && $auth->exp > $user->exp) {
            return "exp_error";
        }
        if ($auth->level != null && $auth->level > $user->level) {
            return "level_error";
        }
        return "success";
    }

    public function require_kill($activity_id)
    {
        if (Auth::guard('wechat')->guest()) {
            return "unlogin";
        }
        $user = UserInfo::where('user_id', session('user_id'))->first();
        $auth = ActivityRequire::where('activity_id', $activity_id)->first();
        if(User::find(session('user_id'))->shop_id == null){
            return "shop_error";
        }

        if ($auth->exp != null && $auth->exp > $user->exp) {
            return "exp_error";
        }
        if ($auth->level != null && $auth->level > $user->level) {
            return "level_error";
        }

        $prizeCount = ActivityPrize::where('activity_id', $activity_id)->first()->count;

        $killedCount = ResultApply::where('activity_id', $activity_id)
            ->where('status', 1)
            ->count();

        if ($prizeCount - 1 == $killedCount) {
            Activity::find($activity_id)
                ->update([
                    'end_at' => date("Y-m-d H:i:s")
                ]);
        }

        if ($prizeCount == $killedCount) {
            return 'fail';
        }

        ResultApply::create([
            'activity_id' => $activity_id,
            'user_id' => session('user_id'),
            'status' => 1
        ]);

        return "success";
    }

    public function withoutQuestion($activity_id)
    {
        if(User::find(session('user_id'))->shop_id == null){
            return back()->with('error2', '你未绑定终端，不可以参与申请试用。用微信扫终端二维码，即可绑定。');
        }

        ResultApply::create([
            'activity_id' => $activity_id,
            'user_id' => session('user_id'),
        ]);

        return back()->with('success', '申请成功');
    }


    public function question(ApplyFormRequest $request)
    {
        $data = [
            'activity_id' => $request->activity_id,
            'question_id' => $request->question_id,
            'user_id' => session('user_id'),
        ];
        if ($request->type == 'radio' || $request->type == 'select') {
            $selected = Question::find($request->question_id)->selected;
            if ($selected == null || $selected + 0 == $request->selected) {
                $data['selected'] = $request->selected;
            } else {
                return back()->with('error', '选择错误');
            }
        } elseif ($request->type == 'photo') {
            $path = $request->photo->store('uploads/file/' . date('Ymd'), 'public');
            $data['image_path'] = '/storage/' . $path;
        } else {
            $data['input'] = $request->input;
        }
        ResultQuestion::create($data);

        ResultApply::create([
            'activity_id' => $request->activity_id,
            'user_id' => session('user_id'),
        ]);

        return back()->with('success', '申请成功');
    }

    public function question_for_task(ApplyFormRequest $request)
    {
        if (ResultTask::where('activity_id', $request->activity_id)
            ->where('user_id', session('user_id'))
            ->where('status', 1)
            ->exists()
        ) {
            return back()->with('error', '您已经完成任务，不要重复答题');
        }

        $activity_id = $request->activity_id;
        $id = session("user_id");
        $data = [
            'activity_id' => $activity_id,
            'question_id' => $request->question_id,
            'user_id' => $id,
        ];
        if ($request->type == 'radio' || $request->type == 'select') {
            $selected = Question::find($request->question_id)->selected;
            if ($selected == null || $selected + 0 == $request->selected) {
                $data['selected'] = $request->selected;
            } else {
                return back()->with('error', '选择错误');
            }
        } elseif ($request->type == 'photo') {
            $path = $request->photo->store('uploads/file/' . date('Ymd'), 'public');
            $data['image_path'] = '/storage/' . $path;
        } else {
            $data['input'] = $request->input;
        }
        ResultQuestion::create($data);

        //任务完成的奖励
        $this->give_task_prize($activity_id, $id);

        return back()->with('success', '答题成功，任务完成');
    }

    public function give_task_prize($activity_id, $id)
    {
        $task = ActivityTask::where('activity_id', $activity_id)->first();
        $grass_attr = GrassAttr::where('user_id', $id);

        switch ($task->prize_type) {
            case "water":
                $grass_attr->increment('water', $task->prize_count);
                break;
            case "seed":
                $grass_attr->increment('seed', $task->prize_count);
                break;
            case "ticket":
                UserInfo::where('user_id', $id)
                    ->increment('ticket', $task->prize_count);
                break;
        }
        ResultTask::where('activity_id', $activity_id)
            ->where('user_id', $id)
            ->update([
                'status' => 1,
            ]);
    }
}
