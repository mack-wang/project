<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ActivityShop
 *
 * @property int $id
 * @property int $activity_id
 * @property string $image_path
 * @property string $button 按钮文字
 * @property string $message 店铺名字后的备注，留言，说明
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Activity $activities
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityShop whereActivityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityShop whereButton($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityShop whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityShop whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityShop whereImagePath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityShop whereMessage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityShop whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $link 独有活动链接例如 /wechat/link/takephoto
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityShop whereLink($value)
 * @property-read \App\Models\Article $articles
 * @property string|null $avatar_path
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityShop whereAvatarPath($value)
 */
class ActivityShop extends Model
{
    //
    protected $guarded = [];

    public function activities()
    {
        return $this->hasOne('App\Models\Activity', 'id', 'activity_id');
    }

    public function articles()
    {
        return $this->hasOne('App\Models\Article', 'id', 'article_id');
    }



}
