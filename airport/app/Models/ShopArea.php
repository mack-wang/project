<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ShopArea
 *
 * @property int $id
 * @property string $area
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Shop[] $shops
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopArea whereArea($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopArea whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopArea whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopArea whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ShopArea extends Model
{
    //
    protected $guarded = [];
    public function shops()
    {
        return $this->hasMany('App\Models\Shop','area_id','id');
    }


}
