<?php

namespace App\Models;

use App\Models\Products;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Store extends Model
{
    use HasSlug;

    protected $fillable = [
        'user_id',
        'name',
        'email_address',
        'description',
        'buyers_location',
        'products_type',
        'accepted_currencies',
        'state_code',
        'country_code',
    ];

    protected $casts = [
        'accepted_currencies' => 'array', // Will cast to (Array)
    ];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['has_products'];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(50)
            ->doNotGenerateSlugsOnUpdate();
    }

    public function owner()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function products()
    {
        return $this->hasMany(Products::class);
    }

    public function bank_details()
    {
        return $this->hasOne(StoreBankDetails::class);
    }

    /* Scope a query to only include active stores.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {

        return $query->where('is_active', true);
    }

    /**
     * Get the hasProducts flag for the store.
     *
     * @return bool
     */
    public function getHasProductsAttribute()
    {
        return $this->attributes['has_products'] = (bool) $this->products()->count();
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
