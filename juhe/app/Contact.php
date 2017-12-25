<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Contact
 *
 * @property int $id
 * @property string $image
 * @property string $phone
 * @property string $time
 * @property string $content
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Contact whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contact whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contact whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contact wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contact whereTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contact whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Contact extends Model
{
    protected $guarded = [];
}
