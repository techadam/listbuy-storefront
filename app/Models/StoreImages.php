<?php

namespace App\Models;

use App\Models\Store;
use Illuminate\Database\Eloquent\Model;

class StoreImages extends Model
{
    protected $fillable = ['store_id', 'url', 'cloudinary_id'];
    protected $hidden = ['id', 'store_id', 'created_at', 'updated_at', 'cloudinary_id'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
