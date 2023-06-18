<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    use Sluggable, NodeTrait {
        NodeTrait::replicate as replicateNode;
        Sluggable::replicate as replicateSlug;
    }

    protected $fillable = [
        'title',
        'description',
        'content',
        'keywords',
        'thumb',
        'path',
        'parent_id',
    ];

    protected $casts = [
        'keywords' => 'array',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function replicate(array $except = null)
    {
        $instance = $this->replicateNode($except);
        (new SlugService())->slug($instance, true);

        return $instance;
    }

    protected static function booted(): void
    {
        static::saving(function (self $model) {
            if ($model->isDirty('slug', 'parent_id')) {
                $model->generatePath();
            }
        });

        static::saved(function (self $model) {
            // Данная переменная нужна для того, чтобы потомки не начали вызывать
            // метод, т.к. для них путь также изменится
            static $updating = false;

            if ( ! $updating && $model->isDirty('path')) {
                $updating = true;

                $model->updateDescendantsPaths();

                $updating = false;
            }
        });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('categories')
             ->useFallbackUrl(asset('storage/img/placeholder-image.jpg'))
             ->useFallbackUrl(asset('storage/img/placeholder-image.jpg'), 'thumb')
             ->useFallbackPath(asset('storage/img/placeholder-image.jpg'))
             ->useFallbackPath(asset('storage/img/placeholder-image.jpg'), 'thumb');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            // ->format(Manipulations::FORMAT_WEBP)
            ->fit(Manipulations::FIT_CROP, 336, 336)
            ->nonOptimized()
            ->nonQueued();
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class);
    }

    public function getUrl(): string
    {
        return $this->path;
    }

    public function generatePath(): string
    {
        $slug = $this->slug;
        $this->path = $this->isRoot() ? $slug : $this->parent->path.'/'.$slug;

        return $this;
    }

    public function updateDescendantsPaths(): void
    {
        // Получаем всех потомков в древовидном порядке
        $descendants = $this->descendants()
            ->defaultOrder()->get();

        // Данный метод заполняет отношения parent и children
        $descendants->push($this)
            ->linkNodes()->pop();

        foreach ($descendants as $model) {
            $model->generatePath()->save();
        }
    }

    public function getChildrenOrdered()
    {
        return $this->children()->defaultOrder()->get();
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
