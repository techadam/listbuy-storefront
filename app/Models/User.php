<?php

namespace App\Models;

use App\Models\Store;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'firstname', 'lastname', 'country_code', 'phone', 'role', 'phone_otp', 'verified', 'password_reset_code',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'phone_otp', 'password_reset_code',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function routeNotificationForTwilio()
    {
        return $this->phone;
    }

    public function store()
    {
        return $this->hasOne(Store::class);
    }

    /* Scope a query to only include admin(s).
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */

    public function scopeIsAdmin($query)
    {
        return $query->where('role', 'admin');
    }

}
