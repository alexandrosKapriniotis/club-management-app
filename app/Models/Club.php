<?php

namespace App\Models;

use App\Services\PathService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Club extends Model
{
    public const STORAGE_DIR = 'clubs';
    public const IMAGE_WIDTH = 400;

    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'description'
    ];

    protected $guarded = [];

    /**
     * @return HasMany
     */
    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    /**
     * @return Attribute
     */
    public function logoUrl(): Attribute
    {
        return new Attribute(
            get: fn ($value,$attributes) => $attributes['logo']?PathService::getUrl($attributes['logo'], self::STORAGE_DIR):PathService::getDefaultImage()
        );
    }

}
