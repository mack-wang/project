<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultChargeBuy extends Model
{
    protected $guarded = [];

    public function result_charge_callbacks()
    {
        return $this->hasOne("App\Models\ResultChargeCallback", "downstreamSerialno", "serialno");
    }
}
