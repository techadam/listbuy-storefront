<?php

namespace App\Models;

use App\Models\Store;
use Illuminate\Database\Eloquent\Model;

class StoreBankDetails extends Model
{
    protected $fillable = ['store_id', 'bank_name', 'account_number', 'account_name'];

    protected $hidden = ['created_at'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
