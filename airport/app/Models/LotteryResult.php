<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LotteryResult
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $prize_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotteryResult whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotteryResult whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotteryResult wherePrizeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotteryResult whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotteryResult whereUserId($value)
 * @mixin \Eloquent
 */
class LotteryResult extends Model
{
    protected $guarded = [];
}
