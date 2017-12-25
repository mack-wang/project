<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ResultTask
 *
 * @property int $id
 * @property int $activity_id
 * @property int $user_id
 * @property bool $status 任何活动都是四个状态 null 已参与 0 是失败 1 是成功
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Activity $activities
 * @property-read \App\Models\ActivityTask $activity_tasks
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultTask whereActivityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultTask whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultTask whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultTask whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultTask whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultTask whereUserId($value)
 * @mixin \Eloquent
 */
class ResultTask extends Model
{
    protected $guarded=[];

    public function activity_tasks()
    {
        return $this->hasOne('App\Models\ActivityTask','activity_id','activity_id');
    }

    public function activities()
    {
        return $this->hasOne('App\Models\Activity','id','activity_id');
    }
}
