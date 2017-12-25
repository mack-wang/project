<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Catalog
 *
 * @property int $id
 * @property string $catalog
 * @property bool $auth 1 重要目录，只能修改，不能删除
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Catalog whereAuth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Catalog whereCatalog($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Catalog whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Catalog whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Catalog whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property bool $off 1 为关闭 0 为开启
 * @property bool $top 1 为置顶 默认为时间排序
 * @property bool $recommend 0 为默认 1 为首页推荐
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Article[] $articles
 * @method static \Illuminate\Database\Query\Builder|\App\Catalog whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Catalog whereOff($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Catalog whereRecommend($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Catalog whereTop($value)
 */
class Catalog extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected  $guarded = [];

    public function articles()
    {
        return $this->hasMany('App\Article','catalog_id','id');
    }

}
