<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Grass
 *
 * @property int $id
 * @property int $user_id
 * @property int $water 当前这棵草的水滴
 * @property int $total 当前这棵草长成所有要的经验值
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Grass whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Grass whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Grass whereTotal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Grass whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Grass whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Grass whereWater($value)
 * @mixin \Eloquent
 * @property-read \App\Models\GrassAttr $grass_attrs
 */
class Grass extends Model
{
    //
    protected $guarded=[];
    public function grass_attrs()
    {
        return $this->hasOne('App\Models\GrassAttr', 'user_id', 'user_id');
    }
}
