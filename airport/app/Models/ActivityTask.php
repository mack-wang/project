<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ActivityTask
 *
 * @property int $id
 * @property int $activity_id
 * @property string $type 任务类型 airport 机场任务 shop 烟店任务 all 通用任务
 * @property string $link 任务链接例如 /wechat/task/takephoto
 * @property string $message 任务简称
 * @property string $title 任务全称
 * @property string $prize_name 滴水 颗种子 张礼品券
 * @property string $prize_type water 水 seed 种子 ticket 礼品券
 * @property int $prize_count 奖励奖品的数量
 * @property bool $top 置顶，为1是置顶
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityTask whereActivityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityTask whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityTask whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityTask whereLink($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityTask whereMessage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityTask wherePrizeCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityTask wherePrizeName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityTask wherePrizeType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityTask whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityTask whereTop($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityTask whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityTask whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ActivityTask extends Model
{
    //
    protected $guarded = [];

}
