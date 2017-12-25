<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ResultQuestion
 *
 * @property int $id
 * @property int $activity_id 不同的活动，可以引用相同的问题
 * @property int $question_id
 * @property int $user_id
 * @property string $selected 用户的回答
 * @property string $input
 * @property string $image_path
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultQuestion whereActivityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultQuestion whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultQuestion whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultQuestion whereImagePath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultQuestion whereInput($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultQuestion whereQuestionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultQuestion whereSelected($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultQuestion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ResultQuestion whereUserId($value)
 * @mixin \Eloquent
 */
class ResultQuestion extends Model
{
    protected $guarded = [];
}
