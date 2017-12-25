<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Lottery
 *
 * @property int $id
 * @property int|null $prize_id
 * @property int|null $start_num 起点数
 * @property int|null $end_num 终点数
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lottery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lottery whereEndNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lottery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lottery wherePrizeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lottery whereStartNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lottery whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Lottery extends Model
{
    protected $guarded = [];
}
