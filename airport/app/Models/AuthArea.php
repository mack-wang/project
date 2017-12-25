<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AuthArea
 *
 * @property int $id
 * @property int $activity_id
 * @property int $area_id 凡出现的area_id都不能参加参加对应id活动
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AuthArea whereActivityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AuthArea whereAreaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AuthArea whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AuthArea whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AuthArea whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AuthArea extends Model
{
    //
    protected $guarded = [];
}
