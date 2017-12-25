<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Article
 *
 * @property int $id
 * @property int $activity_id
 * @property string $content 65,535 个字符的字符串
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereActivityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\ActivityShop $activity_shops
 * @property-read \App\Models\ActivityTask $activity_tasks
 * @property string $title 文章标题
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Activity[] $activities
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article whereTitle($value)
 */
class Article extends Model
{
    //
    protected $guarded = [];

    public function activity_shops()
    {
        return $this->hasOne('App\Models\ActivityShop','article_id','id');
    }
    public function activity_tasks()
    {
        return $this->hasOne('App\Models\ActivityTask','article_id','id');
    }
    public function help_articles()
    {
        return $this->hasOne('App\Models\HelpArticle','article_id','id');
    }
    public function activities()
    {
        return $this->hasMany('App\Models\Activity','article_id','id');
    }
}
