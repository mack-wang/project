<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleFormRequest;
use App\Http\Requests\ArticleOnlyFormRequest;
use App\Http\Requests\NavFormRequest;
use App\Http\Requests\QuestionFormRequest;
use App\Http\Requests\TaskFormRequest;
use App\Models\Activity;
use App\Models\ActivityQuestion;
use App\Models\HeadImage;
use App\Models\PrizeDescribe;
use App\Models\Question;
use App\Models\SlideImage;
use Illuminate\Support\Facades\Cookie;

class ActivityController extends Controller
{
    public function apply()
    {
        return view('admin.activity.apply');
    }

    public function kill()
    {
        return view('admin.activity.kill');
    }

    public function airport()
    {
        return view('admin.activity.airport');
    }

    public function shop()
    {
        return view('admin.activity.shop');
    }

    public function task()
    {
        return view('admin.activity.task');
    }

    public function nav()
    {
        $navs = SlideImage::with('articles')
            ->paginate(6);
        return view('admin.activity.nav', [
            'navs' => $navs
        ]);
    }

    public function navToggle($id)
    {
        $nav = SlideImage::find($id);
        $nav->state ? $nav->state = 0 : $nav->state = 1;
        $nav->save();
    }

    public function navDelete($id)
    {
        SlideImage::find($id)->delete();
        return back()->with('success', '删除成功');

    }

    public function getNav($id)
    {
        return SlideImage::find($id)->toJson();
    }

    public function navForm(NavFormRequest $request)
    {
        SlideImage::updateOrCreate(
            $request->only('id'),
            $request->only('article_id', 'redirect_path', 'image_path')
        );

        return back()->with('success', $request->id ? '修改成功' : '上传成功');
    }

    public function question()
    {
        $questions = Question::paginate(8);
        $type = ['radio' => '单选', 'select' => '多选', 'photo' => '照片', 'input' => '文字'];
        return view('admin.activity.question', [
            'questions' => $questions,
            'type' => $type,
        ]);
    }


    //申领活动，秒杀活动提交
    public function article(ArticleFormRequest $request)
    {
        $request->start_at = date("Y-m-d H:i:s", strtotime($request->start_at));
        $request->end_at = date("Y-m-d H:i:s", strtotime($request->end_at));
        $result = Activity::create($request->only([
            "type",
            "cigarette_id",
            "article_id",
            "off",
            "elect",
            "start_at",
            "end_at"
        ]))->activity_headimgs()->create([
            "image_path" => $request->image_path,
        ])->activity_attrs()->create([
            "title" => $request->title,
        ])->activity_prizes()->create($request->only([
            "cigarette_id",
            "name",
            "count",
            "price",
            "description",
        ]))->activity_requires()->create($request->only([
            "level",
            "exp",
        ]));

        if ($request->question_id != null) {
            ActivityQuestion::create([
                "activity_id" => $result->activity_id,
                "question_id" => $request->question_id,
            ]);
        }

        return back()->with('success', $request->off ? '新活动已保存到草稿' : '新活动添加成功');
    }

    //机场活动，烟店活动提交
    public function articleOnly(ArticleOnlyFormRequest $request)
    {
        $images = str_getcsv($request->image_path);
        $request->start_at = date("Y-m-d H:i:s", strtotime($request->start_at));
        $request->end_at = date("Y-m-d H:i:s", strtotime($request->end_at));
        Activity::create($request->only([
            "article_id",
            "type",
            "off",
            "start_at",
            "end_at"
        ]))->activity_requires()->create($request->only([
            "level",
            "exp",
        ]))->activity_shops()->create([
            "image_path"=>$images[0],
            "avatar_path"=>count($images)>1?$images[1]:null,
            "link"=>$request->link,
            "button"=>$request->button,
            "message"=>$request->message,
        ]);

        return back()->with('success', $request->off ? '新活动已保存到草稿' : '新活动添加成功');
    }

    //任务活动提交
    public function task_form(TaskFormRequest $request)
    {
        $request->start_at = date("Y-m-d H:i:s", strtotime($request->start_at));
        $request->end_at = date("Y-m-d H:i:s", strtotime($request->end_at));
        $result = Activity::create($request->only([
            "article_id",
            "type",
            "off",
            "start_at",
            "end_at"
        ]))->activity_requires()->create($request->only([
            "level",
            "exp",
        ]))->activity_tasks()->create([
            "type" => $request->task_type,
            "link" => $request->link,
            "message" => $request->message,
            "title" => $request->title,
            "prize_name" => $request->prize_name,
            "prize_type" => $request->prize_type,
            "prize_count" => $request->prize_count,
            "top" => $request->top,
        ]);

        if ($request->question_id != null) {
            ActivityQuestion::create([
                "activity_id" => $result->activity_id,
                "question_id" => $request->question_id,
            ]);
        }

        return back()->with('success', $request->off ? '新任务已保存到草稿' : '新任务添加成功');
    }

    public function question_form(QuestionFormRequest $request)
    {
        if ($request->type == 'radio') {
            $request->selected = $request->selected[0];
        }

        Question::updateOrCreate(
            ["id" => $request->id],
            $request->only([
                'image_path',
                'question',
                'options',
                'selected',
                'type'
            ]));

        return back()->with('success', $request->id == null ? '新题目添加成功' : '修改成功');
    }

    public function questionDelete($id)
    {
        Question::find($id)->delete();
        return back();
    }

    public function applyList()
    {

    }

}
