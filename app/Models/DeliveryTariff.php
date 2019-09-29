<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryTariff extends Model
{
    protected $fillable = ['delivery_weight_id', 'delivery_zone_id', 'price'];
}
