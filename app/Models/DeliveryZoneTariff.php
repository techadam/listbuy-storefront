<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryZoneTariff extends Model
{

    protected $fillable = ['sending_state_code', 'receiving_state_code', 'delivery_zone_id'];
    public function price()
    {
// return $this->hasOne(DeliveryTariff)
    }
}
