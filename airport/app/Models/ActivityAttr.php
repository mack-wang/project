<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ActivityAttr
 *
 * @property int $id
 * @property int $activity_id
 * @property string $title
 * @property string $image_path 申领和秒杀活动的封面图
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityAttr whereActivityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityAttr whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityAttr whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityAttr whereImagePath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityAttr whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityAttr whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\ActivityPrize $activity_prizes
 */
class ActivityAttr extends Model
{
    //
    protected $guarded = [];
    public function activity_prizes()
    {
        return $this->hasOne('App\Models\ActivityPrize','activity_id','activity_id');
    }
}
