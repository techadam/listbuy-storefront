<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $with = ['payment_record'];
    protected $fillable = [
        'generated_id',
        'store_id',
        'user_id',
        'payment_record_id',
        'amount',
        'shipping_address',
        'buyer_email',
        'buyer_name',
        'buyer_phone',
        'dest_state',
        'dest_country',
        'status',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, "store_id");
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function payment_record()
    {
        return $this->hasOne(PaymentRecords::class, "order_id");
    }

    public function products()
    {
        return $this->hasMany(OrderProducts::class, "order_id");
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'generated_id';
    }
}
