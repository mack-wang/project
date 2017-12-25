<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ResultApply
 *
 * @property int $id
 * @property int $activity_id
 * @property int $user_id
 * @property bool $status 任何活动都是四个状态 null 已参与 0 是失败 1 是成功
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultApply whereActivityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultApply whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultApply whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultApply whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultApply whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultApply whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Activity $activities
 * @property-read \App\Models\ActivityAttr $activity_attrs
 * @property-read \App\Models\Report $reports
 * @property-read \App\Models\UserWechat $user_wechats
 * @property-read \App\Models\UserInfo $user_infos
 */
class ResultApply extends Model
{
    //
    protected $guarded = [];

    public function users(){
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function user_attrs(){
        return $this->hasOne('App\Models\UserAttr', 'user_id', 'user_id');
    }

    public function user_addresses(){
        return $this->hasOne('App\Models\UserAddress', 'user_id', 'user_id');
    }

    public function activity_attrs()
    {
        return $this->hasOne('App\Models\ActivityAttr', 'activity_id', 'activity_id');
    }
    public function activity_prizes()
    {
        return $this->hasOne('App\Models\ActivityAttr', 'activity_id', 'activity_id');
    }

    public function activities()
    {
        return $this->hasOne('App\Models\Activity', 'id', 'activity_id');
    }

    public function reports()
    {
        return $this->hasOne('App\Models\Report', 'activity_id', 'activity_id');
    }

    public function user_wechats()
    {
        return $this->hasOne('App\Models\UserWechat', 'user_id', 'user_id');
    }

    public function user_infos()
    {
        return $this->hasOne('App\Models\UserInfo', 'user_id', 'user_id');
    }



}
