<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Headline
 *
 * @property-read \App\Article $articles
 * @mixin \Eloquent
 * @property int $id
 * @property string $headline
 * @property int $view 浏览数
 * @property int $article_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Headline whereArticleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Headline whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Headline whereHeadline($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Headline whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Headline whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Headline whereView($value)
 */
class Headline extends Model
{
    protected $guarded = [];

    public function articles()
    {
        return $this->hasOne('App\Article', 'id', 'article_id');
    }
}
