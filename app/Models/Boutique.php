<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Boutique extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'address',
        'phone',
        'status',
        'cover_image',
        'social_links',
        'is_subscribed',
        'validation_status',
        'validated_by',
        'validated_at',
        'latitude',
        'longitude',
        'opening_hours',
    ];

    protected $casts = [
        'social_links' => 'array',
        'is_subscribed' => 'boolean',
        'validated_at' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public const VALIDATION_PENDING = 'pending';
    public const VALIDATION_APPROVED = 'approved';
    public const VALIDATION_REJECTED = 'rejected';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(BoutiqueCategory::class);
    }

    public function articles(): HasMany
    {
        return $this->hasMany(BoutiqueArticle::class);
    }

    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function isSubscribed(): bool
    {
        return $this->is_subscribed;
    }

    public function isApproved(): bool
    {
        return $this->validation_status === self::VALIDATION_APPROVED;
    }

    public function isPending(): bool
    {
        return $this->validation_status === self::VALIDATION_PENDING;
    }

    public function isRejected(): bool
    {
        return $this->validation_status === self::VALIDATION_REJECTED;
    }
}

