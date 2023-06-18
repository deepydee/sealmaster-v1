<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Date;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $date) => Date::parse($date)->format('j F Y'),
        );
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $date) => Date::parse($date)->format('j F Y'),
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
             ->useFallbackUrl(asset('storage/img/placeholder-image.jpg'))
             ->useFallbackUrl(asset('storage/img/placeholder-image.jpg'), 'thumb')
             ->useFallbackPath(asset('storage/img/placeholder-image.jpg'))
             ->useFallbackPath(asset('storage/img/placeholder-image.jpg'), 'thumb');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_CROP, 96, 96)
            ->nonOptimized()
            ->nonQueued();
        $this
            ->addMediaConversion('thumb_card')
            ->fit(Manipulations::FIT_CROP, 334, 334)
            ->nonOptimized()
            ->nonQueued();
    }

    public function scopeSearch(Builder $query, $q)
    {
        return $query->where('title', 'LIKE', "%{$q}%");
            // ->orWhereFullText('content', $q);
    }

    // public function getHumanReadableCreatedAt()
    // {

    // }

    // public function getHumanReadableUpdatedAt()
    // {
    //     # code...
    // }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
