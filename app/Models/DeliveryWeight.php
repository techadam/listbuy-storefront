<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryWeight extends Model
{
    protected $fillable = ['weight'];

    public function prices()
    {
        return $this->hasMany(DeliveryTariff::class);
    }
}
