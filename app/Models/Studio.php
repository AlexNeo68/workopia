<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Studio extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\StudioFactory> */
    use HasFactory;
    use HasSlug;
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'preview_text',
        'detail_text',
        'cost_training',
        'contact_email',
        'contact_phone',
        'website_link',
        'vk_link',
        'coordinates',
        'address',
        'city',
        'tags',
        'user_id',
        'sort',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('logo')
            ->singleFile();

        $this
            ->addMediaCollection('gallery');
    }
}
