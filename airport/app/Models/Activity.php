<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Activity
 *
 * @property int $id
 * @property string $type apply 是测评活动 kill 是秒杀活动 airport 是机场活动 shop 是终端活动 wed婚庆活动 5 其他活动1 6 其他活动2
 * @property int $pid 对应申领或秒杀的烟的id
 * @property bool $off 若为1，则强制关闭活动，活动不删除，可以看，但用户无法报名参加
 * @property string $start_at
 * @property string $end_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\ActivityAttr $activity_attrs
 * @property-read \App\Models\ActivityPrize $activity_prizes
 * @property-read \App\Models\ActivityRequire $activity_requires
 * @property-read \App\Models\Article $articles
 * @property-read \App\Models\FetchCigarette $fetch_cigarettes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\GrassEveryday[] $grass_everydays
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Activity whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Activity whereEndAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Activity whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Activity whereOff($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Activity wherePid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Activity whereStartAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Activity whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Activity whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $cigarette_id 对应申领或秒杀的烟的id
 * @property-read \App\Models\ActivityShop $activity_shops
 * @property-read \App\Models\ActivityTask $activity_tasks
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PrizeDescribe[] $prize_describes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ResultApply[] $result_applies
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ResultTask[] $result_tasks
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Activity whereCigaretteId($value)
 * @property int $article_id 对应的文章
 * @property bool $elect 0 系统定时智能选出 1 人工选出 2 选择完毕
 * @property-read \App\Models\ActivityHeadimg $activity_headimgs
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ActivityQuestion[] $activity_questions
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Activity whereArticleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Activity whereElect($value)
 */
class Activity extends Model
{
    //
    protected $guarded = [];

    public function articles()
    {
        return $this->hasOne('App\Models\Article','id','article_id');
    }

    public function activity_attrs()
    {
        return $this->hasOne('App\Models\ActivityAttr');
    }

    public function activity_prizes()
    {
        return $this->hasOne('App\Models\ActivityPrize');
    }

    public function activity_requires()
    {
        return $this->hasOne('App\Models\ActivityRequire');
    }

    public function activity_headimgs()
    {
        return $this->hasOne('App\Models\ActivityHeadimg');
    }



    public function grass_everydays()
    {
        return $this->hasMany('App\Models\GrassEveryday');
    }

    public function prize_describes()
    {
        return $this->hasMany('App\Models\PrizeDescribe');
    }

    public function fetch_cigarettes()
    {
        return $this->hasOne('App\Models\FetchCigarette','cigarette_id','cigarette_id');
    }

    public function activity_shops()
    {
        return $this->hasOne('App\Models\ActivityShop');
    }

    public function activity_tasks()
    {
        return $this->hasOne('App\Models\ActivityTask');
    }

    public function result_applies()
    {
        return $this->hasMany('App\Models\ResultApply');
    }

    public function result_tasks()
    {
        return $this->hasMany('App\Models\ResultTask');
    }

    public function activity_questions()
    {
        return $this->hasOne('App\Models\ActivityQuestion');
    }

    public function apply_delete()
    {
        $this->activity_attrs()->delete();
        $this->activity_prizes()->delete();
        $this->activity_questions()->delete();
        $this->activity_requires()->delete();
        parent::delete();
    }

    public function shop_delete()
    {
        $this->activity_shops()->delete();
        $this->activity_requires()->delete();
        parent::delete();
    }

    public function task_delete()
    {
        $this->activity_tasks()->delete();
        $this->activity_questions()->delete();
        $this->activity_requires()->delete();
        parent::delete();
    }

}
