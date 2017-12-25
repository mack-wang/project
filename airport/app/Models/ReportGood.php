<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ReportGood
 *
 * @property int $id
 * @property int $report_id
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Report $reports
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ReportGood whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ReportGood whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ReportGood whereReportId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ReportGood whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ReportGood whereUserId($value)
 * @mixin \Eloquent
 */
class ReportGood extends Model
{
    protected $guarded = [];

    public function reports()
    {
        return $this->hasOne("App\Models\Report","id","report_id");
    }
}
