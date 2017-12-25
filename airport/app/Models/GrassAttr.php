<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GrassAttr
 *
 * @property int $user_id
 * @property int $water 水量，单位量100滴
 * @property int $seed 种子，1个种子种一棵草
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GrassAttr whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GrassAttr whereSeed($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GrassAttr whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GrassAttr whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GrassAttr whereWater($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Grass[] $grasses
 */
class GrassAttr extends Model
{
    //
    protected $guarded = [];
    public function grasses()
    {
        return $this->hasMany('App\Models\Grass', 'user_id', 'user_id');
    }
}
