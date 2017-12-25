<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Question
 *
 * @property int $id
 * @property string $image_path
 * @property string $question
 * @property string $options 单选和多选的选项，用英文逗号分开选项
 * @property string $selected 单选和多选的答案，用1234来表示 1表示第一个选项，34表示3和4选项
 * @property string $type radio 单选 select 多选 photo 照片 input 输入
 * @property \Carbon\Carbon $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ActivityQuestion[] $activity_questions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ResultQuestion[] $result_questions
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question whereImagePath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question whereOptions($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question whereQuestion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question whereSelected($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Question withoutTrashed()
 */
class Question extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function activity_questions()
    {
        return $this->hasMany('App\Models\ActivityQuestion', 'question_id', 'id');
    }

    public function result_questions()
    {
        return $this->hasMany('App\Models\ResultQuestion', 'question_id', 'id');
    }
}
