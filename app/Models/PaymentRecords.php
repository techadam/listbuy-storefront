<?php

namespace App\Models;

use App\Models\Orders;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class PaymentRecords extends Model
{
    protected $fillable = ['store_id', 'user_id', 'order_id', 'reference_id', 'amount', 'payment_processor', 'payment_method', 'currency', 'status'];

    public function order()
    {
        return $this->belongsTo(Orders::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
