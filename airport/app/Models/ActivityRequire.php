<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ActivityRequire
 *
 * @property int $id
 * @property int $activity_id
 * @property int $level 等级要求
 * @property int $exp 经验要求
 * @property int $request 其他自定义要求
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityRequire whereActivityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityRequire whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityRequire whereExp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityRequire whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityRequire whereLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityRequire whereRequest($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityRequire whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Article $articles
 * @property-read \App\Models\ActivityShop $activity_shops
 * @property-read \App\Models\ActivityTask $activity_tasks
 */
class ActivityRequire extends Model
{
    protected $guarded = [];
    public function articles()
    {
        return $this->hasOne('App\Models\Article','activity_id','activity_id');
    }

    public function activity_shops()
    {
        return $this->hasOne('App\Models\ActivityShop','activity_id','activity_id');
    }
    public function activity_tasks()
    {
        return $this->hasOne('App\Models\ActivityTask','activity_id','activity_id');
    }

}
