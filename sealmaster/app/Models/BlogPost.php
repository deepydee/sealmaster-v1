<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BlogPost extends Model
{
    use HasFactory, Sluggable;
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

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
