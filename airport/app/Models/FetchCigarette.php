<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FetchCigarette
 *
 * @property int $id
 * @property int $pid
 * @property string $image_url
 * @property string $name
 * @property int $brand_id
 * @property string $brand
 * @property string $packet_code
 * @property string $carton_code
 * @property string $type
 * @property string $size
 * @property int $price
 * @property string $company
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FetchCigarette whereBrand($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FetchCigarette whereBrandId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FetchCigarette whereCartonCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FetchCigarette whereCompany($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FetchCigarette whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FetchCigarette whereImageUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FetchCigarette whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FetchCigarette wherePacketCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FetchCigarette wherePid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FetchCigarette wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FetchCigarette whereSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FetchCigarette whereType($value)
 * @mixin \Eloquent
 * @property int $cigarette_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FetchCigarette whereCigaretteId($value)
 * @property int|null $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FetchCigarette whereStatus($value)
 */
class FetchCigarette extends Model
{
    //
    protected $guarded = [];
    public $timestamps = false;
}
