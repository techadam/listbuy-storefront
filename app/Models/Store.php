<?php

namespace App\Models;

use App\Models\User;
use App\Models\Products;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;

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
    ];

    protected $casts = [
        'accepted_currencies' => 'array', // Will convarted to (Array)
    ];

    protected $hidden = ['created_at', 'updated_at'];

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Products::class);
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
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
