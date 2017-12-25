<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Report
 *
 * @property int $id
 * @property int $activity_id 用户获奖的活动id
 * @property bool $scores 打分，满分5分
 * @property int $user_id
 * @property string $smoke 用户的品吸感受
 * @property string $images 上传图片的地址，最多9张
 * @property int $goods 用户点赞总数
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ReportGood[] $report_goods
 * @property-read \App\Models\UserWechat $user_wechats
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Report whereActivityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Report whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Report whereGoods($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Report whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Report whereImages($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Report whereScores($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Report whereSmoke($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Report whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Report whereUserId($value)
 * @mixin \Eloquent
 */
class Report extends Model
{
    protected $guarded = [];

    public function user_wechats()
    {
        return $this->hasOne("App\Models\UserWechat",'user_id','user_id');
    }

    public function report_goods()
    {
        return $this->hasMany("App\Models\ReportGood","report_id","id");
    }
}
