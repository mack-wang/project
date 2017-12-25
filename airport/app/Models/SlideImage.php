<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SlideImage
 *
 * @property int $id
 * @property string $redirect_path
 * @property string $image_path
 * @property bool $state 0 为下架 1为上架
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SlideImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SlideImage whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SlideImage whereImagePath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SlideImage whereRedirectPath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SlideImage whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SlideImage whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $article_id
 * @property-read \App\Models\Article $articles
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SlideImage whereArticleId($value)
 */
class SlideImage extends Model
{
    //
    protected $guarded = [];

    public function articles()
    {
        return $this->hasOne('App\Models\Article', 'id', 'article_id');
    }
}
