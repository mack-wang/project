<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserRecommend
 *
 * @property int $id
 * @property int|null $user_id 当前用户的user_id
 * @property int|null $recommend_id 推荐人的user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\UserInfo $user_infos
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRecommend whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRecommend whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRecommend whereRecommendId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRecommend whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRecommend whereUserId($value)
 * @mixin \Eloquent
 */
class UserRecommend extends Model
{
    protected $guarded = [];

    public function user_infos()
    {
        return $this->hasOne('App\Models\UserInfo','user_id','user_id');
    }
}
