<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReportFormRequest;
use App\Models\Activity;
use App\Models\Report;
use App\Models\ReportGood;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;


class ReportController extends Controller
{
    public function write($activity_id)
    {
        $activity = Activity::with(
            'activity_headimgs',
            'activity_attrs',
            'fetch_cigarettes',
            'activity_prizes'
        )->find($activity_id);
        return view('wechat.home.report', [
            'activity' => $activity,
        ]);
    }

    public function form(ReportFormRequest $request)
    {
        $id = session('user_id');
        $data = "";
        foreach ($request->file('images') as $image) {
            //切记把php.ini中的
            /*
            file_uploads = on ;是否允许通过HTTP上传文件的开关。默认为ON即是开
            upload_tmp_dir ;文件上传至服务器上存储临时文件的地方，如果没指定就会用系统默认的临时文件夹
            upload_max_filesize = 8m ;望文生意，即允许上传文件大小的最大值。默认为2M
            post_max_size = 8m ;指通过表单POST给PHP的所能接收的最大值，包括表单里的所有值。默认为8M
            */

            //获取图片后缀
            $ext = $image->extension();
            //创建日期文件夹，以免同一个文件夹下文件太多
            $date = date('Ymd');
            //生成日期文件夹
            $dir = public_path() . '/uploads/report/' . $date . '/';
            //生成日期文件夹，因为Image这个拓展不能自动创建文件夹
            File::exists($dir) or File::makeDirectory($dir);
            //生成文件名
            $name = str_random(6) . $id . '.' . $ext;
            //调整图片的尺寸，并把文件保存到上面的路径中，根目录是public/，save可以接受第二个数字参数，压缩比
            Image::make($image)->save($dir . $name, 30);
            //把所有的图片地址打包成一个字符串，用逗号分隔
            $data = $data . $date . '/' . $name . ',';
        }

        Report::create([
            'activity_id' => $request->activity_id,
            'scores' => $request->scores,
            'user_id' => $id,
            'smoke' => $request->smoke,
            'images' => rtrim($data, ","),
        ]);
        return redirect('/wechat/home');
    }

    public function good($report_id)
    {
        ReportGood::create([
            'report_id' => $report_id,
            'user_id' => session('user_id')
        ])->reports()->increment('goods');
    }

}
