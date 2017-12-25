<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ActivityPrize
 *
 * @property int $id
 * @property int $activity_id
 * @property int $cigarette_id
 * @property string $name
 * @property int $count 奖品数量
 * @property int $price 奖品价格
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityPrize whereActivityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityPrize whereCigaretteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityPrize whereCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityPrize whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityPrize whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityPrize whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityPrize wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityPrize whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\ActivityRequire $activity_requires
 * @property string $description 奖品描述用逗号分开每一条
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityPrize whereDescription($value)
 */
class ActivityPrize extends Model
{
    //
    protected $guarded = [];
    public function activity_requires()
    {
        return $this->hasOne('App\Models\ActivityRequire','activity_id','activity_id');
    }
}
