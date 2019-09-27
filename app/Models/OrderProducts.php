<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProducts extends Model
{
    protected $with = ['product'];
    protected $fillable = ['product_id', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Products::class);
    }
}
