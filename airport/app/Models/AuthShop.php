<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AuthShop
 *
 * @property int $id
 * @property int $activity_id
 * @property int $shop_id 凡出现的shop_id都不能参加对应id的活动
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AuthShop whereActivityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AuthShop whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AuthShop whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AuthShop whereShopId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AuthShop whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AuthShop extends Model
{
    //
    protected $guarded = [];
}
