<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Model;

class TemporaryUpload extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('ck-images');
    }
}
