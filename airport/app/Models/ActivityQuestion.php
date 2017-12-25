<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ActivityQuestion
 *
 * @property int $activity_id
 * @property int $question_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Question $questions
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityQuestion whereActivityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityQuestion whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityQuestion whereQuestionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ActivityQuestion whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ActivityQuestion extends Model
{
    protected $guarded = [];
    public function questions()
    {
        return $this->hasOne('App\Models\Question','id','question_id');
    }
}
