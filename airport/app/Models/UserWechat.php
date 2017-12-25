<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserWechat
 *
 * @property int $id
 * @property int $user_id
 * @property string $nickname
 * @property string $headimgurl
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\UserWechatInfo $user_wechat_infos
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserWechat whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserWechat whereHeadimgurl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserWechat whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserWechat whereNickname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserWechat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserWechat whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\UserInfo $user_infos
 */
class UserWechat extends Model
{
    //
    protected $guarded = [];

    public function user_wechat_infos()
    {
        return $this->hasOne('App\Models\UserWechatInfo','user_id','user_id');
    }

    public function user_infos()
    {
        return $this->hasOne('App\Models\UserInfo','user_id','user_id');
    }
}
