<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class BlogPost extends Model implements HasMedia
{
    use HasFactory, Sluggable, InteractsWithMedia;
    protected $fillable = [
        'title',
        'slug',
        'description',
        'keywords',
        'content',
        'blog_category_id',
        'user_id',
        'is_published',
    ];

    protected $casts = [
        'keywords' => 'array',
        'updated_at' => 'date:d.m.Y',
    ];

    protected function keywords(): Attribute
    {
        return Attribute::make(
            get: fn (string $val) => join(', ', $this->castAttribute('keywords', $val)),
            set: fn (string $val) =>
                '['.(join(',', array_map(fn ($e) =>
                    '"'.trim($e).'"', explode(',', $val)) ).']'),
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(BlogTag::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('blog')
             ->withResponsiveImages()
             ->useFallbackUrl(asset('storage/img/img/placeholder-image.jpg'))
             ->useFallbackUrl(asset('storage/img/placeholder-image.jpg'), 'thumb')
             ->useFallbackPath(asset('storage/img/placeholder-image.jpg'))
             ->useFallbackPath(asset('storage/img/placeholder-image.jpg'), 'thumb');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_CROP, 96, 96)
            ->nonQueued();
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
