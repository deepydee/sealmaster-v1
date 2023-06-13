<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function isAdministrator(): bool
    {
        return $this->roles->first()->id === Role::IS_ADMIN;
    }

    // public function getRoles(): string
    // {
    //     $rolesTitles = [
    //         1 => 'Администратор',
    //         2 => 'Редактор',
    //         3 => 'Менеджер',
    //     ];

    //     $userRolesIds = $this->roles->pluck('id')->toArray();

    //     return join(', ', array_filter($rolesTitles, fn ($id, $title) => in_array($id, $userRolesIds) ? $title : '', ARRAY_FILTER_USE_BOTH));
    // }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatars')
             ->useFallbackUrl(asset('storage/img/avatar.png'))
             ->useFallbackUrl(asset('storage/img/avatar.png'), 'thumb')
             ->useFallbackPath(asset('storage/img/avatar.png'))
             ->useFallbackPath(asset('storage/img/avatar.png'), 'thumb');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_CROP, 36, 36)
            ->nonQueued();
        $this
            ->addMediaConversion('thumb_post')
            ->fit(Manipulations::FIT_CROP, 216, 216)
            ->nonQueued();
    }
}
