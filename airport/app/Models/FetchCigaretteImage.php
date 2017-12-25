<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FetchCigaretteImage
 *
 * @property int $pid
 * @property string $image_path
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FetchCigaretteImage whereImagePath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FetchCigaretteImage wherePid($value)
 * @mixin \Eloquent
 * @property int $cigarette_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FetchCigaretteImage whereCigaretteId($value)
 */
class FetchCigaretteImage extends Model
{
    //
    protected $guarded = [];
}
