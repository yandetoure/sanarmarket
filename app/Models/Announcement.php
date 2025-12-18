<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Announcement extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'subcategory_id',
        'title',
        'description',
        'price',
        'location',
        'phone',
        'image',
        'featured',
        'status',
        'validation_status',
        'validated_by',
        'validated_at',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'validated_at' => 'datetime',
    ];

    protected $with = ['media'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    public function media(): HasMany
    {
        return $this->hasMany(AnnouncementMedia::class)->orderBy('position');
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }

        $firstImage = $this->media->firstWhere('type', AnnouncementMedia::TYPE_IMAGE);
        if ($firstImage) {
            return $firstImage->url;
        }

        // Image par défaut selon la catégorie
        $categoryImages = [
            'livres' => 'https://images.unsplash.com/photo-1588912914017-923900a34710?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxib29rcyUyMHRleHRib29rcyUyMHN0dWR5aW5nfGVufDF8fHx8MTc2MTE0NTI5OXww&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral',
            'fournitures' => 'https://images.unsplash.com/photo-1584628805011-382667dc3229?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxub3RlYm9vayUyMHBlbnMlMjBzdGF0aW9uZXJ5fGVufDF8fHx8MTc2MTE0NTMwMXww&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral',
            'hygiene' => 'https://images.unsplash.com/photo-1750271336429-8b0a507785c0?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxzb2FwJTIwaHlnaWVuZSUyMHByb2R1Y3RzfGVufDF8fHx8MTc2MTE0NTMwMXww&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral',
            'electronique' => 'https://images.unsplash.com/photo-1729496293008-0794382070c2?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxlbGVjdHJvbmljcyUyMGxhcHRvcHxlbnwxfHx8fDE3NjExMTExMTN8MA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral',
            'vetements' => 'https://images.unsplash.com/photo-1592289924034-c423dd2f1c5d?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxzdHVkZW50JTIwYmFja3BhY2slMjBjbG90aGVzfGVufDF8fHx8MTc2MTE0NTMwMXww&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral',
        ];

        return $categoryImages[$this->category->slug] ?? $categoryImages['electronique'];
    }

    public function primaryMedia(): ?AnnouncementMedia
    {
        return $this->media->first();
    }

    /**
     * Check if announcement is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if announcement is hidden
     */
    public function isHidden(): bool
    {
        return $this->status === 'hidden';
    }

    /**
     * Check if announcement is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Scope for active announcements
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for visible announcements (active and approved only)
     */
    public function scopeVisible($query)
    {
        return $query->where('status', 'active')
            ->where('validation_status', 'approved');
    }
}
