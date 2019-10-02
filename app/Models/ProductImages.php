<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
    protected $fillable = ['product_id', 'url'];
    protected $hidden = ['id', 'created_at', 'updated_at'];

    public function product()
    {
        return $this->belongsTo(Products::class);
    }
}
