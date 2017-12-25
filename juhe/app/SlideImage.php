<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\SlideImage
 *
 * @property int $id
 * @property int $article_id
 * @property string $redirect_path
 * @property string $image_path
 * @property bool $state 0 为下架 1为上架
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Article $articles
 * @method static \Illuminate\Database\Query\Builder|\App\SlideImage whereArticleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SlideImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SlideImage whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SlideImage whereImagePath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SlideImage whereRedirectPath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SlideImage whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SlideImage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SlideImage extends Model
{
    protected $guarded=[];

    public function articles()
    {
        return $this->hasOne('\App\Article','id','article_id');
    }
}
