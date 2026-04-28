<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model
{
    use HasSlug;

    protected $fillable =
    [
        'title',
        'slug',
        'content',
        'status'   // ADDED HERE
    ];

    /*
    |--------------------------------------------------------------------------
    | Slug Configuration
    |--------------------------------------------------------------------------
    */

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()

            ->generateSlugsFrom('title')

            ->saveSlugsTo('slug')

            ->slugsShouldBeNoLongerThan(50)

            ->doNotGenerateSlugsOnUpdate(false);
    }

    /*
    |--------------------------------------------------------------------------
    | Route Binding with Slug
    |--------------------------------------------------------------------------
    */

    public function getRouteKeyName()
    {
        return 'slug';
    }
}