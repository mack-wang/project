<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ActivityHeadimg
 *
 * @property int $id
 * @property int $activity_id
 * @property string $image_path 用逗号分开的路径
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\ActivityAttr $activity_attrs
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityHeadimg whereActivityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityHeadimg whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityHeadimg whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityHeadimg whereImagePath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityHeadimg whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ActivityHeadimg extends Model
{
    protected $guarded = [];

    public function activity_attrs()
    {
        return $this->hasOne('App\Models\ActivityAttr','activity_id','activity_id');
    }
}
