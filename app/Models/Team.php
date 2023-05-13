<?php

namespace App\Models;

use App\Services\PathService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    public const STORAGE_DIR = 'teams';

    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'description',
        'club_id'
    ];

    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }

    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
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
