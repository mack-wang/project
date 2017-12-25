<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Article
 *
 * @property int $id
 * @property int $catalog_id
 * @property string $brand
 * @property string $image
 * @property string $title
 * @property string $brief 简介
 * @property string $content 65,535 个字符的字符串
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Article whereBrand($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Article whereBrief($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Article whereCatalogId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Article whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Article whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Article whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Article whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Article whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Catalog $catalogs
 */
class Article extends Model
{
    protected $guarded = [];

    public function catalogs()
    {
        return $this->hasOne("App\Catalog", "id", "catalog_id");
    }
}
