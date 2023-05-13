<?php

namespace App\Models;

use App\Services\PathService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Player extends Model
{
    public const STORAGE_DIR = 'players';
    public const IMAGE_WIDTH = 400;

    use HasFactory;

    protected $fillable = [
        'name',
        'photo',
        'position',
        'description',
        'team_id',
        'user_id'
    ];

    protected $guarded = [];

    protected $with = [
        'user',
        'team'
    ];

    /**
     * @return BelongsTo
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return Attribute
     */
    public function photoUrl(): Attribute
    {
        return new Attribute(
            get: fn ($value,$attributes) => $attributes['photo']?PathService::getUrl($attributes['photo'], self::STORAGE_DIR):PathService::getDefaultImage()
        );
    }
}
