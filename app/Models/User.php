<?php

namespace App\Models;

use App\Models\Store;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class User extends Authenticatable
{
    use Notifiable, HasSlug;

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['firstname', 'lastname'])
            ->saveSlugsTo('username')
            ->slugsShouldBeNoLongerThan(50);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'username', 'password', 'firstname', 'lastname', 'country_code', 'phone', 'role', 'phone_otp', 'verified', 'password_reset_code',
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

    /* Scope a query to only include a user with `$username`.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */

    public function scopeUsername($query,$username)
    {
        return $query->where('username', $username);
    }

}
