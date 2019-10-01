<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryZoneTariff extends Model
{

    protected $fillable = ['sending_state_code', 'receiving_state_code', 'delivery_zone_id'];

    public function zone()
    {
        return $this->belongsTo(DeliveryZones::class, "delivery_zone_id", "id");
    }
}
