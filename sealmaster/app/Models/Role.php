<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    public const IS_ADMIN = 1;
    public const IS_EDITOR = 2;
    public const IS_MANAGER = 3;

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
