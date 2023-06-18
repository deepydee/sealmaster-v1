<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Slide extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'content',
        'position',
        'link',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $model->position = $model->id;
            $model->save();
        });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('slides')
             ->useFallbackUrl(asset('storage/img/placeholder-image.jpg'))
             ->useFallbackUrl(asset('storage/img/placeholder-image.jpg'), 'thumb')
             ->useFallbackPath(asset('storage/img/placeholder-image.jpg'))
             ->useFallbackPath(asset('storage/img/placeholder-image.jpg'), 'thumb');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            ->width(336)
            ->height(336)
            ->crop(Manipulations::CROP_RIGHT, 336, 336)
            ->nonOptimized()
            ->nonQueued();
    }
}
