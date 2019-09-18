<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{

    protected $fillable = [
        'user_id',
        'name',
        'email_address',
        'description',
        'buyers_location',
        'products_type',
        'accepted_currencies',
    ];

    protected $casts = [
        'accepted_currencies' => 'array', // Will convarted to (Array)
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
